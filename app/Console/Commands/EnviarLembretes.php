<?php

namespace App\Console\Commands;

use App\Mail\LembreteTarefa;
use App\Models\Tarefa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Envia os e-mails de lembrete das tarefas que estão perto de vencer.
 *
 * Roda sozinho pelo agendador (veja routes/console.php) ou na mão:
 *   php artisan tarefas:enviar-lembretes
 */
class EnviarLembretes extends Command
{
    protected $signature = 'tarefas:enviar-lembretes {--agora : Ignora o horário mínimo de envio (8h)}';

    protected $description = 'Envia por e-mail os lembretes de vencimento das tarefas';

    /** Os lembretes só saem a partir deste horário. */
    public const HORA_ENVIO = 8;

    public function handle(): int
    {
        if (! $this->option('agora') && now()->hour < self::HORA_ENVIO) {
            $this->info('Ainda não são ' . self::HORA_ENVIO . 'h. Nenhum lembrete enviado.');

            return self::SUCCESS;
        }

        $hoje = today();

        $tarefas = Tarefa::query()
            ->with('user')
            ->where('lembrete_ativo', true)
            ->whereNull('lembrete_enviado_em')
            ->where('status', '!=', 'concluida')
            ->whereNotNull('data_vencimento')
            ->whereDate('data_vencimento', '>=', $hoje)
            ->whereHas('user', fn ($q) => $q->where('lembretes_email', true))
            ->get()
            // Só as que já chegaram no dia de avisar (vencimento - antecedência <= hoje)
            ->filter(fn (Tarefa $t) => $t->dataEnvioLembrete()->lte($hoje));

        $enviados = 0;

        foreach ($tarefas as $tarefa) {
            try {
                Mail::to($tarefa->user->email)->send(new LembreteTarefa($tarefa, $tarefa->user));
                $tarefa->forceFill(['lembrete_enviado_em' => now()])->save();
                $enviados++;
            } catch (\Throwable $e) {
                Log::warning("Falha ao enviar lembrete da tarefa {$tarefa->id}: " . $e->getMessage());
                $this->warn("Falha na tarefa {$tarefa->id}: " . $e->getMessage());
            }
        }

        $this->info("Lembretes enviados: {$enviados}");

        return self::SUCCESS;
    }
}
