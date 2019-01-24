/**
 * Created by 7du-29 on 2017/6/8.
*/

//设备码
device_number='123';

$(function(){
    var check_username=$("#check_username");
    var check_userCode=$("#check_userCode");
    var check_pwd1=$("#check_pwd1");
    var check_pwd2=$("#check_pwd2");
    var regTips=$(".regTips");

    // 正则
    var reg={
        userPhone:/^[\d]{5,20}$/,//手机  0~9 最少5位 最多20位
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

    //  手机或用户名验证匹配
    /*check_username.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入手机号或用户名！");
    });*/
    check_username.blur(function(){
         usernameVal=$(this).val();
        if((reg.userPhone).test(usernameVal)||(reg.username).test(usernameVal)){
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.userPhone=true;

            return;

        }else if(usernameVal==""){//如果为空
            console.log("请输入手机号或用户名");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号或用户名不能为空！");
            regState.userPhone=false;
            regState.username=false;
            return;
        }else{
            console.log("不通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("用户名必须以字母开头最少5位最多20位或填写手机号！");
            regState.userPhone=false;
            regState.username=false;
            return;
        }
    });

    // 验证码匹配
    /*(check_userCode.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入验证码！");
    })*/
    check_userCode.blur(function(){
        var userCodeVal=$(this).val();

        send_phone['comprehensive']=userCodeVal;
        if((reg.userCode).test(userCodeVal)){
            console.log("ok");
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
            console.log("不通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请将正确的验证码输入！");
            regState.userCode=false;
            return;
        }

    });

    //  密码验证匹配
    /*check_pwd1.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入密码！");
    })*/
    check_pwd1.blur(function(){
        var userPwdVal=$(this).val();
        if((reg.userPwd).test(userPwdVal)){
            console.log("ok");
            regState.userPwd1=true;
            return;
        }else if(userPwdVal==""){//如果为空
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不能为空！");
            regState.userPwd1=false;
        } else{
            console.log("不通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码最少6位最多16位！");
            regState.userPwd1=false;
            return;
        }
    });
   //  二次密码验证
   check_pwd2.blur(function(){
        var userPwdVal1=check_pwd1.val();
        var userPwdVal2=check_pwd2.val();
        if(userPwdVal1!==userPwdVal2){//如果输入的密码和二次输入的密码不一样
            console.log("密码不一样");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不一致！");
            regState.userPwd2=false;
            return;
        }else{
            console.log("ok");
            regState.userPwd2=true;
            return;
        }
    })


    //  提交
    $(".sub").click(function(){
            // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
            if( (regState.userPhone || regState.username) && regState.userPwd1 && regState.userPwd2 && regState.userCode ){
                // $(".register>form").submit();//提交
                var param=$("form").serialize();
                reg_dispose(param);
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

    // 点击验证提示框以外隐藏
       check_username,check_userCode,check_pwd1,check_pwd2.click(function(){
            regTips.show().delay(3000).fadeOut(300);
       });

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

    //发送ajax 请求
    function reg_dispose(send_data){
        console.log(send_data);
            $.ajax({
                  type: 'POST',
                  data: send_data,
                  url : 'reg_dispose',
                  beforeSend:function(){
 
                  },
                  success: function(json) {
                    var json_data = eval('(' + json + ')');
                    if(json_data['status']){
                        regTips.text("注册成功");
                    //解绑发送按钮
                    $("#send_code").unbind();
                    }else{
                        regTips.text(json['tips']);
                    }

                  },
                  error: function() {
                      alert('请检查网络配置,稍后再试');
                  }
              });
    }

    $("#send_code").click(function(){
        if(regState.userPhone==true){

            var send_data={};
            send_data['device_number']=device_number;
            send_data['comprehensive']=usernameVal;
            send_data['source']='注册';

            send_phone(send_data);
        }
    })

})




