
<?php
    $tarefa = $tarefa ?? null;
    $corAtual = old('cor', $tarefa?->cor ?? '');
    $lembreteAtivo = (bool) old('lembrete_ativo', $tarefa?->lembrete_ativo ?? false);
    $lembreteDias = (int) old('lembrete_dias', $tarefa?->lembrete_dias ?? (auth()->user()->lembrete_dias_padrao ?? 1));
?>

<?php if($errors->any()): ?>
    <div class="alert alert-error" role="alert">
        <div>
            <strong>Confira os campos abaixo:</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $erro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($erro); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="field">
    <label for="titulo" class="label">Título <span class="req">*</span></label>
    <input type="text" name="titulo" id="titulo" required maxlength="255" autofocus
           value="<?php echo e(old('titulo', $tarefa?->titulo)); ?>"
           placeholder="Digite o título da tarefa"
           class="input <?php echo e($errors->has('titulo') ? 'is-invalid' : ''); ?>">
    <?php $__errorArgs = ['titulo'];
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
    <label for="descricao" class="label">Descrição <span class="opt">(opcional)</span></label>
    <textarea name="descricao" id="descricao" rows="4" placeholder="Descreva sua tarefa"
              class="input <?php echo e($errors->has('descricao') ? 'is-invalid' : ''); ?>"><?php echo e(old('descricao', $tarefa?->descricao)); ?></textarea>
    <?php $__errorArgs = ['descricao'];
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
    <label for="data_vencimento" class="label">Data de vencimento <span class="opt">(opcional)</span></label>
    <input type="date" name="data_vencimento" id="data_vencimento"
           value="<?php echo e(old('data_vencimento', $tarefa?->data_vencimento?->format('Y-m-d'))); ?>"
           min="<?php echo e(date('Y-m-d')); ?>"
           class="input input-date <?php echo e($errors->has('data_vencimento') ? 'is-invalid' : ''); ?>">
    <?php $__errorArgs = ['data_vencimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-text"><?php echo e($message); ?></span>
    <?php else: ?>
        <span class="hint">Não pode ser no passado. Necessária para o lembrete por e-mail.</span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<fieldset class="field" style="border: 0; margin: 0; padding: 0">
    <legend class="label" style="padding: 0; margin-bottom: 10px">Cor da tarefa</legend>
    <div class="tn-palette">
        <?php $__currentLoopData = \App\Models\Tarefa::CORES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chave => [$nome, $hex]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="tn-swatch" title="<?php echo e($nome); ?>">
                <input type="radio" name="cor" value="<?php echo e($chave); ?>" data-hex="<?php echo e($hex); ?>" data-nome="<?php echo e($nome); ?>" <?php if($corAtual === $chave): echo 'checked'; endif; ?>>
                <span style="background: <?php echo e($hex); ?>">
                    <svg class="check" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
                </span>
                <span class="sr-only"><?php echo e($nome); ?></span>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <label class="tn-swatch is-none" title="Sem cor">
            <input type="radio" name="cor" value="" data-hex="" data-nome="Sem cor" <?php if($corAtual === '' || $corAtual === null): echo 'checked'; endif; ?>>
            <span>
                <svg class="none" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M6.5 17.5l11-11"/></svg>
            </span>
            <span class="sr-only">Sem cor</span>
        </label>
    </div>
    <?php $__errorArgs = ['cor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-text"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</fieldset>

<div class="tn-reminder">
    <div class="tn-reminder-head">
        <span class="tn-reminder-icon" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </span>
        <div style="flex: 1; min-width: 0">
            <div class="tn-reminder-title">Lembrete por e-mail</div>
            <div class="tn-reminder-sub">Enviado para <?php echo e(auth()->user()->email); ?>, a partir das 8h.</div>
        </div>
        <label class="tn-switch">
            <input type="hidden" name="lembrete_ativo" value="0">
            <input type="checkbox" name="lembrete_ativo" value="1" <?php if($lembreteAtivo): echo 'checked'; endif; ?> aria-label="Ativar lembrete por e-mail">
            <span></span>
        </label>
    </div>
    <div class="tn-reminder-when">
        <span class="label" style="font-size: 13px">Quando avisar</span>
        <div class="tn-choice">
            <?php $__currentLoopData = \App\Models\Tarefa::LEMBRETE_OPCOES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dias => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label>
                    <input type="radio" name="lembrete_dias" value="<?php echo e($dias); ?>" <?php if($lembreteDias === $dias): echo 'checked'; endif; ?>>
                    <span><?php echo e($texto); ?></span>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <span class="hint" data-aviso-sem-data>Sem data de vencimento o lembrete não é enviado.</span>
    </div>
</div>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/tarefas/_campos.blade.php ENDPATH**/ ?>