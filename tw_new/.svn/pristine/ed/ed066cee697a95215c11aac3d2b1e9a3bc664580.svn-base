/**
 * Created by 7du-29 on 2018/1/3.
 */
$(function(){
    $(".lay").hide();
    $(".tips").hide();
    $(".lay").height( $(document).height() );
    $(".lay").click(function(){
        $(this).hide();
        $(".tips").hide();
    });
    $(".nav>a.audit").click(function(){
        $(".lay").show();
        setDivCenter( $(".tips"))
    });
    $(".cancel").click(function(){
        $(".lay").hide();
        $(".tips").hide();
    });

    $(".while>a").click(function(){
        $(this).addClass("whileCur");
        $(".while>a").not($(this)).removeClass("whileCur");
    });

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/2;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop }).show();
    }
});








