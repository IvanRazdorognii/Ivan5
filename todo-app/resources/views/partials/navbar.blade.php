<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">TO-DO-DU</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Existing links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks.create') }}">Добавить задачу</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Список задач</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @if(Auth::check())
                    <!-- Authenticated links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Личный кабинет</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="nav-link btn btn-link" type="submit" style="display: inline; padding: 10; border: none; background: none;">Выйти</button>
                        </form>
                    </li>
                @else
                    <!-- Guest links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>