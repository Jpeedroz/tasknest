<x-guest-layout title="Entrar">
    <div>
        <h1 class="tn-auth-title">Entrar na sua conta</h1>
        <p class="tn-auth-sub">Bem-vindo de volta! Informe seus dados.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email" class="label">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="voce@email.com" class="input {{ $errors->has('email') ? 'is-invalid' : '' }}">
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <div class="tn-row-between">
                <label for="password" class="label">Senha</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="tn-link-sm">Esqueceu a senha?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••" class="input {{ $errors->has('password') ? 'is-invalid' : '' }}">
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <label for="remember_me" class="check">
            <input id="remember_me" type="checkbox" name="remember">
            Lembrar de mim
        </label>

        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>

    <x-slot name="footer">
        Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
    </x-slot>
</x-guest-layout>
