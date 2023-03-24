function textAreaAutoResize(){
    function funX(){
        this.style.height = 0;
        this.style.height = (this.scrollHeight) + "px";
    }
    $("textarea[auto-resize]").each(function() {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    }).on("input", funX);
}
$(document).ready(function() {
    textAreaAutoResize();
});