# Лабораторная работа №5. Компоненты безопасности в Laravel
# Цель работы
Познакомиться с основами компонентов безопасности в Laravel, таких как аутентификация, авторизация, защита от CSRF, а также использование встроенных механизмов для управления доступом.
## №2. Аутентификация пользователей
### Создайте контроллер AuthController для управления аутентификацией пользователей.
```
php artisan make:controller AuthController
```
### Добавьте и реализуйте методы для регистрации, входа и выхода пользователя.

### Теперь добавим методы для регистрации, входа и выхода.
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Hash;

class AuthController extends Controller
{
    // Отображение формы регистрации
    public function register()
    {
        return view('auth.register');
    }

    // Обработка данных формы регистрации
    public function storeRegister(RegisterRequest $request)
    {
        // Хэширование пароля
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Вход пользователя после регистрации
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Вы успешно зарегистрированы и вошли.');
    }

    // Отображение формы входа
    public function login()
    {
        return view('auth.login');
    }

    // Обработка данных формы входа
    public function storeLogin(LoginRequest $request)
    {
        // Попытка аутентификации
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Вы успешно вошли.');
        }

        return back()->withErrors(['email' => 'Неверные данные для входа.']);
    }

    // Выход пользователя
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Вы успешно вышли.');
    }
}
```
### 2. Создание классов запросов для валидации данных
Создадим два класса запроса для валидации данных — для регистрации и входа.
```
php artisan make:request RegisterRequest
```
Класс RegisterRequest.php
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    // Правила валидации для регистрации
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    // Авторизация запроса
    public function authorize()
    {
        return true;
    }
}
```
### Команда для создания запроса для входа:
```
php artisan make:request LoginRequest
```
### Класс LoginRequest.php
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // Правила валидации для входа
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    // Авторизация запроса
    public function authorize()
    {
        return true;
    }
}
```
### 3. Маршруты для аутентификации
Теперь добавим маршруты для регистрации, входа и выхода в routes/web.php.
```php
use App\Http\Controllers\AuthController;

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'storeRegister']);
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'storeLogin']);
Route::post('logout', [AuthController::class, 'logout'])
```
### 4  Добавим представление register.blade.php и login.blade.php

## №3. Аутентификация пользователей с помощью готовых компонентов
###  Установливаем библиотеку Laravel Breeze для быстрой настройки аутентификации. 
- `composer require laravel/breeze --dev`
### Реализуем страницу "Личный кабинет", доступ к которой имеют только авторизованные пользователи.

```php
<!-- resources/views/profile/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Личный кабинет</h1>
        <p>Добро пожаловать, {{ $user->name }}!</p>
        <p>Email: {{ $user->email }}</p>

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Выйти
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
```

### Настраиваем проверку доступа к данной странице, добавив middleware auth в маршрут.

```php
//cabinet
Route::middleware(['auth'])->get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
// Для администраторов
Route::middleware('admin')->get('/admin/users', [AdminController::class, 'index'])->name('admin.users');});
```
### Добавляем защиту от CSRF-атак на формах.
# Контрольные вопросы
### Какие готовые решения для аутентификации предоставляет Laravel? - Laravel предоставляет Breeze, Jetstream, Fortify, Sanctum, Passport.

### Какие методы аутентификации пользователей вы знаете? - Форма входа, OAuth, JWT, API Token-based.

### Чем отличается аутентификация от авторизации? - Аутентификация проверяет личность, авторизация — права доступа.

### Как обеспечить защиту от CSRF-атак в Laravel? - Использовать @csrf директиву для форм в шаблонах.
