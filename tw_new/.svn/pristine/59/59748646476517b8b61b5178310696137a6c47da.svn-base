$(document).ready(function(){
    // 分类样式
    $('.paging a').each(function(i){
        var str = '<b>';
        var num = $(this).html();
        if(num.indexOf(str)!=-1){
            $(this).addClass('active');
        }
    });

    $('.thrid ul li').each(function(i){
        var header = $(this).attr('class');
        if(header.indexOf('active') >= 0){
            var res = $(this).text();
            $('.header_thrid').text(res);
        }
    });

    //列表页获取到二级导航位置改变面包屑
    $('.selector_0 ul li').each(function(i){
        var head = $(this).attr('class');
        if(head == 'active'){
            var res = $(this).text();
            $('.header_second').text(res);
        }
    });
    
    /********购物车页面*********/
    // 点击提交按钮提交表单
    $('.submit').click(function(){
        var str = 'checked';
        $('.check_del').each(function(i){
            res = $(this).attr('class');
            if(res.indexOf(str) == -1){
                $(this).children('input').remove();
            }
        });
        $('.delgoods').remove();
        $("form").submit();
    });

    //删除
    $("#shoppingCart").find(".icon-shanchu").on("click",function(){
        $("#box").removeClass("dn");
        $(".message_box").removeClass("dn");
        var checkgood = $(this).parents('.order_item').find('.checkgood').val();
        $('.delshop').click(function(){
            window.location.href="shop-" + checkgood + "-.html";
        });
    });

    // 点击删除选中购物车按钮
    $('.del_good').click(function(){
        $(this).parents("#shoppingCart").find("#box").removeClass("dn");
        $(this).parents("#shoppingCart").find("#box").find(".message_box").removeClass("dn");
        $(this).parents("#shoppingCart").find("#box").find(".message_box").find("p").text("*确定要移除选中的商品吗？");
        $('.delshop').click(function(){
            var checkgood = '';
            $('.checked').each(function(i){
                checkgoods = $(this).parents('.order_item').find('.checkgood').val();
                if(checkgoods != undefined){
                    checkgood += checkgoods + ',';
                }
            });
            checkgood=checkgood.substring(0,checkgood.length-1);
            window.location.href="shop-" + checkgood + "-.html";
        });
    });

    //结算页面默认地址
    $('.toaddress').text($('.consignee .active .moaddres').text());
    $('.addname').text($('.consignee .active .moname').text());
    $('.tel').text($('.consignee .active .motel').text());

    //结算页面点击支付方式
    $('.balance').click(function(){
        $(this).find('li').addClass('active');
        $('.payondelivery').find('li').removeClass('active');
        $('.payterrace').find('li').removeClass('active');
        $('.paytyp').text('余额支付');
        $('.paytype').val('1');
    });
    $('.payondelivery').click(function(){
        $(this).find('li').addClass('active');
        $('.balance').find('li').removeClass('active');
        $('.payterrace').find('li').removeClass('active');
        $('.paytyp').text('货到付款');
        $('.paytype').val('2');
    });
    $('.payterrace').click(function(){
        $(this).find('li').addClass('active');
        $('.balance').find('li').removeClass('active');
        $('.payondelivery').find('li').removeClass('active');
        $('.paytyp').text('支付平台(支付宝)');
        $('.paytype').val('3');
    });

    //结算页面设置积分
    var total = parseInt($('.total').text());
    $('#integral').change(function(){
        integral = $(this).val();
        var data = integral-integral%100;
        $(this).val(data);
        var usable = parseFloat($('#usable').text());
        if(usable < data){
            alert('你的积分不足');
            $(this).val(0);
            $('.total').text(total);
        }else{
            $('#money').text(data*0.01);
            var money = parseInt($('#money').text());
            $('.total').text(total - money);
        }
    });

    // 结算页面提交订单
    $('.affirmpay').click(function(){
        $(this).parents("form").submit();
    });

    /*结算页面添加页面地址
    */
    //设置默认地址
    $(document).on('click',".address_item",function(){
        var addressid = $(this).parents('.address').attr('data');
        $.ajax({
            type : "POST",
            url : "billaddress",
            data: "address="+addressid,
            dataType : "json",
            success : function(data)
            {
                $('.toaddress').text(data[0]);
                $('.addname').text(data[1]);
                $('.tel').text(data[2]);
            }
        });
    });

    //是否为手机
    function is_mobile(string) {
        var pattern = /^1[34578]\d{9}$/;
        if (pattern.test(string)) {
            return true;
        }else{
            return false;
        }
    };
    
    // 点击第第一个出现第二个select
    $('#area_top').change(function(){
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
                            str +=  "<select name='' id='area_city'>";
                            str +=  "<option>请选择</option>";
                            for (var i = 0; i < json.length; i++) {
                                str += "<option value='" + json[i].area_id + "'>" + json[i].area_name + "</option>";
                            }
                            str += "</select>";

                        if ($('#area_city') == undefined){
                            $('#area_top').after(str);
                        } else if(area_top == false){
                            $('#area_city').remove();
                            $('#area_town').remove();
                        } else{
                            $('#area_city').remove();
                            $('#area_town').remove();
                            $('#area_top').after(str);
                        }
                    }
                }
            });
    });
    
    //三级联动第二级城市
    $(document).on('change',"#area_city",function(){
        var area_city = $(this).val();
        $.ajax({
                type : "POST",
                url : "area",
                data: "area="+area_city,
                success :function(msg)
                {
                    if(msg!=''){  
                        var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                        var str = "";
                            str +=  "<select name='' id='area_town'>";
                            str +=  "<option value=''>请选择</option>";
                            for (var i = 0; i < json.length; i++) {
                                str += "<option value='" + json[i].area_id + "'>" + json[i].area_name + "</option>";
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
                        });
                    }
                }
            });
    });

    // 添加收货地址
    $(document).on('click',".addressarea",function(){
        var receving  = $('.receving').val();
        var area_top  = parseInt($('#area_top').val());
        var area_city = parseInt($('#area_city').val());
        var area_town = parseInt($('#area_town').val());
        var detailed  = $('#detailed').val();
        var phone     = $('#phone').val();
        var tel       = $('#tel').val();
        if(receving == false){
            alert('收货人不能为空');
        } else {
            if(isNaN(area_top) || isNaN(area_city) || isNaN(area_town) ){
                alert('所在地区不能为空');
            } else {
                if(detailed == false){
                    alert('详细地址不能为空');
                } else {
                    if(is_mobile(phone)){
                        $.ajax({
                            type : "POST",
                            url : "addarea",
                            data: "receving=" + receving + "&area_top=" + area_top + "&area_city=" + area_city +
                                  "&area_town=" + area_town + "&detailed=" + detailed + "&phone=" + phone + "&tel=" + tel,
                            success :function(msg)
                            {
                                if (msg != 0){
                                    alert('添加地址成功');
                                    $('.add_address_box').addClass('dn');
                                    $('#box').addClass('dn');
                                    var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                                    var str = "<li data="+ json.address_id + " class='address'><a><div class='address_item'><h4 class='moname'>" +
                                                json.true_name + "</h4><p class='moaddres'>" + json.area_info + " " + json.address + " </p><span class='motel'>"+json.mob_phone;
                                        str += "</span><label></label></div><div class='edit'><i class='iconfont icon-bianji'></i><i class='iconfont icon-shanchu'></i></div></a></li>";
                                    $(".address_ul").find("li:eq(0)").before(str);
                                } else {
                                    alert('添加地址失败请重新添加');
                                }
                            }
                        });
                    }else{
                        alert('手机号码格式不正确');
                    }
                }
            }
        }
    });    

    //删除地址
    $(document).on('click',".icon-shanchu",function(){
        var address = $(this).parents('.address');
        var addressid = address.attr('data');
        $('#box').removeClass('dn');
        $('.message_box').removeClass('dn');
        $(document).on('click',".abolish",function(){
            $('#box').addClass('dn');
            $('.message_box').addClass('dn');
        });
        $(".affirm").unbind("click").click(function(){
            $.ajax({
                type : "POST",
                url : "del_address",
                data: "del_address="+addressid,
                dataType : "json",
                success : function(data)
                {
                    if(data){
                        address.remove();
                        $('#box').addClass('dn');
                        $('.message_box').addClass('dn');
                        alert('删除成功');
                    }else{
                        $('#box').addClass('dn');
                        $('.message_box').addClass('dn');
                        alert('删除失败');
                    }
                }
            });
            
        });
    });

    // 修改地址
    $(document).on('click',".icon-bianji",function(){
        var address     = $(this).parents('.address');
        var addressid   = address.attr('data');
        $("#alterh").val(addressid);
        $("#alter").prop("class","bianji");
        $.ajax({
            type : "POST",
            url : "update_address",
            data: "update_address="+addressid,
            dataType : "json",
            success : function(msg)
            {

                if(msg != ''){
                    $('.add_address_box').find('.addh2').text('修改收货地址');
                    $('.add_address_box').find('.receving').val(msg['true_name']);
                    $('.add_address_box').find('#detailed').val(msg['address']);
                    $('.add_address_box').find('#phone').val(msg['mob_phone']);
                    $('.add_address_box').find('#tel').val(msg['tel_phone']);
                    $('#area_city').remove();
                    $('#area_town').remove();
                    var str = "";
                        str +=  "<select name='' id='area_city'>";
                        str +=  "<option value=''>请选择</option>";
                        for (var i = 0; i < msg['city_sum'].length; i++) {
                            if(msg['city_sum'][i]['area_id'] == msg['city_id']){
                                var selected = "selected";
                            }else{
                                var selected = "";
                            }
                            str += "<option value='" + msg['city_sum'][i].area_id + "'" + selected +  ">" + msg['city_sum'][i].area_name + "</option>";
                        }
                        str += "</select>";
                    $('#area_top').after(str);

                    var res = "";
                        res +=  "<select name='' id='area_town'>";
                        res +=  "<option value=''>请选择</option>";
                        for (var i = 0; i < msg['county_sum'].length; i++) {
                            if(msg['county_sum'][i]['area_id'] == msg['area_id']){
                                var selected = "selected";
                            } else {
                                var selected = "";
                            }
                            res += "<option value='" + msg['county_sum'][i].area_id + "'" + selected +  ">" + msg['county_sum'][i].area_name + "</option>";
                        }
                        res += "</select>";

                    $('#area_city').after(res);  

                    $('#area_top').val(msg['province_id']);
                    $('#box').removeClass('dn');
                    $('.add_address_box').removeClass('dn');

                }
            }
        });
    });

    // 添加收货地址
    $(document).on('click',".bianji",function(){
        var receving  = $('.receving').val();
        var area_top  = parseInt($('#area_top').val());
        var area_city = parseInt($('#area_city').val());
        var area_town = parseInt($('#area_town').val());
        var detailed  = $('#detailed').val();
        var phone     = $('#phone').val();
        var tel       = $('#tel').val();
        var alterh = $("#alterh").val();
        if(receving == false){
            alert('收货人不能为空');
        } else {
            if(isNaN(area_top) || isNaN(area_city) || isNaN(area_town) ){
                alert('所在地区不能为空');
            } else {
                if(detailed == false){
                    alert('详细地址不能为空');
                } else {
                    if(is_mobile(phone)){
                        $.ajax({
                            type : "POST",
                            url : "alter_address",
                            data: "receving=" + receving + "&area_top=" + area_top + "&area_city=" + area_city +
                                  "&area_town=" + area_town + "&detailed=" + detailed + "&phone=" + phone + "&tel=" + tel + "&alterh=" + alterh,
                            success :function(msg)
                            {
                                if (msg != 0){
                                    alert('修改地址成功');
                                    $('.add_address_box').addClass('dn');
                                    $('#box').addClass('dn');

                                    $("li[data="+alterh+"]").remove();
                                    var json = eval('(' + msg + ')');   //将返回的json数据进行解析，并赋给data
                                    if(json.is_default == 1){
                                        is_default = "style='opacity: 1;'";
                                    }else{
                                        is_default = "style='opacity: 0;'";
                                    }
                                    var str = "<li data="+ json.address_id + " class='address'><a><div class='address_item'><h4 class='moname'>" +
                                                json.true_name + "</h4><p class='moaddres'>" + json.area_info + " " + json.address + " </p><span class='motel'>"+json.mob_phone;
                                        str += "</span><label " + is_default + "></label></div><div class='edit'><i class='iconfont icon-bianji'></i><i class='iconfont icon-shanchu'></i></div></a></li>";
                                    $(".address_ul").find("li:eq(0)").before(str);
                                } else {
                                    alert('没有信息被修改');
                                }
                            }
                        });
                    }else{
                        alert('手机号码格式不正确');
                    }
                }
            }
        }
    });    

});