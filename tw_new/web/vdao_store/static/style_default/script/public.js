/**
 * Created by 7du-29 on 2017/8/23.
 */
$(function(){
    $(".navList>li").click(function(){
        if($(this).children("ul").hasClass("hide")){
            $(this).children("a").children("em").children("img").attr('src',"images/pro_41.png");
            $(this).children("ul").removeClass("hide");
            $(".aChild").css("margin-top","11px");
        }else{
            $(this).children("a").children("em").children("img").attr('src',"images/indexPic_34.png");
            $(this).children("ul").addClass("hide");
            $(".aChild").css("margin-top","6px");
        }
    })
})















