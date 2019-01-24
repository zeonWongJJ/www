/**
 * Created by 7du-29 on 2017/12/7.
 */
$(function(){
    // 已占用的座位
    seat_occupy();
    $(".sureSeat").attr("disabled",true);
    $(".sureSeat").css("background","#cccccc");
    $(".seat li.su").click(function(){
        $(this).not(".have").addClass("choice");
        $(".choice").children("img").attr("src","/static/style_default/images/seat_07.png");
        $(".seat li.su").not($(this),".have").removeClass("choice");
        $(".seat li.su").not($(".choice,.have")).children("img").attr("src","/static/style_default/images/seat_03.png");
        $(".sureSeat").attr("disabled",false);
        $(".sureSeat").css("background","#ff7f00");
        // $(".bottom>dl>dd>span").html(($(this).parent().parent().index())+"排"+($(this).index()+1)+"座");
        // console.log(($(this).parent().parent().index())+"排"+($(this).index()+1)+"座");
        $(".bottom>dl>dd>span").html($(this).attr('seatname'));
        $("input[name='office_seatname']").val($(this).attr('seatname'));
        $("input[name='office_seat']").val($(this).attr('office_seat'));
    });
    //已售出的座位
    $(".seat li.have").click(function(){
        $(".tips").stop().show(100).delay(3000).hide(100);
        $(".tips").html("该座位已售出，请选择其他座位！");
        $(".sureSeat").attr("disabled",true);
        $(".sureSeat").css("background","#cccccc");
    });
    //清除座位
    $(".clearSeat").click(function(){
        $(".seat li").removeClass("choice");
        $(".seat li.su>img").not( $(".seat li.have>img")).attr("src","/static/style_default/images/seat_03.png");
        $(this).prev().html("请选择座位");
        $(".sureSeat").attr("disabled",true);
        $(".sureSeat").css("background","#cccccc");
        $("input[name='office_seatname']").val('');
        $("input[name='office_seat']").val('');
    });
});














