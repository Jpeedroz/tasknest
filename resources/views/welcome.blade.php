<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('partials.head', ['title' => null])
</head>
<body class="tn">
    <div class="tn-landing">
        <header class="tn-landing-top">
            <a href="{{ url('/') }}" class="tn-brand" aria-label="TaskNest">
                <x-tn-logo :size="30" />
                <span class="tn-brand-name">Task<span>Nest</span></span>
            </a>
            <div class="tn-topbar-right">
                <x-tn-theme-toggle />
                <a href="{{ route('login') }}" class="tn-login-link">Entrar</a>
            </div>
        </header>

        <main class="tn-hero">
            <div class="tn-hero-mark" aria-hidden="true">
                <svg class="tn-hero-ring" viewBox="0 0 32 32" fill="none"><path d="M16 2.5l11.7 6.75v13.5L16 29.5 4.3 22.75V9.25z" stroke-opacity=".35" stroke-width=".5" stroke-linejoin="round"/></svg>
                <svg class="tn-hero-ring is-late" viewBox="0 0 32 32" fill="none"><path d="M16 2.5l11.7 6.75v13.5L16 29.5 4.3 22.75V9.25z" stroke-opacity=".35" stroke-width=".5" stroke-linejoin="round"/></svg>
                <x-tn-logo :size="96" class="tn-hero-logo" />
            </div>

            <h1>Suas tarefas diárias, no lugar <span>certo.</span></h1>
            <p>Organize o seu dia, acompanhe prazos e conclua o que importa.</p>

            <a href="{{ route('register') }}" class="btn btn-primary">
                Começar agora
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
            </a>
        </main>

        <footer class="tn-landing-foot">© {{ date('Y') }} TaskNest</footer>
    </div>
</body>
</html>
