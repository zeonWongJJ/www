/**
 * Created by 7du-29 on 2017/6/8.
 */
$(function(){
    var check_userPhone=$("#check_userPhone");//手机号输入框
    var check_username=$("#check_username");//用户名输入框
    var check_userCode=$("#check_userCode");//验证码
    var check_pwd1=$("#check_pwd1");//密码输入框
    var check_pwd2=$("#check_pwd2");//二次密码输入框
    var registerRegTips=$(".registerRegTips");//提示框
    var getCode=$(".getCode>i>span");//获取验证码
    var registerHeight=parseInt(($(".userPicture").height()));
    var registerFormHeight=parseInt(($("#registerForm").height()));

    // 正则
    var registerReg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        username: /^[a-zA-Z][a-zA-Z0-9_]{5,20}$/,//用户名  必须以字母开头 最少5位最多20位
        userPwd:/^\w{6,16}$/,//密码
        userCode:/^\d{4}$///验证码
    }
    // 初始化正则状态 默认为为false
    var registerRegState={
        userPhone:false,
        username: false,
        userPwd1:false,
        userPwd2:false,
        userCode:false
    }

    //点击弹出
    /*check_userPhone.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入有效的手机号码！");
    })*/

    //获取验证码
    getCode.click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((registerReg.userPhone).test(userPhoneVal)){//如果手机号验证成功就禁止用户输入
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            check_userPhone.attr("disabled",true);
            $(".getCode>i>s").css("display","block");
            $(this).hide();
            registerTimer();
            registerRegState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("手机号不能为空！");
            registerRegState.userPhone=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("无效的手机号！");
            registerRegState.userPhone=false;
            return;
        }
        event.stopPropagation();
        return;
    });
    // 重新获取验证码
    $(".getCode>i>em").click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((registerReg.userPhone).test(userPhoneVal)){
            check_userPhone.attr("disabled",true);
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            $(".getCode>i>s").css("display","block");
            $(this).hide();
            $(".getCode>i>s").text("2s");
            registerTimer();
            event.stopPropagation();
            registerRegState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("手机号不能为空！");
            registerRegState.userPhone=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("无效的手机号！");
            registerRegState.userPhone=false;
            return;
        }
        return;
    })

    // 用户名匹配
    check_username.blur(function(){
        var usernameVal=$(this).val();
        if((registerReg.userPhone).test(usernameVal)||(registerReg.username).test(usernameVal)){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            registerRegState.username=true;
            return;
        }else if(usernameVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("用户名不能为空！");
            registerRegState.username=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("用户名必须以字母开头最少5位最多20位！");
            registerRegState.username=false;
            return;
        }
    });

    // 验证码匹配

    check_userCode.blur(function(){
        var userCodeVal=$(this).val();
        if((registerReg.userCode).test(userCodeVal)){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            registerRegState.userCode=true;
            return;
        }else if(userCodeVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("验证码不能为空！");
            registerRegState.userCode=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("请将正确的验证码输入！");
            registerRegState.userCode=false;
            return;
        }

    });

    //  密码验证匹配
    check_pwd1.blur(function(){
        var userPwdVal=$(this).val();
        var usernameVal=check_username.val();
        if(userPwdVal==usernameVal){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码不能和用户名一样！");
            registerRegState.userPwd1=false;
            return;
        }
        if((registerReg.userPwd).test(userPwdVal)){
            registerRegState.userPwd1=true;
            return;
        }else if(userPwdVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码不能为空！");
            registerRegState.userPwd1=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码最少6位最多16位！");
            registerRegState.userPwd1=false;
            return;
        }
    });
   //  二次密码验证匹配
   check_pwd2.blur(function(){
        var userPwdVal1=check_pwd1.val();
        var userPwdVal2=check_pwd2.val();
        if(userPwdVal1!==userPwdVal2){//如果输入的密码和二次输入的密码不一样
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码不一致！");
            registerRegState.userPwd2=false;
            return;
        }else if(userPwdVal2==""){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("不能为空！");
            registerRegState.userPwd2=false;
        } else{
            registerRegState.userPwd2=true;
            return;
        }
    })


    //  提交
    $(".registerSub").click(function(){
        console.log()
        var userPhoneVal=check_userPhone.val();
        // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
        if( registerRegState.userPhone && registerRegState.username && registerRegState.userPwd1 && registerRegState.userPwd2 && registerRegState.userCode ){
            if((registerReg.userPhone).test(userPhoneVal)){//如果手机号验证成功就禁止用户输入
                registerRegTips.text("");
                registerRegTips.css("display","block");
                registerRegTips.text("ok");
                registerRegState.userPhone=true;
                $("#registerForm").submit();//提交
                return;
            }else if(userPhoneVal==""){//如果为空
                registerRegTips.text("");
                registerRegTips.css("display","block");
                registerRegTips.text("手机号不能为空！");
                registerRegState.userPhone=false;
                return;
            }else{
                registerRegTips.text("");
                registerRegTips.css("display","block");
                registerRegTips.text("无效的手机号！");
                registerRegState.userPhone=false;
                return;
            }

            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("填写格式有误！不能注册");
            return false;//阻止提交
        }


        })

    // 提示框定时器
    function registerTips(){
        var setTime;
        var timer=setTimeout(function(){
            registerRegTips.show().delay(3000).fadeOut(300);
        },2000)
    }
    check_userPhone.click(function(){registerTips()});
    check_username.click(function(){registerTips()});
    check_userCode.click(function(){registerTips()});
    check_pwd1.click(function(){registerTips()});
    check_pwd2.click(function(){registerTips()});

    // 获取验证码后的倒计时
    function registerTimer(){
        var setTime;
        var timer=parseInt($(".getCode>i>s").text());
        console.log(timer);
        setTime=setInterval(function(){
            if(timer<=0){//如果时间为0时取消手机号禁用 变为可输入
                clearInterval(setTime);
                $(".getCode>i>em").css("display","block");
                $(".getCode>i>s").css("display","none");
                check_userPhone.attr("disabled",false);

            }
            timer--;
            $(".getCode>i>s").text(timer+"s");
        },1000);
    }


    // 动画
    function registerTopAnimate(){
        $(".userPicture").animate({"top":"-"+registerHeight+50+"px"},300);
        $("#registerForm").animate({"top":"-"+parseInt($("#registerForm").height()-50+"px")},300);
        event.stopPropagation();
    }
    function registerBottomAnimate(){
        $(".userPicture").animate({"top":0},300);
        $("#registerForm").animate({"top":0},300);
        event.stopPropagation();
    }

   $("#check_userPhone,#check_username,#check_userCode,#check_pwd1,#check_pwd2").click(function(){
       registerTopAnimate();
    })

    // 除了#check_userPhone,#check_username,#check_userCode,#check_pwd1,#check_pwd2 点击最外层容器.register
    $(".register").not(check_userPhone,check_username,check_userCode,check_pwd1,check_pwd2).click(function(){
        registerBottomAnimate();
    })

})




