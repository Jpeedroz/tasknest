<?php

namespace App\Http\Controllers;

use App\Mail\LembreteTarefa;
use App\Models\Tarefa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

/**
 * Preferências de notificação por e-mail (seção "Notificações" do perfil).
 */
class NotificacaoController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'lembrete_dias_padrao' => ['required', Rule::in(array_keys(Tarefa::LEMBRETE_OPCOES))],
        ]);

        $request->user()->update([
            'lembretes_email' => $request->boolean('lembretes_email'),
            'lembrete_dias_padrao' => (int) $request->lembrete_dias_padrao,
        ]);

        return back()->with('status', 'notificacoes-updated');
    }

    /**
     * Envia um e-mail de exemplo para o usuário conferir se a configuração funciona.
     */
    public function teste(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Tarefa de exemplo (não é salva no banco)
        $exemplo = new Tarefa([
            'titulo' => 'Tarefa de exemplo',
            'descricao' => 'Este é um e-mail de teste do TaskNest. Se ele chegou, seus lembretes estão funcionando.',
            'data_vencimento' => today()->addDay(),
            'status' => 'pendente',
            'cor' => 'azul',
            'lembrete_dias' => 1,
        ]);

        try {
            Mail::to($user->email)->send(new LembreteTarefa($exemplo, $user, teste: true));
        } catch (\Throwable $e) {
            Log::warning('Falha ao enviar e-mail de teste: ' . $e->getMessage());

            return back()->with('status', 'teste-falhou');
        }

        return back()->with('status', 'teste-enviado');
    }
}
