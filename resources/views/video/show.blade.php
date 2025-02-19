<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <script src="{{ asset('js/javascript.js') }}"></script>
    <style>
        body {
            margin: 0;
            background-color: #242424;
        }

        .nav {
            z-index: 100;
            background-color: #323232;
            height: 42px;
            width: 100%;
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-between
        }

        .container {
            margin-top: 42px;
        }

        .back {
            height: 100%;
            width: 100px;
            background-color: #424242;
            color: white;
            font-family: 'Courier New', Courier, monospace;
            cursor: pointer;
        }

        .back a {
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }

        .back:hover {
            background-color: #525252;
        }

        .pagination-top nav {
            height: 100%;
        }

        .pagination-top nav ul {
            display: flex;
            margin: 0;
            height: 100%;
            padding: 0;
        }

        .pagination-top nav ul li {
            display: none;
        }

        .pagination-top nav ul li:last-child,
        .pagination-top nav ul li:first-child {
            display: flex;
            height: 100%;
            background-color: #424242;
        }

        .pagination-top nav ul li:last-child a,
        .pagination-top nav ul li:first-child a {
            color: white;
            font-size: 32px;
            text-decoration: none;
            justify-content: center;
            align-items: center;
            display: flex;
            height: 100%;
            width: 50px;
            background-color: #424242;
        }

        .pagination-top nav ul li:last-child a:hover,
        .pagination-top nav ul li:first-child a:hover {
            background-color: #525252;
        }

        .pagination-bottom {}

        .pagination-bottom nav {
            display: flex;
            justify-content: center
        }

        .pagination-bottom .pagination {
            padding: 0;
            margin: 0;
            display: flex;
            width: 100%;
        }

        .pagination-bottom .page-item {
            list-style: none;
            display: none;
        }
        .pagination-bottom .page-item:last-child,
        .pagination-bottom .page-item:first-child {
            display: block;
            width: 50%;
        }
        .pagination-bottom .page-item .page-link,
        .pagination-bottom .page-item a {
            text-decoration: none;
            height: 42px;
            background-color: #424242;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            border-left: 1px solid #727272;
            border-right: 1px solid #727272;
        }

        .pagination-bottom .page-item.active .page-link,
        .pagination-bottom .page-item.active a {
            background-color: #525252;
        }

        .box-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .box-wrapper a {
            display: flex;
            /* width: 33.3333%; */
            /* height: 100%; */
            padding: 4px;
        }

        .box-wrapper a img {
            width: 300px;
            /* height: 250px; */
        }


        video {
            width: 100%;
            max-height: 90vh;
        }

        .section_detail {
            box-sizing: border-box;
            padding: 5px 10px 15px 15px;
            background-color: #727272;
            width: 100%;
            display: flex;
            justify-content: space-between
        }
        .section_detail .info {
        }
        .section_detail .text {
            color: white;
            font-family: 'Courier New', Courier, monospace;
            padding-bottom: 8px;
            word-wrap: break-word;
        }
        .section_detail .name {
        }
        .section_detail .option {
            margin-left: 10px;
            display: flex;
            align-items: flex-start;
        }
        .section_detail .button-style {
            color: white;
            margin-left: 5px;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4px 8px;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
            text-wrap: nowrap;
            position: relative;
            overflow: hidden;
            transition: background-color 0.2s linear;
        }

        .section_detail .button-delete {
            background-color: #b50000;
        }
        .section_detail .button-error {
            background-color: #cf8600;
        }
        .section_detail .button-duplicate {
            background-color: #afaf00;
        }
        .section_detail .button-miss-category {
            background-color: #670067;
        }
        .section_detail .button-style.disable {
            background-color: #555555;
        }
        .section_detail .button-delete:hover {
            background-color: #880000;
        }
        .section_detail .button-error:hover {
            background-color: #a36a00;
        }
        .section_detail .button-duplicate:hover {
            background-color: #808000;
        }
        .section_detail .button-miss-category:hover {
            background-color: #3d003d;
        }
        .section_detail .button-style.disable {
            background-color: #555555;
        }
        .section_detail .button-style.disable:hover {
            background-color: rgb(73, 73, 73);
        }

        .section_detail .button-style.loading {
            background-color: #000000;
        }
    </style>
</head>

<body>
    <div class="nav">
        <div class="back">
            <a href="/videos" id="back">Back</a>
        </div>
        <div class="pagination-top">
            <nav>
                <ul class="pagination">
                    <li class="page-item" aria-disabled="true" aria-label="« Previous">
                        <a class="page-link" {{(!$prev && 'disable')}} href="{{ '/videos/' . ($next != null ? $next->id : '') }}" rel="next"
                            aria-label="Next »">‹</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" {{(!$next && 'disable')}} href="{{ '/videos/' . ($prev != null ? $prev->id : '') }}" rel="next"
                            aria-label="Next »">›</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container">
        <video controls id="{{ $data ? $data->id : ''}}" class="main_video">
            <source src="{{ $data ? '/storage' . $data->path : ''}}" type="video/mp4">
        </video>

        <div class="section_detail">
            <div class="info">
                <div class="name text">{{$data->name}}</div>
                <div class="duration text">Duration: {{$data->duration ? $data->duration : 'unable to calculate'}}</div>
                <div class="path text">PATH: {{$data->path}}</div>
            </div>
            <div class="option">

                <?php
                    $mark = [];
                    foreach ($data->mark as $key => $value) {
                        if ($value->status) {
                            $mark[$value->mark_name] = $value->mark_text;
                        }
                    }
                ?>
                <div class="button-style move_video_button disable">Move to old</div>
                <div class="button-delete button-style video_option_button {{array_key_exists('delete', $mark) ? '' : 'disable'}}" value="delete">Delete</div>
                <div class="button-error button-style video_option_button {{array_key_exists('error', $mark) ? '' : 'disable'}}" value="error">Error</div>
                <div class="button-duplicate button-style video_option_button {{array_key_exists('duplicate', $mark) ? '' : 'disable'}}" value="duplicate">Duplicate</div>
                <div class="button-miss-category button-style video_option_button {{array_key_exists('wrong_category', $mark) ? '' : 'disable'}}" value="wrong_category">Miss Category</div>
            </div>
        </div>
        <div class="box-wrapper">
            @foreach ($datas as $item)
                <?php

                // ;public_path('storage/thumbnail/')
                    if(isset($item->cover_path)){
                        $src = URL::to('/') .'/storage/thumbnail/'. $item->cover_path .'.jpg';
                    }else{
                        $src = URL::to('/') .'/assets/image/none-image.png';
                    }
                ?>
                {{-- <p>This is user {{ $user->id }}</p> --}}
                <a href="/videos/{{$item->id}}" class="box">
                    <img src="{{$src}}" alt="">
                </a>

            @endforeach
        </div>
    </div>
    <div class="pagination-bottom">
        {{$datas->links()}}
    </div>

    <script>
        let video = getCookie("video");
        let id = $(".main_video").attr("id");
        if(video){
            $(".back a").attr("href", video);
        }
        // $(document).ready(function(){
        //     $(".button-delete").click(function(){
        //         $.get("/", function(data, status){
        //             alert("Data: " + data + "\nStatus: " + status);
        //         });
        //     });
        // });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function ajaxCustom(data_, url_, func_) {
            $.ajax({
                url: url_,
                data: data_,
                type: "POST",
                success: function(result) {
                    if (typeof func_ == "function") {
                        func_(result);
                    }
                }
            });
        }

        $(".video_option_button").click(function(){
            let _this = $(this)
            let status = $(this).attr("value");
            if (_this.hasClass("loading")) {
                return false;
            }
            _this.addClass("loading");
            ajaxCustom({
                "status": status,
                "id": id
            }, "/v1/video/status/update", function(res) {
                console.log(res);
                if (res) {
                    _this.removeClass("disable");
                } else {
                    _this.addClass("disable");
                }
                _this.removeClass("loading");
            });
        });

        $(".move_video_button").click(function(){
            let _this = $(this)
            if (_this.hasClass("loading")) {
                return false;
            }
            _this.addClass("loading");
            ajaxCustom({
                "id": id
            }, "/v1/video/status/move", function(res) {
                if (res == 'move') {
                    _this.removeClass("disable");
                    back();
                } else {
                    _this.addClass("disable");
                }
                _this.removeClass("loading");
            });
        });
        function back(){
            var back = document.getElementById("back");
            back.click();
        }
    </script>
</body>

</html>
