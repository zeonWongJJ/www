/**
 * Created by 7du-29 on 2018/3/31.
 */
$(function(){
    var t;
    var m=60;//秒数
    function time(ele){
        m--;
        if( m==0 ){
            ele.attr("disabled",false);
            ele.val("获取验证码");
            clearInterval(t);
            m=60;
        }else{
            ele.attr("disabled",true);
            ele.val(m+"s");
        }
    }
    $(".removeBtn").click(function(){
        var phone=$("#user_phone").val();
        t=setInterval(function(){
           time($(".removeBtn"));
        },1000);
        $(".tips").stop().show(100).delay(3000).hide(100);
        $(".tips").html("已发送验证码");
    });

    $("#codeSub").click(function(){
        if( $("#code").val()!="" ){
            $(this).submit();
        }else{
            return false;
        }
    });
});













