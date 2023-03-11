@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .home-page {
            width: 100%;
            height: 100vh;
        }

        .home-page .container {
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            height: 100%;
        }
    </style>
    <div class="home-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- {{ __('You are logged in!') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
