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
        .vertical-container .list-vertical-title .input-text{
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
        .vertical-container .list-vertical-title .title{
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
    </style>
    <div class="task-page task_page">
        <div class="container">
            <div class="custom_scroll_container">
                <div class="task-container custom_scroll" dd-field-id="horizontal-dd" dd_container="horizontal-dd">
                    <?php
                    if (isset($lists)) {
                        $str_list = '';
                        foreach ($lists as $key => $list) {
                            $str_task = '';
                            foreach ($list->tasks as $key => $task) {
                                $str_task .=
                                    '<div class="task-element" dd-element-id="vertical-dd" dd-group-id="vertical-dd" dd-holder-id="vertical-dd" task-id="' .
                                    $task->id .
                                    '">
                                        <div class="task-element-title">
                                    <div class="text">' .
                                    $task->title .
                                    '</div>
                                                <div class="tool"><i class="fa-solid fa-pen"></i></div>
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
                let el = $(`
                

                    <div class="vertical-container task_list_container" dd-field-id="vertical-dd" dd-group-id="horizontal-dd" list-id="" style="">
                                    <div class="list-vertical-title" dd-holder-id="horizontal-dd"><div class="title">` + val + `</div><div class="tool"><div class="tool-icon list_tool"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></div>
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
                let el = $(`<div class="task-element" dd-element-id="vertical-dd" dd-group-id="vertical-dd" dd-holder-id="vertical-dd" task-id="">
                                <div class="task-element-title">
                                    <div class="text">` + val + `</div>
                                    <div class="tool"><i class="fa-solid fa-pen"></i></div>
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
            option.on("click",function(){
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
                if(!$(e.target).closest(menu).length){
                    menu.closest(".task_list_container").css("z-index","");
                    menu.remove();
                }
            }
            $(document).off("mousedown",funX);
            $(document).on("mousedown",funX);
            $(this).closest(".task_list_container").css("z-index",10);
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
                if(!$(e.target).closest(this).length){
                    let new_text = el.val();
                    el.remove();
                    if(prev_text != new_text){
                        let w_id = window.location.pathname.split("/")[2];
                        let list_id = $(this).closest(".task_list_container").attr("list-id");
                        ajaxCustom({
                            "list_id": list_id,
                            "list_title": new_text,
                            "workspace_id": w_id,
                        }, "/change-list-task-title", function(res) {
                            console.log(res)
                        });
                        $(this).text(new_text);
                    }
                }
            }
            $(document).off("mousedown",funX);
            $(document).on("mousedown",funX);
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
