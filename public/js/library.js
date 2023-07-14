function textAreaAutoResize() {
    function funX() {
        this.style.height = 0;
        this.style.height = (this.scrollHeight) + "px";
    }
    $("textarea[auto-resize]").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    });
    $(document).on("input", "textarea[auto-resize]", funX);
}
function customNotification(config) {
    // ---------------Usage--------------------------
    // customNotification({
    //     option :{"Confirm":()=>{alert("confirm")},"Cancel":()=>{}},
    //     cancel:"none",
    //     type:"warning",
    //     title: "Warning",
    //     description : "Do you want to delete this workspace?"
    // });
    // --------------- Usage --------------------------
    let type = title = description = icon = button = btn_cancel = "";
    if(config != null && typeof config == "object"){
        type = config.type ? config.type : "";
        title = config.title ? config.title : "";
        description = config.description ? config.description : "";
        btn_cancel = config.cancel ? config.cancel : "";
        if(config.option != null){
            button = '';
            for (const key in config.option) {
                button += `<input type="button" value="${key}"> `;
            }
        }
    }
    switch (type) {
        case "warning":
            type = "warning";
            icon = `<div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>`;
            break;

        default:
            type = ""
            break;
    }
    let str = `
        <div class="custom-notification layout-container layout_container">
            <style>
                .custom-notification.layout-container{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    width: 100vw;
                    background-color: rgb(36 36 36 / 40%);
                    z-index: 500;
                    position: absolute;
                }
                .custom-notification .card-wrapper{
                    min-width: 200px;
                    max-width: 360px;
                    min-height: 100px;
                    max-height: 500px;
                    background-color: #8b8b8b;
                    border-radius: 2px;
                }
                .custom-notification .banner{    
                    display: flex;
                    padding: 18px 4px 0 28px;
                }
                .custom-notification .banner.warning .icon{
                    color:#ffa500;
                }
                .custom-notification .icon{    
                    font-size: 46px;
                    padding: 0 12px 0 0;
                }
                .custom-notification .title{    
                    font-size: 24px;
                    font-weight: bold;
                    display: flex;
                    align-items: center;
                    flex-grow: 1;
                }
                .custom-notification .noti_body{
                    font-size: 16px;
                    padding: 10px 20px 0px 36px;
                }
                .custom-notification .choices_wrapper{
                    display: flex;
                    flex-direction: row-reverse;
                }
                .custom-notification .choices{
                    padding: 20px 32px 16px 0;
                }
                .custom-notification input[type="button"]{
                    height: 32px;
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
                    padding: 4px 12px;
                    background-color: #a9a9a9;
                    color: white;
                    margin-left: 6px;
                    min-width: 64px;
                }
                .custom-notification input[type="button"]:hover{
                    background-color: #b5b5b5;
                }
            </style>
            <div class="card-wrapper card_wrapper" >
                <div class="banner ${type} banner_" >
                    ${icon}
                    <div class="title">${title}</div>
                </div>
                <div class="noti_body body_">
                    <div class="description">${description}</div>
                </div>
                <div class="choices_wrapper" style="display: flex; flex-direction: row-reverse;}">
                    <div class="choices choices_">
                        <div class="option">
                            ${btn_cancel == "none"?"":'<input type="button" value="Cancel">'}
                            ${button}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    let el = $(str);

    if(config != null && typeof config == "object"){
        if(config.option != null){
            for (const key in config.option) {
                el.find("[value='"+key+"']").on("click",config.option[key]).on("click",closeBtn);
            }
        }
    }
    el.find("[value='Cancel']").on("click",closeBtn);
    function closeBtn(e) {
            el.remove();
    }
    function close(e) {
        if (!$(e.target).closest(".card_wrapper").length && $(e.target).closest(".layout_container").length ) {
            $(document).off("click", close);
            el.remove();
        }
    }
    $(document).off("click", close);
    $(document).on("click", close);
    $("body").append(el);
    
}
function removeWaterMark() {
    let t = 0;
    let x = setInterval(() => {
        t += 50;
        // console.log("Removed Brand Name");
        if ($("[alt='www.000webhost.com']").length) {
            $("[alt='www.000webhost.com']").parent().parent().css("display", "none");
            clearInterval(x);
        }
        if (t > 2000) {
            clearInterval(x);
        }
    }, 50);
}
$(document).ready(function () {
    textAreaAutoResize();
    removeWaterMark();
    
});
