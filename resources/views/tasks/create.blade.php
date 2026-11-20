@extends('layouts.app')

@section('title', 'Nova tarefa · TaskFlow')

@section('content')
    <a href="{{ route('tasks.index') }}" class="mb-4 inline-block text-sm text-slate-500 hover:text-blue-600 dark:text-slate-400">&larr; Voltar às tarefas</a>
    <h1 class="text-2xl font-bold tracking-tight">Nova tarefa</h1>
    <p class="mb-6 mt-1 text-sm text-slate-500 dark:text-slate-400">Preencha os dados para adicionar ao seu fluxo.</p>

    <form method="POST" action="{{ route('tasks.store') }}" class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
        @csrf
        @include('tasks._form')
    </form>
@endsection
