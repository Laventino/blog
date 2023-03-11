@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .task-page {
            position: absolute;
            height: calc(100vh - var(--nav-height));
            width: calc(100vw - var(--menu-width));
            margin: var(--nav-height) 0 0 var(--menu-width);
            overflow: auto;
        }

        .task-page .container {
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            position: relative;
            height: 100%;
            width: 100%;
        }

        .task-page .task-container {
            overflow: auto;
            display: inline-flex;
        }

        .task-page .task-container .vertical-container {
            background-color: rgb(102, 102, 102);
            width: 300px;
            margin-right: 20px;
            height: 800px;
            flex-grow: 0;
            flex-shrink: 0;
        }

        
    </style>
    <div class="task-page">
        <div class="container">
            <div class="custom_scroll_container">
                <div class="task-container custom_scroll">
                    <div class="vertical-container dd_container" dd-group="c-123">
                        <div class="cs_dd_box">
                            <div class="tt"></div>
                        </div>
                    </div>
                    <div class="vertical-container dd_container" dd-group="c-123"></div>
                    <div class="vertical-container dd_container" dd-group="c-123"></div>
                    <div class="vertical-container dd_container" dd-group="c-123"></div>
                    <div class="vertical-container dd_container" dd-group="c-123"></div>
                    <div class="vertical-container dd_container" dd-group="c-123"></div>
                </div>
                <div class="custom_scroll_vertical_bar">
                    <div class="bar"></div>
                </div>
                <div class="custom_scroll_horizontal_bar">
                    <div class="bar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
