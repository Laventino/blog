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
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10 and IE 11 */
            user-select: none;
            /* Standard syntax */
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
            padding: 40px 10px 0 10px;
        }

        .vertical-container {
            z-index: 2;
            background-color: rgb(102, 102, 102);
            width: 280px;
            margin-right: 20px;
            height: fit-content;
            flex-grow: 0;
            flex-shrink: 0;
            border-radius: 3px;
            padding: 0 0 8px 0;
        }

        .task-element {
            margin: 7px;
            width: calc(100% - 14px);
            background-color: rgb(219, 219, 219);
            border-radius: 3px;
            cursor: pointer;
        }

        .task-element .task-element-title {
            display: flex;
            align-items: center;
            padding: 10px;
            justify-content: space-between;
        }

        .task-element .task-element-title .text {
            font-size: 13px;
            width: calc(100% - 25px);
        }

        .task-element .task-element-title .tool {
            font-size: 13px;
            opacity: 0;
            align-self: flex-start;
            width: 25px;
            height: 25px;
            border-radius: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .task-element .task-element-title .tool:hover {
            background-color: #77777724;
        }

        .task-element .task-element-title:hover .tool {
            opacity: 1;
        }

        .vertical-container .add-card-vertical-container {
            margin: 7px 7px 0px 7px;
        }

        .vertical-container .add-card-form textarea {
            background-color: rgb(219, 219, 219);
            width: 100%;
            resize: none;
            border: none;
            outline: none;
            box-shadow: 1px 1px rgb(82, 82, 82);
            border-radius: 3px;
            min-height: 64px;
            padding: 10px 10px 20px 10px;
            font-family: Noto-Sans;
        }

        .vertical-container .add-card-vertical-title:hover {
            background-color: rgb(87, 87, 87);
        }

        .vertical-container .add-card-vertical-title {
            width: calc(100%);
            padding: 6px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 13px;
            color: white;
        }

        .task-page .task-container .add-list-vertical-container {
            width: 280px;
            height: fit-content;
            /* cursor: pointer; */
            position: relative;
            z-index: 1;
        }

        .task-page .task-container .add-list-vertical-container:hover {
            /* background-color: #b8b8b84f; */
        }

        .task-page .task-container .add-list-vertical-text {
            width: 280px;
            background-color: #383838;
            border-radius: 3px;
            display: flex;
            color: white;
            align-items: center;
            padding: 0 12px;
            font-size: 13px;
            height: 48px;
            cursor: pointer;
        }

        .vertical-container .list-vertical-title {
            justify-content: space-between;
            padding: 0 6px 0 7px;
            display: flex;
            color: white;
            align-items: center;
            font-size: 13px;
            height: 36px;
        }

        .vertical-container .list-vertical-title .input-text {
            height: 30px;
            border: none;
            outline: none;
            font-size: 13px;
            color: white;
            border-radius: 3px;
            box-shadow: 0 0 0 2px rgb(138, 138, 138);
            background-color: #6e6e6e;
            padding: 0 8px;
            width: 100%;
            position: absolute;
            left: 2px;
            font-family: Noto-Sans;
        }

        .vertical-container .list-vertical-title .title {
            padding-left: 10px;
            align-items: center;
            display: flex;
            height: calc(100% - 6px);
            margin-top: 6px;
            width: calc(100% - 24px);
            cursor: pointer;
            position: relative;
        }

        .vertical-container .list-vertical-title .tool-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .vertical-container .list-vertical-title .tool-icon,
        .vertical-container .list-vertical-title .tool {
            width: 24px;
            height: 24px;
            border-radius: 2px;
            position: relative;
        }

        .vertical-container .list-vertical-title .tool-icon:hover {
            background-color: #585858;
        }

        /* ++ tool menu ++ */
        .vertical-container .tool-menu-wrapper {
            position: absolute;
            padding: 2px 0;
            border-radius: 2px;
            top: 100%;
            background-color: #888888;
            left: 0;
        }

        .vertical-container .tool-menu-wrapper .option {
            height: 24px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            padding: 0px 12px 0px 8px;
        }

        .vertical-container .tool-menu-wrapper .option:hover {
            background-color: #777777;
        }

        .task-page .header-display .participant {
            font-size: 20px;
            color: white;
            padding: 0 6px;
            margin: 0 6px;
            border-radius: 2px;
            display: flex;
            cursor: pointer;
        }

        .task-page .header-display .participant:hover {
            background-color: #cccccc;
            color: black;

        }

        .task-page .header-display {
            display: flex;
            position: absolute;
            top: 0;
            left: 0;
            height: 40px;
            width: 100%;
            padding: 2px 10px;
            align-items: center;
            z-index: 10;
        }

        .task-page .header-display .title {
            font-size: 20px;
            color: white;
            padding-right: 12px;
            border-right: 1px solid rgb(117, 117, 117);
        }

        /* -- tool menu -- */
        .vertical-container .add-list-vertical-title {
            display: flex;
            color: white;
            align-items: center;
            padding: 0 16px;
            font-size: 13px;
            height: 36px;
        }

        .task-page .task-container .add-list-vertical-text:hover {
            background-color: #424242;
        }

        .task-page .task-container .add-list-vertical-form {
            overflow: hidden;
            display: none;
            background-color: #666666;
            border-radius: 3px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;

        }

        .task-page .task-container .add-list-vertical-form .input-text {
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

        .task-page .task-container .add-list-vertical-form .input-text::placeholder {
            color: rgb(201, 201, 201);
        }


        .task-page .task-container .add-list-vertical-form .input-text:focus-visible {
            /* box-shadow: 0 0 0 2px rgb(138, 138, 138); */
        }

        .task-page .task-container .input-submit-list {
            margin: 0 10px 10px 10px;
            padding: 4px 12px;

            background-color: #999999;
            color: white;
        }

        .vertical-container .input-submit-card {
            padding: 4px 12px;
            background-color: #999999;
            color: white;
        }

        .vertical-container .input-submit,
        .task-page .task-container .input-submit {
            height: 32px;
            min-height: 32px;
            outline: none;
            align-items: center;
            border: none;
            border-radius: 3px;
            box-shadow: none;
            cursor: pointer;
            display: inline-flex;
            font-size: 14px;
            font-weight: 400;
            justify-content: center;
            text-decoration: none;
        }

        .vertical-container .input-submit:hover,
        .task-page .task-container .input-submit:hover {
            background-color: #8a8a8a;
        }

        .vertical-container .input-submit:active,
        .task-page .task-container .input-submit:active {
            background-color: #666666;
        }

        .background-layer {
            background-color: #24242477;
            width: 100vw;
            height: 100vh;
            position: fixed;
            z-index: 400;
            top: 0;
            left: 0;
        }

        .background-layer .task-editor-container {
            position: absolute;
            /* background-color: white; */
        }

        .background-layer textarea {
            background-color: rgb(219, 219, 219);
            width: 100%;
            resize: none;
            border: none;
            outline: none;
            box-shadow: 1px 1px rgb(82, 82, 82);
            border-radius: 3px;
            min-height: 100%;
            padding: 10px 10px 10px 10px;
            font-family: Noto-Sans;
        }

        .background-layer .tool-menu-wrapper {
            position: absolute;
            top: 0;
            left: calc(100% + 3px);
        }

        .background-layer .tool-menu-wrapper .option {
            height: 24px;
            border-radius: 2px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
            background-color: #ddd;
            padding: 0px 12px 0px 8px;
        }

        .background-layer .tool-menu-wrapper .option:hover {
            background-color: #ccc;
        }

        /* -- end tool menu -- */

        /* paricipant card */
        .background-layer .participant-card {
            background-color: rgb(219, 219, 219);
            border-radius: 2px;
            max-width: 262px;
            max-height: 300px;
            min-width: 100px;
            min-height: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .background-layer .participant-card .title {
            display: flex;
            justify-content: center;
            font-size: 20px;
            padding: 2px 5px;
        }

        .background-layer .participant-card .invite-by-email {
            padding: 5px 12px;
        }

        .background-layer .participant-card .invite-by-email input[type="text"] {
            width: calc(100% - 55px);
            height: 32px;
            border: none;
            outline: none;
            font-size: 13px;
            color: black;
            padding: 0 12px;
            border-radius: 2px;
            box-sizing: border-box;
        }

        .background-layer .participant-card .invite-by-email input[type="submit"] {
            box-sizing: border-box;
            height: 32px;
            width: 50px;
            border: none;
            outline: none;
            font-size: 13px;
            color: black;
            border-radius: 2px;
            cursor: pointer;
        }

        .background-layer .participant-card .invite-by-email input[type="submit"]:hover {
            background-color: #cccccc;
        }

        .background-layer .participant-card .line {
            border-top: 1px solid rgb(190, 190, 190);
            margin: 5px 20px;
        }

        .background-layer .participant-card .participant-wrapper {
            margin: 7px;
            display: flex;
            flex-wrap: wrap;
            overflow: auto;
            max-height: 210px;
            align-content: flex-start;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper {
            width: 50px;
            margin: 5px;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(193 193 193);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user:hover {
            background-color: rgb(163 163 163);
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user .remove {
            display: none;
            font-size: 20px;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user .text {
            font-size: 20px;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user:hover .remove {
            display: block;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user:hover .text {
            display: none;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user.owner_:hover .remove {
            display: none;
        }
        
        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .circle-user.owner_:hover .text {
            display: block;
        }

        .background-layer .participant-card .participant-wrapper .circle-user-wrapper .participant-name {
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 50px;
            font-size: 16px;
            -webkit-line-clamp: 1;
            overflow: hidden;
            text-align: center;
        }

        /* -- end participant card -- */
    </style>
    <div class="task-page task_page">
        <div class="container">
            <div class="custom_scroll_container">
                <div class="header-display">
                    <div class="title">{{ $workspace->title }}</div>
                    <div class="participant">
                        Participant
                    </div>
                </div>
                <div class="task-container custom_scroll" dd-field-id="horizontal-dd" dd_container="horizontal-dd">
                    <?php
                    
                    if (isset($lists)) {
                        $str_list = '';
                        foreach ($lists as $key => $list) {
                            $str_task = '';
                            foreach ($list->tasks as $key => $task) {
                                $str_task .=
                                    '<div class="task-element task_element" dd-element-id="vertical-dd" dd-group-id="vertical-dd" dd-holder-id="vertical-dd" task-id="' .
                                    $task->id .
                                    '">
                                                                                                                                                                                                                            <div class="task-element-title task_element_title">
                                                                                                                                                                                                                        <div class="text text_">' .
                                    nl2br($task->title) .
                                    '</div>
                                                                                                                                                                                                                                    <div class="tool task_edit"><i class="fa-solid fa-pen"></i></div>
                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            ';
                            }
                            $str_list .=
                                '<div class="vertical-container task_list_container" dd-field-id="vertical-dd" dd-group-id="horizontal-dd" list-id="' .
                                $list->id .
                                '">
                                                                                                                                                                                                                            <div class="list-vertical-title" dd-holder-id="horizontal-dd"><div class="title change_list_title">' .
                                $list->title .
                                '</div><div class="tool"><div class="tool-icon list_tool"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></div>
                                                                                                                                                                                                                        <div dd_container="vertical-dd">
                                                                                                                                                                                                                            ' .
                                $str_task .
                                '
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    <div class="add-card-vertical-container add_card_vertical_container">
                                                                                                                                                                                                                        <div class="add-card-vertical-title add_card_vertical_title">
                                                                                                                                                                                                                            Add a card
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                        <div class="add-card-form d-hidden add_card_form">
                                                                                                                                                                                                                            <textarea name="" id="" auto-resize="on" placeholder="Please enter task title..."></textarea>
                                                                                                                                                                                                                            <input class="input-submit input-submit-card input_submit_card" type="submit"
                                                                                                                                                                                                                                value="Add card">
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                </div>';
                        }
                        echo $str_list;
                    }
                    
                    ?>
                    <div class="add-list-vertical-container add_list_vertical_container">
                        <div class="add-list-vertical-text add_list_btn">Add another list</div>
                        <div class="add-list-vertical-form add_list_form">
                            <input class="input-text" type="text" name="" id=""
                                placeholder="Enter list title...">
                            <input class="input-submit input-submit-list input_submit_list" type="submit" value="Add list">
                        </div>
                    </div>

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

        function showFormAddNewList() {
            let x = $(".add_list_form");
            let h = x.outerHeight(true);
            let i = 0;
            x.css({
                "display": "block"
            });
            x.css({
                "height": "0px"
            });

            function funX(e) {
                if (!$(e.target).closest(x).length) {
                    let i = h;
                    let ani = setInterval(() => {
                        i -= 10;
                        if (0 < i) {
                            x.css("height", i + "px");
                        } else {
                            x.css({
                                "display": "none",
                                "height": ""
                            });
                            clearInterval(ani);
                        }
                    }, 10);
                    $(document).off("mousedown", funX);
                }
            }
            $(document).off("mousedown", funX);
            $(document).on("mousedown", funX);
            let ani = setInterval(() => {
                i += 10;
                if (h > i) {
                    x.css("height", i + "px");
                } else {
                    x.css("height", h + "px");
                    x.find(".input-text").focus();
                    clearInterval(ani);
                }
            }, 10);

        }

        function submitNewList() {
            let val = $(".add-list-vertical-container .input-text").val();
            if (val.length) {
                let el = $(
                    `
                

                    <div class="vertical-container task_list_container" dd-field-id="vertical-dd" dd-group-id="horizontal-dd" list-id="" style="">
                                    <div class="list-vertical-title" dd-holder-id="horizontal-dd"><div class="title">` +
                    val + `</div><div class="tool"><div class="tool-icon list_tool"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></div>
                        <div dd_container="vertical-dd">
                        </div>
                        <div class="add-card-vertical-container add_card_vertical_container">
                            <div class="add-card-vertical-title add_card_vertical_title">
                                Add a card
                            </div>
                            <div class="add-card-form d-hidden add_card_form">
                                <textarea name="" id="" auto-resize="on" placeholder="Please enter task title..." style="height:0px;overflow-y:hidden;"></textarea>
                                <input class="input-submit input-submit-card input_submit_card" type="submit" value="Add card">
                            </div>
                        </div>
                    </div>
                    `);
                $(".add-list-vertical-container").before(el);
                let w_id = window.location.pathname.split("/")[2];
                ajaxCustom({
                    "title": val,
                    "workspace_id": w_id,
                }, "/add-new-list", function(res) {
                    el.attr("list-id", res.id);
                });
                $(".add-list-vertical-container .input-text").val("").focus();
                if (typeof checkCustomScrollBar === 'function') {
                    checkCustomScrollBar();
                }
            }

        }

        function submitNewCard() {
            let val = $(this).parent().find("textarea").val();
            let list_id = $(this).closest("[list-id]").attr("list-id");
            if (val.length) {
                let el = $(`<div class="task-element task_element" dd-element-id="vertical-dd" dd-group-id="vertical-dd" dd-holder-id="vertical-dd" task-id="">
                                <div class="task-element-title task_element_title">
                                    <div class="text text_">` + val + `</div>
                                    <div class="tool task_edit"><i class="fa-solid fa-pen"></i></div>
                                </div>
                            </div>`);
                $(this).closest(".task_list_container").find("[dd_container]").append(el);
                if (list_id != "") {
                    ajaxCustom({
                        "title": val,
                        "list_id": list_id
                    }, "/add-new-card", function(res) {
                        el.attr("task-id", res.id);
                    });
                } else {
                    let waiting = setInterval(() => {
                        let list_id = el.closest("[list-id]").attr("list-id");
                        if (list_id != "") {
                            ajaxCustom({
                                "title": val,
                                "list_id": list_id
                            }, "/add-new-card", function(res) {
                                el.attr("task-id", res.id);
                            });
                            clearInterval(waiting);
                        }
                    }, 500);
                }
                $(this).parent().find("textarea").val("").focus();
            }

        }

        function btnAddCard(e) {
            let funY = null;

            function funX(e) {
                if (!$(e.target).closest(".add_card_form").length) {
                    $(this).css("display", "block");
                    $(this).parent().find(".add_card_form").css("display", "none");
                    $(document).off("mousedown", funY);
                }
            }
            $(this).css("display", "none");
            $(this).parent().find(".add_card_form").css("display", "block").find("textarea").focus();
            funY = funX.bind(this);
            $(document).off("mousedown", funY);
            $(document).on("mousedown", funY);
        }

        function getStructure() {
            let l = [];
            let t = {};
            $("[list-id]").each(function(index) {
                let z = [];
                $(this).find("[task-id]").each(function(index) {
                    let y = {
                        "id": $(this).attr("task-id"),
                    }
                    z.push(y);
                });
                t[$(this).attr("list-id")] = z;
                let i = {
                    "id": $(this).attr("list-id")
                }
                l.push(i);
            });
            return {
                "list_groups": l,
                "task_groups": t
            };
        }

        function listTool() {
            let str_menu = `<div class="tool-menu-wrapper" dd-disabler>
                                <div class="option" name="archive">Archive</div>
                            </div>`;
            let menu = $(str_menu);
            let option = menu.find(".option");
            option.on("click", function() {
                let choice = $(this).attr("name");
                switch (choice) {
                    case "archive":
                        let list_id = $(this).closest("[list-id]").attr("list-id");
                        let w_id = window.location.pathname.split("/")[2];
                        ajaxCustom({
                            "list_id": list_id,
                            "workspace_id": w_id,
                        }, "/archive-list-task", function(res) {});
                        $(this).closest(".task_list_container").remove();

                        break;
                    default:
                        break;
                }
            });
            let funX = (e) => {
                if (!$(e.target).closest(menu).length) {
                    menu.closest(".task_list_container").css("z-index", "");
                    menu.remove();
                }
            }
            $(document).off("mousedown", funX);
            $(document).on("mousedown", funX);
            $(this).closest(".task_list_container").css("z-index", 10);
            $(this).after(menu);
        }

        function changeListTitle() {
            let prev_text = $(this).text();
            let str = `<input class="input-text" type="text" name="" id="">`;
            let el = $(str);
            el.val(prev_text)
            $(this).append(el);
            el.focus().select();
            let funX = (e) => {
                if (!$(e.target).closest(this).length) {
                    let new_text = el.val();
                    el.remove();
                    if (prev_text != new_text) {
                        let w_id = window.location.pathname.split("/")[2];
                        let list_id = $(this).closest(".task_list_container").attr("list-id");
                        ajaxCustom({
                            "list_id": list_id,
                            "list_title": new_text,
                            "workspace_id": w_id,
                        }, "/change-list-task-title", function(res) {});
                        $(this).text(new_text);
                    }
                }
            }
            $(document).off("mousedown", funX);
            $(document).on("mousedown", funX);
        }

        function taskEdit() {
            let str = `<div class="background-layer">
                            <div class="task-editor-container task_editor_container">
                                <textarea name="" id="" auto-resize="on" placeholder="Please enter task title..." style="height:0px;overflow-y:hidden;"></textarea>
                                <div class="tool-menu-wrapper tool_menu_wrapper">
                                    <div class="option" name="archive">Archive</div>
                                </div>
                            </div>
                        </div>`;
            let target_ = $(this);
            let origin = $(this).closest(".task_element_title");
            let origin_text = origin.find(".text_");
            let el = $(str);
            let w = origin.outerWidth();
            let h = origin.outerHeight();
            let container = el.find(".task_editor_container");
            let textarea = el.find("textarea");
            let tool_menu_wrapper = el.find(".tool_menu_wrapper");
            textarea.val(origin_text.html().replaceAll("\n", "").replaceAll("<br>", "\n"))
            container.css({
                "width": w,
                "height": h
            }).offset({
                top: origin.offset().top,
                left: origin.offset().left
            });
            let funX = (e) => {
                let inside = $(e.target).closest(container).length;
                if (!inside) {
                    if (origin_text.html().replaceAll("<br>", "\n") != textarea.val() && textarea.val() != "") {
                        let w_id = window.location.pathname.split("/")[2];
                        let task_id = $(this).closest("[task-id]").attr("task-id");
                        ajaxCustom({
                            "task_id": task_id,
                            "task_title": textarea.val(),
                            "workspace_id": w_id,
                        }, "/change-list-task-title", function(res) {});
                        origin_text.html(textarea.val().trim().replaceAll("\n", "<br>"));
                    }
                    el.remove();
                    $(document).off("mousedown", funX);
                }

            }

            let option = tool_menu_wrapper.find(".option");
            option.on("click", function() {
                let choice = $(this).attr("name");
                switch (choice) {
                    case "archive":
                        let task_id = target_.closest("[task-id]").attr("task-id");
                        let w_id = window.location.pathname.split("/")[2];
                        ajaxCustom({
                            "task_id": task_id,
                            "workspace_id": w_id,
                        }, "/archive-list-task", function(res) {});
                        target_.closest(".task_element").remove();
                        el.remove();
                        $(document).off("mousedown", funX);
                        break;
                    default:
                        break;
                }
            });

            $(document).off("mousedown", funX)
            $(document).on("mousedown", funX)
            $("body").append(el);
            textarea.css({
                "overflow-y": "hidden",
                "height": textarea.prop('scrollHeight')
            })
            textarea.focus().select();
        }

        function addParticipant() {
            let str = `<div class="background-layer">
                            <div class="participant-card">
                                <div class="title">
                                    Invite Participant
                                </div>
                                <div class="line"></div>
                                <div class="invite-by-email">
                                    <input type="text">
                                    <input class="" type="submit" value="Send">
                                </div>
                                <div class="participant-wrapper participant_wrapper">
                                
                                    <div class="circle-user-wrapper circle_user_wrapper">
                                        <div class="circle-user"></div>
                                        <div class="participant-name">...</div>
                                    </div>
                                
                                    <div class="circle-user-wrapper circle_user_wrapper">
                                        <div class="circle-user"></div>
                                        <div class="participant-name">...</div>
                                    </div>
                                    <div class="circle-user-wrapper circle_user_wrapper">
                                        <div class="circle-user"></div>
                                        <div class="participant-name">...</div>
                                    </div>
                                    <div class="circle-user-wrapper circle_user_wrapper">
                                        <div class="circle-user"></div>
                                        <div class="participant-name" title="">...</div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            let target_ = $(this);
            let el = $(str);
            let container = el.find(".participant-card");
            let w_id = window.location.pathname.split("/")[2];
            ajaxCustom({
                "workspace_id": w_id,
            }, "/get-participant-list", function(res) {
                let str = "";
                for (let x of res) {
                    let y = x.name.split(" ");
                    str += `<div class="circle-user-wrapper circle_user_wrapper">
                                <div class="circle-user circle_user ${x.owner?"owner_":""}" user-id="${x.id}"><div class="text">${y[0]!=null?y[0].slice(0, 1).toUpperCase():"" +" "+  y[1]!=null?y[1].slice(0, 1).toUpperCase():""}</div><div class="remove"><i class="fa-sharp fa-solid fa-x"></i></div></div>
                                <div class="participant-name participant_name" title="${x.name}">${x.name}</div>
                            </div>`;
                }
                let el_participant = $(str);
                el_participant.find(".circle_user").on("click", function() {
                    if($(this).hasClass("owner_")){
                        return false;
                    }
                    let w_id = window.location.pathname.split("/")[2];
                    let user_id = $(this).attr("user-id");
                    let this_ =  $(this);
                    ajaxCustom({
                        "workspace_id": w_id,
                        "user_id": user_id,
                    }, "/remove-participant", function(res) {
                        res = JSON.parse(res);
                        if(res.state == "success"){
                            if(res.workspace == true){
                                $('<a href="/workspace">asd</a>')[0].click(); 
                            }
                        }
                        this_.closest(".circle_user_wrapper").remove();
                    });
                })
                el.find(".participant_wrapper").html("");
                el.find(".participant_wrapper").append(el_participant);
            });
            el.find('[type="submit"]').on("click", function() {
                let val = el.find('[type="text"]').val();
                let w_id = window.location.pathname.split("/")[2];
                if (val != "") {

                    ajaxCustom({
                        "workspace_id": w_id,
                        "email": val,
                    }, "/invite-participant", function(res) {
                        res = JSON.parse(res);
                        switch (res.state) {
                            case "exist":
                                break;
                            case "success":
                                let y = res.name.split(" ");
                                let str = `<div class="circle-user-wrapper circle_user_wrapper">
                                            <div class="circle-user circle_user" user-id="${res.id}"><div class="text">${y[0]!=null?y[0].slice(0, 1).toUpperCase():"" +" "+  y[1]!=null?y[1].slice(0, 1).toUpperCase():""}</div><div class="remove"><i class="fa-sharp fa-solid fa-x"></i></div></div>
                                            <div class="participant-name participant_name" title="${res.name}">${res.name}</div>
                                        </div>`;
                                let new_participant = $(str);
                                new_participant.find(".circle_user").on("click", function() {
                                    let w_id = window.location.pathname.split("/")[2];
                                    let user_id = $(this).attr("user-id");
                                    let this_ =  $(this);
                                    ajaxCustom({
                                        "workspace_id": w_id,
                                        "user_id": user_id,
                                    }, "/remove-participant", function(res) {
                                        this_.closest(".circle_user_wrapper").remove();
                                    });
                                })
                                el.find(".participant_wrapper").append(new_participant);
                                break;

                            default:
                                break;
                        }
                    });
                }
            })
            let funX = (e) => {
                let inside = $(e.target).closest(container).length;
                if (inside) {} else {
                    el.remove();
                    $(document).off("mousedown", funX);
                }

            }

            $(document).off("mousedown", funX)
            $(document).on("mousedown", funX)
            $("body").append(el);
        }
        $(document).ready(function() {
            $(document).off("click", ".add_list_vertical_container .add_list_btn", showFormAddNewList);
            $(document).on("click", ".add_list_vertical_container .add_list_btn", showFormAddNewList);
            $(document).off("click", ".add_list_vertical_container .input_submit_list", submitNewList);
            $(document).on("click", ".add_list_vertical_container .input_submit_list", submitNewList);
            $(document).off("click", ".add_card_vertical_container .input_submit_card", submitNewCard);
            $(document).on("click", ".add_card_vertical_container .input_submit_card", submitNewCard);
            $(document).off("click", ".add_card_vertical_title", btnAddCard);
            $(document).on("click", ".add_card_vertical_title", btnAddCard);
            $(document).off("click", ".task_page .list_tool", listTool);
            $(document).on("click", ".task_page .list_tool", listTool);
            $(document).off("click", ".task_page .change_list_title", changeListTitle);
            $(document).on("click", ".task_page .change_list_title", changeListTitle);
            $(document).off("click", ".task_page .task_edit", taskEdit);
            $(document).on("click", ".task_page .task_edit", taskEdit);
            $(document).off("click", ".task_page .header-display .participant", addParticipant);
            $(document).on("click", ".task_page .header-display .participant", addParticipant);

            let map = getStructure();
            let dd = new dragdrop();
            dd.funcAfterMouseUp = (t) => {
                if (JSON.stringify(map) !== JSON.stringify(getStructure())) {
                    let c = getStructure();
                    let change_list = "";
                    let change_task = [];
                    if (JSON.stringify(map.list_groups) !== JSON.stringify(c.list_groups)) {
                        change_list = c.list_groups;
                    }
                    for (let list_id in map.task_groups) {
                        if (JSON.stringify(map.task_groups[list_id]) !== JSON.stringify(c.task_groups[
                                list_id])) {
                            change_task.push({
                                "list_id": list_id,
                                "tasks": c.task_groups[list_id]
                            });

                        }
                    }
                    let w_id = window.location.pathname.split("/")[2];
                    ajaxCustom({
                        "list": change_list,
                        "task": change_task,
                        "workspace_id": w_id,
                    }, "/change-list-task-position", function(res) {});

                }
                map = getStructure();
            }
            dd.init();
        });
    </script>
@endsection
