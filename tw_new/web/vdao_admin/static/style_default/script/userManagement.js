/**
 * Created by 7du-29 on 2017/10/13.
 */
$(function (){
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var userSelect=$(".managesmentBody>em.v1>img");//用户选择

    //全选
    function allSelect(eleThis,addClassA,img1,img2){
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
            $(".managesmentBody>em.v1>img").removeClass("userSelect");
            $(".managesmentBody>em.v1>img").attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
            $(".managesmentBody>em.v1>img").addClass("userSelect");
            $(".managesmentBody>em.v1>img").attr("src",img1);
        }
    }
    bottomAllselect.click(function(){
        allSelect($(this),"allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    function user_select(eleThis,addClassA,img1,img2){
        var len;
        var classLen;
        if(eleThis.hasClass(addClassA)){
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
        }else{
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
        }
        len=userSelect.length;
        classLen=$(".managesmentBody>em.v1>img.userSelect").length;
        if( len==classLen ){
            bottomAllselect.addClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_23.png");
        }else{
            bottomAllselect.removeClass("allSelect");
            bottomAllselect.attr("src","/static/style_default/image/pro_07.png");
        }
    }
    userSelect.click(function(){
        user_select($(this),"userSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

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

});







