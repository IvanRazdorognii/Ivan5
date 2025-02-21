<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Определите, авторизован ли пользователь для выполнения этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        // Если требуется проверка авторизации, реализуйте ее здесь.
        // Пока что возвращаем true, чтобы разрешить все запросы.
        return true;
    }

    /**
     * Получите правила валидации, применяемые к запросу.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:500',
            'due_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
        ];
    }

    /**
     * Получите пользовательские сообщения об ошибках для правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Поле Название обязательно для заполнения.',
            'title.string' => 'Поле Название должно быть строкой.',
            'title.min' => 'Поле Название должно содержать минимум :min символа.',
            'title.max' => 'Поле Название не должно превышать :max символов.',
            'description.string' => 'Поле Описание должно быть строкой.',
            'description.max' => 'Поле Описание не должно превышать :max символов.',
            'due_date.required' => 'Поле Дата выполнения обязательно для заполнения.',
            'due_date.date' => 'Поле Дата выполнения должно быть датой.',
            'due_date.after_or_equal' => 'Поле Дата выполнения должно быть не ранее сегодняшней даты.',
            'category_id.required' => 'Поле Категория обязательно для заполнения.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }
}