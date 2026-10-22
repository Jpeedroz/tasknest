<?php $__env->startSection('title', 'Editar tarefa'); ?>

<?php $__env->startSection('content'); ?>
<main class="tn-main">
    <a href="<?php echo e(route('tarefas.show', $tarefa)); ?>" class="tn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/></svg>
        Voltar para a tarefa
    </a>

    <div>
        <h1 class="tn-page-title">Editar tarefa</h1>
        <p class="tn-page-sub">
            Criada em <?php echo e($tarefa->created_at->format('d/m/Y H:i')); ?>

            <?php if($tarefa->updated_at && $tarefa->updated_at->ne($tarefa->created_at)): ?>
                · atualizada em <?php echo e($tarefa->updated_at->format('d/m/Y H:i')); ?>

            <?php endif; ?>
        </p>
    </div>

    <div class="tn-form-layout">
        <form method="POST" action="<?php echo e(route('tarefas.update', $tarefa)); ?>" class="tn-card" data-form-tarefa>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="tn-card-body">
                <?php echo $__env->make('tarefas._campos', ['tarefa' => $tarefa], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <p class="hint" style="margin: 0">Para mudar o status, use o botão Iniciar, Concluir ou Reabrir na lista de tarefas.</p>
            </div>
            <div class="tn-card-footer">
                <a href="<?php echo e(route('tarefas.index')); ?>" class="btn btn-outline btn-fixed">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-fixed">Salvar alterações</button>
            </div>
        </form>

        <?php echo $__env->make('tarefas._preview', ['status' => $tarefa->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/claude-0/full/tasknest/resources/views/tarefas/edit.blade.php ENDPATH**/ ?>