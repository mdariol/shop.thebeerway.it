<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The BeerWay') }}</title>

    <!-- Scripts -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.maps.key') }}&libraries=places"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/Home-icon-yellow.png" alt="Home" width="40px" >
                </a>
                <a class="navbar-brand" href="{{ url(request()->exists('packaging') ? str_replace('bottiglie','fusti',request()->getRequestUri()) : '/beers?packaging=fusti&stock=on')}}">
                    <img src="/Fusto.png" alt="Fusti" height="40px" >
                </a>
                <a class="navbar-brand" href="{{ url(request()->exists('packaging') ? str_replace('fusti','bottiglie',request()->getRequestUri()) : '/beers?packaging=bottiglie&stock=on')}}">
                    <img src="/Bottiglia512.png" alt="Bottiglie" height="40px" >
                </a>

                @hasanyrole('Publican|Admin|Distributor')

                    <a class="navbar-brand" href="{{route('orders.index')}}" data-container="body" data-toggle="popover" data-placement="bottom" data-content="test test">
                        <img src="/Ordini_TBW.png" alt="Ordini" height="40px" >
                    </a>

                    <a class="navbar-brand" href="{{route('beers.shoppingcart')}}" data-container="body" data-toggle="popover" data-placement="bottom" data-content="test test">
                        <img src="/Carrello-TheBeerWay.png" alt="Carrello" height="40px" >
                        <span class="badge badge-pill btn-warning shadow-sm mt-1 px-2" >
                            {{Session::has('cart') ? Session::get('cart')->totalQty : ''}}
                        </span>
                    </a>
                @endhasanyrole

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="mailto:massimo@thebeerway.it">massimo@thebeerway.it</a> </li>
                        <li class="nav-item"><a class="nav-link" href="tel:+393356371167">+39 335 637 1167</a> </li>
                        <li class="nav-item">
                            <a class="navbar-brand" href="https://www.facebook.com/TheBeerWay/" target="_blank">
                                <svg height="40px" viewBox="0 0 448 512">
                                    <path d="M448 56.7v398.5c0 13.7-11.1 24.7-24.7 24.7H309.1V306.5h58.2l8.7-67.6h-67v-43.2c0-19.6 5.4-32.9 33.5-32.9h35.8v-60.5c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9h-58.4v67.6h58.4V480H24.7C11.1 480 0 468.9 0 455.3V56.7C0 43.1 11.1 32 24.7 32h398.5c13.7 0 24.8 11.1 24.8 24.7z" /></svg>
                            </a>
                            <a class="navbar-brand" href="https://www.instagram.com/thebeerway/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 0 448 512" src="img/instagram.svg">
                                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" /></svg>
                            </a>

                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', ['user' => auth()->user()->id]) }}">{{ __('Profilo') }}</a>
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

        <main class="py-4">
            @if ($message = Session::get('success'))
                <div class="container mb-4">
                    <div class="alert alert-success alert-block">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="container mb-4">
                    <div class="alert alert-danger alert-block">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
