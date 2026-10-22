
<aside class="tn-preview" aria-label="Pré-visualização">
    <span class="tn-preview-label">Pré-visualização</span>
    <div class="tn-preview-card">
        <div class="tn-preview-cover" data-prev="capa"></div>
        <div class="tn-preview-body">
            <span class="tn-preview-tag" data-prev="etiqueta"></span>
            <div class="tn-preview-title" data-prev="titulo">Título da tarefa</div>
            <div class="tn-preview-desc" data-prev="descricao"></div>
            <div class="tn-preview-chips">
                <span class="tn-chip" data-prev="data">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <span>Sem prazo</span>
                </span>
                <span class="badge badge-<?php echo e($status ?? 'pendente'); ?>"><?php echo e(\App\Models\Tarefa::STATUS_LABELS[$status ?? 'pendente']); ?></span>
                <span class="tn-chip is-accent" data-prev="lembrete" hidden>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/></svg>
                    <span>E-mail</span>
                </span>
            </div>
        </div>
    </div>
    <p class="tn-preview-note">Na lista, a cor aparece como uma faixa ao lado do nome da tarefa.</p>
</aside>

<script>
    (function () {
        var form = document.querySelector('[data-form-tarefa]');
        if (!form) return;
        var $ = function (n) { return document.querySelector('[data-prev="' + n + '"]'); };
        var opcoes = { '0': 'no dia', '1': '1 dia antes', '3': '3 dias antes' };

        function atualizar() {
            var titulo = form.querySelector('[name="titulo"]').value.trim();
            var descricao = form.querySelector('[name="descricao"]').value.trim();
            var data = form.querySelector('[name="data_vencimento"]').value;
            var cor = form.querySelector('[name="cor"]:checked');
            var hex = cor ? cor.dataset.hex : '';
            var lembrete = form.querySelector('input[type="checkbox"][name="lembrete_ativo"]').checked;
            var dias = form.querySelector('[name="lembrete_dias"]:checked');

            $('titulo').textContent = titulo || 'Título da tarefa';
            $('descricao').textContent = descricao;
            $('descricao').hidden = !descricao;
            $('capa').style.background = hex || '';
            $('etiqueta').style.background = hex || '';
            $('data').querySelector('span').textContent = data ? data.split('-').reverse().slice(0, 2).join('/') : 'Sem prazo';

            var mostraLembrete = lembrete && !!data;
            $('lembrete').hidden = !mostraLembrete;
            if (mostraLembrete && dias) $('lembrete').querySelector('span').textContent = 'E-mail ' + opcoes[dias.value];

            var aviso = form.querySelector('[data-aviso-sem-data]');
            if (aviso) aviso.hidden = !!data;
        }

        form.addEventListener('input', atualizar);
        form.addEventListener('change', atualizar);
        atualizar();
    })();
</script>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/tarefas/_preview.blade.php ENDPATH**/ ?>