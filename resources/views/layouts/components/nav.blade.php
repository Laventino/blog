<style>
    .nav-section {
        position: absolute;
        top: 0;
        right: 0;
        /* height: 46px; */
        width: calc(100vw - var(--menu-width));
        height: var(--nav-height);
        z-index: 300;
        
        /* background-color: #6287A2; */
        /* box-shadow: 0 0 8px 0px #ffffff20; */
        /* background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%); */
        background-color: #303030;
    }

    .nav-section .container {
        display: flex;
        justify-content: space-between;

    }

    .nav-section .profile-container {
        height: calc(var(--nav-height) - 12px);
        border-radius: 50%;
        overflow: hidden;
        margin:  6px 12px;   
        cursor: pointer;
    }
</style>
<div class="nav-section">
    <div class="container">
        <div class="left-content"></div>
        <div class="profile-container menu_right_slider_toggle">
            <img src="{{ URL::to('/') }}/assets/image/logo.svg" width="100%" height="100%" alt="">
        </div>
    </div>
</div>
