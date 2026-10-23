<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tarefa extends Model
{
    use HasFactory;

    /** Nome de cada status para mostrar na tela. */
    public const STATUS_LABELS = [
        'pendente' => 'Pendente',
        'em_andamento' => 'Em andamento',
        'concluida' => 'Concluída',
    ];

    /** Paleta de cores (estilo Trello): chave => [nome, cor] */
    public const CORES = [
        'verde' => ['Verde', '#22c55e'],
        'amarelo' => ['Amarelo', '#eab308'],
        'laranja' => ['Laranja', '#f97316'],
        'vermelho' => ['Vermelho', '#ef4444'],
        'rosa' => ['Rosa', '#ec4899'],
        'roxo' => ['Roxo', '#a855f7'],
        'azul' => ['Azul', '#3b82f6'],
        'ceu' => ['Céu', '#06b6d4'],
        'lima' => ['Lima', '#84cc16'],
        'marrom' => ['Marrom', '#a16207'],
        'grafite' => ['Grafite', '#475569'],
    ];

    /** Quantos dias antes do vencimento o lembrete pode ser enviado. */
    public const LEMBRETE_OPCOES = [
        0 => 'No dia',
        1 => '1 dia antes',
        3 => '3 dias antes',
    ];

    protected $fillable = [
        'titulo',
        'descricao',
        'data_vencimento',
        'status',
        'cor',
        'lembrete_ativo',
        'lembrete_dias',
        'user_id',
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'lembrete_ativo' => 'boolean',
        'lembrete_dias' => 'integer',
        'lembrete_enviado_em' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Ex.: "Em andamento" */
    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /** Texto do botão que avança o status (pendente → em andamento → concluída → pendente). */
    public function proximaAcao(): string
    {
        return match ($this->status) {
            'pendente' => 'Iniciar',
            'em_andamento' => 'Concluir',
            default => 'Reabrir',
        };
    }

    /** Cor em hexadecimal, ou null se a tarefa não tem cor. */
    public function corHex(): ?string
    {
        return self::CORES[$this->cor][1] ?? null;
    }

    /** Nome da cor, ex.: "Azul". */
    public function corNome(): string
    {
        return self::CORES[$this->cor][0] ?? 'Sem cor';
    }

    /** O lembrete só faz sentido se a tarefa tem data e ainda não foi concluída. */
    public function podeTerLembrete(): bool
    {
        return $this->data_vencimento !== null && $this->status !== 'concluida';
    }

    /** Lembrete ligado e válido. */
    public function lembreteLigado(): bool
    {
        return $this->lembrete_ativo && $this->podeTerLembrete();
    }

    /** Ex.: "1 dia antes" */
    public function lembreteQuando(): string
    {
        return self::LEMBRETE_OPCOES[$this->lembrete_dias] ?? $this->lembrete_dias . ' dias antes';
    }

    /** Dia em que o e-mail de lembrete deve ser enviado. */
    public function dataEnvioLembrete(): ?Carbon
    {
        return $this->data_vencimento?->copy()->subDays($this->lembrete_dias)->startOfDay();
    }

    /**
     * Informações do prazo para a tela.
     *
     * @return array{texto: ?string, curto: ?string, dias: ?int, urgente: bool, atrasada: bool}
     */
    public function prazo(): array
    {
        if (! $this->data_vencimento) {
            return ['texto' => null, 'curto' => 'Sem prazo', 'dias' => null, 'urgente' => false, 'atrasada' => false];
        }

        $dias = (int) round(today()->diffInDays($this->data_vencimento->copy()->startOfDay(), false));
        $data = $this->data_vencimento->format('d/m/Y');
        $aberta = $this->status !== 'concluida';

        $curto = match (true) {
            ! $aberta => 'Concluída',
            $dias < 0 => 'Atrasada há ' . abs($dias) . (abs($dias) === 1 ? ' dia' : ' dias'),
            $dias === 0 => 'Vence hoje',
            $dias === 1 => 'Vence amanhã',
            default => 'Faltam ' . $dias . ' dias',
        };

        return [
            'texto' => $aberta ? $curto . ' · ' . $data : 'Prazo: ' . $data,
            'curto' => $curto,
            'dias' => $dias,
            'urgente' => $aberta && $dias <= 1,
            'atrasada' => $aberta && $dias < 0,
        ];
    }
}
