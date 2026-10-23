<?php

use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Página inicial: visitantes veem a apresentação; quem já entrou vai direto para as tarefas.
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('tarefas.index')
        : view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('tarefas', TarefaController::class);

    Route::patch('tarefas/{tarefa}/toggle-status', [TarefaController::class, 'toggleStatus'])
        ->name('tarefas.toggle-status');

    // Sininho: liga/desliga o lembrete por e-mail da tarefa
    Route::patch('tarefas/{tarefa}/lembrete', [TarefaController::class, 'toggleLembrete'])
        ->name('tarefas.toggle-lembrete');

    // Preferências de notificação (perfil)
    Route::patch('/profile/notificacoes', [NotificacaoController::class, 'update'])->name('notificacoes.update');
    Route::post('/profile/notificacoes/teste', [NotificacaoController::class, 'teste'])
        ->middleware('throttle:3,1')
        ->name('notificacoes.teste');
});

// Mantida porque o login e o cadastro redirecionam para "dashboard".
Route::get('/dashboard', function () {
    return redirect()->route('tarefas.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
