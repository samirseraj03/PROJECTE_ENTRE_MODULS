<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Inici') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Estilos CSS -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <!-- Scripts JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/validacion.js') }}" defer></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necesario para Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Archivo JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>


<body>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="row">
                    <div class="col mt-1">
                        <span class="material-symbols-outlined">grid_view</span>
                    </div>
                    <div class="col">
                        <span>{{ config('app.name', 'Inici') }}</span>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @if(Auth::check() && !is_null(session('id_enquestadores')))
                    <!-- Mostrar estos elementos solo si el usuario es enquestador -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new_company') }}">Donar d'alta la localització</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new_survey') }}">Donar d'alta les enquestes</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="enquestesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Més</a>
                        <div class="dropdown-menu" aria-labelledby="enquestesDropdown">
                            <a class="dropdown-item" href="{{ route('new_ask') }}">Donar d'alta noves preguntes enquestes</a>
                            <a class="dropdown-item" href="{{ route('show_option_form') }}">Donar d'alta opcions</a>
                            <a class="dropdown-item" href="{{ route('informes') }}">Informes</a>
                        </div>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>

</body>

</html>