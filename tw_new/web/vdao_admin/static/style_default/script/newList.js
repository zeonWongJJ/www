/**
 * Created by 7du-29 on 2017/10/17.
 */
$(function(){
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var newsSelect=$(".leftNews>img");//用户选择
    //选择分类
    function choiceCate(eleThis,add_class,ele){
        eleThis.addClass(add_class);
        ele.not(eleThis).removeClass(add_class);
    }

    $(".news_cateA>a>span").click(function(){
        choiceCate($(this),"cateCur",$(".news_cateA>a>span"));
    });
    $(".news_cateB>a>span").click(function(){
        choiceCate($(this),"typeCur",$(".news_cateB>a>span"))
    });
    $(".news_cateC>a>span").click(function(){
        choiceCate($(this),"typeCur",$(".news_cateC>a>span"))
    });


    //全选
    function allSelect(eleThis,addClassA,img1,img2){
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
            newsSelect.removeClass("newsSelect");
            newsSelect.attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
            newsSelect.addClass("newsSelect");
            newsSelect.attr("src",img1);
        }
    }
    bottomAllselect.click(function(){
        allSelect($(this),"allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    function news_select(eleThis,addClassA,img1,img2){
        var len;
        var classLen;
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
        }
        len=newsSelect.length;
        classLen=$(".leftNews>img.newsSelect").length;
        if( len==classLen ){
            bottomAllselect.addClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_23.png");
        }else{
            bottomAllselect.removeClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_07.png");
        }
    }
    newsSelect.click(function(){
        news_select($(this),"newsSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    // $(".displayBl").mouseenter(function(){
    //     $(this).attr("src","/static/style_default/image/ann_10.png");
    // });
    // $(".displayBl").mouseleave(function(){
    //     $(this).attr("src","/static/style_default/image/ann_07.png");
    // });
    // $(".leftNews>span").click(function(e){
    //     $(".showLay").removeClass("hide");
    //     e.stopPropagation();
    // });
    // $(".showLay").click(function(e){
    //     e.stopPropagation();
    // });
    // $(document.body).click(function(){
    //     $(".showLay").addClass("hide");
    // });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    // 重置弹出窗口的屏幕显示位置
    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.tips').outerHeight();
    var tipw   = $('.tips').outerWidth();
    $('.tips').css('top', (nagheight-tiph)/2);
    $('.tips').css('left', (nagwidth-tipw)/2);

    var showLayh   = $('.showLay').outerHeight();
    var showLayw   = $('.showLay').outerWidth();
    $('.showLay').css('top', (nagheight-showLayh)/2);
    $('.showLay').css('left', (nagwidth-showLayw)/2);

});