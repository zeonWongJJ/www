/**
 * Created by 7du-29 on 2017/8/4.
 */
$(function(){
    $(".sex>a").click(function(){
        $(this).css({"border-color":"#3190E8","color":"#6F99F0"});
        $(".sex>a").not($(this)).css({"border-color":"#ddd","color":"black"})
    });
    $(".settingAddr").toggle(function(){
        $(this).children("i").children("img").attr("src","../img/co_06.png");
    },function(){
        $(this).children("i").children("img").attr("src","../img/co_03.png");
    })

})