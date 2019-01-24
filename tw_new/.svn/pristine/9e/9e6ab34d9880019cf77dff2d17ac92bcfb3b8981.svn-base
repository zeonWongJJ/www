/**
 * Created by 7du-29 on 2017/7/17.
 */
$(function(){
    var competitiveSelect=$(".competitiveSelect>div");
    var screening=$(".screen");
    //获取遮罩层的高度
    var zhezhaoBoxHeight=parseInt($(".orderInfo").outerHeight(true)+$(".orderBtnBox").outerHeight(true)+$(".competitiveServant>p").outerHeight(true)+$(".servantChoice").outerHeight(true))-10+"px";
    $(".zhezhaoBox").height(zhezhaoBoxHeight);
    $(".zhezhao").height(parseInt(($(".competitiveDetails").height())));

    competitiveSelect.click(function(){
        hasClass($(this));
        //点击除了自己外所有兄弟元素ul隐藏
        ($(".competitiveSelect>div").children("ul")).not($(this).children("ul")).hide();
        //($(this).children("i").children("img")).not($(".competitiveSelect>div>i>img")).attr("src","../img/shangb.png");
    })

    function hasClass(seleDiv){
        if(seleDiv.hasClass("all")) {//判断是否为对应的class
            if($(".allBox").is(":hidden")){//如果为true 再次判断是否隐藏
                $(".allBox").show(); // true 显示
                seleDiv.children("i").children("img").attr("src","../img/shangb.png");//更换图片样式
            }else{
                $(".allBox").hide();// false 隐藏
                seleDiv.children("i").children("img").attr("src","../img/xiab.png");//更换图片样式
            }
        }
        if(seleDiv.hasClass("sort")) {
            if($(".sortBox").is(":hidden")){
                $(".sortBox").show();
                seleDiv.children("i").children("img").attr("src","../img/shangb.png");
            }else{
                $(".sortBox").hide();
                seleDiv.children("i").children("img").attr("src","../img/xiab.png");
            }
        }
        if(seleDiv.hasClass("nearSertvan")) {
            if($(".nearSertvanBox").is(":hidden")){
                $(".nearSertvanBox").show();
                seleDiv.children("i").children("img").attr("src","../img/shangb.png");
            }else{
                $(".nearSertvanBox").hide();
                seleDiv.children("i").children("img").attr("src","../img/xiab.png");
            }
        }
        if(seleDiv.hasClass("screen")) {
            if($(".screenBox").is(":hidden")){
                $(".screenBox").show();
                seleDiv.children("i").children("img").attr("src","../img/shangb.png");
            }else{
                $(".screenBox").hide();
                seleDiv.children("i").children("img").attr("src","../img/xiab.png");
            }
        }
    }


    $(".competitiveSelect>div>ul>li").click(function(){
        $(this).parent().prev().prev().html($(this).html());
    })
    $(".orderInfo").not(".competitiveSelect").click(function(){
        $(".competitiveSelect>div>ul").css("display","none");
    });
    $(".competitiveList").click(function(){
        $(".competitiveSelect>div>ul").css("display","none");
    })
    $(".servantChoice").click(function(){
        $(".competitiveSelect>div>ul").css("display","none");
    })

    // 点击筛选
    screening.click(function(){
        $(".zhezhao").show();
        $(".zhezhaoBox").show();
        $(".servantChoice").show();
        $("body,html").animate({scrollTop:$(".competitiveSelect").offset().top},200)
        //$('body').css({
        //    "overflow-x":"hidden",
        //   "overflow-y":"hidden"
        //});
        $(".competitiveDetails").height(parseInt($(".zhezhao").outerHeight()));
    });

    // 只看企业
    $(".companySwitch>i").toggle(function(){
        $(this).children("img").attr("src","../img/off_03.png");
        $(this).attr("class","off");
    },function(){
        $(this).children("img").attr("src","../img/on_03.png");
        $(this).attr("class","open");
    })
    //服务者等级
    $(".servantRank>ul>li>a>span").click(function(){
        $(this).css({"color":"white","background":"#666df4"});
        $(this).addClass("choice");
        $(".servantRank>ul>li>a>span").not($(this)).css({"color":"black","background":"white"});
        $(".servantRank>ul>li>a>span").not($(this)).removeClass("choice");
    })
    //信誉
    $(".credit>a").click(function(){
        $(this).css({"color":"white","background":"#666df4"});
        $(".credit>a").not($(this)).css({"color":"black","background":"white"});
    })
    // 获取保障金的值
    $(document).on("input",".rangeMoney",function(){
        $(".rangeBox>p:first-child>span").html($(this).val()+"+");
    });
    $(document).on("input",".rangeMon",function(){
        $(".rangeBox>p:nth-child(5)>span").html($(this).val()+"个月+");
    });
    //重置
    $(".ketubbah>em").click(function(){
        $(".rangeMoney").val("0");
        $(".rangeBox>p:first-child>span").text("0+");
        $(".rangeMon").val("0");
        $(".rangeBox>p:nth-child(5)>span").text("0个月+");
    })
    // 确定
    $(".ketubbahSure").click(function(){
        $(".zhezhao").hide();
        $(".zhezhaoBox").hide();
        $(".servantChoice").hide();
        $("body,html").animate({scrollTop:0},200);
    })

    //选择 请Ta服务
    $(".contactBtn>a:nth-child(2)").click(function(){
        $(".pop").show();
        $(".zhezhao").show();
        $(".zhezhao").css("z-index","11");
    })
    $(".pop>a>span").click(function(){
        $(".pop").hide();
        $(".zhezhao").hide();
    })
    $(".pop>a>em").click(function(){
        $(".pop").hide();
        $(".zhezhao").hide();
    })
})