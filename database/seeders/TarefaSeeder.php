<?php

namespace Database\Seeders;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@email.com'],
            [
                'name' => 'Usuario Demo',
                'password' => bcrypt('123456')
            ]
        );

        // Criar tarefas de exemplo (descomentar para utilizar)
        $tarefas = [
            [
                'titulo' => 'Implementar sistema de login',
                'descricao' => 'Criar funcionalidade de autenticação com login e registro de usuários',
                'data_vencimento' => now()->addDays(7),
                'status' => 'pendente',
                'cor' => 'roxo',
                'lembrete_ativo' => true,
            ],
            [
                'titulo' => 'Estudar Laravel',
                'descricao' => 'Revisar conceitos de Models, Views e Controllers do Laravel',
                'data_vencimento' => now()->addDays(3),
                'status' => 'em_andamento',
                'cor' => 'azul',
            ],
            [
                'titulo' => 'Reunião com equipe',
                'descricao' => 'Discutir próximos passos do projeto e definir prioridades',
                'data_vencimento' => now()->addDays(1),
                'status' => 'pendente',
                'cor' => 'vermelho',
                'lembrete_ativo' => true,
            ],
            [
                'titulo' => 'Configurar banco de dados',
                'descricao' => 'Definir estrutura das tabelas e relacionamentos',
                'data_vencimento' => now()->subDays(1),
                'status' => 'concluida',
                'cor' => 'verde',
            ],
            [
                'titulo' => 'Criar documentação',
                'descricao' => 'Documentar API e funcionalidades do sistema',
                'data_vencimento' => now()->addDays(14),
                'status' => 'pendente',
                'cor' => 'amarelo',
            ],
        ];

        foreach ($tarefas as $tarefaData) {
            $user->tarefas()->create($tarefaData);
        }
    }
}
