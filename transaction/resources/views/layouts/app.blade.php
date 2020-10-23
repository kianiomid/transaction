<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('label.transaction') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}"/>

    <link rel="stylesheet" href="{{ asset( 'vendor/bootstrap/4.4.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset( "vendor/fontawesome/css/font-awesome.min.css" )}}">

    <link rel="stylesheet" href="{{ asset( "css/uikit-core.css" )}}">
    <link rel="stylesheet" href="{{ asset( "css/uikit-components.css" )}}">
    <link rel="stylesheet" href="{{ asset( "css/uikit-globals.css" )}}">
    <link rel="stylesheet" href="{{ asset( "css/uikit-custom.css" )}}">

    @yield('css')
</head>

<body class="g-bg-gray-light-v5">

    <div id="content" class="content">
        @yield('content')
    </div>



    <script src="{{ asset( "vendor/jquery/jquery-3.4.1.min.js" )}}"></script>
    <script src="{{ asset( "vendor/bootstrap/4.4.1/js/bootstrap.min.js" )}}"></script>

    @yield('scripts')
</body>
</html>