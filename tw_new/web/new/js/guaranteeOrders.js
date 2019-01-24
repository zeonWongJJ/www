/**
 * Created by 7du-29 on 2017/8/7.
 */
$(function(){
    $(".nav>a").click(function(){
        if($(this).hasClass("all")){
            $(".orderList>ul").show();
            $(this).addClass("cur");
            $(".nav>a").not($(this)).removeClass("cur");
        }else if($(this).hasClass("apply")){
            $(".naApplication").show();
            $(".orderList>ul").not(".naApplication").hide();
            $(this).addClass("cur");
            $(".nav>a").not($(this)).removeClass("cur");
        }else if($(this).hasClass("servant")){
            $(".waitToservant").show();
            $(".orderList>ul").not(".waitToservant").hide();
            $(this).addClass("cur");
            $(".nav>a").not($(this)).removeClass("cur");
        }else if($(this).hasClass("conduct")){
            $(".conducting").show();
            $(".orderList>ul").not(".conducting").hide();
            $(this).addClass("cur");
            $(".nav>a").not($(this)).removeClass("cur");
        }
    })
})






