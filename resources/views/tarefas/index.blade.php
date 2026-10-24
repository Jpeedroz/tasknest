@extends('layouts.app')

@section('title', 'Minhas tarefas')

@section('content')
@php
    $filtro = request('status', '');
    $abas = [
        '' => 'Todas',
        'pendente' => 'Pendentes',
        'em_andamento' => 'Em andamento',
        'concluida' => 'Concluídas',
    ];
    $cartoes = [
        ['Total', $contagem['todas'], ''],
        ['Pendentes', $contagem['pendente'], 'is-pendente'],
        ['Em andamento', $contagem['em_andamento'], 'is-andamento'],
        ['Concluídas', $contagem['concluida'], 'is-concluida'],
    ];
@endphp

<main class="tn-main">
    <div class="tn-page-head is-center">
        <div>
            <h1 class="tn-page-title">Minhas tarefas</h1>
            <p class="tn-page-sub">Acompanhe prazos e o andamento das suas atividades.</p>
        </div>
        <a href="{{ route('tarefas.create') }}" class="btn btn-primary btn-lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Nova tarefa
        </a>
    </div>

    @include('partials.alertas')

    <div class="tn-stat-cards">
        @foreach ($cartoes as [$nome, $qtd, $classe])
            <div class="tn-stat-card {{ $classe }}">
                <span class="tn-stat-card-label">{{ $nome }}</span>
                <span class="tn-stat-card-value">{{ $qtd }}</span>
            </div>
        @endforeach
    </div>

    <section class="tn-table-card">
        <div class="tn-table-toolbar">
            <nav class="tn-seg" aria-label="Filtrar por status">
                @foreach ($abas as $valor => $nome)
                    <a href="{{ $valor === '' ? route('tarefas.index') : route('tarefas.index', ['status' => $valor]) }}"
                       class="{{ $filtro === $valor ? 'is-active' : '' }}"
                       @if ($filtro === $valor) aria-current="page" @endif>{{ $nome }}</a>
                @endforeach
            </nav>
            <span class="tn-muted">Mais recentes primeiro</span>
        </div>

        @if ($tarefas->count() > 0)
            <div class="tn-table-scroll">
                <table class="tn-table">
                    <thead>
                        <tr>
                            <th scope="col">Tarefa</th>
                            <th scope="col" class="col-status">Status</th>
                            <th scope="col" class="col-venc">Vencimento</th>
                            <th scope="col" class="col-acoes">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tarefas as $tarefa)
                            @php
                                $prazo = $tarefa->prazo();
                                $classeAcao = match ($tarefa->status) {
                                    'pendente' => 'btn-start',
                                    'em_andamento' => 'btn-success',
                                    default => 'btn-reopen',
                                };
                                $ligado = $tarefa->lembreteLigado();
                                $tituloSino = ! $tarefa->data_vencimento
                                    ? 'Defina uma data de vencimento para ativar o lembrete'
                                    : ($tarefa->status === 'concluida'
                                        ? 'Tarefa concluída — sem lembrete'
                                        : ($ligado ? 'Lembrete ativo (' . mb_strtolower($tarefa->lembreteQuando()) . ') — clique para desativar' : 'Ativar lembrete por e-mail'));
                            @endphp
                            <tr class="{{ $tarefa->status === 'concluida' ? 'is-done' : '' }}">
                                <td>
                                    <div class="tn-cell-task">
                                        <span class="tn-color-bar" style="background: {{ $tarefa->corHex() ?? 'var(--border-2)' }}" title="Cor: {{ $tarefa->corNome() }}"></span>
                                        <div class="tn-cell-text">
                                            <a href="{{ route('tarefas.show', $tarefa) }}" class="tn-cell-title">{{ $tarefa->titulo }}</a>
                                            @if ($tarefa->descricao)
                                                <span class="tn-cell-desc">{{ \Illuminate\Support\Str::limit($tarefa->descricao, 70) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="col-status">
                                    <span class="tn-status st-{{ $tarefa->status }}">
                                        <span class="tn-status-dot"></span>{{ $tarefa->statusLabel() }}
                                    </span>
                                </td>
                                <td class="col-venc">
                                    @if ($tarefa->data_vencimento)
                                        <span class="tn-date">{{ $tarefa->data_vencimento->format('d/m/Y') }}</span>
                                    @else
                                        <span class="tn-date">—</span>
                                    @endif
                                    <span class="tn-date-rel {{ $prazo['atrasada'] ? 'is-late' : ($prazo['urgente'] ? 'is-urgent' : '') }}">{{ $prazo['curto'] }}</span>
                                </td>
                                <td class="col-acoes">
                                    <div class="tn-actions">
                                        <form method="POST" action="{{ route('tarefas.toggle-lembrete', $tarefa) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="tn-bell-btn {{ $ligado ? 'is-on' : '' }}"
                                                    aria-label="{{ $tituloSino }}" title="{{ $tituloSino }}"
                                                    aria-pressed="{{ $ligado ? 'true' : 'false' }}"
                                                    @disabled(! $tarefa->podeTerLembrete())>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $ligado ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" fill="none"/></svg>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('tarefas.toggle-status', $tarefa) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-status {{ $classeAcao }}">
                                                @if ($tarefa->status === 'pendente')
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 4.5v15l12-7.5z"/></svg>
                                                @elseif ($tarefa->status === 'em_andamento')
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
                                                @else
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg>
                                                @endif
                                                {{ $tarefa->proximaAcao() }}
                                            </button>
                                        </form>

                                        <div class="tn-btn-group">
                                            <a href="{{ route('tarefas.show', $tarefa) }}" aria-label="Ver tarefa" title="Ver">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                            <a href="{{ route('tarefas.edit', $tarefa) }}" aria-label="Editar tarefa" title="Editar">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('tarefas.destroy', $tarefa) }}"
                                                  data-confirm-title="Excluir tarefa?"
                                                  data-confirm="A tarefa “{{ $tarefa->titulo }}” será apagada. Essa ação não pode ser desfeita."
                                                  data-confirm-button="Excluir tarefa">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="is-danger" aria-label="Excluir tarefa" title="Excluir">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tn-table-foot">
                <span>Mostrando {{ $tarefas->firstItem() }} a {{ $tarefas->lastItem() }} de {{ $tarefas->total() }} {{ $tarefas->total() === 1 ? 'tarefa' : 'tarefas' }}</span>
                @if ($tarefas->hasPages())
                    @php $tarefas->appends(request()->query()); @endphp
                    <nav class="tn-pager-links" aria-label="Paginação">
                        @if ($tarefas->onFirstPage())
                            <span class="is-disabled">Anterior</span>
                        @else
                            <a href="{{ $tarefas->previousPageUrl() }}">Anterior</a>
                        @endif
                        @foreach ($tarefas->getUrlRange(1, $tarefas->lastPage()) as $pagina => $url)
                            @if ($pagina === $tarefas->currentPage())
                                <span class="is-current" aria-current="page">{{ $pagina }}</span>
                            @else
                                <a href="{{ $url }}">{{ $pagina }}</a>
                            @endif
                        @endforeach
                        @if ($tarefas->hasMorePages())
                            <a href="{{ $tarefas->nextPageUrl() }}">Próxima</a>
                        @else
                            <span class="is-disabled">Próxima</span>
                        @endif
                    </nav>
                @endif
            </div>
        @else
            <div class="tn-empty is-flat">
                <x-tn-logo :size="48" />
                @if ($filtro !== '')
                    <p>Nenhuma tarefa com esse status.</p>
                    <a href="{{ route('tarefas.index') }}" class="btn btn-outline">Ver todas as tarefas</a>
                @else
                    <p>Você ainda não tem tarefas. Que tal criar a primeira?</p>
                    <a href="{{ route('tarefas.create') }}" class="btn btn-primary">Criar primeira tarefa</a>
                @endif
            </div>
        @endif
    </section>
</main>
@endsection
