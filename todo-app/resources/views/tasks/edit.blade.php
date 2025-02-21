@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать задачу</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ошибки при заполнении формы:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Метод для обновления задачи -->

        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input 
                type="text" 
                name="title" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                value="{{ old('title', $task->title) }}" 
                required
            >
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea 
                name="description" 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                rows="3"
            >{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Дата выполнения</label>
            <input 
                type="date" 
                name="due_date" 
                class="form-control @error('due_date') is-invalid @enderror" 
                id="due_date" 
                value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" 
                required
            >
            @error('due_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Категория</label>
            <select 
                name="category_id" 
                class="form-select @error('category_id') is-invalid @enderror" 
                id="category_id" 
                required
            >
                <option value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option 
                        value="{{ $category->id }}" 
                        {{ (old('category_id', $task->category_id) == $category->id) ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Обновить задачу</button>
    </form>
</div>
@endsection