<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve(['title' => 'Criar conta'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div>
        <h1 class="tn-auth-title">Criar sua conta</h1>
        <p class="tn-auth-sub">Leva menos de um minuto.</p>
    </div>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="field">
            <label for="name" class="label">Nome</label>
            <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name"
                   placeholder="Seu nome completo" class="input <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>">
            <?php $__errorArgs = ['name'];
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
            <label for="email" class="label">E-mail</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="username"
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

        <div class="field-row">
            <div class="field">
                <label for="password" class="label">Senha</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="••••••••" class="input <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>">
            </div>
            <div class="field">
                <label for="password_confirmation" class="label">Confirmar senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="••••••••" class="input">
            </div>
        </div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="error-text"><?php echo e($message); ?></span>
        <?php else: ?>
            <span class="hint" style="margin-top: -6px">Use pelo menos 8 caracteres.</span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit" class="btn btn-primary btn-block">Criar conta</button>
    </form>

     <?php $__env->slot('footer', null, []); ?> 
        Já tem conta? <a href="<?php echo e(route('login')); ?>">Entrar</a>
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
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/auth/register.blade.php ENDPATH**/ ?>