<?php

namespace Tests\Feature;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarefaTest extends TestCase
{
    use RefreshDatabase;

    private function tarefaDe(User $user, array $dados = []): Tarefa
    {
        return Tarefa::factory()->create(array_merge(['user_id' => $user->id, 'status' => 'pendente'], $dados));
    }

    public function test_visitante_e_redirecionado_para_login(): void
    {
        $this->get('/tarefas')->assertRedirect('/login');
        $this->get('/tarefas/create')->assertRedirect('/login');
    }

    public function test_listagem_mostra_apenas_tarefas_do_usuario(): void
    {
        $joao = User::factory()->create();
        $outro = User::factory()->create();
        $this->tarefaDe($joao, ['titulo' => 'Minha tarefa']);
        $this->tarefaDe($outro, ['titulo' => 'Tarefa de outro']);

        $this->actingAs($joao)->get('/tarefas')
            ->assertOk()
            ->assertSee('Minha tarefa')
            ->assertDontSee('Tarefa de outro');
    }

    public function test_filtro_por_status(): void
    {
        $user = User::factory()->create();
        $this->tarefaDe($user, ['titulo' => 'Tarefa pendente', 'status' => 'pendente']);
        $this->tarefaDe($user, ['titulo' => 'Tarefa pronta', 'status' => 'concluida']);

        $this->actingAs($user)->get('/tarefas?status=concluida')
            ->assertOk()
            ->assertSee('Tarefa pronta')
            ->assertDontSee('Tarefa pendente');
    }

    public function test_tela_de_criacao_tem_formulario(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/tarefas/create')
            ->assertOk()
            ->assertSee('name="titulo"', false)
            ->assertSee(route('tarefas.store'), false);
    }

    public function test_cria_tarefa(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tarefas', [
            'titulo' => 'Estudar Laravel',
            'descricao' => 'Rotas e controllers',
            'data_vencimento' => now()->addDays(3)->format('Y-m-d'),
        ])->assertRedirect('/tarefas')->assertSessionHas('success');

        $this->assertDatabaseHas('tarefas', [
            'titulo' => 'Estudar Laravel',
            'status' => 'pendente',
            'user_id' => $user->id,
        ]);
    }

    public function test_validacao_ao_criar(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tarefas', [
            'titulo' => '',
            'data_vencimento' => now()->subDay()->format('Y-m-d'),
        ])->assertSessionHasErrors(['titulo', 'data_vencimento']);

        $this->assertDatabaseCount('tarefas', 0);
    }

    public function test_ver_e_editar_tarefa(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefaDe($user, ['titulo' => 'Antiga']);

        $this->actingAs($user)->get("/tarefas/{$tarefa->id}")->assertOk()->assertSee('Antiga');
        $this->actingAs($user)->get("/tarefas/{$tarefa->id}/edit")->assertOk();

        $this->actingAs($user)->put("/tarefas/{$tarefa->id}", [
            'titulo' => 'Nova',
            'descricao' => null,
            'data_vencimento' => null,
        ])->assertRedirect('/tarefas');

        $this->assertSame('Nova', $tarefa->fresh()->titulo);
    }

    public function test_exclui_tarefa(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefaDe($user);

        $this->actingAs($user)->delete("/tarefas/{$tarefa->id}")->assertRedirect('/tarefas');

        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    }

    public function test_alterna_status_em_ciclo(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefaDe($user);
        $url = "/tarefas/{$tarefa->id}/toggle-status";

        $this->actingAs($user)->patch($url);
        $this->assertSame('em_andamento', $tarefa->fresh()->status);
        $this->actingAs($user)->patch($url);
        $this->assertSame('concluida', $tarefa->fresh()->status);
        $this->actingAs($user)->patch($url);
        $this->assertSame('pendente', $tarefa->fresh()->status);
    }

    public function test_lista_mostra_contagem_e_prazo(): void
    {
        $user = User::factory()->create();
        $this->tarefaDe($user, ['titulo' => 'Urgente', 'data_vencimento' => now()->addDay()->format('Y-m-d')]);
        $this->tarefaDe($user, ['status' => 'concluida']);

        $this->actingAs($user)->get('/tarefas')
            ->assertOk()
            ->assertSee('2 tarefas')
            ->assertSee('Vence amanhã')
            ->assertSee('Iniciar')
            ->assertSee('Reabrir');
    }

    public function test_lista_vazia_mostra_convite(): void
    {
        $this->actingAs(User::factory()->create())->get('/tarefas')
            ->assertOk()
            ->assertSee('Criar primeira tarefa');
    }

    public function test_alternar_status_volta_para_a_tela_anterior(): void
    {
        $user = User::factory()->create();
        $tarefa = $this->tarefaDe($user);

        $this->actingAs($user)
            ->from("/tarefas/{$tarefa->id}")
            ->patch("/tarefas/{$tarefa->id}/toggle-status")
            ->assertRedirect("/tarefas/{$tarefa->id}");
    }

    public function test_paginas_de_acesso_e_perfil_abrem(): void
    {
        $this->get('/login')->assertOk()->assertSee('Entrar na sua conta');
        $this->get('/register')->assertOk()->assertSee('Criar sua conta');
        $this->get('/forgot-password')->assertOk();

        $this->actingAs(User::factory()->create())->get('/profile')
            ->assertOk()
            ->assertSee('Alterar senha')
            ->assertSee('Excluir conta');
    }

    public function test_nao_acessa_tarefa_de_outro_usuario(): void
    {
        $dono = User::factory()->create();
        $intruso = User::factory()->create();
        $tarefa = $this->tarefaDe($dono);

        $this->actingAs($intruso)->get("/tarefas/{$tarefa->id}")->assertForbidden();
        $this->actingAs($intruso)->get("/tarefas/{$tarefa->id}/edit")->assertForbidden();
        $this->actingAs($intruso)->put("/tarefas/{$tarefa->id}", ['titulo' => 'x'])->assertForbidden();
        $this->actingAs($intruso)->patch("/tarefas/{$tarefa->id}/toggle-status")->assertForbidden();
        $this->actingAs($intruso)->delete("/tarefas/{$tarefa->id}")->assertForbidden();

        $this->assertDatabaseHas('tarefas', ['id' => $tarefa->id]);
    }
}
