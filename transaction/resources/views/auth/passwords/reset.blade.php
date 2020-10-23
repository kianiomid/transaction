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
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="wrap-input100 validate-input m-b-16{{ $errors->has('email') ? ' has-error' : '' }}"
                             data-validate="Email is required">
                            <input class="input100 @error('email') is-invalid @enderror" type="email" name="email"
                                   placeholder="Email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            <span class="focus-input100"></span>
                        </div>
                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="wrap-input100 validate-input m-b-16{{ $errors->has('password') ? ' has-error' : '' }}"
                             data-validate="Password is required">
                            <input class="input100 @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-16"
                             data-validate="Password Confirmation is required">
                            <input class="input100" type="password" id="password-confirm" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="container-login100-form-btn m-t-17">
                            <button class="login100-form-btn" type="submit">
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
