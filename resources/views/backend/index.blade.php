<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Commerce | Panel</title>

@auth
    <!-- TokenS -->
        <script>
            window.Tokens = @json(['csrf' => csrf_token(), 'user' => auth()->user()]);
        </script>
@endauth
@guest
    <!-- TokenS -->
        <script>
            window.Tokens = @json(['csrf' => '',  'user' =>'']);
        </script>
@endguest
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('FA5PRO-master/css/all.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body  class=" sidebar-mini layout-footer-fixed layout-fixed layout-navbar-fixed text-sm">
    @auth
        <div class="wrapper" id="app">
            <bodyy></bodyy>
        </div>
    @endauth
    @guest
        <div class="wrapper" style="background: #ececec;" id="app">
            <login></login>
        </div>
    @endguest
</body>
</html>
