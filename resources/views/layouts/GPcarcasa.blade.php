<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Órdenes del día</title>

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
                <a class="navbar-brand" href="{{ url('/Vista/ordenes/ordinarias') }}">
                    Sistema de órdenes del día
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto ">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('certificates.GPindex') }}">Lista de actas</a>
                        </li>
                        <li class="nav-item dropdown" aria-current="page" >
                            <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                Lista de órdenes del H. Ayuntamiento
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('orders.GPHCOOrdersView') }}">Lista de órdenes ordinarias</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.GPHCEOOrdersView') }}">Lista de órdenes extraordinarias</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.GPHCSOrdersView') }}">Lista de órdenes solemnes</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('comision.GPindex') }}">Lista de comisiones</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('js')
</body>
</html>
