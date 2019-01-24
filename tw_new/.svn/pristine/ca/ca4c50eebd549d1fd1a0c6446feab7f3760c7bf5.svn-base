/**
 * Created by 7du-29 on 2017/7/22.
 */
$(function(){
   $(".edit").click(function(){
        $(".collectList>ul>li").removeClass("selectedOn");//清除class
        $(".servantCon").removeClass("servantOn");//清除class
        $(".bottomDelete>span").text("0");//复位0
        if($(this).hasClass("edit")){//如果class是edit
            $(this).removeClass("edit");
            $(this).addClass("complete");
            $(this).text("完成");
            $(".collectList>ul>li>i>em ").show();
            $(".bottomDelete").show();
            $(".collectList>ul>li>i>em>img").attr("src","../img/fuxuan5.png");
            $(".servantCon>i>img").attr("src","../img/fuxuan5.png");
            $(".servantCon").css("padding-left","1.4rem");
            $(".servantInfo>i>em").css("left","2.5rem");
            $(".servantInfo>span").css("left","3.3rem");
            $(".servantCon>i").show();
        }else if($(this).hasClass("complete")){//如果class是complete
            $(this).removeClass("complete");
            $(this).addClass("edit");
            $(this).text("编辑");
            $(".collectList>ul>li>i>em").hide();
            $(".servantCon").css("padding-left","0.4rem");
            $(".servantInfo>i>em").css("left","1.4rem");
            $(".servantInfo>span").css("left","2.3rem");
            $(".servantCon>i").hide();
            $(".bottomDelete").hide();
        }
    })
    $(".headTitle>p>span").click(function(){
        $(".collectList>ul>li").removeClass("selectedOn");//清楚class
        $(".servantCon").removeClass("servantOn");//清楚class
        $(".collectList>ul>li>i>em>img").attr("src","../img/fuxuan5.png");
        $(".servantCon>i>img").attr("src","../img/fuxuan5.png");
        $(".bottomDelete>span").text("0");
        if($(this).hasClass("collectServe")){
            $(this).css("border-bottom","2px solid red");
            $(".headTitle>p>span").not($(this)).css("border","none");
            $(".servant").hide();
            $(".collectList").show();
        }else if($(this).hasClass("collectServant")){
            $(this).css("border-bottom","2px solid red");
            $(".headTitle>p>span").not($(this)).css("border","none");
            $(".servant").show();
            $(".collectList").hide();
        }
    })
    $(".servantCon").click(function(){
        var src=$(this).children("i").children("img").attr("src");//获取图片路径
        if(src=="../img/fuxuan5.png"){//如果路径等于 ../img/fuxuan5.png
            $(this).children("i").children("img").attr("src","../img/fuxuan1.png");//换图片的路径
            $(this).addClass("servantOn");//添加class为selectedOn
        }else{//否则
            $(this).children("i").children("img").attr("src","../img/fuxuan5.png");//换图片的路径
            $(this).removeClass("servantOn");//清楚class
        }
        $(".bottomDelete>span").text($(".servantOn").length);//将class为selectedOn的length放进橙色底部固定栏
    })

    $(".collectList>ul>li").live("click",function(event){
        var src=$(this).children("i").children("em").children("img").attr("src");//获取图片路径
        if(src=="../img/fuxuan5.png"){//如果路径等于 ../img/fuxuan5.png
            $(this).children("i").children("em").children("img").attr("src","../img/fuxuan1.png");//换图片的路径
            $(this).addClass("selectedOn");//添加class为selectedOn
        }else{//否则
            $(this).children("i").children("em").children("img").attr("src","../img/fuxuan5.png");//换图片的路径
            $(this).removeClass("selectedOn");//清楚class
        }
        $(".bottomDelete>span").text($(".selectedOn").length);//将class为selectedOn的length放进橙色底部固定栏
    })
    $(".bottomDelete").click(function(){
        $(".selectedOn").remove();
        $(".servantOn").remove();
        $(".bottomDelete>span").text("0");
    })

})






