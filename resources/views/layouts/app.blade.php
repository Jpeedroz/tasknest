<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('partials.head', ['title' => trim($__env->yieldContent('title')) ?: ($title ?? null)])
</head>
<body class="tn">
    @auth
        @php
            $usuario = Auth::user();
            $partesNome = preg_split('/\s+/', trim($usuario->name));
            $iniciais = mb_substr($partesNome[0], 0, 1) . (count($partesNome) > 1 ? mb_substr(end($partesNome), 0, 1) : '');

            // Tarefas com o sininho ligado (para o sino do topo)
            $lembretesAtivos = $usuario->tarefas()
                ->where('lembrete_ativo', true)
                ->where('status', '!=', 'concluida')
                ->whereNotNull('data_vencimento')
                ->orderBy('data_vencimento')
                ->get();
        @endphp
    @endauth

    <div class="tn-topbar-wrap">
        <header class="tn-topbar">
            <a href="{{ route('tarefas.index') }}" class="tn-brand" aria-label="TaskNest — minhas tarefas">
                <x-tn-logo :size="32" />
                <span class="tn-brand-name">Task<span>Nest</span></span>
            </a>

            @auth
                <nav class="tn-topnav" aria-label="Menu principal">
                    <a href="{{ route('tarefas.index') }}" class="{{ request()->routeIs('tarefas.*') ? 'is-active' : '' }}"
                       @if (request()->routeIs('tarefas.*')) aria-current="page" @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Tarefas
                    </a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'is-active' : '' }}"
                       @if (request()->routeIs('profile.*')) aria-current="page" @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        Perfil
                    </a>
                </nav>
            @endauth

            <div class="tn-topbar-right">
                @auth
                    {{-- Sino: lembretes ativos --}}
                    <details class="tn-menu tn-bell">
                        <summary class="tn-ghost-btn" aria-label="Lembretes por e-mail ativos: {{ $lembretesAtivos->count() }}" title="Lembretes por e-mail">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                            @if ($lembretesAtivos->count() > 0)
                                <span class="tn-bell-count">{{ $lembretesAtivos->count() }}</span>
                            @endif
                        </summary>
                        <div class="tn-menu-panel tn-bell-panel">
                            <div class="tn-menu-head">
                                <strong>Lembretes por e-mail</strong>
                                @unless ($usuario->lembretes_email)
                                    <span class="tn-menu-warn">Desligados no perfil</span>
                                @endunless
                            </div>
                            @forelse ($lembretesAtivos as $lembrete)
                                <a href="{{ route('tarefas.show', $lembrete) }}" class="tn-bell-item">
                                    <span class="tn-color-dot" style="background: {{ $lembrete->corHex() ?? 'var(--border-2)' }}"></span>
                                    <span class="tn-bell-text">
                                        <span class="tn-bell-title">{{ $lembrete->titulo }}</span>
                                        <span class="tn-bell-sub">
                                            Vence {{ $lembrete->data_vencimento->format('d/m') }} ·
                                            {{ $lembrete->lembrete_enviado_em ? 'e-mail enviado' : 'e-mail ' . mb_strtolower($lembrete->lembreteQuando()) }}
                                        </span>
                                    </span>
                                </a>
                            @empty
                                <p class="tn-menu-empty">Nenhum lembrete ativo. Clique no sininho de uma tarefa para ativar.</p>
                            @endforelse
                            <a href="{{ route('profile.edit') }}#notificacoes" class="tn-menu-foot">Configurar notificações</a>
                        </div>
                    </details>
                @endauth

                <button type="button" class="tn-ghost-btn tn-theme-toggle" onclick="tnToggleTheme()" aria-label="Alternar tema claro ou escuro" title="Alternar tema">
                    <svg class="icon-moon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
                    <svg class="icon-sun" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                </button>

                @auth
                    <span class="tn-divider" aria-hidden="true"></span>

                    <details class="tn-menu tn-user">
                        <summary aria-label="Menu do usuário">
                            <span class="tn-avatar">{{ $iniciais }}</span>
                            <span class="tn-user-text">
                                <span class="tn-user-name">{{ $usuario->name }}</span>
                                <span class="tn-user-mail">{{ $usuario->email }}</span>
                            </span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="tn-chevron"><path d="M6 9l6 6 6-6"/></svg>
                        </summary>
                        <div class="tn-menu-panel">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="tn-menu-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </details>
                @endauth
            </div>
        </header>
    </div>

    @hasSection('content')
        @yield('content')
    @elseif(isset($slot))
        {{ $slot }}
    @endif

    <x-tn-confirm-dialog />

    <script>
        // Fecha os menus (sino e usuário) ao clicar fora ou apertar Esc
        document.addEventListener('click', function (e) {
            document.querySelectorAll('details.tn-menu[open]').forEach(function (m) {
                if (!m.contains(e.target)) m.removeAttribute('open');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('details.tn-menu[open]').forEach(function (m) { m.removeAttribute('open'); });
        });
    </script>
</body>
</html>
