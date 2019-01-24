/**
 * Created by 7du-29 on 2018/1/2.
 */
$(function(){
    $(".lay").hide();
    $(".tips").hide();
    $(".lay").height($(document).height());
    $(".nav>a").click(function(){
        $(this).addClass("navCur");
        $(".nav>a").not($(this)).removeClass("navCur")
    });

    //点击遮罩层恢复
    $(".lay").click(function(){
        $(this).hide();
        $(".tips").hide();
    });
    //接单
    // $(".meet").click(function(){
    //     $(".lay").show();
    //     setDivCenter($(".tips"));
    //     $(".tips").show();
    // });
    //取消
    $(".cancel").click(function(){
        $(".lay").hide();
        $(".tips").hide();
    });
    //取消订单
    // $(".cancelOrder").click(function(){
    //     setDivCenter($(".tipsTNT"));
    //     $(".tipsTNT").stop().show(100).delay(3000).hide(100);
    //     $(".tipsTNT").html("订单取消成功！");
    // });


    //让指定的DIV始终显示在屏幕正中间
    // function setDivCenter(divName){
    //     var top = ($(window).height() - divName.height())/2;
    //     var left = ($(window).width() - divName.width())/2;
    //     var scrollTop = $(document).scrollTop();
    //     //var scrollLeft = $(document).scrollLeft();
    //     divName.css( { 'top' : top + scrollTop});
    // }
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.tips').outerHeight();
    var tipw   = $('.tips').outerWidth();
    $('.tips').css('top', (nagheight-tiph)/2);
    $('.tips').css('left', (nagwidth-tipw)/2);

});





