<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo $__env->make('partials.head', ['title' => trim($__env->yieldContent('title')) ?: ($title ?? null)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="tn">
    <?php if(auth()->guard()->check()): ?>
        <?php
            $usuario = Auth::user();
            $partesNome = preg_split('/\s+/', trim($usuario->name));
            $iniciais = mb_substr($partesNome[0], 0, 1) . (count($partesNome) > 1 ? mb_substr(end($partesNome), 0, 1) : '');

            // Tarefas com o sininho ligado (para o sino do topo)
            $lembretesAtivos = $usuario->tarefas()
                ->where('lembrete_ativo', true)
                ->where('status', '!=', 'concluida')
                ->whereNotNull('data_vencimento')
                ->orderBy('data_vencimento')
                ->get();
        ?>
    <?php endif; ?>

    <div class="tn-topbar-wrap">
        <header class="tn-topbar">
            <a href="<?php echo e(route('tarefas.index')); ?>" class="tn-brand" aria-label="TaskNest — minhas tarefas">
                <?php if (isset($component)) { $__componentOriginal58216d62b6ff9703dfabb7e42814850b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58216d62b6ff9703dfabb7e42814850b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-logo','data' => ['size' => 32]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 32]); ?>
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
                <?php if(auth()->guard()->check()): ?>
                    
                    <details class="tn-menu tn-bell">
                        <summary class="tn-ghost-btn" aria-label="Lembretes por e-mail ativos: <?php echo e($lembretesAtivos->count()); ?>" title="Lembretes por e-mail">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                            <?php if($lembretesAtivos->count() > 0): ?>
                                <span class="tn-bell-count"><?php echo e($lembretesAtivos->count()); ?></span>
                            <?php endif; ?>
                        </summary>
                        <div class="tn-menu-panel tn-bell-panel">
                            <div class="tn-menu-head">
                                <strong>Lembretes por e-mail</strong>
                                <?php if (! ($usuario->lembretes_email)): ?>
                                    <span class="tn-menu-warn">Desligados no perfil</span>
                                <?php endif; ?>
                            </div>
                            <?php $__empty_1 = true; $__currentLoopData = $lembretesAtivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lembrete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('tarefas.show', $lembrete)); ?>" class="tn-bell-item">
                                    <span class="tn-color-dot" style="background: <?php echo e($lembrete->corHex() ?? 'var(--border-2)'); ?>"></span>
                                    <span class="tn-bell-text">
                                        <span class="tn-bell-title"><?php echo e($lembrete->titulo); ?></span>
                                        <span class="tn-bell-sub">
                                            Vence <?php echo e($lembrete->data_vencimento->format('d/m')); ?> ·
                                            <?php echo e($lembrete->lembrete_enviado_em ? 'e-mail enviado' : 'e-mail ' . mb_strtolower($lembrete->lembreteQuando())); ?>

                                        </span>
                                    </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="tn-menu-empty">Nenhum lembrete ativo. Clique no sininho de uma tarefa para ativar.</p>
                            <?php endif; ?>
                            <a href="<?php echo e(route('profile.edit')); ?>#notificacoes" class="tn-menu-foot">Configurar notificações</a>
                        </div>
                    </details>
                <?php endif; ?>

                <button type="button" class="tn-ghost-btn tn-theme-toggle" onclick="tnToggleTheme()" aria-label="Alternar tema claro ou escuro" title="Alternar tema">
                    <svg class="icon-moon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
                    <svg class="icon-sun" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                </button>

                <?php if(auth()->guard()->check()): ?>
                    <span class="tn-divider" aria-hidden="true"></span>

                    <details class="tn-menu tn-user">
                        <summary aria-label="Menu do usuário">
                            <span class="tn-avatar"><?php echo e($iniciais); ?></span>
                            <span class="tn-user-text">
                                <span class="tn-user-name"><?php echo e($usuario->name); ?></span>
                                <span class="tn-user-mail"><?php echo e($usuario->email); ?></span>
                            </span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="tn-chevron"><path d="M6 9l6 6 6-6"/></svg>
                        </summary>
                        <div class="tn-menu-panel">
                            <a href="<?php echo e(route('tarefas.index')); ?>" class="tn-menu-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                Minhas tarefas
                            </a>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="tn-menu-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                                Perfil e notificações
                            </a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="tn-menu-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </details>
                <?php endif; ?>
            </div>
        </header>
    </div>

    <?php if (! empty(trim($__env->yieldContent('content')))): ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php elseif(isset($slot)): ?>
        <?php echo e($slot); ?>

    <?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalcbbe4074c115919ab35ff767140b054a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbbe4074c115919ab35ff767140b054a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tn-confirm-dialog','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tn-confirm-dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbbe4074c115919ab35ff767140b054a)): ?>
<?php $attributes = $__attributesOriginalcbbe4074c115919ab35ff767140b054a; ?>
<?php unset($__attributesOriginalcbbe4074c115919ab35ff767140b054a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbbe4074c115919ab35ff767140b054a)): ?>
<?php $component = $__componentOriginalcbbe4074c115919ab35ff767140b054a; ?>
<?php unset($__componentOriginalcbbe4074c115919ab35ff767140b054a); ?>
<?php endif; ?>

    <script>
        // Fecha os menus (sino e usuário) ao clicar fora ou apertar Esc
        document.addEventListener('click', function (e) {
            document.querySelectorAll('details.tn-menu[open]').forEach(function (m) {
                if (!m.contains(e.target)) m.removeAttribute('open');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('details.tn-menu[open]').forEach(function (m) { m.removeAttribute('open'); });
        });
    </script>
</body>
</html>
<?php /**PATH /tmp/claude-0/full/tasknest/resources/views/layouts/app.blade.php ENDPATH**/ ?>