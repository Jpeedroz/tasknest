<x-app-layout title="Perfil">
<main class="tn-main">
    <div>
        <h1 class="tn-page-title">Perfil</h1>
        <p class="tn-page-sub">Gerencie seus dados, notificações e a segurança da sua conta.</p>
    </div>

    {{-- Notificações por e-mail --}}
    <form method="POST" action="{{ route('notificacoes.update') }}" class="tn-card" id="notificacoes">
        @csrf
        @method('PATCH')
        <div class="tn-card-body">
            <div style="display: flex; align-items: center; gap: 14px">
                <span class="tn-notif-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </span>
                <div>
                    <h2 class="tn-section-title">Notificações por e-mail</h2>
                    <p class="tn-section-sub">Os lembretes são enviados para <strong style="color: var(--text-2)">{{ $user->email }}</strong>, a partir das 8h.</p>
                </div>
            </div>

            @if (session('status') === 'teste-enviado')
                <div class="alert alert-success" role="status">E-mail de teste enviado para {{ $user->email }}. Confira sua caixa de entrada (e o spam).</div>
            @elseif (session('status') === 'teste-falhou')
                <div class="alert alert-error" role="alert">Não foi possível enviar o e-mail de teste. Confira as configurações de e-mail (MAIL_...) no arquivo .env.</div>
            @endif

            <div class="tn-notif-row">
                <div>
                    <div class="tn-notif-title">Receber lembretes de vencimento</div>
                    <div class="tn-notif-sub">Desligando aqui, nenhum lembrete é enviado, mesmo nas tarefas com o sininho ativo.</div>
                </div>
                <label class="tn-switch">
                    <input type="hidden" name="lembretes_email" value="0">
                    <input type="checkbox" name="lembretes_email" value="1" @checked(old('lembretes_email', $user->lembretes_email)) aria-label="Receber lembretes de vencimento">
                    <span></span>
                </label>
            </div>

            <div class="tn-notif-row">
                <div>
                    <div class="tn-notif-title">Antecedência padrão</div>
                    <div class="tn-notif-sub">Usada quando você liga o sininho de uma tarefa pela lista.</div>
                </div>
                <div class="tn-choice is-fixed">
                    @foreach (\App\Models\Tarefa::LEMBRETE_OPCOES as $dias => $texto)
                        <label>
                            <input type="radio" name="lembrete_dias_padrao" value="{{ $dias }}" @checked((int) old('lembrete_dias_padrao', $user->lembrete_dias_padrao ?? 1) === $dias)>
                            <span>{{ $texto }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @error('lembrete_dias_padrao') <span class="error-text">{{ $message }}</span> @enderror
        </div>
        <div class="tn-card-footer is-split" style="align-items: center">
            <button type="submit" form="form-email-teste" class="btn btn-outline btn-fixed">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4z"/></svg>
                Enviar e-mail de teste
            </button>
            <div style="display: flex; align-items: center; gap: 12px">
                @if (session('status') === 'notificacoes-updated')
                    <span class="tn-saved" role="status">Preferências salvas.</span>
                @endif
                <button type="submit" class="btn btn-primary btn-fixed">Salvar</button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('notificacoes.teste') }}" id="form-email-teste" hidden>
        @csrf
    </form>

    <div class="tn-profile-grid">
        {{-- Informações pessoais --}}
        <form method="POST" action="{{ route('profile.update') }}" class="tn-card">
            @csrf
            @method('PATCH')
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title">Informações pessoais</h2>
                    <p class="tn-section-sub">Nome e e-mail da sua conta.</p>
                </div>
                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                           class="input {{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="email" class="label">E-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="input {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="tn-card-footer" style="align-items: center">
                @if (session('status') === 'profile-updated')
                    <span class="tn-saved" role="status">Dados salvos.</span>
                @endif
                <button type="submit" class="btn btn-primary btn-fixed">Salvar</button>
            </div>
        </form>

        {{-- Alterar senha --}}
        <form method="POST" action="{{ route('password.update') }}" class="tn-card">
            @csrf
            @method('PUT')
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title">Alterar senha</h2>
                    <p class="tn-section-sub">Use uma senha longa e difícil de adivinhar.</p>
                </div>
                <div class="field">
                    <label for="current_password" class="label">Senha atual</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                           class="input {{ $errors->updatePassword->has('current_password') ? 'is-invalid' : '' }}">
                    @if ($errors->updatePassword->has('current_password'))
                        <span class="error-text">{{ $errors->updatePassword->first('current_password') }}</span>
                    @endif
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="password" class="label">Nova senha</label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="input {{ $errors->updatePassword->has('password') ? 'is-invalid' : '' }}">
                    </div>
                    <div class="field">
                        <label for="password_confirmation" class="label">Confirmar</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="input">
                    </div>
                </div>
                @if ($errors->updatePassword->has('password'))
                    <span class="error-text" style="margin-top: -10px">{{ $errors->updatePassword->first('password') }}</span>
                @endif
            </div>
            <div class="tn-card-footer" style="align-items: center">
                @if (session('status') === 'password-updated')
                    <span class="tn-saved" role="status">Senha atualizada.</span>
                @endif
                <button type="submit" class="btn btn-outline btn-fixed">Atualizar senha</button>
            </div>
        </form>

        {{-- Excluir conta --}}
        <form method="POST" action="{{ route('profile.destroy') }}" class="tn-card tn-danger-zone"
              data-confirm-title="Excluir sua conta?"
              data-confirm="Sua conta e todas as suas tarefas serão apagadas para sempre. Essa ação não pode ser desfeita."
              data-confirm-button="Excluir minha conta">
            @csrf
            @method('DELETE')
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title" style="color: var(--danger)">Excluir conta</h2>
                    <p class="tn-section-sub">Apaga sua conta e todas as suas tarefas. Não dá para desfazer.</p>
                </div>
                <div class="field" style="max-width: 360px">
                    <label for="delete_password" class="label">Digite sua senha para confirmar</label>
                    <input id="delete_password" name="password" type="password" required placeholder="Sua senha"
                           class="input {{ $errors->userDeletion->has('password') ? 'is-invalid' : '' }}">
                    @if ($errors->userDeletion->has('password'))
                        <span class="error-text">{{ $errors->userDeletion->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="tn-card-footer">
                <button type="submit" class="btn btn-danger btn-fixed">Excluir minha conta</button>
            </div>
        </form>
    </div>
</main>
</x-app-layout>
