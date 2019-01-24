/**
 * Created by 7du-29 on 2017/10/30.
 */
$(function(){
    //添加一级分类
    //初始化分类状态
    var cateState={
        category:false,
        openClose:false,
        addCateName:false
    };
    var cateReg={
        cateName:/^.{1,14}$/,
        cateDesicribe:/^.{1,200}$/
    }
    //二级联动
    $("#cateA").change(function(){
        var id = $(this).attr('value');        
        $('.cateB').removeClass('hide');
        $.ajax({
            type : 'post',
            url  : 'attri_id_2',
            data : {id:id},
            dataType : 'json',
            success  : function(data) {
                var html = '<option value="'+id+'">请选择二级分类</option>';
                $.each(data, function(i, value){
                    html += '<option value="'+value.attri_id+'-'+2+'">'+value.attri_name+'</option>';
                })
                $('.cateB').html(html);
            }
        })
        $('.proid').val(id);
        // cateState.category=true;
        // return true;
    });
    $('.cateB').change(function(){
        var id = $(this).attr('value');
        $('.proid').val(id);
    });

    $("#cateA").click(function(){
        if( ($(this).get(0).selectedIndex!=0) ){
            $(".category>em").removeClass("hide");
            $(".category>em>img").attr("src","static/style_default/image/t_03.png");
            $(".category>em>span").html("");
            cateState. category=true;
        }else{
            $(".category>em").removeClass("hide");
            $(".category>em>img").attr("src","static/style_default/image/f_03.png");
            $(".category>em>span").html("请选择");
            cateState. category=false;
        }
    });

    // 是否开放
    $(".openClose>em").click(function(){
        if($(this).index()==1){
            $('.show').val(1);
            $(this).parent("li.openClose").find(".sure>img").attr("src","static/style_default/image/pro_36.png");
            $(".openClose>em.deny>img").attr("src","static/style_default/image/pro_38.png");
        }else if($(this).index()==2){
            $('.show').val(2);
            $(this).parent("li.openClose").find(".deny>img").attr("src","static/style_default/image/pro_36.png");
            $(".openClose>em.sure>img").attr("src","static/style_default/image/pro_38.png");
        }
        $(".openClose>em.cateTip").removeClass("hide");
        $(".openClose>em.cateTip>img").attr("src","static/style_default/image/t_03.png");
        cateState.openClose=true;
        return true;
    });
    //添加分类名称
    $("#add_cateName").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","static/style_default/image/f_03.png");
            $(".addCateName>em>span").html("不能为空");
            cateState.addCateName=false;
            return false;
        }
        if( cateReg.cateName.test(val)){
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","static/style_default/image/t_03.png");
            $(".addCateName>em>span").html("");
            cateState.addCateName=true;
            return true;
        }else{
            $(".addCateName>em").removeClass("hide");
            $(".addCateName>em>img").attr("src","static/style_default/image/f_03.png");
            $(".addCateName>em>span").html("格式错误");
            cateState.addCateName=false;
            return false;
        }
    })

    //提交
    $("#cateSub").click(function(){
        if(cateState.openClose && cateState.addCateName){
            $(this).submit();
        }else{
            alert("有选项未选择或格式错误！");
            return false;
        }
    })

});

















