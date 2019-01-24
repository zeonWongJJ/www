/**
 * Created by 7du-29 on 2017/9/5.
 */
$(function(){
    var all_select=$(".all_select>img");
    var choice_list=$(".choice_list>img");
    var bottom_allselect=$(".bottomAllSelect>img");

    $(".lay").hide();

    // 全选
    function allSelect(eleThis,findEle1,findEle2,add_class1,add_class2,img1,img2){
        if(!(eleThis.hasClass(add_class1))){
            eleThis.addClass(add_class1);
            eleThis.attr("src",img1);
            findEle1.addClass(add_class2);
            findEle1.attr("src",img1);
            findEle2.addClass(add_class1);
            findEle2.attr("src",img1);
            bottom_allselect.addClass("bottom_select");
            bottom_allselect.attr("src",img1);
        }else{
            eleThis.removeClass(add_class1);
            eleThis.attr("src",img2);
            findEle1.removeClass(add_class2);
            findEle1.attr("src",img2);
            findEle2.removeClass(add_class1);
            findEle2.attr("src",img2);
            bottom_allselect.removeClass("bottom_select");
            bottom_allselect.attr("src",img2);
        }
    }
    // 全选
    all_select.click(function(){
        allSelect($(this),choice_list,bottom_allselect,"checkbox","checkbox_list","static/style_default/image/pro_23.png","static/style_default/image/pro_07.png");
    });

    // 底部工具栏
    function bottomAllselect(eleThis,findEle1,addClass1,addClass2,img1,img2){
        if( !(eleThis.hasClass(addClass1)) ){
            eleThis.addClass(addClass1);
            eleThis.attr("src",img1);
            findEle1.addClass(addClass2);
            findEle1.attr("src",img1);
            all_select.addClass("checkbox");
            all_select.attr("src",img1);
        }else{
            eleThis.removeClass(addClass1);
            eleThis.attr("src",img2);
            findEle1.removeClass(addClass2);
            findEle1.attr("src",img2);
            all_select.removeClass("checkbox");
            all_select.attr("src",img2);
        }
    }
    // 底部工具栏
    bottom_allselect.click(function(){
        bottomAllselect($(this),choice_list,"bottom_select","checkbox_list","static/style_default/image/pro_23.png","static/style_default/image/pro_07.png");
    });

    //选择杯型
    function choicelist(eleThis,has_class1,img1,img2){
        var choiceLen;
        var len;
        if(!(eleThis.hasClass(has_class1))){
            eleThis.addClass(has_class1);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(has_class1);
            eleThis.attr("src",img2);
        }
        choiceLen=$(".choice_list>img.checkbox_list").length;
        len=$(".choice_list>img").length;
        console.log(choiceLen);
        if( choiceLen==len ){
            all_select.addClass("checkbox");
            all_select.attr("src",img1);
            bottom_allselect.addClass("bottom_select");
            bottom_allselect.attr("src",img1);
        }else{
            all_select.removeClass("checkbox");
            all_select.attr("src",img2);
            bottom_allselect.removeClass("bottom_select");
            bottom_allselect.attr("src",img2);
        }

    }

    //选择杯型
    choice_list.click(function(){
        choicelist($(this),"checkbox_list","static/style_default/image/pro_23.png","static/style_default/image/pro_07.png");
    });

    setDivCenter($(".tips_lay"))
    //删除
    $(".chocie_select>img:first-child").click(function(){
        $(".tips_lay").removeClass("hide");
        $(".lay").show();
    });
    $(".tips_btn>span").click(function(){
        $(".tips_lay").addClass("hide");
        $(".lay").hide();
    });
    $(".tipsClose").click(function(){
        $(".tips_lay").addClass("hide");
        $(".lay").hide();
    });
    $(".lay").click(function(){
        $(".tips_lay").addClass("hide");
        $(".lay").hide();
    });
    $(".bottomDelect").click(function(){
        $(".tips_lay").removeClass("hide");
        $(".lay").show();
    });
    // $(".tips_btn>em").click(function(){
    //     $(".tips_lay").addClass("hide");
    //     $(".lay").hide();
    // });

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop,'left':left+scrollLeft } );
    }
});














