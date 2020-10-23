<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('label.transaction') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}"/>

    {{-- fruit templete --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description"
          content="Fruit Shop is new Html theme that we have designed to help you transform your store into a beautiful online showroom. This is a fully responsive Html theme, with multiple versions for homepage and multiple templates for sub pages as well"/>
    <meta name="keywords" content="Fruit,7uptheme"/>
    <meta name="robots" content="noodp,index,follow"/>
    <meta name='revisit-after' content='1 days'/>
    <title>Fruit Shop | Home Style 13</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/ionicons.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/bootstrap-theme.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/jquery.fancybox.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/jquery-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/owl.carousel.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/owl.transitions.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/jquery.mCustomScrollbar.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/owl.theme.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/libs/hover.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/color13.css')}}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/theme.css')}}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/responsive.css')}}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/browser.css')}}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/custom.css')}}" media="all"/>
    {{-- end fruit templete --}}

    <link href="{{ asset("static/css/" . Config::get('app.REACT_CSS_MAIN')) }}" rel="stylesheet">

    @yield('css')
</head>

<body class="g-bg-gray-light-v5">

    <div id="content" class="content h-100">
        @yield('content')
    </div>

    {{-- fruit template --}}
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery.fancybox.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery.jcarousellite.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery.elevatezoom.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/jquery.mCustomScrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/slick.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/popup.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/timecircles.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/libs/wow.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/assets/js/theme.js')}}"></script>
    {{-- end fruit template --}}

    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>!function (e) {
        function r(r) {
            for (var n, a, f = r[0], l = r[1], i = r[2], c = 0, s = []; c < f.length; c++) a = f[c], Object.prototype.hasOwnProperty.call(o, a) && o[a] && s.push(o[a][0]), o[a] = 0;
            for (n in l) Object.prototype.hasOwnProperty.call(l, n) && (e[n] = l[n]);
            for (p && p(r); s.length;) s.shift()();
            return u.push.apply(u, i || []), t()
        }

        function t() {
            for (var e, r = 0; r < u.length; r++) {
                for (var t = u[r], n = !0, f = 1; f < t.length; f++) {
                    var l = t[f];
                    0 !== o[l] && (n = !1)
                }
                n && (u.splice(r--, 1), e = a(a.s = t[0]))
            }
            return e
        }

        var n = {}, o = {1: 0}, u = [];

        function a(r) {
            if (n[r]) return n[r].exports;
            var t = n[r] = {i: r, l: !1, exports: {}};
            return e[r].call(t.exports, t, t.exports, a), t.l = !0, t.exports
        }

        a.m = e, a.c = n, a.d = function (e, r, t) {
            a.o(e, r) || Object.defineProperty(e, r, {enumerable: !0, get: t})
        }, a.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
        }, a.t = function (e, r) {
            if (1 & r && (e = a(e)), 8 & r) return e;
            if (4 & r && "object" == typeof e && e && e.__esModule) return e;
            var t = Object.create(null);
            if (a.r(t), Object.defineProperty(t, "default", {
                enumerable: !0,
                value: e
            }), 2 & r && "string" != typeof e) for (var n in e) a.d(t, n, function (r) {
                return e[r]
            }.bind(null, n));
            return t
        }, a.n = function (e) {
            var r = e && e.__esModule ? function () {
                return e.default
            } : function () {
                return e
            };
            return a.d(r, "a", r), r
        }, a.o = function (e, r) {
            return Object.prototype.hasOwnProperty.call(e, r)
        }, a.p = "/";
        var f = this["webpackJsonpfront-ramotak"] = this["webpackJsonpfront-ramotak"] || [], l = f.push.bind(f);
        f.push = r, f = f.slice();
        for (var i = 0; i < f.length; i++) r(f[i]);
        var p = l;
        t()
    }([])</script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>

    <script>!function(e){function r(r){for(var n,f,i=r[0],l=r[1],a=r[2],c=0,s=[];c<i.length;c++)f=i[c],Object.prototype.hasOwnProperty.call(o,f)&&o[f]&&s.push(o[f][0]),o[f]=0;for(n in l)Object.prototype.hasOwnProperty.call(l,n)&&(e[n]=l[n]);for(p&&p(r);s.length;)s.shift()();return u.push.apply(u,a||[]),t()}function t(){for(var e,r=0;r<u.length;r++){for(var t=u[r],n=!0,i=1;i<t.length;i++){var l=t[i];0!==o[l]&&(n=!1)}n&&(u.splice(r--,1),e=f(f.s=t[0]))}return e}var n={},o={1:0},u=[];function f(r){if(n[r])return n[r].exports;var t=n[r]={i:r,l:!1,exports:{}};return e[r].call(t.exports,t,t.exports,f),t.l=!0,t.exports}f.m=e,f.c=n,f.d=function(e,r,t){f.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},f.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},f.t=function(e,r){if(1&r&&(e=f(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(f.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var n in e)f.d(t,n,function(r){return e[r]}.bind(null,n));return t},f.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return f.d(r,"a",r),r},f.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},f.p="/";var i=this["webpackJsonpfront-fish-farm"]=this["webpackJsonpfront-fish-farm"]||[],l=i.push.bind(i);i.push=r,i=i.slice();for(var a=0;a<i.length;a++)r(i[a]);var p=l;t()}([])</script>
    <script src="{{ asset( "static/js/".Config::get('app.REACT_JS_CHUNK')) }}"></script>
    <script src="{{ asset( "static/js/".Config::get('app.REACT_JS_MAIN')) }}"></script>

    @yield('scripts')
</body>
</html>