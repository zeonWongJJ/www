/**
 * Created by 7du-29 on 2017/9/24.
 */
$(function(){
    upload_update();
    // 产品名称
    $('#productName').keyup(function(){
        var limitNum =14;
        var pattern = '还可以输入' + limitNum + '字符/汉字';
        $('.product_name>span>em').html(pattern);
        var remain = $(this).val().length;
        if(remain >14){
            pattern = "字数超过限制！";
            $('.product_name>span>img').attr("src","static/style_default/image/f_03.png");
            initState.productName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            $('.product_name>span>img').attr("src","static/style_default/image/t_03.png");
            initState.productName=true;
        }
        $('.product_name>span>em').html(pattern);
    });
    $("#productName").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".product_name>span").removeClass("hide");
            $('.product_name>span>img').attr("src","static/style_default/image/f_03.png");
            $('.product_name>span>em').html("请输入");
            initState.productName=false;
        }else{
            $(".product_name>span").removeClass("hide");
            $('.product_name>span>img').attr("src","static/style_default/image/t_03.png");
            $('.product_name>span>em').html("");
            initState.productName=true;
        }
    });

    //温度加料
    $(".temperatureBox>a").click(function(){
        var id = $(this).attr('value');
        console.log(id);
        if( $(this).hasClass("check") ){
            $(this).find("input[name='wen["+id+"][]']").prop("name","");
            $(this).removeClass("check");
            $(this).children("img").remove();
        }else{
            $(this).find("input[name='']").prop("name","wen["+id+"][]");
            $(this).addClass("check");
            $(this).append($("<img src='static/style_default/image/ac_03.png'>"));
        }
    });
    // $(".feedingBox>a").click(function(){
    //     if( $(this).hasClass("check") ){
    //         $(this).find("input[name='liao[]']").prop("name","");
    //         $(this).removeClass("check");
    //         $(this).children("img").remove();
    //     }else{
    //         $(this).find("input[name='']").prop("name","liao[]");
    //         $(this).addClass("check");
    //         $(this).append($("<img src='static/style_default/image/ac_03.png'>"));
    //     }
    // });
//  产品关键词
   $("#product_key").keydown(function(e){
        if(e.keyCode==13){
            if($(this).val()!=""){
                $(this).next().next(".containerCate").append($("<span class='tag'>"+$(this).val()+",<img src='static/style_default/image/pro_19.png'>"+"</span>"));
                $(this).val("");
                var name = $('.tag').text();
                $('.name').val(name);
            }else{
                alert( "请输入");
            }
        }

    });
   $(".tag>img").live("click",function(){
        $(this).parent("span.tag").remove();
        var name = $('.tag').text();
        $('.name').val(name);
   });

//    产品描述
   $('#product_des').keyup(function(){
        var limitNum =200;
        var pattern =limitNum;
        $('.product_text>p>span').html(pattern);
        var remain = $(this).val().length;
        if(remain >200){
            pattern = "字数超过限制！";
        }else{
            var result = limitNum - remain;
            pattern =result;
        }
        $('.product_text>p>span').html(pattern);
   });

   $('#product_cate_A').change(function() {
        var id = $(this).val();
        $('.product_cate_B').empty();
        $('.product_cate_C').empty();
        $('.product_cate_C').html('<option value="">请选择三级分类</option>');
        $.ajax({
            type : 'post',
            url  : 'proid_id_2',
            data : "id="+id,
            dataType : 'json',
            success  : function(data) {
                string = "<option value=''>请选择二级分类</option>";
                $.each(data, function (n, value) {
                    string+="<option value="+value.pro_id+">"+value.pro_name+"</option>";
                })              
                $('.product_cate_B').append(string);
            }
        })
   });
   $('.product_cate_B').click(function() {
        var id = $(this).val();
        $('.product_cate_C').empty();
        $.ajax({
            type : 'post',
            url  : 'proid_id_3',
            data : "id="+id,
            dataType : 'json',
            success  : function(data) {
                string = "<option value=''>请选择三级分类</option>";
                $.each(data, function (n, value) {
                    string+="<option value="+value.pro_id+">"+value.pro_name+"</option>";
                });
               
                $('.product_cate_C').append(string);
            }
        })
   });
   $(".cup_type>ul>li>input").keyup(function(){
        $(this).val($(this).val().replace(/[^\-?\d.]/g,''));  
   })


    $("#productSort").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $('.product_sort>span').removeClass("hide");
            $('.product_sort>span>img').attr("src","static/style_default/image/f_03.png");
            $('.product_sort>span>em').html("请输入");
            initState.productSort=false;
        }else{
            $('.product_sort>span').removeClass("hide");
            $('.product_sort>span>img').attr("src","static/style_default/image/t_03.png");
            $('.product_sort>span>em').html("");
            initState.productSort=true;
        }

    });

    $("#product_cate_A").click(function(){
        if( ($(this).get(0).selectedIndex!=0) ){
            $(".productCate>span").removeClass("hide");
            $(".productCate>span>img").attr("src","static/style_default/image/t_03.png");
            $(".productCate>span>em").html("");
            initState.productCate=true;
        }else{
            $(".productCate>span").removeClass("hide");
            $(".productCate>span>img").attr("src","static/style_default/image/f_03.png");
            $(".productCate>span>em").html("请选择");
            initState.productCate=false;
        }
    });

    /*$(".cup_price>input").blur(function(){
            var val=$(".cup_price>input");
            if( $(this).parent().parent().find(".cup_price>input").val()=="" ){
                $(".material_price>span").removeClass("hide");
                $(".material_price>span>img").attr("src","static/style_default/image/f_03.png");
                $(".material_price>span>em").html("请输入价格(必填)");
                initState.material=false;
            }else{
                var material ="";
                $(this).parent().parent().find( ".cup_coffee>input").each(function(){
                    material+= $(this).val();
                });
                if(material==""){
                    $(".material_price>span").removeClass("hide");
                    $(".material_price>span>img").attr("src","static/style_default/image/f_03.png");
                    $(".material_price>span>em").html("至少输入一个以上的耗材分类！");
                }else{
                    for( var i=0;i<$(this).parent().parent().find(".cup_price>input").length;i++ ){
                        if( $(this).parent().parent().find(".cup_price>input")[i].value==""){
                            $(".material_price>span").removeClass("hide");
                            $(".material_price>span>img").attr("src","static/style_default/image/f_03.png");
                            $(".material_price>span>em").html("请输入价格(必填)");
                            initState.material=false;
                        } else{
                            $(".material_price>span").removeClass("hide");
                            $(".material_price>span>img").attr("src","static/style_default/image/t_03.png");
                            $(".material_price>span>em").html("");
                            initState.material=true;
                        }
                    }
                }
            }

    });

    $(".cup_coffee>input").blur(function(){
        var material ="";
        $(this).parent().parent().find( ".cup_coffee>input").each(function(){
            material+= $(this).val();
        });
        console.log(material);
        if(material==""){
            $(".material_price>span").removeClass("hide");
            $(".material_price>span>img").attr("src","static/style_default/image/f_03.png");
            $(".material_price>span>em").html("至少输入一个以上的耗材分类！");
        }else{
            for( var i=0;i<$(this).parent().parent().find(".cup_price>input").length;i++ ){
                if( $(this).parent().parent().find(".cup_price>input")[i].value==""){
                    $(".material_price>span").removeClass("hide");
                    $(".material_price>span>img").attr("src","static/style_default/image/f_03.png");
                    $(".material_price>span>em").html("请输入价格(必填)");
                    initState.material=false;
                } else{
                    $(".material_price>span").removeClass("hide");
                    $(".material_price>span>img").attr("src","static/style_default/image/t_03.png");
                    $(".material_price>span>em").html("");
                    initState.material=true;
                }
            }
        }
    });*/

    $("#product_key").blur(function(){
        if( $(".containerCate>span").length>0 ){
            $(".productKey>span").removeClass("hide");
            $(".productKey>span>img").attr("src","static/style_default/image/t_03.png");
            $(".productKey>span>em").html("");
            initState.productKey=true;
        }else{
            $(".productKey>span").removeClass("hide");
            $(".productKey>span>img").attr("src","static/style_default/image/f_03.png");
            $(".productKey>span>em").html("请输入关键字后按下回车");
            initState.productKey=false;
        }
    });

    var initState={
        productName:false,
        productSort:false,
        productCate:false,
        productKey:false
    };
    $(this).keydown( function(e) {
        var key = window.event?e.keyCode:e.which;
        if(key.toString() == "13"){
            return false;
        }
    });
    $("#reSub").click(function(){
        if( initState.productName && initState.productSort && initState.productCate && initState.productKey ){
            $(this).submit();
        }else{
            alert("有选项未输入或未选择");
            return false;
        }
    });
    
    function lala($this,classA,img1){
        if( $this.hasClass(classA) ){
            $this.removeClass(classA);
            $this.children("img").remove();
            $this.find("input[name='time[]']").prop("name","");
        }else{
            $this.find("input[name='']").prop("name","time[]");
            $this.addClass(classA);
            $this.append($("<img src='"+img1+"'>"));
        }
    }
    $(".supplyBox>a").click(function(){
        var id = $(this).attr('value');
        lala($(this),"check","static/style_default/image/ac_03.png");
    });

});











