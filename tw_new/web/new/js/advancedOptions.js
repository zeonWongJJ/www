/**
 * Created by 7du-29 on 2017/7/31.
 */
$(function(){
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
})












