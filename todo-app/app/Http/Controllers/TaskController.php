<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    // Метод для отображения списка задач
    public function index()
    {
        $tasks = Task::with('category')->get();
        return view('tasks.index', compact('tasks'));
    }

    // Метод для отображения формы создания задачи
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    // Метод для сохранения новой задачи
    public function store(CreateTaskRequest $request)
    {
        // Данные уже валидированы через CreateTaskRequest
        $validated = $request->validated();

        // Создание задачи
        Task::create($validated);

        // Перенаправление с сообщением об успешном добавлении
        return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена!');
    }

    // Метод для отображения формы редактирования задачи
    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    // Метод для обновления задачи
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Данные уже валидированы через UpdateTaskRequest
        $validated = $request->validated();

        // Обновление задачи
        $task->update($validated);

        // Перенаправление с сообщением об успешном обновлении
        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена!');
    }

    // Метод для отображения конкретной задачи (опционально)
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Метод для удаления задачи (опционально)
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }
}