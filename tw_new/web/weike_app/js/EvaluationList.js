/**
 * Created by 7du-29 on 2017/7/21.
 */
$(function(){
    $(".allEva").click(function(){
        $(".evaluateContent>ul>li").show();
        $(".forOtherEva>em").css("border-bottom","none");
        $(this).children("em").css("border-bottom","1px solid red");
    });
    $(".forOtherEva").click(function(){
        $(".forEva").hide();
        $(".allEva>em").css("border-bottom","none");
        $(this).children("em").css("border-bottom","1px solid red");
    })
})





