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
        }

        .task-element .task-element-title .tool {}

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

        .vertical-container .list-vertical-title,
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
            background-color: #6e6e6e
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
    <div class="task-page">
        <div class="container">
            <div class="custom_scroll_container">
                <div class="task-container custom_scroll" dd-field-id="c-1234" dd_container="c-1234" >
                    <div class="vertical-container task_list_container" dd-field-id="c-123" dd-group-id="c-1234"{{-- dd-element-id="c-1234"  --}}> 
                        <div class="list-vertical-title"  dd-holder-id="c-1234">Pending</div>
                        <div  dd_container="c-123">
                            <div class="task-element" dd-element-id="c-123" dd-group-id="c-123" dd-holder-id="c-123">
                                <div class="task-element-title">
                                    <div class="text">Add function to task list</div>
                                    <div class="tool">+</div>
                                </div>
                            </div>
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

                    </div>
                    <div class="vertical-container task_list_container" dd-field-id="c-123" dd-group-id="c-1234">
                        <div class="list-vertical-title" dd-holder-id="c-1234">On going</div>
                        <div dd_container="c-123">

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
                    </div>
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
                let str = `
                    <div class="vertical-container task_list_container" dd-field-id="c-123" dd-group-id="c-1234">
                        <div class="list-vertical-title" dd-holder-id="c-1234">`+val+`</div>
                        <div dd_container="c-123">

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
                    </div>
                    `;
                $(".add-list-vertical-container").before(str);
                $(".add-list-vertical-container .input-text").val("").focus();
                if (typeof checkCustomScrollBar === 'function') {
                    checkCustomScrollBar();
                }
            }

        }

        function submitNewCard() {
            let val = $(this).parent().find("textarea").val();
            if (val.length) {
                let str = `<div class="task-element" dd-element-id="c-123" dd-group-id="c-123" dd-holder-id="c-123">
                                <div class="task-element-title">
                                    <div class="text">`+val+`</div>
                                    <div class="tool">+</div>
                                </div>
                            </div>`;
                $(this).closest(".task_list_container").find("[dd_container]").append(str);
                $(this).parent().find("textarea").val("").focus();
            }

        }

        function btnAddCard() {
            let funY = null;
            function funX(e) {
                if (!$(e.target).closest(".add_card_form").length) {
                    $(this).css("display", "block");
                    $(this).parent().find(".add_card_form").css("display", "none");
                    $(document).off("mousedown", funY);
                }
            }
            function funZ(e) {
                $(this).css("display", "none");
                $(this).parent().find(".add_card_form").css("display", "block").find("textarea").focus();
                funY = funX.bind(this);
                $(document).off("mousedown", funY);
                $(document).on("mousedown", funY);
            }
            $(document).off("click",".add_card_vertical_title",funZ );
            $(document).on("click",".add_card_vertical_title",funZ );

        }
        $(document).ready(function() {
            $(document).off("click",".add_list_vertical_container .add_list_btn", showFormAddNewList);
            $(document).on("click",".add_list_vertical_container .add_list_btn", showFormAddNewList);
            $(document).off("click",".add_list_vertical_container .input_submit_list", submitNewList);
            $(document).on("click",".add_list_vertical_container .input_submit_list", submitNewList);
            $(document).off("click",".add_card_vertical_container .input_submit_card", submitNewCard);
            $(document).on("click",".add_card_vertical_container .input_submit_card", submitNewCard);
            btnAddCard();
        });
    </script>
@endsection
