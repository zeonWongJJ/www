/**
 * Created by 7du-29 on 2017/7/13.
 */
$(function(){
   $(".seriveInfo>img").toggle(function(){
        $(".seriveList").show();
        $(".seriveInfo>img").attr("src","../img/shang.png");
   },function(){
        $(".seriveList").hide();
        $(".seriveInfo>img").attr("src","../img/xia.png");
   });

    $(".discount>div").toggle(function(){
        $(this).children("i").children("img").attr("src","../img/fuxuan3.png");
        $(this).children("i").addClass('checked');
    },function(){
        $(this).children("i").children("img").attr("src","../img/fuxuan4.png");
        $(this).children("i").removeClass('checked');
    });

    $(".otherPay>dl>dd").click(function(){
        $(this).children("b").children("img").attr("src","../img/fuxuan1.png");
        $(".otherPay>dl>dd>b>img").not($(this).children("b").children("img")).attr("src","../img/fuxuan2.png");
    })
})