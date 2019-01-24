/**
 * Created by 7du-29 on 2017/10/30.
 */
$(function(){
    //添加一级分类
    //初始化分类状态
    var cateState={
        category:true,
        openClose:true,
        addCateName:true,
        cateDesicribe:true
    };
    var cateReg={
        cateName:/^.{1,14}$/,
        cateDesicribe:/^.{1,200}$/
    }
    //二级联动
    $("#cateA").change(function(){
        $("#cateA option").each(function(i,o){
            if($(this).attr("selected")){
                $(".cateB").hide();
                $(".cateB").eq(i).show();
            }
        });
    });
    $("#cateA").change();

    $("#cateA").click(function(){
       if($(this).get(0).selectedIndex!=0){
           $(".category>em").removeClass("hide");
           $(".category>em>img").attr("src","/static/style_default/image/t_03.png");
           $(".category>em>span").html("");
           cateState.category=true;
           return true;
       }else{
           $(".category>em").removeClass("hide");
           $(".category>em>img").attr("src","/static/style_default/image/f_03.png");
           $(".category>em>span").html("请选择");
           cateState.category=false;
           return false;
       }
    });

    // 是否开放
    $(".openClose>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.openClose").find(".sure>img").attr("src","/static/style_default/image/pro_36.png");
            $(".openClose>em.deny>img").attr("src","/static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.openClose").find(".deny>img").attr("src","/static/style_default/image/pro_36.png");
            $(".openClose>em.sure>img").attr("src","/static/style_default/image/pro_38.png");
        }
        $("input[name='is_show']").val($(this).attr('value'));
        $(".openClose>em.cateTip").removeClass("hide");
        $(".openClose>em.cateTip>img").attr("src","/static/style_default/image/t_03.png");
        cateState.openClose=true;
        return true;
    });
    //添加分类名称
    $("#add_cateName").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addCateName>em>span").html("不能为空");
            cateState.addCateName=false;
            return false;
        }
        if( cateReg.cateName.test(val)){
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".addCateName>em>span").html("");
            cateState.addCateName=true;
            return true;
        }else{
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".addCateName>em>span").html("格式错误");
            cateState.addCateName=false;
            return false;
        }
    })

    var maxCount = 200;  // 最高字数
    $("#cateText").on('keyup', function() {
        var len = getStrLength(this.value);
        $("#cateNum").html(len);
        //$("#cateNum").html(maxCount-len);
    });

// 中文字符判断
    function getStrLength(str) {
        var len = str.length;
        var reLen = 0;
        for (var i = 0; i < len; i++) {
            if (str.charCodeAt(i) < 27 || str.charCodeAt(i) > 126) {
                // 全角
                reLen += 2;
            } else {
                reLen++;
            }
        }
        $(".cateDescribe>em").removeClass("hide");
        $(".cateDescribe>em>img").attr("src","/static/style_default/image/t_03.png");
        $(".cateDescribe>em>span").html("");
        cateState.cateDesicribe=true;
        return reLen;
    }
    $("#cateText").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".cateDescribe>em").removeClass("hide");
            $(".cateDescribe>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".cateDescribe>em>span").html("不能为空");
            cateState.cateDesicribe=false;
            return false;
        }
    });

    //提交
    $("#cateSub").click(function(){
        if( cateState.category && cateState.openClose && cateState.addCateName && cateState.cateDesicribe ){
            $(this).submit();
        }else{
            alert("有选项未选择或格式错误！");
            return false;
        }
    })

});

















