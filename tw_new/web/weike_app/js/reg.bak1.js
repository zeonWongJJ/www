/**
 * Created by 7du-29 on 2017/6/8.
 */
$(function(){
    var check_userPhone=$("#check_userPhone");//手机号输入框
    var check_username=$("#check_username");//用户名输入框
    var check_userCode=$("#check_userCode");//验证码
    var check_pwd1=$("#check_pwd1");//密码输入框
    var check_pwd2=$("#check_pwd2");//二次密码输入框
    var regTips=$(".regTips");//提示框
    var getCode=$(".getCode");//获取验证码

    // 正则
    var reg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        username: /^[a-zA-Z][a-zA-Z0-9_]{5,20}$/,//用户名  必须以字母开头 最少5位最多20位
        userPwd:/^\w{6,16}$/,//密码
        userCode:/^\d{4}$///验证码
    }
    // 初始化正则状态 默认为为false
    var regState={
        userPhone:false,
        username: false,
        userPwd1:false,
        userPwd2:false,
        userCode:false
    }

    //获取验证码
    getCode.click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((reg.userPhone).test(userPhoneVal)){//如果手机号验证成功就禁止用户输入

            var send_data={};
            send_data['device_number']='123123';
            send_data['comprehensive']=userPhoneVal;
            send_data['source']='注册';

            send_phone(send_data);

            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            check_userPhone.attr("disabled",true);
            $(".codeBox>span").css("display","block");
            $(this).hide();
            timer();
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
        event.stopPropagation();
        return;
    });
    // 重新获取验证码
    $(".codeBox>em").click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((reg.userPhone).test(userPhoneVal)){
            check_userPhone.attr("disabled",true);
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            $(".codeBox>span").css("display","block");
            $(this).hide();
            $(".codeBox>span").text("2s");
            timer();
            event.stopPropagation();
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
        return;
    })

    // 用户名匹配
    check_username.blur(function(){
        var usernameVal=$(this).val();
        if((reg.userPhone).test(usernameVal)||(reg.username).test(usernameVal)){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.username=true;
            return;
        }else if(usernameVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("用户名不能为空！");
            regState.username=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("用户名必须以字母开头最少5位最多20位！");
            regState.username=false;
            return;
        }
    });

    // 验证码匹配

    check_userCode.blur(function(){
        var userCodeVal=$(this).val();
        if((reg.userCode).test(userCodeVal)){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.userCode=true;
            return;
        }else if(userCodeVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("验证码不能为空！");
            regState.userCode=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请将正确的验证码输入！");
            regState.userCode=false;
            return;
        }

    });

    //  密码验证匹配
    check_pwd1.blur(function(){
        var userPwdVal=$(this).val();
        var usernameVal=check_username.val();
        if(userPwdVal==usernameVal){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不能和用户名一样！");
            regState.userPwd1=false;
            return;
        }
        if((reg.userPwd).test(userPwdVal)){
            regState.userPwd1=true;
            return;
        }else if(userPwdVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不能为空！");
            regState.userPwd1=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码最少6位最多16位！");
            regState.userPwd1=false;
            return;
        }
    });
   //  二次密码验证匹配
   check_pwd2.blur(function(){
        var userPwdVal1=check_pwd1.val();
        var userPwdVal2=check_pwd2.val();
        if(userPwdVal1!==userPwdVal2){//如果输入的密码和二次输入的密码不一样
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不一致！");
            regState.userPwd2=false;
            return;
        }else if(userPwdVal2==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("不能为空！");
            regState.userPwd2=false;
        } else{
            regState.userPwd2=true;
            return;
        }
    })


    //  提交
    $(".sub").click(function(){
        var userPhoneVal=check_userPhone.val();
        if((reg.userPhone).test(userPhoneVal)){//如果手机号验证成功就禁止用户输入
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
            // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
            if( regState.userPhone && regState.username && regState.userPwd1 && regState.userPwd2 && regState.userCode ){
                $(".register>form").submit();//提交
                $(".sub").css("color","white");
                return;
            }else{
                //alert("填写格式错误！");
                regTips.text("");
                regTips.css("display","block");
                regTips.text("填写格式有误！不能注册");
                return false;//阻止提交
            }
        })

    // 提示框定时器
 function tips(){
        var setTime;
        var timer=setTimeout(function(){
            regTips.show().delay(3000).fadeOut(300);
        },2000)
    }
    check_userPhone.click(function(){tips()});
    check_username.click(function(){tips()});
    check_userCode.click(function(){tips()});
    check_pwd1.click(function(){tips()});
    check_pwd2.click(function(){tips()});

    // 获取验证码后的倒计时
    function timer(){
        var setTime;
        var timer=parseInt($(".codeBox>span").text());
        setTime=setInterval(function(){
            if(timer<=0){//如果时间为0时取消手机号禁用 变为可输入
                clearInterval(setTime);
                $(".codeBox>em").css("display","block");
                $(".codeBox>span").css("display","none");
                check_userPhone.attr("disabled",false);
                return;
            }
            timer--;
            $(".codeBox>span").text(timer+"s");
        },1000);
    }

        //发送ajax 请求
    function send_phone(send_data){
        console.log(send_data);
            $.ajax({
                  type: 'POST',
                  data: send_data,
                  url : 'send_code',
                  beforeSend:function(){
 
                  },
                  success: function(json) {
                    var json_data = eval('(' + json + ')');
                    if(json_data['status']){
                        regTips.text("发送成功");
                    //解绑发送按钮
                    $("#send_code").unbind();
                    }else{
                        regTips.text("发送失败");
                    }

                  },
                  error: function() {
                      alert('请检查网络配置,稍后再试');
                  }
              });
    }

})




