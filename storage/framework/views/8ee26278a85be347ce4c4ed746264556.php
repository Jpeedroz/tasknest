<?php $__env->startSection('title', 'Nova tarefa'); ?>

<?php $__env->startSection('content'); ?>
<main class="tn-main">
    <a href="<?php echo e(route('tarefas.index')); ?>" class="tn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
        Voltar para a lista de tarefas
    </a>

    <div>
        <h1 class="tn-page-title">Nova tarefa</h1>
        <p class="tn-page-sub">Escolha uma cor para identificar a tarefa de longe, como uma etiqueta.</p>
    </div>

    <div class="tn-form-layout">
        <form method="POST" action="<?php echo e(route('tarefas.store')); ?>" class="tn-card" data-form-tarefa>
            <?php echo csrf_field(); ?>
            <div class="tn-card-body">
                <?php echo $__env->make('tarefas._campos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="tn-card-footer">
                <a href="<?php echo e(route('tarefas.index')); ?>" class="btn btn-outline btn-fixed">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-fixed">Criar tarefa</button>
            </div>
        </form>

        <?php echo $__env->make('tarefas._preview', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/tarefas/create.blade.php ENDPATH**/ ?>