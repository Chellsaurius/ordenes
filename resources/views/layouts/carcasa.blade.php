<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Órdenes del día</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Datatables Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet"/>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ secure_asset('css/AdminLTE.min.css') }}">

    @yield('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Sistema de órdenes del día
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto ">
                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Puntos pendientes
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pending.index') }}">Lista de puntos de orden del día</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.newPending') }}">Añadir nuevo punto</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.aceptedList') }}">Lista de puntos aprobados</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.rejectedList') }}">Lista de puntos no aprobados</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.disabledList') }}">Puntos dados de baja</a></li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Puntos pendientes
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pending.index') }}">Lista de puntos de orden del día</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.aceptedList') }}">Lista de puntos aprobados</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pending.rejectedList') }}">Lista de puntos no aprobados</a></li>
                                </ul>
                            </li>
                        @endif
                        
                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Órdenes
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('order.index') }}">Lista de órdenes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('order.new') }}">Añadir nueva órden</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('order.disabledList') }}">Órdenes dadas de baja</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('order.iRIndex', Auth::user()->id) }}">Órdenes</a>
                            </li>
                            
                        @endif
                        @if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Actas
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('certificates.index') }}">Lista de actas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('certificates.newCertificate') }}">Añadir nueva acta</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('certificates.disabledList') }}">Actas dadas de baja</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('certificates.index') }}">Actas</a>
                            </li>
                        @endif
                        
                        
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Comisiones
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('comision.index') }}">Lista de comisiones</a></li>
                                    <li><a class="dropdown-item" href="{{ route('comision.new') }}">Añadir nueva comisión</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('comision.recordsList') }}">Hisorial de comisiones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('comision.disabledComisions') }}">Comisiones dadas de baja</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Usuarios
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Lista de usuarios</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.new') }}">Añadir nuevo usuario</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('user.disabledUsers') }}">Usuarios dados de baja</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('comision.index') }}">Lista de comisiones</a>
                            </li>
                        @endif
                        @if(Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6)
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Partidos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('party.index') }}">Lista de partidos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('party.newParty') }}">Añadir nuevo partido</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('party.disabledParties') }}">Partidos dados de baja</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.changePass') }}">
                                        Cambiar contraseña
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
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
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });
    </script>
    @yield('js')
</body>
</html>
