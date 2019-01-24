/**
 * Created by 7du-29 on 2017/10/17.
 */
$(function(){
    var head_allselect=$(".cateHead>em.v1>img");//全选
    var bottomAllselect=$(".bottomAllSelect>img");//底部全选按钮
    var choice_shoper=$(".cateBody>em.v1>img");//选择店主

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
        allSelect($(this),"all_select","bottom_allSelect","varietiesChoice",bottomAllselect,$(".cateBody>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });
    //底部工具栏全选
    bottomAllselect.click(function(){
        allSelect($(this),"bottom_allSelect","all_select","varietiesChoice",head_allselect,$(".cateBody>em.v1>img"),"/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png");
    });

    //选择店主
    function mobileShoper(eleThis,addClass1,addClass2,addClass3,img1,img2){
        var len;
        var classLen;
        if(!(eleThis.hasClass(addClass1))){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
        }
        len=choice_shoper.length;
        classLen=$(".cateBody>em.v1>img.varietiesChoice").length;
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
    choice_shoper.click(function(){
        mobileShoper($(this),"varietiesChoice","all_select","bottom_allSelect","/static/style_default/image/pro_23.png","/static/style_default/image/pro_07.png")
    });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

});