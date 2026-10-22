
<dialog id="tn-confirm" class="tn-dialog" aria-labelledby="tn-confirm-title" aria-describedby="tn-confirm-text">
    <div class="tn-dialog-body">
        <span class="tn-dialog-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
        </span>
        <div>
            <h2 id="tn-confirm-title" class="tn-dialog-title">Tem certeza?</h2>
            <p id="tn-confirm-text" class="tn-dialog-text"></p>
        </div>
    </div>
    <div class="tn-dialog-actions">
        <button type="button" class="btn btn-outline" data-confirm-cancel>Cancelar</button>
        <button type="button" class="btn btn-danger" data-confirm-ok>Excluir</button>
    </div>
</dialog>

<script>
    (function () {
        var dialog = document.getElementById('tn-confirm');
        if (!dialog || typeof dialog.showModal !== 'function') return;

        var titulo = dialog.querySelector('#tn-confirm-title');
        var texto = dialog.querySelector('#tn-confirm-text');
        var botaoOk = dialog.querySelector('[data-confirm-ok]');
        var formPendente = null;

        // Intercepta o envio de qualquer formulário com data-confirm
        document.addEventListener('submit', function (evento) {
            var form = evento.target;
            if (!form.hasAttribute('data-confirm') || form.dataset.confirmado === '1') return;

            evento.preventDefault();
            formPendente = form;
            titulo.textContent = form.dataset.confirmTitle || 'Tem certeza?';
            texto.textContent = form.dataset.confirm;
            botaoOk.textContent = form.dataset.confirmButton || 'Excluir';
            dialog.showModal();
            dialog.querySelector('[data-confirm-cancel]').focus();
        });

        botaoOk.addEventListener('click', function () {
            if (!formPendente) return;
            formPendente.dataset.confirmado = '1';
            botaoOk.disabled = true;
            HTMLFormElement.prototype.submit.call(formPendente);
        });

        dialog.querySelector('[data-confirm-cancel]').addEventListener('click', function () {
            dialog.close();
        });

        // Clicar fora da janela também cancela
        dialog.addEventListener('click', function (evento) {
            if (evento.target === dialog) dialog.close();
        });

        dialog.addEventListener('close', function () {
            formPendente = null;
            botaoOk.disabled = false;
        });
    })();
</script>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/components/tn-confirm-dialog.blade.php ENDPATH**/ ?>