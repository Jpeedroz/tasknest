@extends('layouts.app')

@section('title', 'Nova tarefa')

@section('content')
<main class="tn-main">
    <a href="{{ route('tarefas.index') }}" class="tn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
        Voltar para a lista de tarefas
    </a>

    <div>
        <h1 class="tn-page-title">Nova tarefa</h1>
        <p class="tn-page-sub">Escolha uma cor para identificar a tarefa de longe, como uma etiqueta.</p>
    </div>

    <div class="tn-form-layout">
        <form method="POST" action="{{ route('tarefas.store') }}" class="tn-card" data-form-tarefa>
            @csrf
            <div class="tn-card-body">
                @include('tarefas._campos')
            </div>
            <div class="tn-card-footer">
                <a href="{{ route('tarefas.index') }}" class="btn btn-outline btn-fixed">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-fixed">Criar tarefa</button>
            </div>
        </form>

        @include('tarefas._preview')
    </div>
</main>
@endsection
