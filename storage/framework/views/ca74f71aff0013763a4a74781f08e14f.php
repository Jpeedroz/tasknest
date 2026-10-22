<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Perfil'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<main class="tn-main">
    <div>
        <h1 class="tn-page-title">Perfil</h1>
        <p class="tn-page-sub">Gerencie seus dados, notificações e a segurança da sua conta.</p>
    </div>

    
    <form method="POST" action="<?php echo e(route('notificacoes.update')); ?>" class="tn-card" id="notificacoes">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <div class="tn-card-body">
            <div style="display: flex; align-items: center; gap: 14px">
                <span class="tn-notif-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </span>
                <div>
                    <h2 class="tn-section-title">Notificações por e-mail</h2>
                    <p class="tn-section-sub">Os lembretes são enviados para <strong style="color: var(--text-2)"><?php echo e($user->email); ?></strong>, a partir das 8h.</p>
                </div>
            </div>

            <?php if(session('status') === 'teste-enviado'): ?>
                <div class="alert alert-success" role="status">E-mail de teste enviado para <?php echo e($user->email); ?>. Confira sua caixa de entrada (e o spam).</div>
            <?php elseif(session('status') === 'teste-falhou'): ?>
                <div class="alert alert-error" role="alert">Não foi possível enviar o e-mail de teste. Confira as configurações de e-mail (MAIL_...) no arquivo .env.</div>
            <?php endif; ?>

            <div class="tn-notif-row">
                <div>
                    <div class="tn-notif-title">Receber lembretes de vencimento</div>
                    <div class="tn-notif-sub">Desligando aqui, nenhum lembrete é enviado, mesmo nas tarefas com o sininho ativo.</div>
                </div>
                <label class="tn-switch">
                    <input type="hidden" name="lembretes_email" value="0">
                    <input type="checkbox" name="lembretes_email" value="1" <?php if(old('lembretes_email', $user->lembretes_email)): echo 'checked'; endif; ?> aria-label="Receber lembretes de vencimento">
                    <span></span>
                </label>
            </div>

            <div class="tn-notif-row">
                <div>
                    <div class="tn-notif-title">Antecedência padrão</div>
                    <div class="tn-notif-sub">Usada quando você liga o sininho de uma tarefa pela lista.</div>
                </div>
                <div class="tn-choice is-fixed">
                    <?php $__currentLoopData = \App\Models\Tarefa::LEMBRETE_OPCOES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dias => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label>
                            <input type="radio" name="lembrete_dias_padrao" value="<?php echo e($dias); ?>" <?php if((int) old('lembrete_dias_padrao', $user->lembrete_dias_padrao ?? 1) === $dias): echo 'checked'; endif; ?>>
                            <span><?php echo e($texto); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php $__errorArgs = ['lembrete_dias_padrao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-text"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="tn-card-footer is-split" style="align-items: center">
            <button type="submit" form="form-email-teste" class="btn btn-outline btn-fixed">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4z"/></svg>
                Enviar e-mail de teste
            </button>
            <div style="display: flex; align-items: center; gap: 12px">
                <?php if(session('status') === 'notificacoes-updated'): ?>
                    <span class="tn-saved" role="status">Preferências salvas.</span>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-fixed">Salvar</button>
            </div>
        </div>
    </form>
    <form method="POST" action="<?php echo e(route('notificacoes.teste')); ?>" id="form-email-teste" hidden>
        <?php echo csrf_field(); ?>
    </form>

    <div class="tn-profile-grid">
        
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="tn-card">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title">Informações pessoais</h2>
                    <p class="tn-section-sub">Nome e e-mail da sua conta.</p>
                </div>
                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <input id="name" name="name" type="text" value="<?php echo e(old('name', $user->name)); ?>" required autocomplete="name"
                           class="input <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-text"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="email" class="label">E-mail</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username"
                           class="input <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-text"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="tn-card-footer" style="align-items: center">
                <?php if(session('status') === 'profile-updated'): ?>
                    <span class="tn-saved" role="status">Dados salvos.</span>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-fixed">Salvar</button>
            </div>
        </form>

        
        <form method="POST" action="<?php echo e(route('password.update')); ?>" class="tn-card">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title">Alterar senha</h2>
                    <p class="tn-section-sub">Use uma senha longa e difícil de adivinhar.</p>
                </div>
                <div class="field">
                    <label for="current_password" class="label">Senha atual</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                           class="input <?php echo e($errors->updatePassword->has('current_password') ? 'is-invalid' : ''); ?>">
                    <?php if($errors->updatePassword->has('current_password')): ?>
                        <span class="error-text"><?php echo e($errors->updatePassword->first('current_password')); ?></span>
                    <?php endif; ?>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="password" class="label">Nova senha</label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="input <?php echo e($errors->updatePassword->has('password') ? 'is-invalid' : ''); ?>">
                    </div>
                    <div class="field">
                        <label for="password_confirmation" class="label">Confirmar</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="input">
                    </div>
                </div>
                <?php if($errors->updatePassword->has('password')): ?>
                    <span class="error-text" style="margin-top: -10px"><?php echo e($errors->updatePassword->first('password')); ?></span>
                <?php endif; ?>
            </div>
            <div class="tn-card-footer" style="align-items: center">
                <?php if(session('status') === 'password-updated'): ?>
                    <span class="tn-saved" role="status">Senha atualizada.</span>
                <?php endif; ?>
                <button type="submit" class="btn btn-outline btn-fixed">Atualizar senha</button>
            </div>
        </form>

        
        <form method="POST" action="<?php echo e(route('profile.destroy')); ?>" class="tn-card tn-danger-zone"
              data-confirm-title="Excluir sua conta?"
              data-confirm="Sua conta e todas as suas tarefas serão apagadas para sempre. Essa ação não pode ser desfeita."
              data-confirm-button="Excluir minha conta">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="tn-card-body">
                <div>
                    <h2 class="tn-section-title" style="color: var(--danger)">Excluir conta</h2>
                    <p class="tn-section-sub">Apaga sua conta e todas as suas tarefas. Não dá para desfazer.</p>
                </div>
                <div class="field" style="max-width: 360px">
                    <label for="delete_password" class="label">Digite sua senha para confirmar</label>
                    <input id="delete_password" name="password" type="password" required placeholder="Sua senha"
                           class="input <?php echo e($errors->userDeletion->has('password') ? 'is-invalid' : ''); ?>">
                    <?php if($errors->userDeletion->has('password')): ?>
                        <span class="error-text"><?php echo e($errors->userDeletion->first('password')); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tn-card-footer">
                <button type="submit" class="btn btn-danger btn-fixed">Excluir minha conta</button>
            </div>
        </form>
    </div>
</main>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/profile/edit.blade.php ENDPATH**/ ?>