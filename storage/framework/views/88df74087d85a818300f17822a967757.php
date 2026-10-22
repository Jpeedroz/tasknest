<?php
    $prazo = $tarefa->prazo();
    $primeiroNome = explode(' ', trim($usuario->name))[0];
    $diasSemana = ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'];
    $dataLonga = $diasSemana[$tarefa->data_vencimento->dayOfWeek] . ', ' . $tarefa->data_vencimento->format('d/m/Y');
    $cor = $tarefa->corHex() ?? '#f59e0b';
    $titulo = match ($prazo['curto']) {
        'Vence hoje' => 'Sua tarefa vence hoje.',
        'Vence amanhã' => 'Sua tarefa vence amanhã.',
        default => 'Sua tarefa vence em breve.',
    };
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembrete TaskNest</title>
</head>
<body style="margin:0; padding:0; background:#e9ecf1; font-family: -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#e9ecf1; padding:32px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border:1px solid #dfe3ea; border-radius:16px; overflow:hidden;">
                <tr>
                    <td style="padding:28px 32px 0;">
                        <span style="font-size:20px; font-weight:700; color:#0f172a; letter-spacing:-0.02em;">
                            <span style="display:inline-block; width:22px; height:22px; line-height:22px; text-align:center; background:#4f46e5; color:#ffffff; border-radius:6px; font-size:14px; vertical-align:-3px;">&#10003;</span>
                            Task<span style="color:#4f46e5;">Nest</span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 32px 8px;">
                        <?php if($teste): ?>
                            <p style="margin:0 0 12px; display:inline-block; font-size:12px; font-weight:700; color:#3730a3; background:#eef2ff; padding:4px 10px; border-radius:999px;">E-MAIL DE TESTE</p>
                        <?php endif; ?>
                        <h1 style="margin:0; font-size:24px; line-height:1.3; color:#0f172a;">Olá, <?php echo e($primeiroNome); ?>! <?php echo e($titulo); ?></h1>
                        <p style="margin:8px 0 0; font-size:15px; line-height:1.6; color:#475569;">
                            <?php echo e($teste ? 'Assim é o lembrete que você vai receber antes do vencimento das suas tarefas.' : 'Este é o lembrete que você ativou no TaskNest.'); ?>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb; border-left:4px solid <?php echo e($cor); ?>; border-radius:12px;">
                            <tr>
                                <td style="padding:18px 20px;">
                                    <p style="margin:0; font-size:17px; font-weight:600; color:#0f172a;"><?php echo e($tarefa->titulo); ?></p>
                                    <?php if($tarefa->descricao): ?>
                                        <p style="margin:8px 0 0; font-size:14px; line-height:1.6; color:#475569;"><?php echo e($tarefa->descricao); ?></p>
                                    <?php endif; ?>
                                    <p style="margin:12px 0 0; font-size:14px; font-weight:600; color:#c2410c;">&#128197; Vence <?php echo e($dataLonga); ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 32px 28px;">
                        <a href="<?php echo e($tarefa->exists ? route('tarefas.show', $tarefa) : route('tarefas.index')); ?>"
                           style="display:inline-block; background:#4f46e5; color:#ffffff; text-decoration:none; font-size:15px; font-weight:600; padding:12px 22px; border-radius:10px;">
                            <?php echo e($tarefa->exists ? 'Abrir tarefa' : 'Abrir o TaskNest'); ?>

                        </a>
                        <p style="margin:18px 0 0; font-size:13px; line-height:1.6; color:#64748b;">
                            Se a tarefa já foi feita, é só marcar como concluída no TaskNest — você não recebe mais lembretes dela.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px; background:#f8fafc; border-top:1px solid #e5e7eb; font-size:12px; line-height:1.6; color:#64748b;">
                        Você recebeu este e-mail porque ativou os lembretes no TaskNest.<br>
                        <a href="<?php echo e(route('profile.edit')); ?>#notificacoes" style="color:#4338ca;">Gerenciar notificações</a> · © <?php echo e(date('Y')); ?> TaskNest
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php /**PATH /tmp/claude-0/full/tasknest/resources/views/emails/lembrete.blade.php ENDPATH**/ ?>