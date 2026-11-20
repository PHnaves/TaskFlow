<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Sem página inicial: quem acessa a raiz vai direto para as tarefas (o middleware auth manda visitantes ao login).
Route::redirect('/', '/tasks');

Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});

require __DIR__.'/auth.php';
