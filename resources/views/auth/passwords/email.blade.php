@extends('layouts.app')

@section('content')
<style>
    .reset-password-page {
        width: 100%;
        height: 100vh;
    }

    .reset-password-page .container {
        /* background-color: #f7faff; */
        background-image: repeating-linear-gradient(#f7faff 0%, #ecf0f8 45%, #f2f7ff 100%);
        height: 100%;
    }

    .reset-password-page .card-wrapper {
        position: absolute;
        top: 300px;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .reset-password-page .card {
        max-width: 380px;
        min-width: 380px;
        padding: 34px 42px 20px 42px;
        background-color: #fdfdfd;
        border-radius: 3px;
        box-shadow: 0 0 8px 4px #dfe1e9;
    }

    .reset-password-page .logo-container {
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: center;
        margin: 0 0 46px 0;

    }

    .reset-password-page input[type='password'],
    .reset-password-page input[type='email'] {
        height: 36px;
        border: none;
        border-radius: 3px;
        padding: 0 12px;
        font-size: 14px;
        margin: 18px 0 0 0;
        width: 100%;
        outline: #dfdfdf solid 2px;

    }

    .reset-password-page input[type='password']:focus-visible,
    .reset-password-page input[type='email']:focus-visible {
        border: none;
        outline: none;
        outline: #6287A2 solid 2px;

    }

    .reset-password-page .fgp-container {
        display: flex;
        justify-content: end;
    }

    .reset-password-page .fgp-container a {
        color: grey;
        text-decoration: none;
        font-size: 14px;
    }

    .reset-password-page .fgp-container a:hover {
        color: rgb(63, 120, 177);
    }

    .reset-password-page .btn-submit {
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

    .reset-password-page .btn-submit:hover {
        background-color: #486e8b;
    }

    .reset-password-page .sigin-banner {
        display: flex;
        justify-content: center;
        margin-bottom: 24px;
        font-weight: bold;
        color: #888888;
    }
    .reset-password-page .invalid-feedback{
        font-size: 12px;
        color: red;
    }
    .reset-password-page .normal-checkbox{
        margin-top: 18px;
    }
</style>
<div class="reset-password-page">
    <div class="container">
        <div class="card-wrapper">
            <div class="logo-container"><img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%" height="100%"
                    alt=""></div>
            <div class="card">
                <div class="sigin-banner">
                    {{ __('Reset Password') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
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
                    
                        <button type="submit" class="btn-submit">
                            {{ __('Send Password Reset Link') }}
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
@endsection
