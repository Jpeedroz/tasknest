<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve(['title' => 'Entrar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div>
        <h1 class="tn-auth-title">Entrar na sua conta</h1>
        <p class="tn-auth-sub">Bem-vindo de volta! Informe seus dados.</p>
    </div>

    <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="field">
            <label for="email" class="label">E-mail</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                   placeholder="voce@email.com" class="input <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-text"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="field">
            <div class="tn-row-between">
                <label for="password" class="label">Senha</label>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="tn-link-sm">Esqueceu a senha?</a>
                <?php endif; ?>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••" class="input <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error-text"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <label for="remember_me" class="check">
            <input id="remember_me" type="checkbox" name="remember">
            Lembrar de mim
        </label>

        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>

     <?php $__env->slot('footer', null, []); ?> 
        Ainda não tem conta? <a href="<?php echo e(route('register')); ?>">Cadastre-se</a>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/auth/login.blade.php ENDPATH**/ ?>