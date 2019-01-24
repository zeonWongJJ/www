/**
 * Created by 7du-29 on 2017/7/24.
 */
$(function(){
    $('#nav').navbarscroll({
        defaultSelect:0,
        scrollerWidth:6,
        fingerClick:1
    });

    $(".nav .scroller li").click(function(){
       $(this).children("a").children("hr").css("left",parseInt(($(this).width()/4.5)));
    });

    $("#nav li").click(function(){
        if($(this).hasClass("nsServiceCur")){
            $(".allOrders>ul").show();
        }else if($(this).hasClass("competitiveCur")){
            $(".competitive").show();
            $(".allOrders>ul").not(".competitive").hide();
        }else if($(this).hasClass("payCur")){
            $(".pay").show();
            $(".allOrders>ul").not(".pay").hide();
        }else if($(this).hasClass("ordersCur")){
            $(".orders").show();
            $(".allOrders>ul").not(".orders").hide();
        }else if($(this).hasClass("serviceCur")){
            $(".service").show();
            $(".allOrders>ul").not(".service").hide();
        }else if($(this).hasClass("pendingServiceCur")){
            $(".pendingService").show();
            $(".allOrders>ul").not(".pendingService").hide();
        }else if($(this).hasClass("evaluateCur")){
            $(".evaluate").show();
            $(".allOrders>ul").not(".evaluate").hide();
        }else if($(this).hasClass("customerServiceCur")){
            $(".customerService").show();
            $(".allOrders>ul").not(".customerService").hide();
        }
    })
})