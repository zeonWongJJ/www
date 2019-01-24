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
    var reg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        username: /^[a-zA-Z][a-zA-Z0-9_]{5,20}$/,//用户名  必须以字母开头 最少5位最多20位0
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

    //点击弹出
    /*check_userPhone.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入有效的手机号码！");
    })*/

    //获取验证码
    getCode.click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((reg.userPhone).test(userPhoneVal)){//如果手机号验证成功就禁止用户输入
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            check_userPhone.attr("disabled",true);
            $(".getCode>i>s").css("display","block");
            $(this).hide();
            timer();
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
        event.stopPropagation();
        return;
    });
    // 重新获取验证码
    $(".getCode>i>em").click(function(event){
        var userPhoneVal=check_userPhone.val();
        if((reg.userPhone).test(userPhoneVal)){
            check_userPhone.attr("disabled",true);
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            $(".getCode>i>s").css("display","block");
            $(this).hide();
            $(".getCode>i>s").text("2s");
            timer();
            event.stopPropagation();
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
        return;
    })

    // 用户名匹配
    check_username.blur(function(){
        var usernameVal=$(this).val();
        if((reg.userPhone).test(usernameVal)||(reg.username).test(usernameVal)){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            regState.username=true;
            return;
        }else if(usernameVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("用户名不能为空！");
            regState.username=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("用户名必须以字母开头最少5位最多20位！");
            regState.username=false;
            return;
        }
    });

    // 验证码匹配

    check_userCode.blur(function(){
        var userCodeVal=$(this).val();
        if((reg.userCode).test(userCodeVal)){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            regState.userCode=true;
            return;
        }else if(userCodeVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("验证码不能为空！");
            regState.userCode=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("请将正确的验证码输入！");
            regState.userCode=false;
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
            regState.userPwd1=false;
            return;
        }
        if((reg.userPwd).test(userPwdVal)){
            regState.userPwd1=true;
            return;
        }else if(userPwdVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码不能为空！");
            regState.userPwd1=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("密码最少6位最多16位！");
            regState.userPwd1=false;
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
            regState.userPwd2=false;
            return;
        }else if(userPwdVal2==""){
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("不能为空！");
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
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("ok");
            regState.userPhone=true;
            return;
        }else if(userPhoneVal==""){//如果为空
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("手机号不能为空！");
            regState.userPhone=false;
            return;
        }else{
            registerRegTips.text("");
            registerRegTips.css("display","block");
            registerRegTips.text("无效的手机号！");
            regState.userPhone=false;
            return;
        }
            // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
            if( regState.userPhone && regState.username && regState.userPwd1 && regState.userPwd2 && regState.userCode ){
                $(".register>form").submit();//提交
                return;
            }else{
                //alert("填写格式错误！");
                registerRegTips.text("");
                registerRegTips.css("display","block");
                registerRegTips.text("填写格式有误！不能注册");
                return false;//阻止提交
            }
        })

    // 提示框定时器
    function tips(){
        var setTime;
        var timer=setTimeout(function(){
            registerRegTips.show().delay(3000).fadeOut(300);
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
        var timer=parseInt($(".getCode>i>s").text());
        console.log(timer);
        setTime=setInterval(function(){
            if(timer<=0){//如果时间为0时取消手机号禁用 变为可输入
                clearInterval(setTime);
                $(".getCode>i>em").css("display","block");
                $(".getCode>i>s").css("display","none");
                check_userPhone.attr("disabled",false);
                return;
            }
            timer--;
            $(".getCode>i>s").text(timer+"s");
        },1000);
    }


    // 动画
    function topAnimate(){
        $(".userPicture").animate({"top":"-"+registerHeight},300);
        $("#registerForm").animate({"top":"-"+registerHeight},300);
        event.stopPropagation();
    }
    function bottomAnimate(){
        $(".userPicture").animate({"top":0},300);
        $("#registerForm").animate({"top":0},300);
        event.stopPropagation();
    }

   $("#check_userPhone,#check_username,#check_userCode,#check_pwd1,#check_pwd2").click(function(){
        topAnimate();
    })

    // 除了#check_userPhone,#check_username,#check_userCode,#check_pwd1,#check_pwd2 点击最外层容器.register
    $(".register").not(check_userPhone,check_username,check_userCode,check_pwd1,check_pwd2).click(function(){
        bottomAnimate();
    })

})




