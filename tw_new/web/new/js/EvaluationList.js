/**
 * Created by 7du-29 on 2017/7/21.
 */
$(function(){
    $(".allEva").click(function(){
        $(".forEva").show();
        $(".otherEva").hide();
        $(".forOtherEva>em").css("border-bottom","none");
        $(this).children("em").css("border-bottom","0.1rem solid red");
    });
    $(".forOtherEva").click(function(){
        $(".otherEva").show();
        $(".forEva").hide();
        $(".allEva>em").css("border-bottom","none");
        $(this).children("em").css("border-bottom","0.1rem solid red");
    });
})




