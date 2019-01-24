/**
 * Created by 7du-29 on 2017/9/19.
 */
$(function(){
    //初始化状态
    var initState={
        suppliesCate:true,
        suppliesName:true,
        suppliesNum:true,
        suppliesTotal:true
    }
    upload_update();

    //产品描述
    $("#describe").keyup(function(){
        keyCode(200,$(this),$(".suppliesDescribe>span>em"),$(".suppliesDescribe>span>img"),"static/style_default/image/t_03.png","static/style_default/image/f_03.png");
    });

    //耗材分类
    $("#supplies_cate_A").change(function() {
        var id = $(this).val();
        $('.cons_id_2').removeClass('hide');
        $('.cons_id').html('<option value="">请选择耗材</option>');
        $.ajax({
            type : 'post',
            url  : 'cons_id_2',
            data : {id:id},
            dataType : 'json',
            success  : function(data) {
                    html = '<option value="">请选择</option>';
                $.each(data, function(i, value) {
                    html += '<option value="'+value.id+'">'+value.cons_name+'</option>';
                });
                $('.cons_id_2').html(html);
            }
        })
    });
    $("#supplies_cate_A").click(function(){
        if($(this).get(0).selectedIndex!=0){
            console.log("ss");
            $(".suppliesCate>s").removeClass("hide");
            $(".suppliesCate>s>img").attr("src","static/style_default/image/t_03.png");
            $(".suppliesCate>s>span").html("");
            initState.suppliesCate=true;
            return true;
        }else{
            $(".suppliesCate>s").removeClass("hide");
            $(".suppliesCate>s>img").attr("src","static/style_default/image/f_03.png");
            $(".suppliesCate>s>span").html("请选择");
            initState.suppliesCate=false;
            return false;
        }
    });

    $(".cons_id").click(function(){
        if($(this).get(0).selectedIndex!=0){
            console.log("ss");
            $(".suppliesName>s").removeClass("hide");
            $(".suppliesName>s>img").attr("src","static/style_default/image/t_03.png");
            $(".suppliesName>s>span").html("");
            initState.suppliesName=true;
            return true;
        }else{
            $(".suppliesName>s").removeClass("hide");
            $(".suppliesName>s>img").attr("src","static/style_default/image/f_03.png");
            $(".suppliesName>s>span").html("请选择");
            initState.suppliesName=false;
            return false;
        }
    });
    $(".cons_id_2").change(function() {
        var id = $(this).val();
        $('.cons_id').html('<option value="">请选择耗材</option>');
        $('.cons_id_3').removeClass('hide');
        $.ajax({
            type : 'post',
            url  : 'cons_id_3',
            data : {id:id},
            dataType : 'json',
            success  : function(data) {
                    html = '<option value="">请选择</option>';
                $.each(data, function(i, value) {
                    html += '<option value="'+value.id+'">'+value.cons_name+'</option>';
                })
                $('.cons_id_3').html(html);
            }
        })
    });
    $(".cons_id_3").change(function() {
        var id = $(this).val();
        $('.cons_id').html('<option value="">请选择耗材</option>');
        $.ajax({
            type : 'post',
            url  : 'cons_name',
            data : {id:id},
            dataType : 'json',
            success  : function(data) {
                html = '<option value="">请选择</option>';
                $.each(data, function(i, value) {
                    html += '<option value="'+value.consumption_id+'">'+value.consu_name+'</option>';
                })
                $('.cons_id').html(html);
            }
        });
        initState.suppliesCate=true;
        return true;
    });


    $('.cons_id').change(function() {
        var name = $('.cons_id option:selected').text();
        // console.log(name);
        $('.cons_name').val(name);
        initState.suppliesName=true;
        return true;
    });

    $("#supplies_num").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesPrice>s").removeClass("hide");
            $(".suppliesPrice>s>img").attr("src","static/style_default/image/f_03.png");
            $(".suppliesPrice>s>span").html("不能为空");
            initState.suppliesNum=false;
            return false;
        }else{
            $(".suppliesPrice>s").removeClass("hide");
            $(".suppliesPrice>s>img").attr("src","static/style_default/image/t_03.png");
            $(".suppliesPrice>s>span").html("");
            initState.suppliesNum=true;
            return true;
        }
    });
    $("#totalPrice").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesTotal>s").removeClass("hide");
            $(".suppliesTotal>s>img").attr("src","static/style_default/image/f_03.png");
            $(".suppliesTotal>s>span").html("不能为空");
            initState.suppliesTotal=false;
            return false;
        }else{
            $(".suppliesTotal>s").removeClass("hide");
            $(".suppliesTotal>s>img").attr("src","static/style_default/image/t_03.png");
            $(".suppliesTotal>s>span").html("");
            initState.suppliesTotal=true;
            return true;
        }
    });

    //提交
    $("#suppliesSub").click(function(){
        if( initState.suppliesCate && initState.suppliesName && initState.suppliesNum && initState.suppliesTotal ){
            $(this).submit();
        }else{
            alert("有选项未选择或格式错误！");
            return false;
        }
    });
})









