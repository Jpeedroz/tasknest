<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo $__env->make('partials.head', ['title' => $title ?? null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="tn">
    <div class="tn-auth">
        <svg class="tn-auth-bg" viewBox="0 0 400 400" fill="none" aria-hidden="true">
            <path d="M200 20l155.9 90v180L200 380 44.1 290V110z" stroke-opacity=".07" stroke-width="1.2"/>
            <path d="M200 70l112.6 65v130L200 330 87.4 265V135z" stroke-opacity=".09" stroke-width="1.2"/>
            <path d="M200 120l69.3 40v80L200 280l-69.3-40v-80z" stroke-opacity=".11" stroke-width="1.2"/>
        </svg>

        <div class="tn-auth-top">
            <a href="<?php echo e(url('/')); ?>" class="tn-auth-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
                Voltar ao início
            </a>
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
        </div>

        <main class="tn-auth-center">
            <a href="<?php echo e(url('/')); ?>" class="tn-auth-brand" aria-label="TaskNest — página inicial">
                <?php if (isset($component)) { $__componentOriginal58216d62b6ff9703dfabb7e42814850b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58216d62b6ff9703dfabb7e42814850b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-logo','data' => ['size' => 40]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 40]); ?>
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

            <div class="tn-auth-card">
                <?php echo e($slot); ?>

            </div>

            <?php if(isset($footer)): ?>
                <p class="tn-auth-foot"><?php echo e($footer); ?></p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH /tmp/claude-0/full/tasknest/resources/views/layouts/guest.blade.php ENDPATH**/ ?>