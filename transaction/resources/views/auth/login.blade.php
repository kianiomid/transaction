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
                        <img src="{{ asset("img/ramotak.jpg") }}" class="img-responsive w-100 h-100" />
                    </div>

                    <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30 border">
                        <header class="text-center mb-4 pb-4">
                            <h2 class="h2 g-color-black text-uppercase login100-form-title">ورود به پنل مدیریت</h2>
                        </header>

                        <form class="login100-form validate-form flex-sb flex-w"
                              role="form" method="POST" action="{{ route('login') }}">
                            {!! csrf_field() !!}

                            <div class="wrap-input100 validate-input m-b-16{{ $errors->has('email') ? ' has-error' : '' }}"
                                 data-validate="Email is required">
                                <input class="input100" type="email" name="email" placeholder="ایمیل">
                                <span class="focus-input100"></span>
                            </div>

                            @if ($errors->has('email'))
                                <span class="help-block text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif

                            <div class="wrap-input100 validate-input m-b-16{{ $errors->has('password') ? ' has-error' : '' }}"
                                 data-validate="Password is required">
                                <input class="input100" type="password" name="password" placeholder="رمز عبور">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                                <span class="focus-input100"></span>
                            </div>

                            <div class="flex-sb-m w-full p-t-3 p-b-24">
                                <div>
                                    <a href="{{ route('password.request') }}" class="txt1">
                                        فراموشی رمز عبور؟
                                    </a>
                                </div>
                                <div class="contact100-form-checkbox">
                                    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                    <label class="label-checkbox100" for="ckb1">
                                        به خاطر آوردن
                                    </label>
                                </div>


                            </div>

                            <div class="container-login100-form-btn m-t-17">
                                <button class="login100-form-btn">
                                    ورود
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
