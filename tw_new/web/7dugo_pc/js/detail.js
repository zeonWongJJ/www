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
    //点击搜索按钮
    $('.search button').click(function(){
        var parent=$(this).parents(".search");
        var none_word=parent.children("label").children("input").attr("value");
        var left=parent.children("span").children("input").eq(0).attr("value");
        var right=parent.children("span").children("input").eq(1).attr("value");
        var store_id=$("input[name='store_id']").val();
        var word = encodeURI(none_word).replace(/\-/, "+");
        window.location.href="search-" + word + "---"+left+"-"+right+"--------"+store_id+".html";
    });


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

    //滚动显示菜单
    $(window).scroll(function () {
        var srollY = $(document).scrollTop();
        var  hight = $(".product_info_p").height()+124;

        if(srollY> hight){
            $(".product_detail_nav").addClass("fixed")
            $(".aside_bar .search h2").addClass("fixed").css({"border-bottom":"2px solid #34383b"})
            $(".product_detail_nav .price span").css("display","flex")
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
});

