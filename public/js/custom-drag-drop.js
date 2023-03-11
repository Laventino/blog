!(function (t) {
    !window.jQuery ? console.log("Custom scroll library is require Jquery library to run") : t();
})(function () {
    /* 
        -cs_dd_container
        -cs_dd_box
    */
    class dragdrop {
        constructor(el) {
            this.droppable_box = ["a", "c-123"];
            this.undroppable_box = ["b"];
            this.current_target = null;
            this.clone_el = null;
            this.sample_clone_el = null;
            this.virtual_space = null;
            this.onMouseUpOn = null;
            this.onMouseMoveOn = null;
            this.init(el);
        }
        init(el) {
            let onDrag = this.onDrag.bind(this)
            el.off("mousedown", onDrag);
            el.on("mousedown", onDrag);
        }
        onDrag(e) {
            e.preventDefault();
            this.virtual_space =  $('<div></div>');
            let clone_el = $(e.currentTarget).clone();
            let sample_clone_el = $(e.currentTarget).clone();
            $(e.currentTarget).addClass("dd_current_origin")
            this.current_target = $(e.currentTarget);
            this.clone_el = clone_el;
            this.sample_clone_el = sample_clone_el;
            sample_clone_el.css({ "opacity": "0.5", }).addClass("dd_sample_element");
            clone_el.css({
                "width": $(e.currentTarget).outerWidth(), "height": $(e.currentTarget).outerHeight(), "opacity": "0.5", "position": "fixed", "z-index": "1000", "pointer-events": "none"
            });
            this.setPositionClone(e.originalEvent.offsetX, e.originalEvent.offsetY, $(e.currentTarget).outerWidth(), $(e.currentTarget).outerHeight(), e);
            let onMouseMove = this.onMouseMove.bind(this, e.originalEvent.offsetX, e.originalEvent.offsetY, $(e.currentTarget).outerWidth(), $(e.currentTarget).outerHeight());
            let onMouseUp = this.onMouseUp.bind(this, onMouseMove);
            this.onMouseUpOn = onMouseUp;
            this.onMouseMoveOn = onMouseMove;
            $(document).off("mousemove", onMouseMove).on("mousemove", onMouseMove).off("mouseup", onMouseUp).on("mouseup", onMouseUp);
            clone_el.appendTo("body");
        }
        setPositionClone(x, y, w, h, e) {
            if ((e.clientX - x) >= 0) {
                if (window.innerWidth >= (e.clientX + (w - x))) {
                    this.clone_el.css("left", e.clientX - x)
                } else {
                    this.clone_el.css("left", window.innerWidth - w)
                }
            } else {
                this.clone_el.css("left", 0)
            }
            if ((e.clientY - y) >= 0) {
                if (window.innerHeight >= (e.clientY + (h - y))) {
                    this.clone_el.css("top", e.clientY - y)
                } else {
                    this.clone_el.css("top", window.innerHeight - h)
                }

            } else {
                this.clone_el.css("top", 0)
            }
        }
        isNumber(n) {
            return !isNaN(parseFloat(n)) && !isNaN(n - 0)
        }
        isInArray(arr, compare_data) {
            let x = Array.isArray(compare_data);
            let res = null;
            if (Array.isArray(arr) != true) {
                console.log("compare data must be array");
                return null;
            }
            if (x != "number") {
                if (this.isNumber(compare_data)) {
                    x = "number";
                }
            }
            switch (x) {
                case true:
                    for (let e of compare_data) {
                        res = arr.includes(e);
                        if (res == true) {
                            break;
                        }
                    }
                    break;
                default:
                    res = arr.includes(compare_data);
                    break;
            }
            return res;

        }
        sampleDropRender(e) {
            let over_el = $(e.target).closest(".dd_container");
            if(over_el.length){
                let group_name = over_el.attr("dd-group");
                let isInArray = this.isInArray(this.droppable_box, group_name);
                if(isInArray){
                    if(over_el.find(".dd_current_origin").length){
                        $(this.virtual_space).append(this.sample_clone_el);
                    }else{
                        $(e.target).closest(".dd_container").append(this.sample_clone_el);
                    }
                }
            }else{
                $(this.virtual_space).append(this.sample_clone_el);
            }
        }
        onMouseMove(x, y, w, h, e) {
            this.setPositionClone(x, y, w, h, e);
            this.sampleDropRender(e);
        }
        onMouseUp(e) {
            if($(document).find(this.sample_clone_el).length){
                this.sample_clone_el.after(this.current_target);
            }else{
            }
            this.current_target?this.current_target.removeClass("dd_current_origin"):null;
            this.clone_el?this.clone_el.remove():null;
            this.sample_clone_el?this.sample_clone_el.remove():null;
            this.virtual_space?this.virtual_space.remove():null;
            $(document).off("mousemove", this.onMouseMoveOn).off("mouseup", this.onMouseUpOn);
        }
    }


    $(document).ready(function () {
        let x = $(".cs_dd_box")
        let y = new dragdrop(x);
        y.id = "c-123";
        $(window).resize(function () { });
    });

});
