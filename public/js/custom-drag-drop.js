
class dragdrop {
    constructor() {
        this.droppable_box = ["a", "c-123"];
        this.undroppable_box = ["b"];
        this.current_target = null;
        this.clone_el = null;
        this.sample_clone_el = null;
        // this.virtual_space = null;
        this.onMouseUpOn = null;
        this.onMouseMoveOn = null;
        this.funcAfterMouseUp = null;
    }
    init() {
        let onDrag = this.onDrag.bind(this);
        $(document).off("mousedown", onDrag);
        $(document).on("mousedown", onDrag);
    }
    onDrag(e) {
        if (e.which == 1) {
            let holder = $(e.target).closest("[dd-holder-id]");
            let disabler = $(e.target).closest("[dd-disabler]");
            if(holder.find(disabler).length){
                return false;
            }
            if (holder.length) {
                e.preventDefault();
                this.current_target = $(e.target).closest("[dd-group-id]");
                let clone_el = this.current_target.clone();
                let sample_clone_el = this.current_target.clone();
                this.clone_el = clone_el;
                this.sample_clone_el = sample_clone_el;
                sample_clone_el.css({ "opacity": "0.5", }).addClass("dd_sample_element");
                clone_el.css({
                    "width": this.current_target.outerWidth(), "height": this.current_target.outerHeight(), "opacity": "1", "margin": "0", "position": "fixed", "z-index": "1000", "pointer-events": "none"
                });
                this.setPositionClone(e.clientX - this.current_target.offset().left, e.clientY - this.current_target.offset().top, this.current_target.outerWidth(), this.current_target.outerHeight(), e);
                let onMouseMove = this.onMouseMove.bind(this, e.clientX - this.current_target.offset().left, e.clientY - this.current_target.offset().top, this.current_target.outerWidth(), this.current_target.outerHeight());
                let onMouseUp = this.onMouseUp.bind(this, onMouseMove);
                this.onMouseUpOn = onMouseUp;
                this.onMouseMoveOn = onMouseMove;
                $(document).off("mousemove", onMouseMove).on("mousemove", onMouseMove).off("mouseup", onMouseUp).on("mouseup", onMouseUp);
                
                $("body").addClass("isDraging");
            }
        }
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
        let group_id = this.current_target.attr("dd-group-id");
        let over_el = $(e.target).closest("[dd-field-id=" + group_id + "]");

        if (over_el.length) {
            // let field_id = over_el.attr("dd-field-id");
            // group_id = group_id.split(",")
            // dd-element-id="c-123" dd-group-id="c-123"
            // let isInArray = this.isInArray(this.droppable_box, field_id);
            let over_dd_box = $(e.target).closest("[dd-group-id=" + group_id + "]");
            if (over_dd_box.length && (this.sample_clone_el[0] != over_dd_box[0])) {
                if (over_dd_box.parent().find(this.sample_clone_el).length &&
                    ((this.sample_clone_el.offset().left > (over_dd_box.offset().left + over_dd_box.outerWidth())) ||
                        (over_dd_box.offset().left > (this.sample_clone_el.offset().left + this.sample_clone_el.outerWidth())))) {

                    // if (e.clientX < ((over_dd_box.outerWidth() / 2) + over_dd_box.offset().left)) {
                    //     if ($(over_dd_box).prev()[0] != this.sample_clone_el[0]) {
                    //         $(over_dd_box).before(this.sample_clone_el);
                    //     }
                    // } else {
                    //     if ($(over_dd_box).next()[0] != this.sample_clone_el[0]) {
                    //         $(over_dd_box).after(this.sample_clone_el);
                    //     }
                    // }


                    if (over_dd_box.offset().left > this.sample_clone_el.offset().left) {

                        if ($(over_dd_box).next()[0] != this.sample_clone_el[0]) {
                            $(over_dd_box).after(this.sample_clone_el);
                        }
                    } else {
                        if ($(over_dd_box).prev()[0] != this.sample_clone_el[0]) {
                            $(over_dd_box).before(this.sample_clone_el);
                        }
                    }
                } else {

                    if (over_dd_box.offset().top > this.sample_clone_el.offset().top) {
                        if ($(over_dd_box).next()[0] != this.sample_clone_el[0]) {
                            $(over_dd_box).after(this.sample_clone_el);
                        }
                    } else {
                        if ($(over_dd_box).prev()[0] != this.sample_clone_el[0]) {
                            $(over_dd_box).before(this.sample_clone_el);
                        }
                    }
                    // if (e.clientY < ((over_dd_box.outerHeight() / 2) + over_dd_box.offset().top)) {
                    //     if ($(over_dd_box).prev()[0] != this.sample_clone_el[0]) {
                    //         $(over_dd_box).before(this.sample_clone_el);
                    //     }
                    // } else {
                    //     if ($(over_dd_box).next()[0] != this.sample_clone_el[0]) {
                    //         $(over_dd_box).after(this.sample_clone_el);
                    //     }
                    // }
                }
            } else {
                if (!over_el.find("[dd_container=" + group_id + "]").find(this.sample_clone_el).length) {
                    over_el.find("[dd_container=" + group_id + "]").append(this.sample_clone_el);
                }
            }
        }
    }
    onMouseMove(x, y, w, h, e) {
        if(!$(".dd_current_origin").length){
            this.current_target.before(this.sample_clone_el).css({ "display": "none", }).addClass("dd_current_origin")
            this.clone_el.appendTo("body");
        }
        this.setPositionClone(x, y, w, h, e);
        this.sampleDropRender(e);
    }
    onMouseUp(e) {
        if ($(document).find(this.sample_clone_el).length) {
            this.sample_clone_el.after(this.current_target);
        } else {
        }
        this.current_target ? this.current_target.removeClass("dd_current_origin").css({ "display": "", }) : null;
        this.clone_el ? this.clone_el.remove() : null;
        this.sample_clone_el ? this.sample_clone_el.remove() : null;
        // this.virtual_space ? this.virtual_space.remove() : null;
        $(document).off("mousemove", this.onMouseMoveOn).off("mouseup", this.onMouseUpOn);
        $("body").removeClass("isDraging");
        if (typeof this.funcAfterMouseUp == "function") {
            this.funcAfterMouseUp(this);
        }
    }
}


// $(document).ready(function () {
//     let y = new dragdrop();
//     y.init();
//     // funcAfterMouseUp
//     // $(window).resize(function () { });
// });

// !(function (t) {
//     !window.jQuery ? console.log("Custom scroll library is require Jquery library to run") : t();
// })(function () {
// });


/* usage
<div dd-field-id="c-123">
<div dd_container>
    <div dd-element-id="c-123" dd-group-id="c-123">
    </div>
</div>
</div> */