@extends('layouts.app')

@section('content')
    <style>
        .login-page {
            width: 100%;
            height: 100vh;
        }

        .login-page .container {
            /* background-color: #f7faff; */
            background-image: repeating-linear-gradient(#f7faff 0%, #ecf0f8 45%, #f2f7ff 100%);
            height: 100%;
        }

        .login-page .card-wrapper {
            position: absolute;
            top: 300px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .login-page .card {
            max-width: 380px;
            min-width: 380px;
            padding: 34px 42px 20px 42px;
            background-color: #fdfdfd;
            border-radius: 3px;
            box-shadow: 0 0 8px 4px #dfe1e9;
        }

        .login-page .logo-container {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: center;
            margin: 0 0 46px 0;

        }

        .login-page input[type='password'],
        .login-page input[type='email'] {
            height: 36px;
            border: none;
            border-radius: 3px;
            padding: 0 12px;
            font-size: 14px;
            margin: 18px 0 0 0;
            width: 100%;
            outline: #dfdfdf solid 2px;

        }

        .login-page input[type='password']:focus-visible,
        .login-page input[type='email']:focus-visible {
            border: none;
            outline: none;
            outline: #6287A2 solid 2px;

        }

        .login-page .fgp-container {
            display: flex;
            justify-content: space-between;
        }

        .login-page .fgp-container a {
            color: grey;
            text-decoration: none;
            font-size: 14px;
        }

        .login-page .fgp-container a:hover {
            color: rgb(63, 120, 177);
        }

        .login-page .btn-submit {
            font-size: 16px;
            background-color: #6287A2;
            cursor: pointer;
            border: none;
            width: 100%;
            color: white;
            height: 36px;
            border-radius: 3px;
            margin: 0 0 46px 0;
        }

        .login-page .btn-submit:hover {
            background-color: #486e8b;
        }

        .login-page .sigin-banner {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
            font-weight: bold;
            color: #888888;
        }
        .login-page .invalid-feedback{
            font-size: 12px;
            color: red;
        }
        .login-page .normal-checkbox{
            margin-top: 18px;
        }
    </style>
    <div class="login-page">
        <div class="container">
            <div class="card-wrapper">
                <div class="logo-container"><img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%" height="100%"
                        alt=""></div>
                <div class="card">
                    <div class="sigin-banner">
                        Sign In
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="">

                                <div class="">
                                    <input id="email" type="email" class=" @error('email') is-invalid @enderror"
                                        name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}"
                                        required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input id="password" type="password" placeholder="{{ __('Password') }}"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <label class="normal-checkbox" for="remember">{{ __('Remember Me') }}
                                            <input type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-submit">
                                {{ __('Login') }}
                            </button>


                            <div class="fgp-container">
                                <div class="">

                                    @if (Route::has('password.request'))
                                        <a class="" href="{{ route('register') }}">
                                            {{ __('Sigin Up') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="">

                                    @if (Route::has('password.request'))
                                        <a class="" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
