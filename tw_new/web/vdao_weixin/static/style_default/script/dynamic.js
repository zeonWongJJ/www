/**
 * Created by 7du-29 on 2017/11/29.
 */
$(function(){
    $(".labelBox").hide();
    $(".lay").hide();
    //�˵��л�������ʾ
    $(".pjoTitle>a").live("click",function(){
        if( $(this).hasClass("menu") ){
            $(this).removeClass("menu");
            $(this).addClass("closeMenu");
            $(this).children("img").attr("src","/static/style_default/images/xx_03.png");
            $(".labelBox").slideDown(200);
            $(".lay").show();
        }else{
            $(this).removeClass("closeMenu");
            $(this).addClass("menu");
            $(this).children("img").attr("src","/static/style_default/images/dt_03.png");
            $(".labelBox").slideUp(200);
            $(".lay").hide();
        }
    });

    $(".labelBox>ul>li").click(function(){
        $(this).children("a").css("color","#ff6633");
        $(".labelBox>ul>li>a").not($(this).children("a")).css("color","#333333")
    });

    //�ֲ�
    var mySwiper = new Swiper('.swiper-container', {
        width:100,
        spaceBetween :5
    });
});














