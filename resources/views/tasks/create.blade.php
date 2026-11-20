@extends('layouts.app')

@section('title', 'Nova tarefa · TaskFlow')

@section('content')
    <h1 class="mb-6 text-xl font-semibold">Nova tarefa</h1>

    <form method="POST" action="{{ route('tasks.store') }}" class="rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
        @csrf
        @include('tasks._form')
    </form>
@endsection
