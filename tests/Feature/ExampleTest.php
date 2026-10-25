<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitante_ve_a_pagina_inicial(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('TaskNest')
            ->assertSee('no lugar')
            ->assertSee(route('register'), false);
    }

    public function test_usuario_logado_vai_direto_para_as_tarefas(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertRedirect(route('tarefas.index'));
    }

    public function test_dashboard_redireciona_para_tarefas(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/dashboard')
            ->assertRedirect(route('tarefas.index'));
    }
}
