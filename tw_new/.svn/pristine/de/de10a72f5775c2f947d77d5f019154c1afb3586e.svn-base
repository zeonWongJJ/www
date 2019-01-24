$(document).ready(function(){
    //上传图片;
    function ThumbView (obj , w , h) {
        for (var i = 0 ; i<obj.files.length; i++){
            (function(){
                var fr = new FileReader(); // 一个filereader对象只能读取一个文件
                fr.onload = function () {
                    
                    var img = $(obj).prev('img')[0];

                    img = img.setAttribute('src' , fr.result);

                }
                fr.readAsDataURL(obj.files[i]);
            })(i);
        }
    }

    // 点击第第一个出现第二个select
    $(".gc_id_1").change(function(){
        var area_top = $(this).val();
        $.ajax({
                type : "POST",
                url : "classify",
                data: "classify="+area_top,
                success :function(msg)
                {
                    if(msg!=''){  
                        var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                        var str = "";
                            str +=  '<select class="gc_id_2" name="gc_id_2" id="area_city" >';
                            str +=  "<option>请选择</option>";
                            for (var i = 0; i < json.length; i++) {
                                str += "<option value='" + json[i].gc_id + "'>" + json[i].gc_name + "</option>";
                            }
                            str += "</select>";
                        if ($('#area_city') == undefined){
                            $('.gc_id_1').after(str);
                        } else if(area_top == false){
                            $('#area_city').remove();
                            $('#area_town').remove();
                        } else{
                            $('#area_city').remove();
                            $('#area_town').remove();
                            $('.gc_id_1').after(str);
                        }
                    }
                }
            });
    });

    //分类三级联动
    $(document).on('change',".gc_id_2",function(){
        var area_city = $(this).val();
        $.ajax({
                type : "POST",
                url : "classify",
                data: "classify="+area_city,
                success :function(msg)
                {
                    if(msg!=''){  
                        var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                        var str = "";
                            str +=  '<select class="gc_id_3" name="gc_id_3" id="area_town" >';
                            str +=  "<option value=''>请选择</option>";
                            for (var i = 0; i < json.length; i++) {
                                str += "<option value='" + json[i].gc_id + "'>" + json[i].gc_name + "</option>";
                            }
                            str += "</select>";
                        if ($('#area_town') == undefined){
                            $('#area_city').after(str);
                        } else if(area_city == '请选择'){
                            $('#area_town').remove();
                        } else {
                            $('#area_town').remove();
                            $('#area_city').after(str);
                        }

                        // 当第三个选择框选中赋值
                        $('#area_town').change(function(){
                            var area_town = $('#area_town').val();
                            var gc_id_1 = $('[name="gc_id_1"]').find('option:selected').text();
                            var gc_id_2 = $('#area_city').find('option:selected').text();
                            var gc_id_3 = $('#area_town').find('option:selected').text();
                            $('input[name="gc_id_1_name"]').val(gc_id_1);
                            $('input[name="gc_id_2_name"]').val(gc_id_2);
                            $('input[name="gc_id_3_name"]').val(gc_id_3);

                        });
                    }
                }
            });
    });

    // 城市联动1，2级联动
    $(".areaid_1").change(function(){
        var area_top = $(this).val();
        $.ajax({
                type : "POST",
                url : "area",
                data: "area="+area_top,
                success :function(msg)
                {
                    if(msg!=''){  
                        var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                        var str = "";
                            str +=  '<select class="areaid_2" name="areaid_2" id="areaid_2" >';
                            str +=  "<option>请选择</option>";
                            for (var i = 0; i < json.length; i++) {
                                str += "<option value='" + json[i].area_id + "'>" + json[i].area_name + "</option>";
                            }
                            str += "</select>";
                        if ($('#areaid_2') == undefined){
                            $('.areaid_1').after(str);
                        } else if(area_top == false){
                            $('#areaid_2').remove();
                        } else{
                            $('#areaid_2').remove();
                            $('.areaid_1').after(str);
                        }
                    }
                }
            });
    });

    // 加载运行获取其中的代码
    $(function(){
        var store_name = $("select[name='store_id'] option:selected").attr('data');
        $("input[name='store_name']").val(store_name);

        var transport_id = $("select[name='transport_id'] option:selected").attr('data');
        $("input[name='goods_freight']").val(transport_id);

         var brand_name= $('select[name="brand_id"]').find('option:selected').text();
        $("input[name='brand_name']").val(brand_name);

        var transport_title = $("select[name='transport_id']").find('option:selected').text();
        $("input[name='transport_title']").val(transport_title);

        var gc_id_1 = $("select[name='gc_id_1']").find('option:selected').text();
        $("input[name='gc_id_1_name']").val(gc_id_1);

        var gc_id_2 = $("select[name='gc_id_2']").find('option:selected').text();
        $("input[name='gc_id_2_name']").val(gc_id_2);

        var gc_id_3 = $("select[name='gc_id_3']").find('option:selected').text();
        $("input[name='gc_id_3_name']").val(gc_id_3);
    });


    //选中商品获取商品的名称
    $("select[name='store_id']").change(function(){
        var store_name = $("select[name='store_id'] option:selected").attr('data');
        $("input[name='store_name']").val(store_name);
    });

    $("select[name='transport_id']").change(function(){
        var transport_id = $("select[name='transport_id'] option:selected").attr('data');
        $("input[name='goods_freight']").val(transport_id);
    });

    //当选中品牌时获取品牌的名字
    $('select[name="brand_id"]').change(function(){
        var brand_name= $(this).find('option:selected').text();
        $("input[name='brand_name']").val(brand_name);
    });

    //当选中运费模板的时候获取运费模板的名称
    $('select[name="transport_id"]').change(function(){
        var transport_title = $(this).find('option:selected').text();
        $("input[name='transport_title']").val(transport_title);
        
    });
function status(){
    var str = true;
    $('select').each(function(){
        if($(this).find('option:selected').val() == ''){
            str = false;
            return false;
        }
    });
    return str;
}

// function input(){
//     var inp = true;
//     $('input').each(function(){
//         if($(this).val() == ""){
//             if($(this).attr('name') != ''){
//                 inp = false;
//                 return false;
//             }
//         }
//     });
//     return inp;
// }
    // 修改和添加表单JS验证数据是否为空
    $(document).on('click',".btn-info",function(){
        var goods_name              = $("input[name='goods_name']").val();
        var goods_jingle            = $("input[name='goods_jingle']").val();
        var keywords                = $("input[name='keywords']").val();
        var goods_price             = $("input[name='goods_price']").val();
        var goods_marketprice       = $("input[name='goods_marketprice']").val();
        var goods_promotion_price   = $("input[name='goods_promotion_price']").val();
        var goods_discount          = $("input[name='goods_discount']").val();
        var goods_storage_alarm     = $("input[name='goods_storage_alarm']").val();
        var goods_click             = $("input[name='goods_click']").val();
        var goods_salenum           = $("input[name='goods_salenum']").val();
        var goods_collect           = $("input[name='goods_collect']").val();
        var goods_storage           = $("input[name='goods_storage']").val();
        var deductible_point        = $("input[name='deductible_point']").val();
        var goods_feng              = $("input[name='goods_feng']").val();
        var payment                 = $("select[name='payment']").val();
        var evaluation_count        = $("input[name='evaluation_count']").val();
        var evaluation_good_star    = $("input[name='evaluation_good_star']").val();
        var virtual_indate          = $("input[name='virtual_indate']").val();
        var virtual_limit           = $("input[name='virtual_limit']").val();
        var gc_id_1_name            = $("input[name='gc_id_1_name']").val();
        var gc_id_2_name            = $("input[name='gc_id_2_name']").val();
        var gc_id_3_name            = $("input[name='gc_id_3_name']").val();
        var brand_name              = $("input[name='brand_name']").val();
        var transport_title         = $("input[name='transport_title']").val();
        var store_name              = $("input[name='store_name']").val();
        var goods_freight           = $("input[name='goods_freight']").val();
        var statu = status();
       if(statu != false){
        
            if( goods_name != '' &&
                goods_jingle != '' &&
                keywords != '' &&
                goods_price != '' &&
                goods_marketprice != '' &&
                goods_promotion_price != '' &&
                goods_discount != '' &&
                goods_storage_alarm != '' &&
                goods_click != '' &&
                goods_salenum != '' &&
                goods_collect != '' &&
                goods_storage != '' &&
                deductible_point != '' &&
                goods_feng != '' &&
                payment != '' &&
                evaluation_count != '' &&
                evaluation_good_star != '' &&
                virtual_indate != '' &&
                virtual_limit != '' &&
                gc_id_1_name != '' &&
                gc_id_2_name != '' &&
                gc_id_3_name != '' &&
                brand_name != '' &&
                transport_title != '' &&
                store_name != '' &&
                goods_freight != '' ){
                $(this).parents('form').submit();
            }else{
                alert('存在未填写字段');
            }
       } else{
        alert('下拉框中存在空字段');
       }

    });

    
    //点击删除
    $(document).on('click',".del_goods",function(){
        var goods_id = $(this).attr('data');
        var str = confirm("你确定要删除这件商品？");
        if(str){
            $.ajax({
                type : "POST",
                url : "del_goods",
                data: "goods="+goods_id,
                success : function(data)
                {
                    newData = data.replace(/\r\n/g,'');
                    if(newData == 'del') {
                        layer.msg("删除成功！");
                        setTimeout("delayer()", 2000);
                    } else {
                        layer.msg("删除失败！");
                        setTimeout("delayer()", 2000);
                    }
                }
            })
        }
    });

    //点击删除
    $(document).on('click',".del_goods_form",function(){
        var str = confirm("你确定要删除这些商品？");
        var chk_value =[];
        $('input[name="del_goods[]"]:checked').each(function(){
        chk_value.push($(this).val());
        });
       if(str){
            $.ajax({
                type : "POST",
                url : "del_goods",
                data: "goods_id="+chk_value,
                success : function(data)
                {
                    newData = data.replace(/\r\n/g,'');
                    if(newData == 'del') {
                        layer.msg("删除成功！");
                        setTimeout("delayer()", 2000);
                    } else {
                        layer.msg("删除失败！");
                        setTimeout("delayer()", 2000);
                    }
                }
            })
        }
    });

    //点击下架
    $(document).on('click',".sold_off_form",function(){
        var str = confirm("你确定要下架这些商品？");
        var chk_value =[];
        $('input[name="del_goods[]"]:checked').each(function(){
        chk_value.push($(this).val());
        });
        if(str){
            $.ajax({
                type : "POST",
                url : "sold_off",
                data: "goods_id="+chk_value,
                success : function(data)
                {
                    newData = data.replace(/\r\n/g,'');
                    if(newData == 'sold') {
                        layer.msg("下架成功！");                     
                        setTimeout("delayer()", 2000);
                    } else {
                        layer.msg("下架失败！");
                        setTimeout("delayer()", 2000);      
                    }
                }
            })
        }
    });

    //点击上架
    $(document).on('click',".new_stock_form",function(){
        var str = confirm("你确定要上架这些商品？");
        var chk_value =[];
        $('input[name="del_goods[]"]:checked').each(function(){
        chk_value.push($(this).val());
        });
        if(str){
            $.ajax({
                type : "POST",
                url : "new_stock",
                data: "goods_id="+chk_value,
                success : function(data)
                {
                    newData = data.replace(/\r\n/g,'');
                    if(newData == 'new') {
                        layer.msg("上架成功！");
                        setTimeout("delayer()", 2000);
                    } else {
                        layer.msg("上架失败！");
                        setTimeout("delayer()", 2000);
                    }
                }
            })
        }
    }); 
});

    
function delayer() {
    window.location.href="goods.html";
}

