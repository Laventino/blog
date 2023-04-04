<style>
    .right-slider {
        overflow: hidden;
        position: absolute;
        top: 0;
        right: 0;
        height: 100vh;
        background-image: repeating-linear-gradient(#363636 0%, #343434 45%, #323232 100%);
        z-index: 500;
        box-shadow: 0 0 8px 4px #24242424;
        width: 0;
    }

    .right-slider .container {
        height: 100%;
        position: relative;
        top: 0;
        right: 0;
        width: var(--right-slider-width);
    }

    .right-slider .header-container {
        /* height: 46px; */
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction: column;

    }

    .right-slider .profile-container {
        height: 130px;
        width: 130px;
        /* padding: 6px; */
        margin: 100px 0 24px 0;
        border-radius: 50%;
        overflow: hidden;
        outline: #ffffff solid 4px;

    }

    .right-slider .header-title {
        font-weight: bold;
        font-size: 24px;
        color: white;
        text-transform: capitalize;
    }

    .right-slider .body-container {
        overflow: hidden;
        width: var(--right-slider-width);
        position: absolute;
        --menu-top: 300px;
        top: var(--menu-top);
        height: calc(100% - var(--menu-top));
    }

    .right-slider .menu-info {
        left: 100%;

    }

    .right-slider .menu-container {
        left: 0%;
    }

    .right-slider .menu-info,
    .right-slider .menu-container {
        position: absolute;
        margin-top: 24px;
        width: var(--right-slider-width);
    }

    .right-slider .menu-info .back-menu {
        margin-top: 24px;
    }

    .right-slider .menu-info .back-menu,
    .right-slider .menu-info .first-dc,
    .right-slider .menu-container .first-dc {
        list-style-type: none;
        padding: 8px 12px;
        color: white;
        cursor: pointer;
        justify-content: center;
        display: flex;
    }

    .right-slider .menu-info .back-menu:hover,
    .right-slider .menu-info .first-dc:hover,
    .right-slider .menu-container .first-dc:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .right-slider .menu-info .back-menu.active,
    .right-slider .menu-info .first-dc.active,
    .right-slider .menu-container .first-dc.active {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .right-slider .menu-info .icon-menu,
    .right-slider .menu-container .icon-menu {
        margin-right: 5px;
    }

    .right-slider .menu-info .icon-menu:hover,
    .right-slider .menu-container .icon-menu:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .right-slider .menu-info .info-data {
        display: flex;
        list-style-type: none;
        padding: 8px 12px;
        color: white;
        white-space: nowrap;
        /* cursor: pointer; */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .right-slider .menu-info {
        --menu-info-label: 64px;
    }

    .right-slider .menu-info .input-style {
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0 5px;
        width: calc(100% - var(--menu-info-label));

    }

    .right-slider .menu-info .info-data label {
        width: var(--menu-info-label);
    }

    .right-slider .close-right-slider-menu {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 0;
        /* padding: 5px; */

        width: calc(var(--nav-height) - 12px);
        height: calc(var(--nav-height) - 12px);
        overflow: hidden;
        margin: 6px 12px;


        display: flex;
        justify-content: center;
        align-items: center;
        right: 0;
        cursor: pointer;
        border-radius: 50%;

    }

    .right-slider .close-right-slider-menu:hover {
        background-color: rgba(255, 255, 255, 0.7);

    }

    .right-slider .icon-right-pointer {
        border-right: 4px solid white;
        border-bottom: 4px solid white;
        border-top: 0px solid transparent;
        border-left: 0px solid transparent;
        transform: rotateZ(-45deg) translate(-12%, -12%);
        width: 16px;
        height: 16px;
        border-radius: 2px;
    }

    .right-slider .close-right-slider-menu:hover .icon-right-pointer {
        border-right: 4px solid #363636;
        border-bottom: 4px solid #363636;
    }
</style>
<div class="right-slider">
    <div class="container">
        <div class="close-right-slider-menu menu_right_slider_toggle">
            <div class="icon-right-pointer"></div>
        </div>
        <div class="header-container">
            <div class="profile-container"><img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%"
                    height="100%" alt=""></div>
            <div class="header-title">
                {{Auth::user()->name}}
            </div>
        </div>
        <div class="body-container">
            <div class="menu-container ">
                <li class="first-dc" menu-slider-pointer="info">
                    Info
                </li>
                <li class="first-dc">
                    Change Password
                </li>
                <li class="first-dc">
                    Setting
                </li>
                <li class="first-dc"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>




            </div>
            <div class="menu-info " menu-slider-target="info">
                <li class="info-data">
                    <label for="name">Name</label>:
                    <div class="input-style" id="name" input-text-click>
                        {{Auth::user()->name}}
                    </div>
                </li>
                <li class="info-data">
                    <label for="name">Email</label>:
                    <div class="input-style" id="email" input-text-click>{{Auth::user()->email}}</div>
                </li>
                <li class="info-data">
                    <label for="name">Phnone</label>:
                    <div class="input-style" id="phone"input-text-click>078277388</div>
                </li>
                <li class="back-menu" menu-slider-pointer="back">
                    Back
                </li>
            </div>
        </div>

    </div>
</div>
<script>
    let r_slider_main_menu = $(".right-slider .menu-container");
    let r_slider_info = $(".right-slider .menu-info");

    function close_menu_right_slider(e) {
        let menu_right_slider = $(".right-slider");
        check_toggle = menu_right_slider.hasClass("active");
        if (check_toggle) {
            if ($(e.target).closest(".menu_right_slider_toggle").length) {} else {
                if ($(e.target).closest(".right-slider").length) {} else {
                    w = $(".body-container").outerWidth(true)
                    menu_right_slider.removeClass("active");
                    let i = w;
                    clearInterval(sliderInterval);
                    var sliderInterval = setInterval(sliderEvent, 10);

                    function sliderEvent() {
                        i -= 5 * 4;
                        menu_right_slider.css("width", i + "px")
                        if (i <= 0) {
                            clearInterval(sliderInterval);
                        }
                    }

                }
            }
        }
    }

    $(document).off("click", close_menu_right_slider);
    $(document).on("click", close_menu_right_slider);

    $("[menu-slider-pointer]").on("click", function() {
        let x = $(this).attr("menu-slider-pointer");
        if (x == "back") {
            let current_menu = $(".active[menu-slider-target]");
            let i = -100;
            let j = 0;
            clearInterval(sliderInterval);
            var sliderInterval = setInterval(sliderEvent, 10);

            function sliderEvent() {
                i += 5;
                j += 5;

                r_slider_main_menu.css("left", i + "%")
                current_menu.css("left", j + "%")
                if (i >= 0) {
                    current_menu.removeClass("active");
                    clearInterval(sliderInterval);
                }
            }
        } else {
            let target_menu = $("[menu-slider-target=" + x + "]");
            target_menu.addClass("active");
            let i = 0;
            let j = 100;
            clearInterval(sliderInterval);
            var sliderInterval = setInterval(sliderEvent, 10);

            function sliderEvent() {
                i -= 5;
                j -= 5;

                r_slider_main_menu.css("left", i + "%")
                target_menu.css("left", j + "%")
                if (i <= -100) {
                    clearInterval(sliderInterval);
                }
            }
        }

    })
    $(".menu_right_slider_toggle").on("click", function() {
        let menu_right_slider = $(".right-slider");
        check_toggle = menu_right_slider.hasClass("active");
        w = $(".right-slider .body-container").outerWidth(true)
        console.log(w)
        if (check_toggle) {
            menu_right_slider.removeClass("active");
            let i = w;
            clearInterval(sliderInterval);
            var sliderInterval = setInterval(sliderEvent, 10);

            function sliderEvent() {
                i -= 5 * 4;
                menu_right_slider.css("width", i + "px")
                if (i <= 0) {
                    clearInterval(sliderInterval);
                }
            }

        } else {
            menu_right_slider.addClass("active");
            let i = 0;
            clearInterval(sliderInterval);
            var sliderInterval = setInterval(sliderEvent, 10);

            function sliderEvent() {
                i += 5 * 4;
                menu_right_slider.css("width", i + "px")
                if (i >= w) {
                    clearInterval(sliderInterval);
                }
            }
        }
    });
</script>
