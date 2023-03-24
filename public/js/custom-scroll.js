function checkCustomScrollBar() {
    $(".custom_scroll_container").each(function () {
        let cs_sw = $(this).find(".custom_scroll").prop("scrollWidth");
        let cs_cw = $(this).find(".custom_scroll").prop("clientWidth");
        let cs_sh = $(this).find(".custom_scroll").prop("scrollHeight");
        let cs_ch = $(this).find(".custom_scroll").prop("clientHeight");
        $(this).data("scrollPrevPosition", {
            x: 0,
            y: 0
        }).data("ContainerHorizontalLength", cs_sw).data("scrollContainerHorizontalLength", cs_cw).data(
            "scrollHorizontalBarLength", 0).data("scrollHorizontalAvailLength", 0).data(
                "ContainerVerticalLength", cs_sh).data("scrollContainerVerticalLength", cs_ch).data(
                    "scrollVerticalBarLength", 0).data("scrollVerticalAvailLength", 0);
        if (cs_ch < cs_sh) {
            let bar_h = Math.pow(cs_ch, 2) / cs_sh;
            $(this).data("scrollVerticalBarLength", bar_h).data("scrollVerticalAvailLength", cs_ch -
                bar_h);
            $(this).find(".custom_scroll_vertical_bar .bar").css("height", bar_h);
            $(this).find(".custom_scroll_vertical_bar").css("display", "block");

        } else {
            $(this).find(".custom_scroll_vertical_bar").css("display", "none");
        }
        if (cs_cw < cs_sw) {
            let bar_w = Math.pow(cs_cw, 2) / cs_sw;
            $(this).data("scrollHorizontalBarLength", bar_w).data("scrollHorizontalAvailLength", cs_cw -
                bar_w);
            $(this).find(".custom_scroll_horizontal_bar .bar").css("width", bar_w);
            $(this).find(".custom_scroll_horizontal_bar").css("display", "block");

        } else {
            $(this).find(".custom_scroll_horizontal_bar").css("display", "none");
        }
    });

}
function scrollOnDragToEdgeListener(){
    $(".custom_scroll_container").each(function () {
        let scroll_container = null;
        let clone_funY = null;
        let interval_scroll = null;
        let switching = null;
        let speed = 0;
        let rang = 0;
        let funX = (e) => {
            scroll_container = $(this);
                clone_funY = funY.bind(this);
                $(document).off("mousemove", funY);
                $(document).on("mousemove", funY);
                $(document).off("mouseup", funZ);
                $(document).on("mouseup", funZ);
        }
        let funY = (e) => {
            if($("body").hasClass("isDraging")){
                let layer_x = e.pageX - $(this).offset().left;
                let layer_y = e.pageY - $(this).offset().top;
                let cs_cw = $(this).prop("clientWidth");
                if (layer_x > cs_cw - 30 || layer_x < 30) {
                    switching = layer_x < 30?0:1;
                    rang = ((cs_cw - layer_x) / 10).toFixed(0);
                    switch (rang) {
                        case "3":
                            speed = 5;
                            break;
                        case "2":
                            speed = 10;
                            break;
    
                        default:
                            speed = 20;
                            break;
                    }
                    if (interval_scroll == null) {
                        interval_scroll != null ? clearInterval(interval_scroll) : null;
                        interval_scroll = setInterval(funI, 20);
                    }
                }else {
                    interval_scroll != null ? clearInterval(interval_scroll) : null;
                    interval_scroll = null;
                }
            }
        }
        let funZ = () => {
            interval_scroll != null ? clearInterval(interval_scroll) : null;
            interval_scroll = null;


            
            let custom_scroll = scroll_container.find(".custom_scroll");
            var scroll_left = custom_scroll.scrollLeft();
            var scroll_top = custom_scroll.scrollTop();
            let cs_cw = custom_scroll.prop("clientWidth");
            let cs_sw = custom_scroll.prop("scrollWidth");
            let cs_sh = custom_scroll.prop("scrollHeight");
            let cs_ch = custom_scroll.prop("clientHeight");
            let bar_scroll_left = ((scroll_left / (cs_sw / 100)) / 100) * cs_cw;
            let bar_scroll_top = ((scroll_top / (cs_sh / 100)) / 100) * cs_ch;
            let curPosition = {
                x: bar_scroll_left,
                y: bar_scroll_top
            };
            scroll_container.data("scrollPrevPosition", curPosition)
            
            $(document).off("mousemove", funY);
            $(document).off("mouseup", funZ);
        }
        let funI = () => {
            speed = speed == 0? 5 :switching?Math.abs(speed):-Math.abs(speed);
            var scroll_left = $(this).find(".custom_scroll").scrollLeft();
            scroll_container.find(".custom_scroll")[0].scrollTo({
                left: scroll_left + speed,
            });
          

        }
        $(this).off("mousedown", funX);
        $(this).on("mousedown", funX);
    });

}
function customScrollBarListener() {
    $(".custom_scroll").each(function () {
        let funX = () => {
            var scroll_left = $(this).scrollLeft();
            var scroll_top = $(this).scrollTop();
            let cs_cw = $(this).prop("clientWidth");
            let cs_sw = $(this).prop("scrollWidth");
            let cs_sh = $(this).prop("scrollHeight");
            let cs_ch = $(this).prop("clientHeight");
            let scroll_container = $(this).closest(".custom_scroll_container");
            let bar_scroll_left = ((scroll_left / (cs_sw / 100)) / 100) * cs_cw;
            let bar_scroll_top = ((scroll_top / (cs_sh / 100)) / 100) * cs_ch;
            let curPosition = {
                x: bar_scroll_left,
                y: bar_scroll_top
            };
            let data = scroll_container.data();
            scroll_container.data("scrollCurPosition", curPosition);
            scroll_container.find(".custom_scroll_horizontal_bar .bar").css("left", curPosition.x);
            scroll_container.find(".custom_scroll_vertical_bar .bar").css("top", curPosition.y);
        }
        $(this).off("scroll", funX);
        $(this).on("scroll", funX);
    });
    $(".custom_scroll_container .custom_scroll_horizontal_bar .bar").each(function () {
        var startMousePos = {
            x: 0,
            y: 0
        };
        let _this = null;
        let scroll_container = null;
        let funX = (event) => {
            _this = $(this);
            scroll_container = $(this).closest(".custom_scroll_container");
            scroll_container.addClass("is_drag_horizontal_bar");
            startMousePos.x = event.pageX;
            startMousePos.y = event.pageY;
            $(document).off("mousemove", funY);
            $(document).on("mousemove", funY);
            $(document).off("mouseup", funZ);
            $(document).on("mouseup", funZ);
        }
        let funY = (event) => {
            var currentMousePos = {
                x: event.pageX - startMousePos.x,
                y: event.pageY - startMousePos.y
            };
            let cs_sw = scroll_container.find(".custom_scroll").prop("scrollWidth");
            let cs_cw = scroll_container.find(".custom_scroll").prop("clientWidth");
            let cs_av_leg = scroll_container.data("scrollHorizontalAvailLength");
            let cs_postion = scroll_container.data("scrollPrevPosition");

            let curPosition = {
                x: currentMousePos.x + cs_postion.x,
                y: 0
            };

            if (curPosition.x >= 0) {
                if (curPosition.x <= cs_av_leg) {
                    scroll_container.find(".custom_scroll_horizontal_bar .bar").css("left", curPosition
                        .x);
                    let x = (((curPosition.x * 100) / cs_cw) / 100) * cs_sw;
                    scroll_container.find(".custom_scroll")[0].scrollTo({
                        left: x,
                    });
                } else {
                    scroll_container.find(".custom_scroll_horizontal_bar .bar").css("left", cs_av_leg);
                    let x = (((cs_av_leg * 100) / cs_cw) / 100) * cs_sw;
                    scroll_container.find(".custom_scroll")[0].scrollTo({
                        left: x,
                    });

                }
            } else {
                scroll_container.find(".custom_scroll_horizontal_bar .bar").css("left", 0);
                scroll_container.find(".custom_scroll")[0].scrollTo({
                    left: 0,
                });
            }
        }
        let funZ = (event) => {
            scroll_container.data("scrollPrevPosition", scroll_container.data("scrollCurPosition"))
            scroll_container.removeClass("is_drag_horizontal_bar");
            $(document).off("mousemove", funY);
            $(document).off("mouseup", funZ);
        }
        $(this).off("mousedown", funX);
        $(this).on("mousedown", funX);
    });
    $(".custom_scroll_container .custom_scroll_vertical_bar .bar").each(function () {
        var startMousePos = {
            x: 0,
            y: 0
        };
        let _this = null;
        let scroll_container = null;
        let funX = (event) => {
            _this = $(this);
            scroll_container = $(this).closest(".custom_scroll_container");
            scroll_container.addClass("is_drag_vertical_bar");
            startMousePos.x = event.pageX;
            startMousePos.y = event.pageY;
            $(document).off("mousemove", funY);
            $(document).on("mousemove", funY);
            $(document).off("mouseup", funZ);
            $(document).on("mouseup", funZ);
        }
        let funY = (event) => {
            var currentMousePos = {
                x: event.pageX - startMousePos.x,
                y: event.pageY - startMousePos.y
            };

            // let cs_sw = scroll_container.find(".custom_scroll").prop("scrollWidth");
            // let cs_cw = scroll_container.find(".custom_scroll").prop("clientWidth");

            let cs_sh = scroll_container.find(".custom_scroll").prop("scrollHeight");
            let cs_ch = scroll_container.find(".custom_scroll").prop("clientHeight");

            let cs_av_leg = scroll_container.data("scrollVerticalAvailLength");
            let cs_postion = scroll_container.data("scrollPrevPosition");

            let curPosition = {
                x: 0,
                y: currentMousePos.y + cs_postion.y
            };
            if (curPosition.y >= 0) {
                if (curPosition.y <= cs_av_leg) {
                    scroll_container.find(".custom_scroll_vertical_bar .bar").css("top", curPosition.y);
                    let y = (((curPosition.y * 100) / cs_ch) / 100) * cs_sh;
                    scroll_container.find(".custom_scroll")[0].scrollTo({
                        top: y,
                    });
                } else {
                    scroll_container.find(".custom_scroll_vertical_bar .bar").css("top", cs_av_leg);
                    let y = (((cs_av_leg * 100) / cs_ch) / 100) * cs_sh;
                    scroll_container.find(".custom_scroll")[0].scrollTo({
                        top: y,
                    });

                }
            } else {
                scroll_container.find(".custom_scroll_vertical_bar .bar").css("top", 0);
                scroll_container.find(".custom_scroll")[0].scrollTo({
                    top: 0,
                });

            }
        }
        let funZ = (event) => {
            scroll_container.data("scrollPrevPosition", scroll_container.data("scrollCurPosition"))
            scroll_container.removeClass("is_drag_vertical_bar");
            $(document).off("mousemove", funY);
            $(document).off("mouseup", funZ);
        }
        $(this).off("mousedown", funX);
        $(this).on("mousedown", funX);
    });
}
function backGroundScroll(e){
    let pre_pos_scroll = null;
    var startMousePos = {
        x: 0,
        y: 0
    };
    let scroll_container = null;
    let funX = (event) => {
        if($(event.target).hasClass("custom_scroll")){
            scroll_container = $(event.target).closest(".custom_scroll_container");
            startMousePos.x = event.pageX;
            startMousePos.y = event.pageY;
            pre_pos_scroll = scroll_container.find(".custom_scroll").scrollLeft();
            $(document).off("mousemove", funY);
            $(document).on("mousemove", funY);
            $(document).off("mouseup", funZ);
            $(document).on("mouseup", funZ);
        }
    }
    
    let funY = (event) => {
        var currentMousePos = {
            x: event.pageX - startMousePos.x,
            y: event.pageY - startMousePos.y
        };
        let custom_scroll = scroll_container.find(".custom_scroll");
        let move = pre_pos_scroll - currentMousePos.x;
        custom_scroll[0].scrollTo({
            left: move,
        });
        
    }
    let funZ = (event) => {
        $(document).off("mousemove", funY);
        $(document).off("mouseup", funZ);
    }
    $(document).on("mousedown",".custom_scroll_container",funX);
}
function initCustomScrollBar() {
    checkCustomScrollBar();
    customScrollBarListener();
    scrollOnDragToEdgeListener();
    backGroundScroll();
}
$(document).ready(function () {
    initCustomScrollBar();
    $(window).resize(function () {
        checkCustomScrollBar();
    });
});