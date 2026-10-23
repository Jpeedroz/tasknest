<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TarefaController extends Controller
{

    public function index(Request $request)
    {
        $query = Tarefa::where('user_id', Auth::id());

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $tarefas = $query->orderBy('created_at', 'desc')->paginate(10);

        // Quantidade de tarefas do usuário em cada status (para os cartões do topo)
        $porStatus = Tarefa::where('user_id', Auth::id())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $contagem = [
            'todas' => (int) $porStatus->sum(),
            'pendente' => (int) ($porStatus['pendente'] ?? 0),
            'em_andamento' => (int) ($porStatus['em_andamento'] ?? 0),
            'concluida' => (int) ($porStatus['concluida'] ?? 0),
        ];

        return view('tarefas.index', compact('tarefas', 'contagem'));
    }


    public function create()
    {
        return view('tarefas.create');
    }


    public function store(Request $request)
    {
        $dados = $this->validar($request);

        Tarefa::create($dados + [
            'status' => 'pendente',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }


    public function show(Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tarefas.show', compact('tarefa'));
    }


    public function edit(Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tarefas.edit', compact('tarefa'));
    }


    public function update(Request $request, Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        $dados = $this->validar($request);

        $tarefa->fill($dados);

        // Se a data ou a antecedência mudaram, o lembrete pode ser enviado de novo
        if ($tarefa->isDirty(['data_vencimento', 'lembrete_dias', 'lembrete_ativo'])) {
            $tarefa->lembrete_enviado_em = null;
        }

        $tarefa->save();

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }


    public function destroy(Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        $tarefa->delete();

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }


    public function toggleStatus(Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        // Ciclo de status: pendente -> em_andamento -> concluida -> pendente
        $novoStatus = match ($tarefa->status) {
            'pendente' => 'em_andamento',
            'em_andamento' => 'concluida',
            'concluida' => 'pendente',
            default => 'pendente'
        };

        $tarefa->update(['status' => $novoStatus]);

        $mensagens = [
            'pendente' => 'Tarefa marcada como pendente!',
            'em_andamento' => 'Tarefa em andamento!',
            'concluida' => 'Tarefa concluída!'
        ];

        // Volta para a tela de onde o botão foi clicado (lista ou detalhes)
        return back(fallback: route('tarefas.index'))
            ->with('success', $mensagens[$novoStatus]);
    }


    /**
     * Liga ou desliga o lembrete por e-mail de uma tarefa (o "sininho").
     */
    public function toggleLembrete(Request $request, Tarefa $tarefa)
    {
        if ($tarefa->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $tarefa->podeTerLembrete()) {
            $motivo = $tarefa->data_vencimento
                ? 'Tarefas concluídas não têm lembrete.'
                : 'Defina uma data de vencimento para ativar o lembrete.';

            return back(fallback: route('tarefas.index'))->with('error', $motivo);
        }

        $ligar = ! $tarefa->lembrete_ativo;

        $tarefa->lembrete_ativo = $ligar;
        $tarefa->lembrete_enviado_em = null;
        if ($ligar) {
            // Usa a antecedência padrão escolhida no perfil
            $tarefa->lembrete_dias = $request->user()->lembrete_dias_padrao ?? 1;
        }
        $tarefa->save();

        $mensagem = $ligar
            ? 'Lembrete ativado: você receberá um e-mail ' . mb_strtolower($tarefa->lembreteQuando()) . ' do vencimento de "' . $tarefa->titulo . '".'
            : 'Lembrete desativado para "' . $tarefa->titulo . '".';

        if ($ligar && ! $request->user()->lembretes_email) {
            $mensagem .= ' Atenção: os lembretes por e-mail estão desligados no seu perfil.';
        }

        return back(fallback: route('tarefas.index'))->with('success', $mensagem);
    }


    /**
     * Validação usada ao criar e ao editar.
     */
    private function validar(Request $request): array
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_vencimento' => 'nullable|date|after_or_equal:today',
            'cor' => ['nullable', Rule::in(array_keys(Tarefa::CORES))],
            'lembrete_ativo' => 'nullable|boolean',
            'lembrete_dias' => ['nullable', Rule::in(array_keys(Tarefa::LEMBRETE_OPCOES))],
        ], [
            'cor.in' => 'Escolha uma das cores da paleta.',
            'lembrete_dias.in' => 'Escolha quando o lembrete deve ser enviado.',
        ]);

        $temData = filled($request->data_vencimento);

        return [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_vencimento' => $request->data_vencimento ?: null,
            'cor' => $request->cor ?: null,
            // Sem data não há como lembrar
            'lembrete_ativo' => $temData && $request->boolean('lembrete_ativo'),
            'lembrete_dias' => (int) ($request->lembrete_dias ?? $request->user()->lembrete_dias_padrao ?? 1),
        ];
    }
}
