{{-- Campos do formulário de tarefa (usado em "Nova tarefa" e "Editar tarefa"). Recebe $tarefa opcional. --}}
@php
    $tarefa = $tarefa ?? null;
    $corAtual = old('cor', $tarefa?->cor ?? '');
    $lembreteAtivo = (bool) old('lembrete_ativo', $tarefa?->lembrete_ativo ?? false);
    $lembreteDias = (int) old('lembrete_dias', $tarefa?->lembrete_dias ?? (auth()->user()->lembrete_dias_padrao ?? 1));
@endphp

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <div>
            <strong>Confira os campos abaixo:</strong>
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="field">
    <label for="titulo" class="label">Título <span class="req">*</span></label>
    <input type="text" name="titulo" id="titulo" required maxlength="255" autofocus
           value="{{ old('titulo', $tarefa?->titulo) }}"
           placeholder="Digite o título da tarefa"
           class="input {{ $errors->has('titulo') ? 'is-invalid' : '' }}">
    @error('titulo')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="descricao" class="label">Descrição <span class="opt">(opcional)</span></label>
    <textarea name="descricao" id="descricao" rows="4" placeholder="Descreva sua tarefa"
              class="input {{ $errors->has('descricao') ? 'is-invalid' : '' }}">{{ old('descricao', $tarefa?->descricao) }}</textarea>
    @error('descricao')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

<div class="field">
    <label for="data_vencimento" class="label">Data de vencimento <span class="opt">(opcional)</span></label>
    <input type="date" name="data_vencimento" id="data_vencimento"
           value="{{ old('data_vencimento', $tarefa?->data_vencimento?->format('Y-m-d')) }}"
           min="{{ date('Y-m-d') }}"
           class="input input-date {{ $errors->has('data_vencimento') ? 'is-invalid' : '' }}">
    @error('data_vencimento')
        <span class="error-text">{{ $message }}</span>
    @else
        <span class="hint">Não pode ser no passado. Necessária para o lembrete por e-mail.</span>
    @enderror
</div>

<fieldset class="field" style="border: 0; margin: 0; padding: 0">
    <legend class="label" style="padding: 0; margin-bottom: 10px">Cor da tarefa</legend>
    <div class="tn-palette">
        @foreach (\App\Models\Tarefa::CORES as $chave => [$nome, $hex])
            <label class="tn-swatch" title="{{ $nome }}">
                <input type="radio" name="cor" value="{{ $chave }}" data-hex="{{ $hex }}" data-nome="{{ $nome }}" @checked($corAtual === $chave)>
                <span style="background: {{ $hex }}">
                    <svg class="check" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
                </span>
                <span class="sr-only">{{ $nome }}</span>
            </label>
        @endforeach
        <label class="tn-swatch is-none" title="Sem cor">
            <input type="radio" name="cor" value="" data-hex="" data-nome="Sem cor" @checked($corAtual === '' || $corAtual === null)>
            <span>
                <svg class="none" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M6.5 17.5l11-11"/></svg>
            </span>
            <span class="sr-only">Sem cor</span>
        </label>
    </div>
    @error('cor')
        <span class="error-text">{{ $message }}</span>
    @enderror
</fieldset>

<div class="tn-reminder">
    <div class="tn-reminder-head">
        <span class="tn-reminder-icon" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </span>
        <div style="flex: 1; min-width: 0">
            <div class="tn-reminder-title">Lembrete por e-mail</div>
            <div class="tn-reminder-sub">Enviado para {{ auth()->user()->email }}, a partir das 8h.</div>
        </div>
        <label class="tn-switch">
            <input type="hidden" name="lembrete_ativo" value="0">
            <input type="checkbox" name="lembrete_ativo" value="1" @checked($lembreteAtivo) aria-label="Ativar lembrete por e-mail">
            <span></span>
        </label>
    </div>
    <div class="tn-reminder-when">
        <span class="label" style="font-size: 13px">Quando avisar</span>
        <div class="tn-choice">
            @foreach (\App\Models\Tarefa::LEMBRETE_OPCOES as $dias => $texto)
                <label>
                    <input type="radio" name="lembrete_dias" value="{{ $dias }}" @checked($lembreteDias === $dias)>
                    <span>{{ $texto }}</span>
                </label>
            @endforeach
        </div>
        <span class="hint" data-aviso-sem-data>Sem data de vencimento o lembrete não é enviado.</span>
    </div>
</div>
