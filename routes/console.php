<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Lembretes por e-mail das tarefas.
 * Roda de hora em hora; cada lembrete é enviado uma vez só, a partir das 8h.
 * (Se o computador estava desligado às 8h, o e-mail sai assim que o agendador voltar a rodar.)
 * Para o agendador funcionar, deixe rodando:  php artisan schedule:work
 */
Schedule::command('tarefas:enviar-lembretes')->hourly()->withoutOverlapping();
