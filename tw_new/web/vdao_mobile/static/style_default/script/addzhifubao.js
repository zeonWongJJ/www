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
        $(".tips").stop().show(100).delay(3000).hide(100);
        $(".tips").html("已发送验证码");
    });

    $("#codeSub").click(function(){
        var phone = $("#user_phone").val();
        var code = $("#code").val();
        var go_type = $("#go_type").val();
        if( $("#code").val()!="" ){
            // 发送ajax请求验证数据是否正确
            $.ajax({
                url: 'account_code',
                type: 'POST',
                dataType: 'json',
                data: {user_phone: phone, code: code},
                success: function(res) {
                    // console.log(res);  return false;
                    if (res.code == 200) {
                        // 跳转到需要绑定界面
                        window.location.replace('account_add-'+go_type);
                    } else {
                        $(".tips").stop().show(100).delay(3000).hide(100);
                        $(".tips").html("验证码错误");
                    }
                }
            })
            return false;
        } else {
            return false;
        }
    });
});













