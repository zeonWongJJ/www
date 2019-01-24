/**
 * Created by 7du-29 on 2018/1/13.
 */
$(function(){
    $(".lay").hide();
    $(".lay").height( $(document).height() );
    $(".regionContainer").hide();
choose_province();
    //选择性别
    $(".userSex>em").click(function(){
        var out = $(this).attr('value');
        $('#nei').val(out);
        $(this).addClass("sexCur");
        $(this).children("img").attr("src","static/style_default/images/redbag_06.png");
        $(".userSex>em").not($(this)).removeClass("sexCur");
        $(".userSex>em").not($(this)).children("img").attr("src","static/style_default/images/redbag_10.png");
    });

    //遮罩层
    $(".lay").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    });

    //选择地区
    $(".regionChoice").click(function(){
        $(".lay").show();
        $(".regionContainer").show();
    });

    $('.harea').click(function() {
        $(".lay").hide();
        $(".regionContainer").hide();
    })

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } );
    }
});










