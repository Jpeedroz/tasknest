<?php $__env->startSection('title', 'Minhas tarefas'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $filtro = request('status', '');
    $abas = [
        '' => 'Todas',
        'pendente' => 'Pendentes',
        'em_andamento' => 'Em andamento',
        'concluida' => 'Concluídas',
    ];
    $cartoes = [
        ['Total', $contagem['todas'], ''],
        ['Pendentes', $contagem['pendente'], 'is-pendente'],
        ['Em andamento', $contagem['em_andamento'], 'is-andamento'],
        ['Concluídas', $contagem['concluida'], 'is-concluida'],
    ];
?>

<main class="tn-main">
    <div class="tn-page-head is-center">
        <div>
            <h1 class="tn-page-title">Minhas tarefas</h1>
            <p class="tn-page-sub">Acompanhe prazos e o andamento das suas atividades.</p>
        </div>
        <a href="<?php echo e(route('tarefas.create')); ?>" class="btn btn-primary btn-lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Nova tarefa
        </a>
    </div>

    <?php echo $__env->make('partials.alertas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="tn-stat-cards">
        <?php $__currentLoopData = $cartoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$nome, $qtd, $classe]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tn-stat-card <?php echo e($classe); ?>">
                <span class="tn-stat-card-label"><?php echo e($nome); ?></span>
                <span class="tn-stat-card-value"><?php echo e($qtd); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <section class="tn-table-card">
        <div class="tn-table-toolbar">
            <nav class="tn-seg" aria-label="Filtrar por status">
                <?php $__currentLoopData = $abas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $nome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($valor === '' ? route('tarefas.index') : route('tarefas.index', ['status' => $valor])); ?>"
                       class="<?php echo e($filtro === $valor ? 'is-active' : ''); ?>"
                       <?php if($filtro === $valor): ?> aria-current="page" <?php endif; ?>><?php echo e($nome); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <span class="tn-muted">Mais recentes primeiro</span>
        </div>

        <?php if($tarefas->count() > 0): ?>
            <div class="tn-table-scroll">
                <table class="tn-table">
                    <thead>
                        <tr>
                            <th scope="col">Tarefa</th>
                            <th scope="col" class="col-status">Status</th>
                            <th scope="col" class="col-venc">Vencimento</th>
                            <th scope="col" class="col-acoes">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tarefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $prazo = $tarefa->prazo();
                                $classeAcao = match ($tarefa->status) {
                                    'pendente' => 'btn-start',
                                    'em_andamento' => 'btn-success',
                                    default => 'btn-reopen',
                                };
                                $ligado = $tarefa->lembreteLigado();
                                $tituloSino = ! $tarefa->data_vencimento
                                    ? 'Defina uma data de vencimento para ativar o lembrete'
                                    : ($tarefa->status === 'concluida'
                                        ? 'Tarefa concluída — sem lembrete'
                                        : ($ligado ? 'Lembrete ativo (' . mb_strtolower($tarefa->lembreteQuando()) . ') — clique para desativar' : 'Ativar lembrete por e-mail'));
                            ?>
                            <tr class="<?php echo e($tarefa->status === 'concluida' ? 'is-done' : ''); ?>">
                                <td>
                                    <div class="tn-cell-task">
                                        <span class="tn-color-bar" style="background: <?php echo e($tarefa->corHex() ?? 'var(--border-2)'); ?>" title="Cor: <?php echo e($tarefa->corNome()); ?>"></span>
                                        <div class="tn-cell-text">
                                            <a href="<?php echo e(route('tarefas.show', $tarefa)); ?>" class="tn-cell-title"><?php echo e($tarefa->titulo); ?></a>
                                            <?php if($tarefa->descricao): ?>
                                                <span class="tn-cell-desc"><?php echo e(\Illuminate\Support\Str::limit($tarefa->descricao, 70)); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-status">
                                    <span class="tn-status st-<?php echo e($tarefa->status); ?>">
                                        <span class="tn-status-dot"></span><?php echo e($tarefa->statusLabel()); ?>

                                    </span>
                                </td>
                                <td class="col-venc">
                                    <?php if($tarefa->data_vencimento): ?>
                                        <span class="tn-date"><?php echo e($tarefa->data_vencimento->format('d/m/Y')); ?></span>
                                    <?php else: ?>
                                        <span class="tn-date">—</span>
                                    <?php endif; ?>
                                    <span class="tn-date-rel <?php echo e($prazo['atrasada'] ? 'is-late' : ($prazo['urgente'] ? 'is-urgent' : '')); ?>"><?php echo e($prazo['curto']); ?></span>
                                </td>
                                <td class="col-acoes">
                                    <div class="tn-actions">
                                        <form method="POST" action="<?php echo e(route('tarefas.toggle-lembrete', $tarefa)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="tn-bell-btn <?php echo e($ligado ? 'is-on' : ''); ?>"
                                                    aria-label="<?php echo e($tituloSino); ?>" title="<?php echo e($tituloSino); ?>"
                                                    aria-pressed="<?php echo e($ligado ? 'true' : 'false'); ?>"
                                                    <?php if(! $tarefa->podeTerLembrete()): echo 'disabled'; endif; ?>>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo e($ligado ? 'currentColor' : 'none'); ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" fill="none"/></svg>
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('tarefas.toggle-status', $tarefa)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-status <?php echo e($classeAcao); ?>">
                                                <?php if($tarefa->status === 'pendente'): ?>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 4.5v15l12-7.5z"/></svg>
                                                <?php elseif($tarefa->status === 'em_andamento'): ?>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
                                                <?php else: ?>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg>
                                                <?php endif; ?>
                                                <?php echo e($tarefa->proximaAcao()); ?>

                                            </button>
                                        </form>

                                        <div class="tn-btn-group">
                                            <a href="<?php echo e(route('tarefas.show', $tarefa)); ?>" aria-label="Ver tarefa" title="Ver">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                            <a href="<?php echo e(route('tarefas.edit', $tarefa)); ?>" aria-label="Editar tarefa" title="Editar">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('tarefas.destroy', $tarefa)); ?>"
                                                  data-confirm-title="Excluir tarefa?"
                                                  data-confirm="A tarefa “<?php echo e($tarefa->titulo); ?>” será apagada. Essa ação não pode ser desfeita."
                                                  data-confirm-button="Excluir tarefa">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="is-danger" aria-label="Excluir tarefa" title="Excluir">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="tn-table-foot">
                <span>Mostrando <?php echo e($tarefas->firstItem()); ?> a <?php echo e($tarefas->lastItem()); ?> de <?php echo e($tarefas->total()); ?> <?php echo e($tarefas->total() === 1 ? 'tarefa' : 'tarefas'); ?></span>
                <?php if($tarefas->hasPages()): ?>
                    <?php $tarefas->appends(request()->query()); ?>
                    <nav class="tn-pager-links" aria-label="Paginação">
                        <?php if($tarefas->onFirstPage()): ?>
                            <span class="is-disabled">Anterior</span>
                        <?php else: ?>
                            <a href="<?php echo e($tarefas->previousPageUrl()); ?>">Anterior</a>
                        <?php endif; ?>
                        <?php $__currentLoopData = $tarefas->getUrlRange(1, $tarefas->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagina => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($pagina === $tarefas->currentPage()): ?>
                                <span class="is-current" aria-current="page"><?php echo e($pagina); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>"><?php echo e($pagina); ?></a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($tarefas->hasMorePages()): ?>
                            <a href="<?php echo e($tarefas->nextPageUrl()); ?>">Próxima</a>
                        <?php else: ?>
                            <span class="is-disabled">Próxima</span>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="tn-empty is-flat">
                <?php if (isset($component)) { $__componentOriginal58216d62b6ff9703dfabb7e42814850b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58216d62b6ff9703dfabb7e42814850b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-logo','data' => ['size' => 48]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 48]); ?>
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
                <?php if($filtro !== ''): ?>
                    <p>Nenhuma tarefa com esse status.</p>
                    <a href="<?php echo e(route('tarefas.index')); ?>" class="btn btn-outline">Ver todas as tarefas</a>
                <?php else: ?>
                    <p>Você ainda não tem tarefas. Que tal criar a primeira?</p>
                    <a href="<?php echo e(route('tarefas.create')); ?>" class="btn btn-primary">Criar primeira tarefa</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/tarefas/index.blade.php ENDPATH**/ ?>