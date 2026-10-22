<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo $__env->make('partials.head', ['title' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="tn">
    <div class="tn-landing">
        <header class="tn-landing-top">
            <a href="<?php echo e(url('/')); ?>" class="tn-brand" aria-label="TaskNest">
                <?php if (isset($component)) { $__componentOriginal58216d62b6ff9703dfabb7e42814850b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58216d62b6ff9703dfabb7e42814850b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-logo','data' => ['size' => 30]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 30]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal58216d62b6ff9703dfabb7e42814850b)): ?>
<?php $attributes = $__attributesOriginal58216d62b6ff9703dfabb7e42814850b; ?>
<?php unset($__attributesOriginal58216d62b6ff9703dfabb7e42814850b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal58216d62b6ff9703dfabb7e42814850b)): ?>
<?php $component = $__componentOriginal58216d62b6ff9703dfabb7e42814850b; ?>
<?php unset($__componentOriginal58216d62b6ff9703dfabb7e42814850b); ?>
<?php endif; ?>
                <span class="tn-brand-name">Task<span>Nest</span></span>
            </a>
            <div class="tn-topbar-right">
                <?php if (isset($component)) { $__componentOriginald257bee1c47ec093995470333c0d01bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald257bee1c47ec093995470333c0d01bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-theme-toggle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-theme-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald257bee1c47ec093995470333c0d01bc)): ?>
<?php $attributes = $__attributesOriginald257bee1c47ec093995470333c0d01bc; ?>
<?php unset($__attributesOriginald257bee1c47ec093995470333c0d01bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald257bee1c47ec093995470333c0d01bc)): ?>
<?php $component = $__componentOriginald257bee1c47ec093995470333c0d01bc; ?>
<?php unset($__componentOriginald257bee1c47ec093995470333c0d01bc); ?>
<?php endif; ?>
                <a href="<?php echo e(route('login')); ?>" class="tn-login-link">Entrar</a>
            </div>
        </header>

        <main class="tn-hero">
            <div class="tn-hero-mark" aria-hidden="true">
                <svg class="tn-hero-ring" viewBox="0 0 32 32" fill="none"><path d="M16 2.5l11.7 6.75v13.5L16 29.5 4.3 22.75V9.25z" stroke-opacity=".35" stroke-width=".5" stroke-linejoin="round"/></svg>
                <svg class="tn-hero-ring is-late" viewBox="0 0 32 32" fill="none"><path d="M16 2.5l11.7 6.75v13.5L16 29.5 4.3 22.75V9.25z" stroke-opacity=".35" stroke-width=".5" stroke-linejoin="round"/></svg>
                <?php if (isset($component)) { $__componentOriginal58216d62b6ff9703dfabb7e42814850b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58216d62b6ff9703dfabb7e42814850b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-logo','data' => ['size' => 96,'class' => 'tn-hero-logo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 96,'class' => 'tn-hero-logo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal58216d62b6ff9703dfabb7e42814850b)): ?>
<?php $attributes = $__attributesOriginal58216d62b6ff9703dfabb7e42814850b; ?>
<?php unset($__attributesOriginal58216d62b6ff9703dfabb7e42814850b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal58216d62b6ff9703dfabb7e42814850b)): ?>
<?php $component = $__componentOriginal58216d62b6ff9703dfabb7e42814850b; ?>
<?php unset($__componentOriginal58216d62b6ff9703dfabb7e42814850b); ?>
<?php endif; ?>
            </div>

            <h1>Suas tarefas diárias, no lugar <span>certo.</span></h1>
            <p>Organize o seu dia, acompanhe prazos e conclua o que importa.</p>

            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                Começar agora
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
            </a>
        </main>

        <footer class="tn-landing-foot">© <?php echo e(date('Y')); ?> TaskNest</footer>
    </div>
</body>
</html>
<?php /**PATH /tmp/claude-0/full/tasknest/resources/views/welcome.blade.php ENDPATH**/ ?>