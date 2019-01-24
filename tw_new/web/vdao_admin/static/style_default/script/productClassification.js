/**
 * Created by 7du-29 on 2017/8/25.
 */
$(function(){
    //显示隐藏
    $(".cateA>a.c1>span,.cateA>a.c1>img").click(function(){
        if( $(this).parent().parent().children(".cateB").hasClass("hide") ){
            $(this).parent().parent().children(".cateB").slideDown(200);
            $(this).parent().parent().children(".cateB").removeClass("hide");
        }else{
            $(this).parent().parent().children(".cateB").slideUp(200);
            $(this).parent().parent().children(".cateB").addClass("hide");
        }
    });

    $(".cateB>a.c1>span,.cateB>a.c1>img").click(function(){
        if( $(this).parent().parent().children(".cateC").hasClass("hide") ){
            $(this).parent().parent().children(".cateC").slideDown();
            $(this).parent().parent().children(".cateC").removeClass("hide");
        }else{
            $(this).parent().parent().children(".cateC").slideUp();
            $(this).parent().parent().children(".cateC").addClass("hide");
        }
    });
    // 启用/暂用
    function disabled($this,classA,img1,img2){
        if( $this.parent().hasClass(classA) ){
            $this.parent().addClass(classA);
            $this.attr("src",img2);
        }else{
            $this.parent().addClass(classA);
            $this.attr("src",img1);
        }
    }

    $(".cateA>a.c4>img").click(function(){
        disabled(
            $(this),
            "disabled",
            "static/style_default/image/pro_10.png",
            "static/style_default/image/pro_33.png"
        );
    });

    $(".cateB>a.c4>img").click(function(){
        disabled(
            $(this),
            "disabled",
            "static/style_default/image/pro_10.png",
            "static/style_default/image/pro_33.png"
        );
    });

    $(".cateC>a.c4>img").click(function(){
        disabled(
            $(this),
            "disabled",
            "static/style_default/image/pro_10.png",
            "static/style_default/image/pro_33.png"
        );
    });

});



