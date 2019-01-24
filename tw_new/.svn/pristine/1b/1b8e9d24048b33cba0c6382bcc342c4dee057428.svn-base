/**
 * Created by 7du-29 on 2017/7/21.
 */
$(function(){
    $(".edit").click(function(){
        $(".footPrintList>ul>li").removeClass("selectedOn");//清楚class
        $(".bottomDelete>span").text("0");//复位0
        if($(this).hasClass("edit")){//如果class是edit
            $(this).removeClass("edit");
            $(this).addClass("complete");
            $(this).text("完成");
            $(".footPrintList>ul>li>i>em ").show();
            $(".bottomDelete").show();
            $(".footPrintList>ul>li>i>em>img").attr("src","../img/fuxuan5.png");
        }else if($(this).hasClass("complete")){//如果class是complete
            $(this).removeClass("complete");
            $(this).addClass("edit");
            $(this).text("编辑");
            $(".footPrintList>ul>li>i>em").hide();
            $(".bottomDelete").hide();
        }
    })
    $(".footPrintList>ul>li").live("click",function(event){
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
        $(".bottomDelete>span").text("0");
    })
})





