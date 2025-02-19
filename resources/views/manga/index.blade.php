<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <script src="{{ asset('js/javascript.js') }}"></script>
    <title>Document</title>
    <style>
        body{
            margin: 0;
            background-color: #242424;
        }
        .nav{
            z-index: 100;
            background-color: #323232;
            height: 42px;
            width: 100%;
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-between
        }
        .container{
            margin-top: 42px;
        }
        .back{
            height: 100%;
            width: 100px;
            background-color: #424242;
            color: white;
            font-family: 'Courier New', Courier, monospace;
            cursor: pointer;
        }
        .back a{
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }
        .back:hover{
            background-color: #525252;
        }
        .pagination-top nav{
            height: 100%;
        }
        .pagination-top nav ul{
            display: flex;
            margin: 0;
            height: 100%;
            padding: 0;
        }
        .pagination-top nav ul li{
            display: none;
        }
        .pagination-top nav ul li:last-child,
        .pagination-top nav ul li:first-child{
            display: flex;
            height: 100%;
            background-color: #424242;
        }
        .pagination-top nav ul li:last-child .page-link,
        .pagination-top nav ul li:first-child .page-link,
        .pagination-top nav ul li:last-child a,
        .pagination-top nav ul li:first-child a{
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
        .pagination-top nav ul li:first-child a:hover{
            background-color: #525252;
        }
        .pagination-bottom{
            margin-top: 5px;

        }
        .pagination-bottom nav{
            display: flex;
            justify-content: center

        }
        .pagination-bottom .pagination{
            padding: 0;
            margin: 0;
            display: flex;
        }
        .pagination-bottom .page-item{
            list-style: none;

        }
        .pagination-bottom .page-item .page-link,
        .pagination-bottom .page-item a{
            text-decoration: none;
            width: 32px;
            height: 32px;
            background-color: #424242;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            border-left: 1px solid #323232;
            border-right: 1px solid #323232;
        }
        .pagination-bottom .page-item.active .page-link,
        .pagination-bottom .page-item.active a{
            background-color: #626262;
        }
        .box-wrapper{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .box-wrapper a{
            display: flex;
            position: relative;
            /* width: 33.3333%; */
            /* height: 100%; */
            margin: 4px;
        }
        .box-wrapper a img{
            width: 280px;
            object-fit: contain;
            height: 360px;
        }
        .menu{
            height: 100%;
            position: relative;
        }
        .menu .title{
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100px;
            background-color: #424242;
            color: white;
            font-family: 'Courier New', Courier, monospace;
            cursor: pointer;
            position: relative;
        }
        .drop-card{
            background-color: #424242;
            width: 100%;
            position: absolute;
            top: 100%;
            display: none;
        }
        .drop-card.show{
            display: block;
        }
        .drop-card .element-card{
            height: 42px;
            display: flex;
            align-items: center;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Courier New', Courier, monospace;
            justify-content: center;
        }
        .drop-card .element-card:hover{
            background-color: #525252;
        }
        .box-wrapper a .duration{
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #242424ba;
            color: white;
            font-size: 16px;
            padding: 3px 9px;
        }
    </style>

</head>
<body>
    <div class="nav">
        <div class="back">
            <a href="/home">Back</a>
        </div>

        <div class="menu">
            <div class="title">FILE</div>
            <div class="drop-card">
                <a class="element-card" href="/manga">
                    ALL
                </a>
                @if (isset($groupMedias))
                    @foreach ($groupMedias as $item)
                        <a class="element-card" href="/manga?type={{$item->slug}}">
                            {{$item->name}}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="pagination-top">
            {{$datas->appends(request()->query())->links()}}
        </div>
    </div>

    <style>
        .option {
            display: flex;
            position: absolute;
            top: 0;
            left: 0;
        }

        .button-style {
            color: white;
            padding: 2px 3px;
        }
        .button-delete {
            background-color: #b50000;
        }
        .button-error {
            background-color: #cf8600;
        }
        .button-duplicate {
            background-color: #afaf00;
        }
        .button-miss-category {
            background-color: #670067;
        }
        .button-style.disable {
            display: none;
            background-color: #555555;
        }
        .image-wrapper {
            margin: 0 2px 4px 2px;
            background-color: white;
        }
        .image-wrapper .text{
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            color: white;
            padding: 4px 4px;
            background-color: #242424aa;
        }
    </style>

    <div class="container">
        <div class="box-wrapper">
        @foreach ($datas as $item)
            <?php
                if(isset($item->manga_images) && count($item->manga_images) && $item->manga_images != '' && $item->manga_images[0] != null){
                    $src = URL::to('/') .'/storage/videos/PT/manga'. $item->manga_images[0]->path;
                }else{
                    $src = URL::to('/') .'/assets/image/none-image.png';
                }
            ?>
            <a href="/manga/{{$item->id}}" class="box image-wrapper">
                <img src="{{$src}}" alt="">
                <div class="text">
                    {{$item->name}}
                </div>
                <div class="option">
                    <div class="button-miss-category button-style video_option_button" value="wrong_category">{{$item->total_image}}</div>
                </div>
            </a>
        @endforeach
        </div>
    </div>
    <div class="pagination-bottom">
        {{$datas->links()}}
    </div>

    <script>
        setCookie("video", window.location.pathname + window.location.search, 30)

        $(".menu .title").on("click", function(){
            $(".menu .drop-card").toggleClass("show");
        })

        $(document).on("click", function(e){
            if (!$(e.target).closest(".menu").length) {
                $(".menu .drop-card").removeClass("show");
            }
        })
    </script>
</body>
</html>
