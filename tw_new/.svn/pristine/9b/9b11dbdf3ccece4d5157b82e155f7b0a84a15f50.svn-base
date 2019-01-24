/**
 * Created by 7du-29 on 2017/12/6.
 */
$(function(){
    $(".leaveSeat").hide();
    $(".choiceSeatTime").hide();
    $(".lay").hide();
    $("#nextStep").attr("disabled",true);
    var now=new Date();
    var day=now.getDay();

    switch(day)
    {
    case 1:
      day = '一'
      break;
    case 2:
      day = '二'
      break;
    case 3:
      day = '三'
      break;
    case 4:
      day = '四'
      break;
    case 5:
      day = '五'
      break;
    case 6:
      day = '六'
      break;
    default:
      day = '天'
    }

    $(".date").html("今天(周"+day+")");

    $(".choiceTimeA,.choiceTimeB").click(function(){
        $(".lay").show();
        $(".choiceSeatTime").slideDown(100);
    });


    //入座时间
    $(".seated>li").click(function(){
        $(this).addClass("seatedCur");
        $(".seated>li").not($(this)).removeClass("seatedCur");
        $("#nextStep").attr("disabled",false);
        $(".choiceTimeA").html("今天"+$(".seatedCur").html()).css("color","#ff7f00");
        // 当前选择的时间
        var thistime = $(this).attr('value');
        // 将数据写入隐藏域
        $("input[name='beginseat']").val(thistime);
        // 隐藏离座时间中小于入座时间的部分
        $('.leaveSeat li').each(function(index, el) {
            if ($(this).attr('value') <= thistime) {
                $(this).hide();
            }
        });
    });
    //离座时间
    $(".leaveSeat>li").click(function(){
        $("#sureStep").attr("disabled",false);
        $(this).addClass("leaveSeatCur");
        $(".leaveSeat>li").not($(this)).removeClass("leaveSeatCur");
        $(".choiceTimeB").html("今天"+$(".leaveSeatCur").html()).css("color","#ff7f00");
        $("#nextStep").attr("disabled",false);
        // 将数据写入隐藏域
        $("input[name='endseat']").val($(this).attr('value'));
        // 计算价格
        var beginseat = $("input[name='beginseat']").val();
        var endseat = $(this).attr('value');
        var perprice = $("input[name='perprice']").val();
        console.log(perprice)
        var mytime = (endseat - beginseat)/3600;
        var actual_pay = Math.ceil(mytime)*perprice;
        var typenum = $("input[name='typenum']").val();
        console.log(typenum);
        if (typenum == 1) {
            $("input[name='actual_pay']").val(actual_pay);
            $("#actual_payshow").html(actual_pay);
        } else {
            // $("input[name='actual_pay']").val(perprice);
            // $("#actual_payshow").html(perprice);
        }
    });
    //下一步
    $("#nextStep").live("click",function(){
        $(this).attr("disabled",true);
        $(this).attr("id","sureStep");
        $(this).val("确定");
        $(".choiceSeatTime>p>span").html("离座时间");
        $(".seated").hide();
        $(".leaveSeat").show();
    });
    //确定
    $("#sureStep").live("click",function(){
        $(".lay").hide();
        $(this).attr("id","nextStep");
        $(this).val("下一步");
        $(".seated").show();
        $(".leaveSeat").hide();
        $(".choiceSeatTime").hide();
        $(".choiceSeatTime>p>span").html("入座时间");
        $(".seated>li").removeClass("seatedCur");
        $(".leaveSeat>li").removeClass("leaveSeatCur");
        $("#nextStep").attr("disabled",true);
        $("#sureStep").attr("disabled",true);
    });

    //取消
    $(".cancel").click(function(){
        $(".lay").hide();
        $(".choiceSeatTime").slideUp(100);
    });

    var officeInit={
        name:false,
        phone:false,
        code:false
    };

    var officeReg={
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)///手机号
    };

    $("#contact_name").blur(function(){
        var val=$(this).val();
        if( val=="" ){
        	$(".tips").html("联系人不能为空！");
            $(".tips").stop(true, true).show(100).delay(3000).hide(100);
            officeInit.name=false;
        }else{
            console.log("ok");
            officeInit.name=true;
        }
    });

    $("#contact_phone").blur(function(){
        var val=$(this).val();
        if( officeReg.phone.test(val) ){
            console.log("ok");
            officeInit.phone=true;
        }else{
        	$(".tips").html("格式错误！");
            $(".tips").stop(true, true).show(100).delay(3000).hide(100);
            officeInit.phone=false;
        }
        if( val=="" ){
        	 $(".tips").html("电话不能为空！");
            $(".tips").stop(true, true).show(100).delay(3000).hide(100);
            officeInit.phone=false;
        }
    });

    $("#contact_code").blur(function(){
        var val=$(this).val();
        if( val=="" ){
        	$(".tips").html("验证码不能为空！");
            $(".tips").stop(true, true).show(100).delay(3000).hide(100);
            officeInit.code=false;
        }else{
            console.log("ok");
            officeInit.code=true;
        }
    });

    //获取验证码
    var t;
    var m=5;//秒数
    function time(ele){
        m--;
        if( m==0 ){
            ele.prop("disabled",false);
            ele.val("获取验证码");
            clearInterval(t);
            m=5;
        }else{
            ele.prop("disabled",true);
            ele.val(m+"s");
        }
    };

    $(".removeBtn").click(function(){
        console.log("dd");
        var phone=$("#contact_phone").val();
        console.log(phone);
        if( officeReg.phone.test(phone) ){
                t=setInterval(function(){
                    time($(".removeBtn"))
                },1000);
                // ajax发送验证码请求
                $.ajax({
                    url: 'send_code',
                    type: 'POST',
                    dataType: 'json',
                    data: {user_phone: phone},
                    success: function(res) {
                        console.log(res);
                    }
                })
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
    });


    $("#makeSub").click(function(){
        var linkman    = $("input[name='linkman']").val();
        var link_phone = $("input[name='link_phone']").val();
        var code       = $("input[name='code']").val();
        if( linkman != '' && link_phone != '' && code != '' && officeReg.phone.test(link_phone) ){
            $(this).submit();
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
            return false;
        }
    });
	
});















