/**
 * Created by 7du-29 on 2017/6/27.
 */
$(function(){
    var loginWidth=parseInt($(".loginBox").width());
    $(".register").css("left",parseInt($(".register").width()));
    $(".findPwd").css("left",parseInt($(".register").width()));
    $(".lrp").css({
        "width":loginWidth,
        "height":parseInt($(".loginBox").height())+50+"px",
        "position":"relative",
        "overflow":"hidden"
    });

    console.log($(".loginBox").height());
    console.log($(".register").height());
    $(".clickRegister>a").click(function(){
        $(".loginBox").animate({"left":"-"+loginWidth},300);
        $(".register").animate({"left":0},300);
        //$(".lrp").height($(".register").height());
    })
    $(".registerBox>a").click(function(){
        $(".loginBox").animate({"left":0},300);
        $(".register").animate({"left":loginWidth},300);
        //$(".lrp").height($(".loginBox").height());
    });
    $(".forget").click(function(){
        $(".loginBox").animate({"left":"-"+loginWidth+parseInt($(".register").width())},300);
        $(".findPwd").animate({"left":0},300);
    });
    $(".head>a").click(function(){
        $(".loginBox").animate({"left":0},300);
        $(".findPwd").animate({"left":loginWidth+parseInt($(".register").width())},300);
    })
})