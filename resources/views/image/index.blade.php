<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            margin: 0;
            background-color: #242424;
        }
        .nav{
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
            /* width: 33.3333%; */
            /* height: 100%; */
            padding: 4px;
        }
        .box-wrapper a img{
            width: 300px;
            /* height: 250px; */
        }
        .menu{
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
        }
        .image-card{
            height: 100px;
            width: 180px;
            background-color: #323232;
            color: white;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Courier New', Courier, monospace;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }
        .image-card:hover{
            background-color: #424242;
        }
        .image-wrapper{
            display: none;
        }
        .image-wrapper.open{
            display: block;
        }
        .image-wrapper img{
            width: 100%;
        }
        .image-card img{
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .cover_color{
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #24242452;
        }
        .image-card .name{
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="back">
            <a href="/home">Back</a>
        </div>

        <div class="pagination-top">
            {{-- {{$datas->links()}} --}}
        </div>
    </div>


    <div class="container">
        <div class="box-wrapper">
        @foreach ($datas as $item)
            <?php
            // ;public_path('storage/thumbnail/')
                // if(isset($item->cover_path) && $item->cover_path != '' && $item->cover_path !=null){
                //     $src = URL::to('/') .'/storage/thumbnail/'. $item->cover_path .'.jpg';
                // }else{
                //     $src = URL::to('/') .'/assets/image/none-image.png';
                // }
            ?>
            <div class="image-card" id="{{$item->id}}" onclick="openImageWrapper({{$item->id}})">
                {!! $item->cover_path ? '<img src="'.URL::to('/') .'/storage'.$item->cover_path.'" alt="">' :''!!}
                <div class="cover_color"></div>
                <div class="name">
                    {{$item->name}}
                </div>
            </div>

        @endforeach
            <div class="image-container">
                @foreach ($datas as $item)
                    <div class="image-wrapper" id = "w{{$item->id}}">
                    @foreach ($item->image as $i)
                        <img src="{{URL::to('/') .'/storage'}}{{$i->path}}" alt="">
                    @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pagination-bottom">
        {{-- {{$datas->links()}} --}}
    </div>
</body>
<script>
    function openImageWrapper(id){
        $(".image-wrapper.open").removeClass("open");
        $("#w"+id).addClass("open");
    }
</script>
</html>
