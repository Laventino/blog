@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .setting-page {
            position: absolute;
            height: calc(100vh - var(--nav-height));
            width: calc(100vw - var(--menu-width));
            margin: var(--nav-height) 0 0 var(--menu-width);
            overflow: auto;
            top:0;
        }

        .setting-page .container {
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            position: relative;
            min-height: 100%;
            width: 100%;
            padding: 8px;
        }

        .label-white {
            color: white;
        }

        .unselect {
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }

        .item-wrapper {
            width: 500px;
            background-color: #424242;
            display: flex;
            padding: 12px 12px;
            flex-direction: column;
            border-radius: 2px;
        }
        .reset-button-wrapper {
            margin-top: 4px;
        }
        .reset-button{
            height: 32px;
            width: 100%;
        }
        .d-flex {
            display: flex;
        }
        .w-p-8 {
            width: 80%;
        }
        .w-p-2 {
            width: 20%;
        }
        .submit-button {
            height: 32px;
            width: 100%;
        }
        .input-text {
            height: 32px;
        }
    </style>
    <div class="setting-page">
        <div class="container">
            <div class="item-wrapper">
                <div class="d-flex">
                    <input type="text" class="w-p-8 input-text" name="" id="url" placeholder="URL">
                    <input type="text" class="w-p-2 input-text" name="" id="start" placeholder="Start Index">
                </div>
               <button id="submit" class="submit-button">Submit</button>
            </div>
        </div>
    </div>

    <script>
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
        let url = $('#url');
        let start = $('#start');
        $('#submit').on('click', function(){
            if(url.val() != null && url.val() != "") {
                ajaxCustom({
                    "url": url.val(),
                    "start": start.val(),
                }, '/download-image/url', function(res) {
                    
                });
                url.val('')
                start.val('')
            }
        })
    </script>
@endsection
