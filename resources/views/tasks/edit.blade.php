@extends('layouts.app')

@section('title', 'Editar tarefa · TaskFlow')

@section('content')
    <h1 class="mb-6 text-xl font-semibold">Editar tarefa</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}" class="rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
        @csrf
        @method('PUT')
        @include('tasks._form')
    </form>
@endsection
