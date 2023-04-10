function textAreaAutoResize(){
    function funX(){
        this.style.height = 0;
        this.style.height = (this.scrollHeight) + "px";
    }
    $("textarea[auto-resize]").each(function() {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    }).on("input", funX);
}
function removeWaterMark(){
    let t = 0;
    let x = setInterval(() => {
        t += 50;
        console.log("Removed Brand Name");
        if($("[alt='www.000webhost.com']").length){
            $("[alt='www.000webhost.com']").parent().parent().css("display","none");
            clearInterval(x);
        }
        if(t > 2000){
            clearInterval(x);
        }
    }, 50);
}
$(document).ready(function() {
    textAreaAutoResize();
    removeWaterMark();
});
