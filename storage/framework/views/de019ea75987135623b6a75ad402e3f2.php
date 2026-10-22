<?php if(session('success')): ?>
    <div class="alert alert-success" role="status">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>
        <span><?php echo e(session('success')); ?></span>
        <button type="button" class="alert-close" aria-label="Fechar aviso" onclick="this.parentElement.remove()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-error" role="alert">
        <span><?php echo e(session('error')); ?></span>
        <button type="button" class="alert-close" aria-label="Fechar aviso" onclick="this.parentElement.remove()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/partials/alertas.blade.php ENDPATH**/ ?>