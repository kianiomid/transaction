<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('label.transaction') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset( 'AdminLTE/dist/css/bootstrap-theme.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset( "AdminLTE/bower_components/font-awesome/css/font-awesome.min.css" )}}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset( "AdminLTE/bower_components/Ionicons/css/ionicons.min.css" )}}">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset( "AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" )}}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset( "AdminLTE/bower_components/select2/dist/css/select2.min.css" )}}">

    {{-- skins --}}
    <link rel="stylesheet" href="{{ asset( "AdminLTE/dist/css/skins/_all-skins.min.css" )}}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset( "AdminLTE/plugins/iCheck/all.css" )}}">
    <link rel="stylesheet" href="{{ asset( "AdminLTE/plugins/iCheck/square/_all.css" )}}">


    @if(\Illuminate\Support\Facades\App::getLocale() == 'fa')

    <!-- Bootstrap rtl -->
        <link rel="stylesheet" href="{{ asset( 'AdminLTE/dist/css/rtl.css' )}}">

        <!-- babakhani datepicker -->
        <link rel="stylesheet" href="{{ asset( 'AdminLTE/dist/css/persian-datepicker.min.css' )}}"/>

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset( "AdminLTE/dist/css/AdminLTE.css" )}}">
        <link rel="stylesheet" href="{{ asset( "AdminLTE/dist/css/rtl-custom.css" )}}">

        @yield('css')

    @else

        {{-- new adminlte v2.4.18 css --}}
        <link rel="stylesheet" href="{{ asset( "AdminLTE/dist/css/AdminLTE-2.4.18/AdminLTE.css" )}}">

        <link rel="stylesheet" href="{{ asset( "AdminLTE/bower_components/jquery-ui/themes/base/jquery-ui.min.css" )}}">

        <link rel="stylesheet" href="{{ asset( "AdminLTE/dist/css/ltr-custom.css" )}}">

        @yield('css')

    @endif
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())

    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="#" class="logo">
                <span class="logo-mini">{{ __('label.transaction') }}</span>
                <span class="logo-lg"><b>{{ __('label.transaction') }}</b></span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="hidden-xs">
{{--                                    {!! dd(Auth::use    r()) !!}--}}
                                    @if(Auth::user() != null)
                                        {!! Auth::user()->name !!}
                                    @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu">

                                <li class="user-footer">
                                    {{--<div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>--}}
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            @if(\Illuminate\Support\Facades\App::getLocale() == "fa")
                                                خروج
                                            @else
                                                Sign out
                                            @endif
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Admin Generator: BGenerator</strong> - Powered By <a href="#">@lang('label.custom')</a>.
        </footer>
    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

@endif

<!-- jQuery 3.1.1 -->
<script src="{{ asset( "AdminLTE/bower_components/jquery/dist/jquery.min.js" )}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset( "AdminLTE/bower_components/bootstrap/dist/js/bootstrap.js" )}}"></script>

<!-- DataTables -->
<script src="{{ asset( "AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js" )}}"></script>
<script src="{{ asset( "AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" )}}"></script>

<!-- SlimScroll -->
<script src="{{ asset( "AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" )}}"></script>

<!-- FastClick -->
<script src="{{ asset( "AdminLTE/bower_components/fastclick/lib/fastclick.js" )}}"></script>

<!-- iCheck -->
<script src="{{ asset( "AdminLTE/plugins/iCheck/icheck.min.js" )}}"></script>

<!-- Select2 -->
<script src="{{ asset( "AdminLTE/bower_components/select2/dist/js/select2.full.min.js" )}}"></script>

<!-- InputMask -->
<script src="{{ asset( "AdminLTE/plugins/input-mask/jquery.inputmask.js" )}}"></script>
<script src="{{ asset( "AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js" )}}"></script>
<script src="{{ asset( "AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js" )}}"></script>

{{-- ChartJs--}}
<script src="{{ asset( "AdminLTE/bower_components/chart.js/Chart.js" )}}"></script>

@if(\Illuminate\Support\Facades\App::getLocale() == 'fa')

    <!-- AdminLTE App -->
    <script src="{{ asset( "AdminLTE/dist/js/adminlte.min.js" )}}"></script>

    <!-- babakhani datepicker -->
    <script src="{{ asset( "AdminLTE/dist/js/persian-date.min.js" )}}"></script>
    <script src="{{ asset( "AdminLTE/dist/js/persian-datepicker.min.js" )}}"></script>

    @yield('scripts')

@else

    {{-- js adminlte v2.4.18 --}}
    <script src="{{ asset( "AdminLTE/dist/js/adminlte.min.js" )}}"></script>

    {{-- english date --}}
    <script src="{{ asset( "AdminLTE/bower_components/jquery-ui/jquery-ui.min.js" )}}"></script>

    @yield('scripts')

@endif


</body>
</html>