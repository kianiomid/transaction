@extends('layouts.app')

@section('css')
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('LoginPage/css/util.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('LoginPage/css/main.css') }}">
<!--===============================================================================================-->
@endsection

@section('content')

    <div class="g-bg-gray-light-v5">
        <div class="container g-py-45">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-lg-5">

                    <div class="d-flex justify-content-center p-4">
                        <img src="{{ asset("front/img/ReelDataLogo-2.png") }}" />
                    </div>

                    <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30 border">
                        <header class="text-center mb-4 pb-4">
                            <h2 class="h2 g-color-black text-uppercase login100-form-title">{{ __('Reset Password') }}</h2>
                        </header>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="login100-form validate-form flex-sb flex-w"
                              method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="wrap-input100 validate-input m-b-16{{ $errors->has('email') ? ' has-error' : '' }}"
                                 data-validate="Email is required">
                                <input class="input100 @error('email') is-invalid @enderror" type="email" name="email"
                                       placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="focus-input100"></span>
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="container-login100-form-btn m-t-17">
                                <button class="login100-form-btn">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('LoginPage/js/main.js') }}"></script>
@endsection



{{--@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection--}}
