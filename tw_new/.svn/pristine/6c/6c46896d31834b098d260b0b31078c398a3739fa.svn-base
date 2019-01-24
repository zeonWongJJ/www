/**
 * Created by 7du-29 on 2017/9/11.
 */
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//全选
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var choice_device=$(".varieties>em.v1>img");//选择设备
    var varietiesDisable=$(".varieties>em.v4>img");//是否开放

    function allSelect(eleThis,addClass1,addClass2,addClass3,ele1,ele2,img1,img2){
        if( !(eleThis.hasClass(addClass1)) ){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
            ele1.addClass(addClass2);
            ele1.attr("src",img1);
            ele2.addClass(addClass3);
            ele2.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
            ele1.removeClass(addClass2);
            ele1.attr("src",img2);
            ele2.removeClass(addClass3);
            ele2.attr("src",img2);
        }
        console.log(eleThis);
    }
    //全选
    head_allselect.click(function(){
        allSelect($(this),"all_select","bottom_allSelect","varietiesChoice",bottomAllselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });
    //底部工具栏全选
    bottomAllselect.click(function(){
        allSelect($(this),"bottom_allSelect","all_select","varietiesChoice",head_allselect,$(".varieties>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

//  选择设备
    function varieties(eleThis,addClass1,addClass2,addClass3,img1,img2){
        var len;
        var classLen;
        if(!(eleThis.hasClass(addClass1))){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
        }
        len=choice_device.length;
        classLen=$(".varieties>em.v1>img.varietiesChoice").length;
        if(len==classLen){
            head_allselect.addClass(addClass2);
            head_allselect.attr("src",img1);
            bottomAllselect.addClass(addClass3);
            bottomAllselect.attr("src",img1);
        }else{
            head_allselect.removeClass(addClass2);
            head_allselect.attr("src",img2);
            bottomAllselect.removeClass(addClass3);
            bottomAllselect.attr("src",img2);
        }
    }

    choice_device.click(function(){
        varieties($(this),"varietiesChoice","all_select","bottom_allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });

    //是否开放
    // function varieties_disabled(eleThis,addClass1,img1,img2){
    //     if( !(eleThis.hasClass(addClass1)) ){
    //         eleThis.addClass(addClass1);
    //         eleThis.attr("src",img1);
    //     }else{
    //         eleThis.removeClass(addClass1);
    //         eleThis.attr("src",img2);
    //     }
    // }
    // varietiesDisable.click(function(){
    //     varieties_disabled($(this),"disabled","/static/style_default/image/pro_33.png","/static/style_default/image/pro_10.png")
    // })

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
    var tiph   = $('.pop_tips').outerHeight();
    var tipw   = $('.pop_tips').outerWidth();
    $('.pop_tips').css('top', (nagheight-tiph)/2);
    $('.pop_tips').css('left', (nagwidth-tipw)/2);

})












