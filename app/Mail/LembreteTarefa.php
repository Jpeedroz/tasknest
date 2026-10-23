<?php

namespace App\Mail;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * E-mail de lembrete de vencimento de uma tarefa.
 */
class LembreteTarefa extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Tarefa $tarefa,
        public User $usuario,
        public bool $teste = false,
    ) {
    }

    public function envelope(): Envelope
    {
        $prazo = $this->tarefa->prazo();
        $quando = mb_strtolower($prazo['curto'] ?? 'em breve');

        $assunto = $this->teste
            ? 'TaskNest: e-mail de teste dos lembretes'
            : 'Lembrete: "' . $this->tarefa->titulo . '" ' . ($quando === 'vence hoje' || $quando === 'vence amanhã' ? $quando : 'vence em ' . $this->tarefa->data_vencimento->format('d/m'));

        return new Envelope(subject: $assunto);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.lembrete');
    }
}
