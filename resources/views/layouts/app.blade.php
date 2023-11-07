<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/img-laravel-128x128.png') }}" type="image/x-icon">
    <meta name="description" content="">
    
    <title>@yield('title',config('app.name'))</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap-material-design-font/css/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/et-line-font-plugin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tether/tether.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/colorm-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/socicon/css/socicon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dropdown/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wowslider-init/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mobirise/css/mbr-additional.css') }}" type="text/css">
    <link rel="stylesheet" href = "{{ asset('assets/wowslider-init/twist/style.css') }}"></link>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/buscador-predictivo.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/preloader.css') }}">
    
    <!-- Styles mio -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles mio -->

</head>
<body>
    <div id="contenedor">
        <div id="carga">

        </div>
    </div>

    <section class="menu1" id="menu-0" data-rv-view="0">

        <nav class="navbar navbar-dropdown navbar-fixed-top">
            <div class="container-fluid">

                <div class="mbr-table">
                    <div class="mbr-table-cell">

                        <div class="navbar-brand">
                            <a href="https://mobirise.com" class="navbar-logo"><img src="{{ asset('assets/images/img-laravel-128x128.png') }}" alt="Mobirise"></a>
                            <a class="navbar-caption text-white" href="https://mobirise.com">{{ config('app.name') }}</a>
                        </div>

                    </div>

                    {{-- buscador --}}
                    <div style="margin-top: 20px">
                        <form class="form-inline" action="{{url('/buscador')}}" method="GET">
                            @csrf
                            <div class="form-group">
                                <input style="width: 250px" id="buscador-predictivo" type="text" class="form-control" id="exampleInputEmail2"
                                name="busqueda" placeholder="Buscar" autocomplete="off">
                            </div>
                            <button style="margin-top: 8px" type="submit" class="btn btn-warning btn-sm">Buscar</button>
                        </form>
                    </div>

                    <div class="mbr-table-cell">

                        <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                            <span class="hamburger-icon"></span>
                        </button>

                        <ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-sm" id="exCollapsingNavbar">
                            <li class="nav-item">
                                <a class="nav-link link" href="{{ route('welcome') }}">INICIO</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link link dropdown-toggle" data-toggle="dropdown-submenu" href="https://mobirise.com/" aria-expanded="false">TEMAS PRINCIPALES</a>
                                <div class="dropdown-menu">
                                    @foreach ($temasTodos as $tema)
                                        
                                        <a class="dropdown-item" href="{{ route('tema.show', $tema) }}">{{ $tema->nombre }}</a>
                                        

                                    @endforeach
                     
                                    {{-- <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle" data-toggle="dropdown-submenu" href="https://mobirise.com/">Trendy blocks</a>
                                        <div class="dropdown-menu dropdown-submenu">
                                            <a class="dropdown-item" href="https://mobirise.com/">Image/content slider</a>
                                            <a class="dropdown-item" href="https://mobirise.com/">Contact forms</a>
                                            
                                        </div>
                                    </div> --}}
                                </div>
                            </li>
                            {{-- Sistema autenticacion --}}
                            @guest
                            <li class="nav-item">
                                <a class="nav-link link" href="#" data-toggle="modal" data-target="#loginModal">{{ __('Login') }}</a>
                            </li>
                           @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if(auth()->user()->hasRole('administrador'))
                                            <a class="dropdown-item" href="{{ url('/admin/temas') }}">Zona Administrador</a>
                                        @endif
                                        @if(auth()->user()->hasRole('moderador'))
                                            <a class="dropdown-item" href="{{ url('moderador/articulos') }}">Zona Moderador</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ url('/home') }}">Zona privada</a>
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
                            {{-- Sistema autenticacion --}}
                        </ul>

                        <button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                            <span class="close-icon"></span>
                        </button>

                    </div>
                </div>

            </div>
        </nav>

    </section>

    @yield('content')


    <footer class="mbr-small-footer mbr-section mbr-section-nopadding" id="footer2-5" data-rv-view="33" style="background-color: rgb(50, 50, 50); padding-top: 1.75rem; padding-bottom: 1.75rem;">
        
        <div class="container">
            <p class="text-xs-center lead">Copyright (c) 2016 <a href="http://mobirise.com">Mobirise</a>.</p>
        </div>
    </footer>


    <script src="{{ asset('assets/web/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/tether/tether.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/viewport-checker/jquery.viewportchecker.js') }}"></script>
    <script src="{{ asset('assets/smooth-scroll/smooth-scroll.js') }}"></script>
    <script src="{{ asset('assets/cookies-alert-plugin/cookies-alert-core.js') }}"></script>
    <script src="{{ asset('assets/cookies-alert-plugin/cookies-alert-script.js') }}"></script>
    <script src="{{ asset('assets/dropdown/js/script.min.js') }}"></script>
    <script src="{{ asset('assets/touch-swipe/jquery.touch-swipe.min.js') }}"></script>
    <script src="{{ asset('assets/wowslider-plugin/wowslider.js') }}"></script>
    <script src="{{ asset('assets/theme/js/script.js') }}"></script>
    <script src="{{ asset('assets/wowslider-effect/effects.js') }}"></script>
    <script src="{{ asset('assets/wowslider-init/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="{{ asset('js/buscador-predictivo.js') }}"></script>
    <script src="{{ asset('js/preloader.js') }}"></script>

    
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('comprobar-alias-js')
    @yield('include-login-modal')

    <input name="animation" type="hidden">
    <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
    <input name="cookieData" type="hidden" data-cookie-text="Utilizamos cookies de terceros.">

</body>
</html>
