<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['size' => 30]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['size' => 30]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<svg width="<?php echo e($size); ?>" height="<?php echo e($size); ?>" viewBox="0 0 32 32" fill="none" aria-hidden="true" <?php echo e($attributes); ?>>
    <path class="tn-logo-hex" d="M16 2.5l11.7 6.75v13.5L16 29.5 4.3 22.75V9.25z" stroke-width="2" stroke-linejoin="round"/>
    <path class="tn-logo-inner" d="M16 8.6l6.4 3.7v7.4L16 23.4l-6.4-3.7v-7.4z" stroke-width="1.4" stroke-linejoin="round"/>
    <path class="tn-logo-check" d="M12.6 16.2l2.5 2.5 4.6-5" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/components/tn-logo.blade.php ENDPATH**/ ?>