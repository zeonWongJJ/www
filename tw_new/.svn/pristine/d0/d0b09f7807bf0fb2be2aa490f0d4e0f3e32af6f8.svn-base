/**
 * Created by 7du-29 on 2017/9/28.
 */
$(function(){
    //初始化状态
    var initState={
        supplies_name:false,
        suppliesCate:false,
        suppliesPrice:false,
        suppliesUnit:false,
        suppliesStock:false,
        suppliesWarning:false
    };

    $("#supplies_name").blur(function(){
        $(".suppliesName>s").show();
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesName>s").removeClass("hide");
            $(".suppliesName>s>em").html("不能为空");
            $(".suppliesName>s>img").attr("src","static/style_default/image/f_03.png");
            initState.supplies_name=false;
            return false;
        }else{
            $(".suppliesName>s").removeClass("hide");
            $(".suppliesName>s>em").html("");
            $(".suppliesName>s>img").attr("src","static/style_default/image/t_03.png");
            initState.supplies_name=true;
            return true;
        }
    });
    function keyCode(codeNum,eleThis,findEle1,findEle2,img1,img2){
        var limitNum =codeNum;
        var pattern = '还可以输入' + limitNum + '字符/汉字';
        findEle1.html(pattern);
        var remain = eleThis.val().length;
        if(remain >codeNum){
            pattern = "字数超过限制！";
            findEle2.attr("src",img2);
            initState.supplies_name=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
            initState.supplies_name=true;
        }
        findEle1.html(pattern);
    }
    //耗材名称
    $("#supplies_name").keyup(function(){
        keyCode(14,$(this),$(".suppliesName>s>em"),$(".suppliesName>s>img"),"static/style_default/image/t_03.png","static/style_default/image/f_03.png");
    });


    //耗材2级分类
    $("#supplies_cate_A").click(function(){
        if( ($(this).get(0).selectedIndex!=0) ){
            $(".suppliesCate>s").removeClass("hide");
            $(".suppliesCate>s>img").attr("src","static/style_default/image/t_03.png");
            $(".suppliesCate>s>em").html("");
            initState.suppliesCate=true;
            return true;
        }else{
            $(".suppliesCate>s").removeClass("hide");
            $(".suppliesCate>s>img").attr("src","static/style_default/image/f_03.png");
            $(".suppliesCate>s>em").html("请选择");
            initState.suppliesCate=false;
            return false;
        }
    });
    $("#supplies_cate_A").change(function(){
        var id = $(this).val();
        $('.supplies_cate_B').empty();
        $.ajax({
            type : 'post',
            url  : 'cons_id_2',
            data : {id:id},
            dataType : 'json',
            success  : function(data){
                var html = '<option value="">请选择2级分类</option>';
                $.each(data, function(i, index){
                    html += '<option value="'+index.id+'">'+index.cons_name+'</option>';
                })
                $('.supplies_cate_B').html(html);
                $(".supplies_cate_B").removeClass("hide");
                $(".supplies_cate_C").addClass("hide");
                $('.supplies_cate_C').html('');
            }
        })
    });
     //耗材3级分类
    $(".supplies_cate_B").change(function(){
        var id = $(this).val();
        $('.supplies_cate_C').empty();
        $.ajax({
            type : 'post',
            url  : 'cons_id_3',
            data : {id:id},
            dataType : 'json',
            success  : function(data){
                var html = '<option value="">请选择3级分类</option>';
                $.each(data, function(i, index){
                    html += '<option value="'+index.id+'">'+index.cons_name+'</option>';
                })
                $('.supplies_cate_C').html(html);
                $(".supplies_cate_C").removeClass("hide");
            }
        })
    });
    $('.supplies_cate_C').change(function(){
        initState.suppliesCate=true;
        return true;
    })
    
    //单价
    $("#supplies_price").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesPrice>s").removeClass("hide");
            $(".suppliesPrice>s>em").html("不能为空");
            $(".suppliesPrice>s>img").attr("src","static/style_default/image/f_03.png");
            initState.suppliesPrice=false;
            return false;
        }else{
            $(".suppliesPrice>s").removeClass("hide");
            $(".suppliesPrice>s>em").html("");
            $(".suppliesPrice>s>img").attr("src","static/style_default/image/t_03.png");
            initState.suppliesPrice=true;
            return true;
        }
    });

    //单位
    $("#supplist_unit").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesUnit>s").removeClass("hide");
            $(".suppliesUnit>s>em").html("不能为空");
            $(".suppliesUnit>s>img").attr("src","static/style_default/image/f_03.png");
            initState.suppliesUnit=false;
            return false;
        }else{
            $(".suppliesUnit>s").removeClass("hide");
            $(".suppliesUnit>s>em").html("");
            $(".suppliesUnit>s>img").attr("src","static/style_default/image/t_03.png");
            initState.suppliesUnit=true;
            return true;
        }
    });
    //库村
    $("#supplist_stock").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesStock>s").removeClass("hide");
            $(".suppliesStock>s>em").html("不能为空");
            $(".suppliesStock>s>img").attr("src","static/style_default/image/f_03.png");
            initState.suppliesStock=false;
            return false;
        }else{
            $(".suppliesStock>s").removeClass("hide");
            $(".suppliesStock>s>em").html("");
            $(".suppliesStock>s>img").attr("src","static/style_default/image/t_03.png");
            initState.suppliesStock=true;
            return true;
        }
    });

    //预警值
    $("#supplist_warning").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".suppliesWarning>s").removeClass("hide");
            $(".suppliesWarning>s>em").html("不能为空");
            $(".suppliesWarning>s>img").attr("src","static/style_default/image/f_03.png");
            initState.suppliesWarning=false;
            return false;
        }else{
            $(".suppliesWarning>s").removeClass("hide");
            $(".suppliesWarning>s>em").html("");
            $(".suppliesWarning>s>img").attr("src","static/style_default/image/t_03.png");
            initState.suppliesWarning=true;
            return true;
        }
    });
    //提交
    $("#suppliesSub").click(function(){
        if( initState.supplies_name && initState.suppliesCate && initState.suppliesPrice && initState.suppliesStock && initState.suppliesUnit && initState.suppliesWarning ){
            $(this).submit();
        }else{
            alert("格式错误或有选项未选择！");
            return false;
        }
    })

});
