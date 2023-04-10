<style>
    .main-menu {
        position: absolute;
        top: 0;
        left: 0;
        width: var(--menu-width);
        height: 100vh;
        /* background-color: #25506e; */
        background-image: repeating-linear-gradient(#363636 0%, #343434 45%, #323232 100%);
        z-index: 400;

        box-shadow: 0 0 8px 4px #24242424;
        overflow: auto;
    }

    .main-menu .container {}

    .main-menu .header-container {
        height: 46px;
        width: 100%;
        display: flex;
        align-items: center;

    }

    .main-menu .logo-container {
        height: 100%;
        padding: 6px;
        margin-left: 6px;
    }

    .main-menu .header-title {
        font-weight: bold;
        font-size: 24px;
        color: white;
    }

    .main-menu .body-container {}

    .main-menu .menu-container {
        margin-top: 24px;
    }

    .main-menu .menu-container .first-dc {
        list-style-type: none;
        padding: 8px 12px;
        color: white;
        cursor: pointer;
    }

    .main-menu .menu-container .first-dc:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .main-menu .menu-container .first-dc.active {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .main-menu .menu-container .icon-menu {
        margin-right: 5px;
    }

    .main-menu .menu-container .icon-menu:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
    }

    .main-menu .menu-container .menu-link {
        text-decoration: none;
    }

    .main-menu .logo-link {
        height: inherit;
        width: 100%;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
</style>
<?php
$menu_name = isset($menu_name) ? $menu_name : '';
?>
<div class="main-menu">
    <div class="container">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo-container"><img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%"
                        height="100%" alt=""></div>
                <div class="header-title">
                    Dashboard
                </div>
            </a>
        </div>
        <div class="body-container">
            <div class="menu-container ">
                <a href="{{ url('/home') }}" class="menu-link">
                    <li class="first-dc {{ \AppHelper::isMenuActive('home', $menu_name) }}">
                        <i class="icon-dashboard icon-menu "></i>Dashboard
                    </li>
                </a>
                <a href="{{ url('/workspace') }}" class="menu-link">
                    <li class="first-dc {{ \AppHelper::isMenuActive('workspace', $menu_name) }}">
                        <i class="icon-task icon-menu"></i>Workspace
                    </li>
                </a>
                <li class="first-dc {{ \AppHelper::isMenuActive('setting', $menu_name) }}">
                    <i class="icon-setting icon-menu"></i>Setting
                </li>
            </div>
        </div>

    </div>
</div>
<script>
    $(".main-menu .menu-container .first-dc").on("click", function() {
        if ($(this).hasClass("active")) {

        } else {
            $(".main-menu .menu-container .first-dc.active").removeClass("active");
            $(this).addClass("active");
        }
    });
</script>
