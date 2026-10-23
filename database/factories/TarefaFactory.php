<?php

namespace Database\Factories;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarefa>
 */
class TarefaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'titulo'=> $this->faker->unique()->word,
           'descricao'=> $this->faker->text(200),
           'status'=> $this->faker->randomElement(['pendente','em_andamento','concluida']),
           'data_vencimento'=> $this->faker->dateTimeBetween('now','+1 year')->format('Y-m-d'),
           'cor' => $this->faker->randomElement(array_merge(array_keys(Tarefa::CORES), [null])),
           'user_id' => User::inRandomOrder()->first()->id ?? User::factory()
        ];
    }
}
