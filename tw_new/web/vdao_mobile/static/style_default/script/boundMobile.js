/**
 * Created by 7du-29 on 2018/1/23.
 */
$(function(){
    var registerReg={
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)///手机号
    };
    setDivCenter($(".tips"));
    //验证手机号码
    $("#user_phone").blur(function(){
        var val=$(this).val();
        if( registerReg.phone.test(val) ){
            console.log("ok");
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
        if( val=="" ){
            console.log("不能为空");
        }
    });

    //验证码倒计时
    var t;
    var m=60;//秒数
    function time(ele){
        m--;
        if( m==0 ){
            ele.css("background","#ff6633");
            ele.attr("disabled",false);
            ele.val("获取验证码");
            clearInterval(t);
            m=60;
        }else{
            ele.css("background","#999999");
            ele.attr("disabled",true);
            ele.val(m+"s");
        }
    }
    //获取验证码
    $(".removeBtn").click(function(){
        var phone=$("#user_phone").val();
        if( registerReg.phone.test(phone) ){

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

            t=setInterval(function(){
                time($(".removeBtn"));
            },1000);
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
    });

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } );
    }
});