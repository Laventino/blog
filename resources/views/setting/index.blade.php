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
            width: 250px;
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
    </style>
    <div class="setting-page">
        <div class="container">
            <div class="item-wrapper">
                @foreach ($groupMedias as $media)
                <div class="item unselect">
                    <input type="checkbox" class="media_checkbox" name="{{$media->id}}" id="{{$media->id}}-checkbox">
                    <label for="{{$media->id}}-checkbox" class="label-white">{{$media->name}}</label>
                </div>
                @endforeach
                <div class="reset-button-wrapper">
                    <button class="reset-button reset_button">RESET</button>
                </div>
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
        let mediaCheckBox = $('.media_checkbox');
        let isProccess = false;
        $('.reset_button').on('click', function(){
            var checkedCheckboxNames = [];
            let _this = $(this);
            _this.html('LOADING...');
            if (isProccess == false) {
                isProccess = true;
                $('.media_checkbox[type="checkbox"]:checked').each(function() {
                    var attributeName = $(this).attr('name');
                    checkedCheckboxNames.push(attributeName);
                });
                if (checkedCheckboxNames.length > 0) {
                    ajaxCustom({
                        "media_ids": checkedCheckboxNames,
                    }, '/setting/reset/medias', function(res) {
                        console.log(res)
                        _this.html('RESET');
                        isProccess = false;
                        $('.media_checkbox[type="checkbox"]:checked').each(function() {
                            $(this).prop('checked', false);
                        });
                    });
                } else {
                    _this.html('RESET');
                        isProccess = false;
                }
            }
        })
    </script>
@endsection
