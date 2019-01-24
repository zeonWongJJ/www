$(document).ready(function(){
    // 首页跳到金芷
    $('.indexbtn').click(function(){
        window.location.href = "good_details-933.html";
    });

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

    $(".icon-use").mouseover(function () {
        $(".setting").removeClass("dn");
    });
    $(".setting").mouseleave(function () {
        $(".setting").addClass("dn");
    });

    //点击或者回车提交数据到搜索页面(个人中心的搜索)
    // $('.searchca .iconfont').click(function(){
    //     var val = $('.searchca input').val();
    //     var value = encodeURI(val).replace(/\-/, "+");
    //     window.location.href=main_domain+"/search-" + value + "-0-0-0-0-0-0-0-0-0-0-0-0-.html";
    // });

    // $('.searchca input').keydown(function(e){
    //     if(e.keyCode==13){
    //     var val = $('.searchca input').val();
    //         var value = encodeURI(val).replace(/\-/, "+");
    //         window.location.href="search-" + value + "-0-0-0-0-0-0-0-0-0-0-0-0-.html";
    //     }
    // });

    //点击或者回车提交数据到搜索页面(分类下面的搜索)
    $('.searchcate .iconfont').click(function(){
        var val = $(this).siblings("input").val();
        var value = encodeURI(val).replace(/\-/, "+");
  
         jump(value);
    });

    $('.searchcate input').keydown(function(e){

        if(e.keyCode==13){
        var val = $(this).val();
        var value = encodeURI(val).replace(/\-/, "+");
         jump(value);
        }
    });

    (function() {
            if (!
                            /*@cc_on!@*/
                    0) return;
            var e = "abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');
            var i= e.length;
            while (i--){
                document.createElement(e[i])
            }
        })();
    $(".login_info").hover(
        function () {
            $(this).find("div").removeClass("dn");
        },
        function () {
            $(this).find("div").addClass("dn");
        }
    );

    $(".menu_login .showInput").click(function(){
        var val = $(this).siblings("div").find("input").val();
        var value = encodeURI(val).replace(/\-/, "+");
        jump(value);
    });

    function jump(value){
        window.location.href=main_domain+"/search-" + value + "-0-0-0-0-0-0-0-0-0-0-0-0-.html";
    }
});