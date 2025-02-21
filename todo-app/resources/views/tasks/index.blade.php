@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список задач</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Добавить задачу</a>

    @if($tasks->isEmpty())
        <p>Задач пока нет.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Дата выполнения</th>
                    <th>Категория</th>
                    <th>Создана</th>
                    <th>Действия</th> <!-- Новая колонка для действий -->
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date->format('d.m.Y') }}</td>
                        <td>{{ $task->category->name }}</td>
                        <td>{{ $task->created_at->diffForHumans() }}</td>
                        <td>
                            <!-- Ссылка на редактирование задачи -->
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Редактировать</a>

                            <!-- Форма для удаления задачи (опционально) -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту задачу?');">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection