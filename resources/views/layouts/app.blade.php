<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Human Orga') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand text-muted" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.png') }}" height="46" alt="logo"/> {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" style="border:none;" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



        <main class="container-fluid">
            <div class="row">

                @auth
                    <!-- Menu mobile -->
                        <section id="menu-mobile" class="d-block d-md-none">
                            <div>
                                <p><a style="display: inline-block;" href="{{ url('/home') }}"><i class="fa fa-home"></i><br>Home</a></p>
                                <p><i class="fas fa-file-contract"></i><br>Reviews</p>
                                <p><i class="fa fa-user"></i><br>Users</p>
                                <p><i class="fa fa-cogs"></i><br>Manage</p>
                            </div>
                        </section>
                        <!-- Menu desktop -->
                <section id="menu-desktop" class="d-none d-md-block col-md-2 p-4">
                    <p class="text-center text-uppercase font-weight-bold pb-2">Menu</p>
                    <nav>
                        <p class="py-2"><a href="{{ url('/home') }}"><i style="width: 24px;" class="fa fa-home"></i> Home</a></p>
                        <p class="py-2"><i style="width: 24px;" class="fas fa-file-contract"></i> Reviews</p>
                        <p class="py-2"><i style="width: 24px;" class="fa fa-user"></i> Users</p>
                        <p class="py-2"><i style="width: 24px;" class="fa fa-cogs"></i> Manage forms</p>
                    </nav>
                    <p class="text-center">
                        <a href="{{ route('new_review', 1) }}" class="btn btn-primary text-uppercase">
                            <i class="fa fa-plus"></i> New review
                        </a>
                    </p>
                </section>

                <section class="col-12 col-md-10 py-4">
                    @yield('content')
                </section>

                @else
                    <section class="col-12 py-4">
                        @yield('content')
                    </section>
                @endauth
            </div>

        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    @yield('javascript')
</body>
</html>
