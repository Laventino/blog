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
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .box-wrapper img {
            display: block;
            width: 100%;
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
            <a href="/videos">Back</a>
        </div>
    </div>

    <div class="container">
        <div class="box-wrapper">
            @foreach ($data as $item)
                <?php
                    if(isset($item->path)){
                        $src = URL::to('/') .'/storage/videos/PT/manga/'. $item->path;
                    }else{
                        $src = URL::to('/') .'/assets/image/none-image.png';
                    }
                ?>
                <img src="{{$src}}" alt="">
                    
            @endforeach
        </div>
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
    </script>
</body>

</html>
