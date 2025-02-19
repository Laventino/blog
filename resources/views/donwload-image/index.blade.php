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
        .action-button {
            height: 32px;
            width: 150px;
        }
        .input-text {
            height: 32px;
        }
        .mb-1 {
            margin-bottom: 1rem;
        }
        .mb-2 {
            margin-bottom: 2rem;
        }
        .mb-3 {
            margin-bottom: 3rem;
        }
        .mb-4 {
            margin-bottom: 4rem;
        }
        .mb-5 {
            margin-bottom: 5rem;
        }
        .table-wrapper {
            background-color: #424242;
            display: flex;
            padding: 12px 12px;
            flex-direction: column;
            border-radius: 2px;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .preview-image {
            width: 150px;
        }
        .url-column,
        .title-column {
            overflow: hidden;
            white-space: nowrap;
            width: 250px;
            text-overflow: ellipsis;        
        }
    </style>
    <div class="setting-page">
        <div class="container">
            <div class="item-wrapper mb-1">
                <div class="d-flex">
                    <input type="text" class="w-p-8 input-text" name="" id="url" placeholder="URL">
                    <input type="text" class="w-p-2 input-text" name="" id="start" placeholder="Start Index">
                </div>
               <button id="submit" class="submit-button">Submit</button>
            </div>
            <div class="item-wrapper mb-1">
                <div class="d-flex">
                    <button id="refresh-cover" class="action-button">Refresh Cover</button>
                    <button id="retry-all" class="action-button">Retry All</button>
                </div>
            </div>
            <div class="table-wrapper">
                <div class="d-flex label-white mb-1">
                    Total: {{ $data->count() }}
                </div>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Url</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Complete</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($data as $item)
                        <tr>
                            <td>
                                <div class="title-column" title="{{$item->title }}">
                                    {{ $item->title }}
                                </div>
                            </td> 
                            <td>
                                <img class="preview-image" src="{{ $item->image }}" alt="">
                            </td>
                            <td>
                                <div class="url-column url_column" title="{{$item->title }}">
                                    {{ $item->url }}
                                </div>
                            </td>
                            <td>{{ $item->status_text }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->completed }}</td>
                            <td>
                                <button class="button_fill" value="{{$item->id}}">Filling</button>
                                <button class="button_retry" value="{{$item->id}}">Retry</button>
                                <button class="button_remove" value="{{$item->id}}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
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
        
        $('.url_column').on('click', function() {
            let text = $(this).text().trim(); 
            navigator.clipboard.writeText(text);
        })
        let url = $('#url');
        let start = $('#start');
        $('#submit').on('click', function(){
            if(url.val() != null && url.val() != "") {
                ajaxCustom({
                    "url": url.val(),
                    "start": start.val(),
                }, '/download-image/url', function(res) {
                    console.log(res);
                    location.reload();
                });
                url.val('')
                start.val('')
            }
        })
        $('#refresh-cover').on('click', function(){
            ajaxCustom({}, '/download-image/refresh-cover', function(res) {
                location.reload();
            });
        })
        $('#retry-all').on('click', function(){
            ajaxCustom({}, '/download-image/retry-all', function(res) {
                location.reload();
            });
        })
        $('.button_retry').on('click', function(){
            const value = $(this).attr('value')
            if(value) {
                ajaxCustom({
                    "id": value
                }, '/download-image/retry', function(res) {
                    location.reload();
                });
            }
        })
        $('.button_fill').on('click', function(){
            const value = $(this).attr('value')
            if(value) {
                ajaxCustom({
                    "id": value
                }, '/download-image/fill', function(res) {
                    location.reload();
                });
            }
  
        })
        $('.button_remove').on('click', function(){
            const value = $(this).attr('value')
            if(value) {
                ajaxCustom({
                    "id": value
                }, '/download-image/delete', function(res) {
                    location.reload();
                });
            }
  
        })
    </script>
@endsection
