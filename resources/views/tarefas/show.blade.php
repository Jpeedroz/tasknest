@extends('layouts.app')

@section('title', $tarefa->titulo)

@section('content')
@php
    $prazo = $tarefa->prazo();
    $classeAcao = match ($tarefa->status) {
        'pendente' => 'btn-primary',
        'em_andamento' => 'btn-success',
        default => 'btn-outline',
    };
    $textoAcao = match ($tarefa->status) {
        'pendente' => 'Iniciar tarefa',
        'em_andamento' => 'Concluir tarefa',
        default => 'Reabrir tarefa',
    };
@endphp

<main class="tn-main is-medium">
    <a href="{{ route('tarefas.index') }}" class="tn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
        Voltar para a lista de tarefas
    </a>

    @include('partials.alertas')

    <article class="tn-card">
        <div class="tn-card-body">
            <div class="tn-detail-head">
                <div>
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px">
                        <span class="tn-status st-{{ $tarefa->status }}"><span class="tn-status-dot"></span>{{ $tarefa->statusLabel() }}</span>
                        <span class="tn-detail-color"><span style="background: {{ $tarefa->corHex() ?? 'var(--border-2)' }}"></span>{{ $tarefa->corNome() }}</span>
                    </div>
                    <h1 class="tn-detail-title">{{ $tarefa->titulo }}</h1>
                </div>
                <form method="POST" action="{{ route('tarefas.toggle-status', $tarefa) }}" style="margin: 0">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $classeAcao }}">
                        @if ($tarefa->status === 'em_andamento')
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
                        @endif
                        {{ $textoAcao }}
                    </button>
                </form>
            </div>

            <div>
                <h2 class="tn-section-label">Descrição</h2>
                @if ($tarefa->descricao)
                    <div class="tn-desc-box">{{ $tarefa->descricao }}</div>
                @else
                    <div class="tn-desc-box" style="color: var(--muted)">Sem descrição.</div>
                @endif
            </div>

            <div class="tn-stats">
                <div class="tn-stat">
                    <div class="tn-stat-label">Data de vencimento</div>
                    @if ($tarefa->data_vencimento)
                        <div class="tn-stat-value">{{ $tarefa->data_vencimento->format('d/m/Y') }}</div>
                        @if ($tarefa->status !== 'concluida')
                            @if ($prazo['dias'] < 0)
                                <div class="tn-stat-note is-late">Atrasada há {{ abs($prazo['dias']) }} {{ abs($prazo['dias']) === 1 ? 'dia' : 'dias' }}</div>
                            @elseif ($prazo['dias'] === 0)
                                <div class="tn-stat-note is-warn">Vence hoje</div>
                            @elseif ($prazo['dias'] <= 3)
                                <div class="tn-stat-note is-warn">Vence em {{ $prazo['dias'] }} {{ $prazo['dias'] === 1 ? 'dia' : 'dias' }}</div>
                            @else
                                <div class="tn-stat-note">Faltam {{ $prazo['dias'] }} dias</div>
                            @endif
                        @endif
                    @else
                        <div class="tn-stat-value">—</div>
                        <div class="tn-stat-note">Sem prazo definido</div>
                    @endif
                </div>
                <div class="tn-stat">
                    <div class="tn-stat-label">Data de criação</div>
                    <div class="tn-stat-value">{{ $tarefa->created_at->format('d/m/Y') }}</div>
                    <div class="tn-stat-note">às {{ $tarefa->created_at->format('H:i') }}</div>
                </div>
                <div class="tn-stat">
                    <div class="tn-stat-label">Última atualização</div>
                    <div class="tn-stat-value">{{ $tarefa->updated_at->format('d/m/Y') }}</div>
                    <div class="tn-stat-note">às {{ $tarefa->updated_at->format('H:i') }}</div>
                </div>
                <div class="tn-stat">
                    <div class="tn-stat-label">Lembrete por e-mail</div>
                    @if ($tarefa->lembreteLigado())
                        <div class="tn-stat-value">{{ $tarefa->lembreteQuando() }}</div>
                        <div class="tn-stat-note">
                            {{ $tarefa->lembrete_enviado_em ? 'Enviado em ' . $tarefa->lembrete_enviado_em->format('d/m H:i') : 'Envio em ' . $tarefa->dataEnvioLembrete()->format('d/m') . ', a partir das 8h' }}
                        </div>
                    @else
                        <div class="tn-stat-value">Desligado</div>
                        <div class="tn-stat-note">{{ $tarefa->podeTerLembrete() ? 'Ative pelo sininho abaixo' : ($tarefa->data_vencimento ? 'Tarefa concluída' : 'Precisa de data de vencimento') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tn-card-footer is-split">
            <form method="POST" action="{{ route('tarefas.destroy', $tarefa) }}"
                  data-confirm-title="Excluir tarefa?"
                  data-confirm="A tarefa “{{ $tarefa->titulo }}” será apagada. Essa ação não pode ser desfeita."
                  data-confirm-button="Excluir tarefa">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Excluir
                </button>
            </form>
            <div style="display: flex; gap: 10px; flex-wrap: wrap">
            @if ($tarefa->podeTerLembrete())
                <form method="POST" action="{{ route('tarefas.toggle-lembrete', $tarefa) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline btn-fixed">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $tarefa->lembreteLigado() ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" fill="none"/></svg>
                        {{ $tarefa->lembreteLigado() ? 'Desligar lembrete' : 'Ligar lembrete' }}
                    </button>
                </form>
            @endif
            <a href="{{ route('tarefas.edit', $tarefa) }}" class="btn btn-outline btn-fixed">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
                Editar tarefa
            </a>
            </div>
        </div>
    </article>
</main>
@endsection
