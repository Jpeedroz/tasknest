<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona:
 *  - cor da tarefa (paleta estilo Trello)
 *  - lembrete por e-mail em cada tarefa
 *  - preferências de notificação do usuário
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->string('cor', 20)->nullable()->after('status');
            $table->boolean('lembrete_ativo')->default(false)->after('cor');
            $table->unsignedTinyInteger('lembrete_dias')->default(1)->after('lembrete_ativo');
            $table->timestamp('lembrete_enviado_em')->nullable()->after('lembrete_dias');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('lembretes_email')->default(true)->after('password');
            $table->unsignedTinyInteger('lembrete_dias_padrao')->default(1)->after('lembretes_email');
        });
    }

    public function down(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropColumn(['cor', 'lembrete_ativo', 'lembrete_dias', 'lembrete_enviado_em']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lembretes_email', 'lembrete_dias_padrao']);
        });
    }
};
