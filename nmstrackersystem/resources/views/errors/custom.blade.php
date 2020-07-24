<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('includes.navbar')
        <main class="py-4">
            <div class="container">
                <div class="jumbotron text-center">
                    <h1>{{$error}}</h1>
                    <h4>You shouldn't be here.</h4>
                    <a href="/" class="btn btn-outline-primary">Go back</a>
                    <br><br>
                    <small>a potato here's</small>
                    <img src="" alt="potatoes" width="28%">
                    <small>here's a potato</small>
                    <br>
                    <br>
                    <small>potato is lost</small>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

