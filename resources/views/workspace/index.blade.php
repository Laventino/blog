@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .workspace-page {
            position: absolute;
            height: calc(100vh - var(--nav-height));
            width: calc(100vw - var(--menu-width));
            margin: var(--nav-height) 0 0 var(--menu-width);
            overflow: auto;
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10 and IE 11 */
            user-select: none;
            /* Standard syntax */
        }

        .workspace-page .container {
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            position: relative;
            min-height: 100%;
            width: 100%;
        }

        .workspace-page .category {
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 30px 10px 10px 10px;
        }

        .workspace-page .my-workspace-container {
            padding: 5px 0 0 30px;
            display: flex;
            flex-wrap: wrap;
        }

        .workspace-page .workspace-card {
            height: 120px;
            width: 240px;
            border-radius: 2px;
            background-color: #b4b4b424;
            padding: 12px 10px;
            cursor: pointer;
        }

        .workspace-page .workspace-card-link{
            text-decoration: none;
            margin: 0 10px 10px 0;
        }

        .workspace-page .workspace-card:hover {
            background-color: #dadada24;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 0px 4px;
        }

        .workspace-page .workspace-card .title,
        .workspace-page .workspace-card .description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .workspace-page .workspace-card .title {
            font-size: 16px;
            color: white;
            -webkit-line-clamp: 1;
        }

        .workspace-page .workspace-card .description {
            padding-top: 8px;
            font-size: 13px;
            color: rgb(212, 212, 212);
            -webkit-line-clamp: 3;
        }

        .workspace-page .workspace-card .add-icon {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .workspace-page .workspace-card .add-icon i {
            color: rgb(104, 104, 104);
            font-size: 24px;
            width: 34px;
            height: 34px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .workspace-page .workspace-card:hover .add-icon i {
            color: rgb(143, 143, 143);
            background-color: #6e6e6e48;
        }

        /* card for create new workspace */
        .background-layer {
            background-color: #24242477;
            width: 100vw;
            height: 100vh;
            position: absolute;
            z-index: 400;
            top: 0;
            left: 0;
        }

        .add-new-workspace-card-container {
            background-color: #424242;
            max-width: 360px;
            min-width: 320px;
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 2px;
            transform: translate(-50%, -50%);
        }

        .add-new-workspace-card-container .header {
            width: 100%;
            height: 35px;
            display: flex;
            padding: 2px 10px;
            position: relative;

        }

        .add-new-workspace-card-container .header .close {
            width: 32px;
            height: 32px;
            position: absolute;
            right: 0;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(204, 204, 204);
            margin: 3px 3px 0 0;
            border-radius: 2px;
            cursor: pointer;
        }

        .add-new-workspace-card-container .header .close:hover {
            color: white;
            background-color: #929292
        }

        .add-new-workspace-card-container .header .title {
            padding: 0 40px;
            color: white;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .add-new-workspace-card-container .header .title::after {
            content: "";
            width: 50%;
            border-bottom: 1px solid #646464;
            position: absolute;
            height: 100%;
        }

        .add-new-workspace-card-container .body {
            padding: 12px 0 0 0;
        }

        .add-new-workspace-card-container .body label {
            padding: 12px;
            font-size: 14px;
            color: white;
        }

        .add-new-workspace-card-container .body .input-text {
            width: calc(100% - 20px);
            margin: 8px 10px;
            height: 34px;
            border: none;
            outline: none;
            font-size: 13px;
            color: white;
            padding: 12px;
            border-radius: 3px;
            box-shadow: 0 0 0 2px rgb(138, 138, 138);
            background-color: #6e6e6e;
        }

        .add-new-workspace-card-container .body textarea {
            resize: none;
            border: none;
            min-height: 64px;
            max-height: 100px;
            font-family: Noto-Sans;
            width: calc(100% - 20px);
            margin: 8px 10px;
            border: none;
            outline: none;
            font-size: 13px;
            color: white;
            padding: 12px;
            border-radius: 3px;
            box-shadow: 0 0 0 2px rgb(138, 138, 138);
            background-color: #6e6e6e;
        }

        .add-new-workspace-card-container .body .input-submit {
            height: 32px;
            min-height: 32px;
            outline: none;
            align-items: center;
            border: none;
            border-radius: 2px;
            box-shadow: none;
            cursor: pointer;
            display: inline-flex;
            font-size: 14px;
            font-weight: 400;
            justify-content: center;
            text-decoration: none;
            margin: 0 10px 24px 10px;
            padding: 4px 12px;
            background-color: #999999;
            color: white;
            width: calc(100% - 20px);
        }
    </style>
    <div class="workspace-page">
        <div class="container">
            <div class="category">
                Your Workspace
            </div>
            <div class="my-workspace-container">
                <?php
                if (isset($workspace)) {
                    $str_workspace = '';
                    foreach ($workspace as $key => $w) {
                        $str_workspace .= '<a href="/workspace/'.$w->id.'" target="" class="workspace-card-link"><div class="workspace-card"><div class="title">' . $w->title . '</div><div class="description">' . $w->description . '</div></div></a>';
                    }
                    echo $str_workspace;
                }
                ?>
                <div class="workspace-card add_new_workspace_card">
                    <div class="add-icon">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
            </div>
            <div class="category">
                Participate Workspace
            </div>
            <div class="my-workspace-container">
                <div class="workspace-card">
                    <div class="title">Participate First Workspace</div>
                    <div class="description">This work space is create to test in style and process of javascript.</div>
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
        let add_new_workspace_card = (e) => {
            let str = `<div class="background-layer">
                        <div class="add-new-workspace-card-container">
                            <div class="header">
                                <div class="title">Create new workspace</div>
                                <div class="close"><i class="fa-sharp fa-solid fa-xmark"></i></div>
                            </div>
                            <div class="body">
                                <label for="workspace-title">Title</label>
                                <input class="input-text" id="workspace-title" type="text">
                                <label for="workspace-description">Description</label>
                                <textarea name="" id="workspace-description" auto-resize="on" placeholder="Please enter task title..."></textarea>
                                <input class="input-submit" type="submit" value="Create">
                            </div>
                        </div>
                    </div>`;
            let el = $(str);
            el.find(".close").on("click", function() {
                el.remove();
            });
            el.find(".input-submit").on("click", function() {
                let title = el.find(".input-text").val();
                let des = el.find("textarea").val();
                if (title != "") {
                    let str_wc = `<a href="#" target="" style="pointer-events: none;" class="workspace-card-link"><div class="workspace-card"><div class="title">${title}</div><div class="description">${des}</div></div></a>`;
                    let el_wc = $(str_wc);
                    $(".add_new_workspace_card").before(el_wc);
                    ajaxCustom({
                        "title": title,
                        "description": des
                    }, "/create-new-workspace", function(res) {
                        el_wc.attr("href","/workspace/"+res.id).css("pointer-events","");
                    });
                  
                    el.remove();
                }
            });
            $("body").append(el);
            el.find(".input-text").focus();
        }
        $(document).off("click", ".add_new_workspace_card", add_new_workspace_card);
        $(document).on("click", ".add_new_workspace_card", add_new_workspace_card);
    </script>
@endsection
