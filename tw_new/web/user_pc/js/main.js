$(document).ready(function(){
    $(".logo").toggle(
        function(){
            $(".menu").show();
            $(".logo>.icon-nav").css("transform","rotate(45deg)");
        },
        function(){
            $(".menu").hide();
            $(".logo>.icon-nav").css("transform","rotate(0deg)");
        }
    );


    $(".section").click(function(){
        $(".menu").hide();
        $(".logo>.icon-nav").css("transform","rotate(0deg)");
    });


    $(".menu>ul>li").hover(
        function () {
            $(this).addClass("active");
            $(this).find(".menu_sub_content").removeClass("dn");
        },
        function () {
            $(this).removeClass("active");
            $(this).find(".menu_sub_content").addClass("dn");
        }
    );

    $(".user_setting").mouseover(function () {
        $(this).find("div").removeClass("dn");
    });
    $(".user_setting").mouseleave(function () {
        $(this).find("div").addClass("dn");
    });



    $(".selector_0").find("ul").find("li").on("click",function(){
            $(this).addClass("active").siblings().removeClass("active");
            $(".selector").find("header").find("div").find("span:nth-of-type(3)").text($(this).text())
    });
    $(".selector_1").find("ul").find("li").on("click",function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(".selector").find("header").find("div").find("span:nth-of-type(5)").text($(this).text())
    });
    $(".classify_bar").find("ul").find("li").on("click",function(){
        $(this).addClass("active").siblings().removeClass("active");
    });

    $(".classify_item").hover(
        function(){
            $(this).find("footer").removeClass("dn").siblings(".classify_item>footer").addClass("dn");
        },
        function(){
            $(this).find("footer").addClass("dn").siblings(".classify_item>footer").addClass("dn");
        }
    );

    $(".classify_bar_box").find(".input").find("div").find("input").focus(function () {
        $(".classify_bar_box").css({"border":"1px solid #cccccc","background":"#ffffff"});
        $(".classify_bar_box").find(".btn").css("opacity","1");
    });
    //去除输入价格
    $(".classify_bar_box>.btn span:first-child").on("click",function (){
        $(this).parent().prev().find("div:first-child").find("input").val("");
        $(this).parent().prev().find("div:last-child").find("input").val("");
        $(this).parent().prev().find("div:last-child").css("border","1px solid #cccccc");
        $(".classify_bar_box").css({"border":"1px solid transparent","background":"none"});
        $(".classify_bar_box .btn").css("opacity","0");

    });
    //确定输入价格
    $(".classify_bar_box>.btn span:last-child").on("click",function (){
        var value1 = parseInt($(this).parent().prev().find("div:first-child").find("input").val());
        var value2 = parseInt($(this).parent().prev().find("div:last-child").find("input").val());
        if (value1 >= value2){
            $(this).parent().prev().find("div:last-child").css("border","1px solid #d7000f")
        }else {
            $(this).parent().prev().find("div:last-child").css("border","1px solid #cccccc")
            $(".classify_bar_box").css({"border":"1px solid transparent","background":"none"});
            $(".classify_bar_box .btn").css("opacity","0");
        }
    });
    $(".product_info_pr .package ul li").hover(
        function () {
            $(this).addClass("active");
            $(this).find(".package_item").removeClass("dn");
        },
        function () {
            $(this).removeClass("active");
            $(this).find(".package_item").addClass("dn");
        }
    );
    $(".product_detail_nav").find("ul").find("li").on("click",function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(".product_detail .content .content_item").eq($(this).index()).removeClass("dn").siblings(".product_detail .content .content_item").addClass("dn");
    });

    $(".aside_bar .classify ul li h3").toggle(
        function(){
            $(this).next().removeClass("dn")
            $(this).find("i").css("transform","rotate(45deg)");
        },
        function(){
            $(this).next().addClass("dn")
            $(this).find("i").css("transform","rotate(0deg)");
        }
    );


    $(".product_info_pl div div ul li").hover(function(){
        $(this).addClass("active").siblings().removeClass("active")
        $(".product_info_pl >span").css("background-image",$(this).css("background-image"))
    });

    //图片选择
    //上
    $(".product_info_pl div a:first-child").on("click",function () {
        var top =parseInt($(this).next().find("ul").css("top"))
        var n =$(this).next().find("ul").children().length;
        if(top>-(n-4)*100){
            top = top - 100;
        }else{
            top = -(n-4)*100
        }
        $(".product_info_pl div div ul").css("top",top+"px");
    });
    //下
    $(".product_info_pl div a:last-child").on("click",function () {
        var top =parseInt($(this).prev().find("ul").css("top"));
        if(top<0){
            top = top + 100;
        }else {
            top = 0
        }
        $(".product_info_pl div div ul").css("top",top+"px")
    })

    //购买数量
    //减
    $(".product_info_pr .btn div button:first-child").on("click",function () {
        var oldValue=parseInt($(this).next().find("input").val());
        if (oldValue>1){
            oldValue--
        }else {
            oldValue = 1
        }
        $(this).next().find("input").val(oldValue);
    });
    $(".product_info_pr .btn div button:last-child").on("click",function () {
        var oldValue=parseInt($(this).prev().find("input").val());
        oldValue++;
        $(this).prev().find("input").val(oldValue);
    });

    $(".product_info>header>div>ul>li:first-child").hover(
        function () {
            $(this).find(".score_detail").removeClass("dn");
        },
        function () {
            $(this).find(".score_detail").addClass("dn");
        }
    );

    $(".user_m").mouseover(function () {
        $(this).find("div").removeClass("dn");
    });
    $(".user_m").mouseleave(function () {
        $(this).find("div").addClass("dn");
    });
    //分享
    $(".product_info_pr .btn ul").on("click",function () {
        if($(this).hasClass("active")){
            $(this).removeClass("active");
        }else{
            $(this).addClass("active");
        }
    });
    //滚动显示菜单
    $(window).scroll(function () {
        var srollY = $(document).scrollTop();
        var  hight = $(".product_info_p").height()+124;

        if(srollY> hight){
            $(".product_detail_nav").addClass("fixed")
            $(".aside_bar .search h2").addClass("fixed").css({"border-bottom":"2px solid #34383b"})
            $(".product_detail_nav .price span").css("display","block")
        }else {
            $(".product_detail_nav").removeClass("fixed")
            $(".aside_bar .search h2").removeClass("fixed").css({"border-bottom":"none"})
            $(".product_detail_nav .price span").css({"display":"none",})
        }
    })

    //手机购买hover事件
    $(".product_detail_nav>div>h2").mouseover(function () {
        $(".phone_buy").removeClass("dn");
    });
    $(".phone_buy").mouseleave(function () {
        $(".phone_buy").addClass("dn");
    });

    //返回顶部
    $(".returnTop").click(function () {
        var speed=200;
        $('body,html').animate({ scrollTop: 0 }, speed);
        return false;
    });

    //评论点击图片
    $(".evaluation_item .cont .user_e div .img").on("click",function () {
        $(this).parent().next(".pic_show").css("display","block");
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().next(".pic_show").css("background-image",$(this).css("background-image"));
        var index = $(this).index();
        var length = $(this).parent().children().length;
        if(index == 0){
            $(this).parent().next().find(".cursor_prev").css("display","none");
            $(this).parent().next().find(".cursor_next").css("display","flex");
        }else if(index == length-1){
            $(this).parent().next().find(".cursor_prev").css("display","flex");
            $(this).parent().next().find(".cursor_next").css("display","none");
        }else {
            $(this).parent().next().find(".cursor_next").css("display","flex");
            $(this).parent().next().find(".cursor_prev").css("display","flex");
        }
    });
    $(".cursor_small").on("click",function () {
        $(this).parent().css("display","none");
        $(this).parent().prev().find(".active").removeClass("active");

    });
    $(".cursor_prev").on("click",function (){
        var n = $(this).parent().prev().find(".active").index();
        if(n>1){
            $(this).parent().prev().find("a").eq(n-1).addClass("active").siblings().removeClass("active");
            $(this).next().css("display","flex");
        }else if (n == 1){
            $(this).parent().prev().find("a").eq(n-1).addClass("active").siblings().removeClass("active");
            $(this).css("display","none");
        }
        $(this).parent().css("background-image",$(this).parent().prev().find("a").eq(n-1).css("background-image"))
    })

    $(".cursor_next").on("click",function (){
        var n = $(this).parent().prev().find(".active").index();
        var length = $(this).parent().prev().children().length;
        if(n<length-2){
            $(this).parent().prev().find("a").eq(n+1).addClass("active").siblings().removeClass("active");
            $(this).prev().css("display","flex");
        }else if(n == length-2) {
            $(this).parent().prev().find("a").eq(n+1).addClass("active").siblings().removeClass("active");
            $(this).css("display","none");
        }
        $(this).parent().css("background-image",$(this).parent().prev().find("a").eq(n+1).css("background-image"))
    })


    $(".classify_bar form a").on("click",function (){
        $(this).find("span").css("opacity","1")
    })

    /***订单结算***/
    //付款方式
    // $(".payment>ul>li>a").on("click",function(){
    //     $(this).parent().addClass("active").siblings(".payment>ul>li").removeClass("active");
    //     $(".payment_item").addClass("dn")
    //     $(this).parent().find(".payment_item").removeClass("dn");
    //      alert("2");

    // });
    //点击支付宝按钮
    $(".payment .payment_item>").find("li").on("click",function(){
        //支付宝同级的选中取消
        $(this).addClass("active").siblings().removeClass("active");
        //余额的选中取消
        $(".payment_item").find("div:eq(0)").find("i").removeClass("active");
        //货到付款按钮选中取消
        $(".more_info").find("em").css("opacity","0");
        $("form input[name=pay_type]").attr('value',$(this).attr("data-type"));

    });

    $(".payment .more_info>p").on("click",function(){
        var op = $(this).find("em").css("opacity")
        if(op*1 == 1){
            $(this).find("em").css("opacity","0");
        }else{
            $(this).find("em").css("opacity","1");
        }
    });
    $(".payment .more_info>div").find("label").on("click",function(){
        var op = $(this).find("em").css("opacity")
        if(op*1 == 1){
            $(this).next().next().addClass("dn")
            $(this).find("em").css("opacity","0");
        }else{
            $(this).next().next().removeClass("dn")
            $(this).find("em").css("opacity","1");
        }
    });
    //添加地址
    $(".consignee>div button:last-child").on("click",function(){
        $("#box").removeClass("dn");
        $(".add_address_box").removeClass("dn");
        $(".add_address_box").find("ul").prev().text("新增收货地址");
    });
    $(".add_address").on("click",function(){
        $("#box").removeClass("dn");
        $(".add_address_box").removeClass("dn");
        $(".add_address_box").find("ul").prev().text("新增收货地址");
    });
    $(".close_box").on("click",function(){
        $("#box").addClass("dn");
        $("#box >div").each(function () {
            $(this).addClass("dn")
        })
    });

    //设置默认地址
    $(".consignee .address_item").on("click",function(){
        $(".consignee").find("label").css("opacity","0");
        $(this).find("label").css("opacity","1");
    });

    //删除地址
    // $(".icon-shanchu").on("click",function(){
    //     $("#box").removeClass("dn");
    //     $(".message_box").removeClass("dn");
    // });
    //显示全部地址
    $(".consignee>div button:first-child").on("click",function(){
        var length = $(".consignee").find("ul").children().length;
        if($(this).text() =="收起收货人地址" ){
            $(this).text( "显示全部收货人地址");
            $(this).parent().prev().find("li").each(function () {
                $(this).addClass("dn")
            });
            $(this).parents(".consignee").find("ul").find("li:nth-child(1)").removeClass("dn")
            $(this).parents(".consignee").find("ul").find("li:nth-child(2)").removeClass("dn")
            $(this).parents(".consignee").find("ul").find("li:nth-child(3)").removeClass("dn")
            $(this).parents(".consignee").find("li:last-child").removeClass("dn")
            $(".consignee ul").css({"height":"150px"});
        }else{
            $(".consignee ul").animate({"height":Math.ceil(length/4)*150+"px"});
            $(this).text( "收起收货人地址");
            $(this).parent().prev().find("li").each(function () {
                $(this).removeClass("dn")
            });
        }
    });

    //新增地址信息
    $(".add_address_box").find("input").blur(function () {
        $(this).next().removeClass("dn")
        if(!$(this).val()){
            $(this).next().find("i").addClass("empty")
            $(this).next().find("i").removeClass("pass")
            $(this).next().find("span").removeClass("dn")
        }else{
            $(this).next().find("i").removeClass("empty")
            $(this).next().find("i").addClass("pass")
            $(this).next().find("span").addClass("dn")
        }
    })
    //编辑地址
    $("#order").find(".icon-bianji").on("click",function(){
        $("#box").removeClass("dn");
        $(".add_address_box").removeClass("dn");
        $(".add_address_box").find("ul").prev().text("编辑收货地址");
    });
    /***购物车***/
    function handleCheck() {
        var pro = $("#shoppingCart").find(".check_pro");
        var tp = 0; //总价钱
        var tn = 0; //总数量
        var td = 0; //总优惠
        for(var i = 0;i<pro.length; i++){
            if($(pro[i]).find("label").hasClass("checked")){
                var pri = $(pro[i]).parents(".order_item").find(".price").find("label").text();
                var num = $(pro[i]).parents(".order_item").find(".btn").find("input").val();
                var discount = $(pro[i]).find("label").attr("data");
                tp = tp + pri*num;
                tn++;
                td = td + discount*num;
            }
        }
        $(".shoppingCart_info").find(".total_discount").text("￥"+td);
        $(".shoppingCart_info").find(".total_price").find("label").text(tp);
        $(".shoppingCart_info").find(".total_num").text(tn);
    }

    //加载运行
    $(function(){
        var list = $(".store_item");
        var  n = $(".store_list").children().length;
        for(var i=0;i<n;i++){
            var sum = 0;
            $(list[i]).find(".amount").find("label").each(function () {
                sum = sum + parseInt($(this).text());
            });
            $(list[i]).find(".header_r").find("label").text(sum);
        }
    });
    //删除
    $("#shoppingCart").find(".icon-shanchu").on("click",function(){
        $("#box").removeClass("dn");
        $(".message_box").removeClass("dn");
    });
    $("#shoppingCart").find(".message_box").find(".btn button:last-child").on("click",function(){
        $("#box").addClass("dn");
        $(".message_box").addClass("dn");
    });
    //收藏
    $(".order_item").find(".edit").find("i:last-child").on("click",function(){
        if($(this).hasClass("icon-shoucang1")){
            $(this).addClass("icon-shoucang");
            $(this).removeClass("icon-shoucang1");
        }else{
            $(this).addClass("icon-shoucang1");
            $(this).removeClass("icon-shoucang");
        }

    });
    //全选
    $(".check_all").on("click",function(){
        var sum = 0;
        var p = $(this).parents(".shoppingCart_info")
        if($(".check_all").find("label").hasClass("checked")){
            $(".check_all").find("label").removeClass("checked")
            $(".shoppingCart_info .store_list .checkbox").each(function () {
                $(this).find("label").removeClass("checked")
            })
        }else{
            $(".check_all").find("label").addClass("checked")
            $(".shoppingCart_info .store_list .checkbox").each(function () {
                $(this).find("label").addClass("checked")
            });
            p.find(".store_item .header_r label").each(function () {
                sum = sum + parseInt($(this).text());
            });
        }
        handleCheck()
    });

    //选择商店
    $(".check_store").on("click",function(){
        if($(this).find("label").hasClass("checked")){
            $(this).find("label").removeClass("checked")
            $(this).parents(".store_item").find(".checkbox").each(function () {
                $(this).find("label").removeClass("checked")
            })
        }else{
            $(this).find("label").addClass("checked")
            $(this).parents(".store_item").find(".checkbox").each(function () {
                $(this).find("label").addClass("checked")
            })
        }
        handleCheck()
    });
    //选择产品
    $(".check_pro").on("click",function(){
        if($(this).find("label").hasClass("checked")){
            $(this).find("label").removeClass("checked")
        }else{
            $(this).find("label").addClass("checked")
        }
        var n = $(this).parents(".store_item").find("section").children().length
        var x =0;
        for(var i=0;i<n;i++){
            var list = $(this).parents(".store_item").find(".check_pro").find("label")
            if($(list[i]).hasClass("checked")){
                x = x + 1
            }
        }
        if(x == n){
            $(this).parents(".store_item").find(".check_store").find("label").addClass("checked")
        }else {
            $(this).parents(".store_item").find(".check_store").find("label").removeClass("checked")
        }
        handleCheck()
    });

    //购物车滚动显示
    $(window).scroll(function () {
        var srollY = $(document).scrollTop();
        var windowH = $(window).height();
        var  hight = $(".shoppingCart_info>section").height()+264 - windowH;
        if(srollY >= hight){
            $(".shoppingCart_info>footer").css("position","static")
        }else{
            $(".shoppingCart_info>footer").css("position","fixed")
        }
    })
    $(".pay_bar_r>div>div>div").hover(
        function () {
           $(this).find("div").removeClass("dn")
        },
        function () {
            $(this).find("div").addClass("dn")
        }
    );
    //编辑数量
    $(".order_item .btn span:first-child").on("click",function () {
        var price = $(this).parent().prev().find("label").text();
        var oldValue = parseInt($(this).next().val());
        var sum = 0;
        if (oldValue>1){
            oldValue--;
            allPrice = price*oldValue;
            $(this).parent().next().find("label").text(allPrice)
            $(this).parent().parent().parent().find(".amount").find("label").each(function () {
                sum = sum + parseInt($(this).text());
            });
            $(this).parent().parent().parent().prev().find(".header_r").find("label").text(sum);
        }else {
            oldValue = 1;
            $(this).parent().next().find("label").text(price)
            $(this).parent().parent().parent().find(".amount").find("label").each(function () {
                sum = sum + parseInt($(this).text());
            });
            $(this).parent().parent().parent().prev().find(".header_r").find("label").text(sum);
        }
        $(this).next().val(oldValue);
        if($(this).parents(".order_item").find(".checkbox").find("label").hasClass("checked")){
            handleCheck()
        }
    });

    $(".order_item .btn span:last-child").on("click",function () {
        var price = $(this).parent().prev().find("label").text();
        var oldValue=parseInt($(this).prev().val());
        var sum = 0;
        oldValue++;
        $(this).prev().val(oldValue);
        $(this).parent().next().find("label").text(price*oldValue)
        $(this).parent().parent().parent().find(".amount").find("label").each(function () {
            sum = sum + parseInt($(this).text());
        });
        $(this).parents(".store_item").find(".header_r").find("label").text(sum);
        if($(this).parents(".order_item").find(".checkbox").find("label").hasClass("checked")){
            handleCheck()
        }
    });
    //移除
    $(".delete_checked").on("click",function(){
        $(this).parents("#shoppingCart").find("#box").removeClass("dn");
        $(this).parents("#shoppingCart").find("#box").find(".message_box").removeClass("dn");
        $(this).parents("#shoppingCart").find("#box").find(".message_box").find("p").text("*确定要移除选中的商品吗？")
    });

    //热卖左右切换
    $(".hot_sale .prev").on("click",function () {
        var left =parseInt($(this).prev().find("ul").css("left"));
        var n =$(this).prev().find("ul").children().length;
        if(left>-(n-5)*210){
            left = left - 210;
        }else{
            left = -(n-5)*210
        }
        $(".hot_sale .list ul").css("left",left+"px");
    });

    $(".hot_sale .next").on("click",function () {
        var left =parseInt($(this).prev().prev().find("ul").css("left"));
        var n =$(this).prev().find("ul").children().length;
        if(left < 0){
            left = left + 210;
        }else {
            left = 0
        }
        $(".hot_sale .list ul").css("left",left+"px");
    })


    /***用户中心***/
    //菜单hover
    // $("#user_sidebar").find("li").hover(
    //     function () {
    //         $(this).find("a").css("background","#f7f7f7");
    //         $(this).find("span").css("color","#1fbba6");
    //         $(this).find(".img").css("background-position-x","0");
    //     },
    //     function () {
    //         if(!$(this).hasClass("active")){
    //             $(this).find("a").css("background","#1fbba6");
    //             $(this).find("span").css("color","#ffffff");
    //             $(this).find(".img").css("background-position-x","-61px");
    //         }else{
    //             $(this).find("a").css("background","#f7f7f7");
    //             $(this).find("span").css("color","#1fbba6");
    //             $(this).find(".img").css("background-position-x","0");
    //         }
    //     }
    // )
    // //滚动event
    // $(window).scroll(function () {
    //     var srollY = $(document).scrollTop();
    //     var windowH = $(window).height();
    //     var  hight = $("#user_sidebar").height()+80 - windowH;
    //     if(srollY > hight){
    //         $("#user_sidebar").css("position","fixed")
    //     }else{
    //
    //     }
    // })

});

