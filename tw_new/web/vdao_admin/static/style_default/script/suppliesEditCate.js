/**
 * Created by 7du-29 on 2017/10/30.
 */
$(function(){
    //添加一级分类
    //初始化分类状态
    var cateState={
        category:true,
        openClose:true,
        addCateName:true
    };
    var cateReg={
        cateName:/^.{1,14}$/
    }

    $('#cateA').click(function() {
        var id = $(this).attr('value');
        $('.cateB').empty();
        if (id == 0) {
            $('.cateB').addClass('hide');
        } else {         
            $('.cateB').removeClass("hide");   
            $.ajax({
                type : 'post',
                url  : 'cons_id_2',
                data : {id:id},
                dataType : 'json',
                success  : function(data) {
                    var html = '<option value="'+id+'">请选择二级</option>';
                    $.each(data, function(i, index){
                        html += '<option value="'+index.id+'-'+2+'">'+index.cons_name+'</option>';
                    })
                    $('.cateB').html(html);
                }
            })
        };
        $('.cons_id').val(id);
        cateState.category=true;
    })
    $('.cateB').click(function(){
        var id = $(this).attr('value');
        $('.cons_id').val(id);
        cateState.category=true;
    })
    
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
        if( cateState.category && cateState.addCateName ){
            $(this).submit();
        }else{
            alert("有选项未选择或格式错误！");
            return false;
        }
    })

});

















