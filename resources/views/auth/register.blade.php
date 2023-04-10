@extends('layouts.app')

@section('content')
    <style>
        .register-page {
            width: 100%;
            height: 100vh;
        }

        .register-page .container {
            /* background-color: #f7faff; */
            background-image: repeating-linear-gradient(#f7faff 0%, #ecf0f8 45%, #f2f7ff 100%);
            height: 100%;
        }

        .register-page .card-wrapper {
            position: absolute;
            top: 350px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .register-page .card {
            max-width: 380px;
            min-width: 380px;
            padding: 34px 42px 20px 42px;
            background-color: #fdfdfd;
            border-radius: 3px;
            box-shadow: 0 0 8px 4px #dfe1e9;
        }

        .register-page .logo-container {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: center;
            margin: 0 0 46px 0;

        }

        .register-page input[type='password'],
        .register-page input[type='text'],
        .register-page input[type='email'] {
            height: 36px;
            border: none;
            border-radius: 3px;
            padding: 0 12px;
            font-size: 14px;
            margin: 18px 0 0 0;
            width: 100%;
            outline: #dfdfdf solid 2px;

        }

        .register-page input[type='password']:focus-visible,
        .register-page input[type='text']:focus-visible,
        .register-page input[type='email']:focus-visible {
            border: none;
            outline: none;
            outline: #6287A2 solid 2px;

        }

        .register-page .fgp-container {
            display: flex;
            justify-content: end;
        }

        .register-page .fgp-container a {
            color: grey;
            text-decoration: none;
            font-size: 14px;
        }

        .register-page .fgp-container a:hover {
            color: rgb(63, 120, 177);
        }

        .register-page .btn-submit {
            font-size: 16px;
            background-color: #6287A2;
            cursor: pointer;
            border: none;
            width: 100%;
            color: white;
            height: 36px;
            border-radius: 3px;
            margin: 18px 0 46px 0;
        }

        .register-page .btn-submit:hover {
            background-color: #486e8b;
        }

        .register-page .sigin-banner {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
            font-weight: bold;
            color: #888888;
        }

        .register-page .invalid-feedback {
            font-size: 12px;
            color: red;
        }

        .register-page .normal-checkbox {
            margin-top: 18px;
        }

        .register-page .card-container {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="register-page">
        <div class="container">
            <div class="card-wrapper">
                <div class="logo-container"><img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%" height="100%"
                        alt=""></div>
                <div class="card-container">

                    <div class="card">
                        <div class="sigin-banner">
                            Register
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf


                                <div class="">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        placeholder="{{ __('Name') }}" value="{{ old('name') }}" required
                                        autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="">
                                    <input id="email" type="email" class=" @error('email') is-invalid @enderror"
                                        name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}"
                                        required autocomplete="email" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="password" type="password" placeholder="{{ __('Password') }}"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="{{ __('Confirm Password') }}" name="password_confirmation"
                                            required autocomplete="new-password">
                                    </div>
                                </div>



                                <button type="submit" class="btn-submit">
                                    {{ __('Register') }}
                                </button>



                                <div class="fgp-container">
                                    <div class="">

                                        @if (Route::has('password.request'))
                                            <a class="" href="{{ route('login') }}">
                                                {{ __('Back To Login') }}
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
    </div>
@endsection
