<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('partials.head', ['title' => $title ?? null])
</head>
<body class="tn">
    <div class="tn-auth">
        <svg class="tn-auth-bg" viewBox="0 0 400 400" fill="none" aria-hidden="true">
            <path d="M200 20l155.9 90v180L200 380 44.1 290V110z" stroke-opacity=".07" stroke-width="1.2"/>
            <path d="M200 70l112.6 65v130L200 330 87.4 265V135z" stroke-opacity=".09" stroke-width="1.2"/>
            <path d="M200 120l69.3 40v80L200 280l-69.3-40v-80z" stroke-opacity=".11" stroke-width="1.2"/>
        </svg>

        <div class="tn-auth-top">
            <a href="{{ url('/') }}" class="tn-auth-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
                Voltar ao início
            </a>
            <x-tn-theme-toggle />
        </div>

        <main class="tn-auth-center">
            <a href="{{ url('/') }}" class="tn-auth-brand" aria-label="TaskNest — página inicial">
                <x-tn-logo :size="40" />
                <span class="tn-brand-name">Task<span>Nest</span></span>
            </a>

            <div class="tn-auth-card">
                {{ $slot }}
            </div>

            @isset($footer)
                <p class="tn-auth-foot">{{ $footer }}</p>
            @endisset
        </main>
    </div>
</body>
</html>
