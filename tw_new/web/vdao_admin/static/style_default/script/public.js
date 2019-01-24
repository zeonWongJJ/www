/**
 * Created by 7du-29 on 2017/8/23.
 */
$(function(){
    $(".navList>li>ul").addClass("show");
    $(".navList>li").click(function(){
        if($(this).children("ul").hasClass("show")){
            $(this).children("a").children("em").children("img").attr('src',"./static/style_default/image/pro_41.png");
            $(this).children("ul").removeClass("show");
            $(this).children("ul").show(200);
			$(".navList>li>ul").not($(this).children("ul")).addClass("show");
			$(".navList>li>ul").not($(this).children("ul")).hide(200);
			$(".navList>li>a>em>img").not($(this).children("a").children("em").children("img")).attr('src',"./static/style_default/image/indexPic_34.png");
		}else{
            $(this).children("a").children("em").children("img").attr('src',"./static/style_default/image/indexPic_34.png");
            $(this).children("ul").addClass("show");
            $(this).children("ul").hide(200);
        }
    })
    
});















