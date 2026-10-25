<?php

namespace Tests\Feature;

use App\Mail\LembreteTarefa;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LembreteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // "Hoje" fixo às 9h, depois do horário de envio
        Carbon::setTestNow(Carbon::parse('2026-10-21 09:00:00'));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function tarefa(User $user, array $dados = []): Tarefa
    {
        return Tarefa::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'pendente',
            'data_vencimento' => '2026-10-22',
            'lembrete_ativo' => true,
            'lembrete_dias' => 1,
        ], $dados));
    }

    // ---------- Cor ----------

    public function test_cria_tarefa_com_cor_e_lembrete(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tarefas', [
            'titulo' => 'Relatório',
            'data_vencimento' => '2026-10-28',
            'cor' => 'azul',
            'lembrete_ativo' => '1',
            'lembrete_dias' => '3',
        ])->assertRedirect('/tarefas');

        $this->assertDatabaseHas('tarefas', [
            'titulo' => 'Relatório',
            'cor' => 'azul',
            'lembrete_ativo' => true,
            'lembrete_dias' => 3,
        ]);
    }

    public function test_cor_invalida_e_recusada(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/tarefas', ['titulo' => 'X', 'cor' => 'dourado'])
            ->assertSessionHasErrors('cor');
    }

    public function test_lembrete_sem_data_fica_desligado(): void
    {
        $this->actingAs(User::factory()->create())->post('/tarefas', [
            'titulo' => 'Sem prazo',
            'lembrete_ativo' => '1',
        ]);

        $this->assertDatabaseHas('tarefas', ['titulo' => 'Sem prazo', 'lembrete_ativo' => false]);
    }

    public function test_lista_mostra_tabela_com_cor(): void
    {
        $user = User::factory()->create();
        $this->tarefa($user, ['titulo' => 'Colorida', 'cor' => 'roxo']);

        $this->actingAs($user)->get('/tarefas')
            ->assertOk()
            ->assertSee('Colorida')
            ->assertSee('#a855f7', false)
            ->assertSee('Acompanhe prazos e o andamento das suas atividades.');
    }

    // ---------- Sininho ----------

    public function test_sininho_liga_e_desliga(): void
    {
        $user = User::factory()->create(['lembrete_dias_padrao' => 3]);
        $tarefa = $this->tarefa($user, ['lembrete_ativo' => false]);

        $this->actingAs($user)->patch("/tarefas/{$tarefa->id}/lembrete")->assertSessionHas('success');
        $tarefa->refresh();
        $this->assertTrue($tarefa->lembrete_ativo);
        $this->assertSame(3, $tarefa->lembrete_dias);

        $this->actingAs($user)->patch("/tarefas/{$tarefa->id}/lembrete");
        $this->assertFalse($tarefa->fresh()->lembrete_ativo);
    }

    public function test_sininho_nao_liga_sem_data(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefa($user, ['data_vencimento' => null, 'lembrete_ativo' => false]);

        $this->actingAs($user)->patch("/tarefas/{$tarefa->id}/lembrete")->assertSessionHas('error');
        $this->assertFalse($tarefa->fresh()->lembrete_ativo);
    }

    public function test_sininho_de_outro_usuario_e_proibido(): void
    {
        $tarefa = $this->tarefa(User::factory()->create());

        $this->actingAs(User::factory()->create())
            ->patch("/tarefas/{$tarefa->id}/lembrete")
            ->assertForbidden();
    }

    // ---------- Envio ----------

    public function test_comando_envia_lembrete_no_dia_certo(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $tarefa = $this->tarefa($user); // vence amanhã, avisar 1 dia antes = hoje

        $this->artisan('tarefas:enviar-lembretes')->assertSuccessful();

        Mail::assertSent(LembreteTarefa::class, fn ($m) => $m->hasTo($user->email) && $m->tarefa->is($tarefa));
        $this->assertNotNull($tarefa->fresh()->lembrete_enviado_em);
    }

    public function test_comando_nao_envia_duas_vezes(): void
    {
        Mail::fake();
        $this->tarefa(User::factory()->create());

        $this->artisan('tarefas:enviar-lembretes');
        $this->artisan('tarefas:enviar-lembretes');

        Mail::assertSentCount(1);
    }

    public function test_comando_ignora_casos_que_nao_devem_receber(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->tarefa($user, ['data_vencimento' => '2026-10-30']);          // ainda é cedo
        $this->tarefa($user, ['status' => 'concluida']);                     // concluída
        $this->tarefa($user, ['lembrete_ativo' => false]);                   // sininho desligado
        $this->tarefa($user, ['data_vencimento' => '2026-10-20']);          // já venceu
        $this->tarefa(User::factory()->create(['lembretes_email' => false])); // desligou no perfil

        $this->artisan('tarefas:enviar-lembretes');

        Mail::assertNothingSent();
    }

    public function test_comando_espera_as_8h(): void
    {
        Mail::fake();
        Carbon::setTestNow(Carbon::parse('2026-10-21 06:00:00'));
        $this->tarefa(User::factory()->create());

        $this->artisan('tarefas:enviar-lembretes');
        Mail::assertNothingSent();

        $this->artisan('tarefas:enviar-lembretes --agora');
        Mail::assertSentCount(1);
    }

    public function test_mudar_data_permite_novo_lembrete(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefa($user);
        $tarefa->forceFill(['lembrete_enviado_em' => now()])->save();

        $this->actingAs($user)->put("/tarefas/{$tarefa->id}", [
            'titulo' => $tarefa->titulo,
            'data_vencimento' => '2026-10-25',
            'lembrete_ativo' => '1',
            'lembrete_dias' => '1',
        ]);

        $this->assertNull($tarefa->fresh()->lembrete_enviado_em);
    }

    public function test_email_de_lembrete_renderiza(): void
    {
        $user = User::factory()->create(['name' => 'Maria Souza']);
        $tarefa = $this->tarefa($user, ['titulo' => 'Entregar trabalho']);

        $html = (new LembreteTarefa($tarefa, $user))->render();

        $this->assertStringContainsString('Olá, Maria!', $html);
        $this->assertStringContainsString('Entregar trabalho', $html);
        $this->assertStringContainsString('vence amanhã', $html);
    }

    // ---------- Perfil ----------

    public function test_salva_preferencias_de_notificacao(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile/notificacoes', [
            'lembretes_email' => '0',
            'lembrete_dias_padrao' => '3',
        ])->assertSessionHas('status', 'notificacoes-updated');

        $user->refresh();
        $this->assertFalse($user->lembretes_email);
        $this->assertSame(3, $user->lembrete_dias_padrao);
    }

    public function test_envia_email_de_teste(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/profile/notificacoes/teste')
            ->assertSessionHas('status', 'teste-enviado');

        Mail::assertSent(LembreteTarefa::class, fn ($m) => $m->teste && $m->hasTo($user->email));
    }
}
