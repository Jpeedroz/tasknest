@extends('layouts.app')

@section('title', 'Editar tarefa')

@section('content')
<main class="tn-main">
    <a href="{{ route('tarefas.show', $tarefa) }}" class="tn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
        Voltar para a tarefa
    </a>

    <div>
        <h1 class="tn-page-title">Editar tarefa</h1>
        <p class="tn-page-sub">
            Criada em {{ $tarefa->created_at->format('d/m/Y H:i') }}
            @if ($tarefa->updated_at && $tarefa->updated_at->ne($tarefa->created_at))
                · atualizada em {{ $tarefa->updated_at->format('d/m/Y H:i') }}
            @endif
        </p>
    </div>

    <div class="tn-form-layout">
        <form method="POST" action="{{ route('tarefas.update', $tarefa) }}" class="tn-card" data-form-tarefa>
            @csrf
            @method('PUT')
            <div class="tn-card-body">
                @include('tarefas._campos', ['tarefa' => $tarefa])
                <p class="hint" style="margin: 0">Para mudar o status, use o botão Iniciar, Concluir ou Reabrir na lista de tarefas.</p>
            </div>
            <div class="tn-card-footer">
                <a href="{{ route('tarefas.index') }}" class="btn btn-outline btn-fixed">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-fixed">Salvar alterações</button>
            </div>
        </form>

        @include('tarefas._preview', ['status' => $tarefa->status])
    </div>
</main>
@endsection
