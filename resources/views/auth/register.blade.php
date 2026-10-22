<x-guest-layout title="Criar conta">
    <div>
        <h1 class="tn-auth-title">Criar sua conta</h1>
        <p class="tn-auth-sub">Leva menos de um minuto.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field">
            <label for="name" class="label">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Seu nome completo" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}">
            @error('name')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label for="email" class="label">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="voce@email.com" class="input {{ $errors->has('email') ? 'is-invalid' : '' }}">
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field-row">
            <div class="field">
                <label for="password" class="label">Senha</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="••••••••" class="input {{ $errors->has('password') ? 'is-invalid' : '' }}">
            </div>
            <div class="field">
                <label for="password_confirmation" class="label">Confirmar senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="••••••••" class="input">
            </div>
        </div>
        @error('password')
            <span class="error-text">{{ $message }}</span>
        @else
            <span class="hint" style="margin-top: -6px">Use pelo menos 8 caracteres.</span>
        @enderror

        <button type="submit" class="btn btn-primary btn-block">Criar conta</button>
    </form>

    <x-slot name="footer">
        Já tem conta? <a href="{{ route('login') }}">Entrar</a>
    </x-slot>
</x-guest-layout>
