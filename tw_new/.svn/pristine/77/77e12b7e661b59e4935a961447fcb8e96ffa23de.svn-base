/**
 * Created by 7du-29 on 2017/9/27.
 */
$(function(){
    var allSelect=$(".cateHead>em.v1>img");//全选
    var bottomSelect=$(".bottomAllSelect>img");//底部全选
    var choiceCate=$(".cateBody>em.v1>img");

    //全部状态
    $(".stateBox").mouseover(function(){
        $(this).css({"background":"white","border":"1px solid #ddd","border-bottom":"none"});
        $(".state").removeClass("hide");
    });
    $(".stateBox").mouseout(function(){
        $(this).css({"background":"none","border":"1px solid #f4f7fc","border-bottom":"none"});
        $(".state").addClass("hide");
    });

    function all_select(eleThis,addClassA,addClassB,addClassC,eleA,img1,img2){
        if(!(eleThis.hasClass(addClassA))){
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
            eleA.addClass(addClassB);
            eleA.attr("src",img1);
            choiceCate.addClass(addClassC);
            choiceCate.attr("src",img1);
        }else{
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
            eleA.removeClass(addClassB);
            eleA.attr("src",img2);
            choiceCate.removeClass(addClassC);
            choiceCate.attr("src",img2);
        }
    }
    allSelect.click(function(){
        all_select($(this),"allSelect","bottomSelect","choiceCate",bottomSelect,"images/pro_23.png","images/pro_07.png");
    });
    bottomSelect.click(function(){
        all_select($(this),"bottomSelect","allSelect","choiceCate",allSelect,"images/pro_23.png","images/pro_07.png");
    });

    function choice_cate(eleThis,addClassA,img1,img2){
        var len;
        var classLen;
        if(!(eleThis.hasClass(addClassA))){
            eleThis.addClass(addClassA);
            eleThis.attr("src",img1);
        }else{
            eleThis.removeClass(addClassA);
            eleThis.attr("src",img2);
        }
        len=$(".cateBody>em.v1>img").length;
        classLen=$(".cateBody>em.v1>img.choiceCate").length;
        if(len==classLen){
            allSelect.addClass("allSelect");
            allSelect.attr("src",img1);
            bottomSelect.addClass("bottomSelect");
            bottomSelect.attr("src",img1);
        }else{
            allSelect.removeClass("allSelect");
            allSelect.attr("src",img2);
            bottomSelect.removeClass("bottomSelect");
            bottomSelect.attr("src",img2);
        }
    }
    choiceCate.click(function(){
        choice_cate($(this),"choiceCate","images/pro_23.png","images/pro_07.png");
    });
});

















