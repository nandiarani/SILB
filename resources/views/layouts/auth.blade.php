<!DOCTYPE html>

<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    @yield('title')

    {{-- style --}}
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">

    {{-- script --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('../assets/node_modules/jquery/jquery.min.js')}}"></script>
</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            @yield('contents')
        </div>
    </div>
    @yield('js')
</body>
</html>
