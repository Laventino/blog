<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery-min.js') }}"></script>
    <script src="{{ asset('js/javascript.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
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
        .previous,
        .back{
            height: 100%;
            width: 100px;
            background-color: #424242;
            color: white;
            font-family: 'Courier New', Courier, monospace;
            cursor: pointer;
        }
        .previous a,
        .back a{
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            width: 100%;
            height: 100%;
        }
        .previous:hover,
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
            width: 300px;
            /* height: 250px; */
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
            max-height: calc(100vh - 100px);
            overflow: auto;
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
            top: 0;
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
        <div class="previous">
            <a href="/videos-folder?path={{$previousPath}}">Previous</a>
        </div>
        <div class="back">
            <a href="/home">Back</a>
        </div>
    </div>
    <style>
        .file-container {
            margin-top: 42px;
            height: calc(100vh - 42px);
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            cursor: default;
        }
        .file-container .folder:hover{
            background-color: #ffffff11;
        }
        .file-container .icon {
            margin: 2px;
            height: 100px;
            width: 136px;
            background-color: #99999922;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .file-container .icon i {
            color: white;
            font-size: 74px;
        }
        .file-container .icon img {
            height: 100px;
            width: 136px;
            object-fit: contain;
        }
        .file-container .name {
            width: 100px;
            display: flex;
            justify-content: left;
            color: white;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .file-container.hide {
            display: none;
        }
    </style>
    <div class="file-container" id="file-container">
        @foreach ($arrPath as $path)
            @if ($path['ext'] == '') 
            <div class="folder" path="{{$path['path']}}">
                <div class="icon">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="name">
                    {{ $path['name'] }}
                </div>
            </div>
            @elseif ($path['ext'] == 'mp4')
            <div class="mp4" url="{{$path['path']}}">
                <div class="icon">
                    <img src="{{$path['img_path']}}" alt="">
                    {{-- <i class="fa-regular fa-circle-play"></i> --}}
                </div>
                <div class="name" title="{{$path['name']}}">
                    {{ $path['name'] }}
                </div>
            </div>
            @endif
        @endforeach
    </div>
    <style>
        #video-modal {
            z-index: 200;
            background-color: #242424;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
        }
        #video-modal.show{
            display: block;
        }
        #video-modal .video-nav {
            position: absolute;
            top: 0;
            height: 42px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        #video-modal .video-nav .trash {
            background-color: #424242;
            cursor: pointer;
            width: 110px;
            height: 42px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #video-modal .video-nav .close{
            background-color: #424242;
            cursor: pointer;
            width: 42px;
            height: 42px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
        }
        #video-modal .video-nav .trash:hover,
        #video-modal .video-nav .close:hover {
            background-color: #525252;
        }
        #video-modal video {
            margin-top: 42px;
            width: 100%;
            height: calc(100% - 46px);
        }
    </style>
    <div id="video-modal">
        <div class="video-nav">
            <div class="trash" id="trash-video">
                Move To Trash
            </div>
            <div class="close" id="close-video">
                x
            </div>
        </div>
        <video id="video" controls class="">
            <source src="" type="video/mp4">
        </video>
    </div>
    <style>
        .confirm-box {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #24242455;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 300;
            border-radius: 2px;
        }
        .confirm-box.show {
            display: flex;
        }
        .notify-box {
            height: 90px;
            width: 250px;
            background-color: white;
            display: flex;
            
        }
        .notify-box-close,
        .notify-box-trash {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90px;
            width: 125px;
        }
        .notify-box-close {
            background-color: #c4c4c455;
        }
        .notify-box-close:hover {
            background-color: #6e6e6e9c;
        }
        .notify-box-trash {
            background-color: #fd63639c;
        }
        .notify-box-trash:hover {
            background-color: #ff4040b4;
        }

    </style>
    <div class="confirm-box" id="confirm-box">
        <div class="notify-box">
            <div class="notify-box-close" id="notify-box-close"> Close</div>
            <div class="notify-box-trash" id="notify-box-trash"> Trash</div>
        </div>
    </div>
    <script>
        setCookie("video", window.location.pathname + window.location.search, 30)
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
        $(".folder").on("click", function(){
            const protocol = window.location.protocol;
            const host = window.location.host;
            const query = encodeURIComponent($(this).attr("path"));
            const fullURL = `${protocol}//${host}/videos-folder?path=${query}`;
            window.location.href = fullURL;
        })
        $(".mp4").on("click", function(){
            const url = 'storage' + $(this).attr("url");
            $('#video source').attr('src', url);
            $("#video")[0].load();
            $("#video")[0].play();
            $("#video-modal").addClass('show');
            $("#file-container").addClass('hide');
        })
        $("#close-video").on("click", function(){
            $('#video source').attr('src', '');
            $("#video")[0].load();
            $("#video-modal").removeClass('show');
            $("#file-container").removeClass('hide');
        })
        $("#trash-video").on("click", function(){
            $("#confirm-box").addClass('show');
        })
        $("#notify-box-close").on("click", function(){
            $("#confirm-box").removeClass('show');
        })
        $("#notify-box-trash").on("click", function(){
            let _this = $(this);
            ajaxCustom({
                "src": $('#video source').attr('src')
            }, "/video/move-to-trash", function(res) {
                $("#confirm-box").removeClass('show');
                $("#close-video").click();
            });
        })

        </script>
</body>
</html>
