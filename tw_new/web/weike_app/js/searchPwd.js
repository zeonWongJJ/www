/**
 * Created by 7du-29 on 2017/6/12.
 */
$(function(){
    var sPhone=$("#phone");//手机号
    var sCode=$("#code");//验证码输入栏
    var sPwd=$("#pwd");//密码
    var srePwd=$("#rePwd");//二次密码
    var regTips=$(".regTips");//提示框
    var getCode=$(".getCode");//获取验证码
    // 正则
    var reg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        userPwd:/^\w{6,16}$/,//密码
        userCode:/^\d{4}$///验证码
    }
    // 初始化正则状态 默认为false
    var regState={
        searchPhone:false,
        searchCode:false,
        searchPwd1:false,
        search2:false
    }

    //点击 获取验证码 验证手机号并获取验证码
    getCode.click(function(){
        var sPhoneVal=sPhone.val();
        if((reg.userPhone).test(sPhoneVal)){//如果手机号验证成功就禁止用户输入
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            sPhone.attr("disabled",true);
            $(this).hide();
            $(".userCode>b").css("display","inline");
            timer();
            regState.searchPhone=true;
            return;
        }else if(sPhoneVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号不能为空！");
            regState.searchPhone=false;
            return;
        } else{
            console.log("no");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请输入有效的手机号！");
            regState.searchPhone=false;
            return;
        }
    });
    // 重新获取验证码
    $(".userCode>em").click(function(event){
        var sPhoneVal=sPhone.val();
        if((reg.userPhone).test(sPhoneVal)){//如果手机号验证成功就禁止用户输入
            sPhone.attr("disabled",true);//重新获取后在次验证手机号如果成功就禁止输入
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            sPhone.attr("disabled",true);
            $(".userCode>b").css("display","inline");
            $(".userCode>b").text("2s");
            timer();
            $(this).hide();
            regState.searchPhone=true;
            return;
        }else if(sPhoneVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号不能为空！");
            regState.searchPhone=false;
            return;
        } else{
            console.log("no");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请输入有效的手机号！");
            regState.searchPhone=false;
            return;
        }
        event.stopPropagation();

    })
    // 倒计时
    function timer(){
        var setTime;
        var timer=parseInt($(".userCode>b").text());
        setTime=setInterval(function(){
            if(timer<=0){
                clearInterval(setTime);
                $(".userCode>em").css("display","inline");
                $(".userCode>b").css("display","none");
                sPhone.attr("disabled",false);
                return;
            }
            timer--;
            $(".userCode>b").text(timer+"s");
        },1000);
    }
    // 验证码
    sCode.blur(function(){
        var sCodeVal=$(this).val();
        if((reg.userCode).test(sCodeVal)){
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.searchCode=true;
            return;
        }else if(sCodeVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("验证码不能为空！");
            regState.searchCode=false;
            return;
        } else{
            console.log("no");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请输入正确的验证码！");
            regState.searchCode=false;
            return;
        }
    });
    // 密码验证
    sPwd.blur(function(){
        var sPwdVal=$(this).val();
        if((reg.userPwd).test(sPwdVal)){
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.searchPwd1=true;
            return;
        }else if(sPwdVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不能为空！");
            regState.searchPwd1=false;
            return;
        }
        else{
            console.log("no");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码格式错误！");
            regState.searchPwd1=false;
            return;
        }
    });
    // 二次密码焦点事件
    srePwd.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入一致的密码！");
    });
    //二次密码验证
    srePwd.blur(function(){
        var sPwdVal=sPwd.val();
        var srePwdVal=srePwd.val();
        if(sPwdVal!==srePwdVal){
            console.log("no");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("输入的密码不一致！");
            regState.searchPwd2=false;
            return;
        }else if(srePwdVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("不能为空！");
            regState.searchPwd2=false;
            return;
        }else{
            console.log("ok");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("ok");
            regState.searchPwd2=true;
            return;
        }
    });

   //  提交
   $(".sub>img").click(function(){
       var sPhoneVal=$(this).val();
       // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
       if( regState.searchPhone && regState.searchCode&& regState.searchPwd1&& regState.searchPwd2){
           $(".validate>form").submit();
           regTips.text("");
           regTips.css("display","block");
           regTips.text("ok");
           return;
       }else{
           regTips.text("");
           regTips.css("display","block");
           regTips.text("格式错误!");
           return false;
       };
       //再次验证手机号
       if((reg.userPhone).test(sPhoneVal)){
           console.log("ok");
           regTips.text("");
           regTips.css("display","block");
           regTips.text("ok");
           regState.searchPhone=true;
           return;
       }else if(sPhoneVal==""){
           regTips.text("");
           regTips.css("display","block");
           regTips.text("手机号不能为空！");
           regState.searchPhone=false;
           return;
       } else{
           console.log("no");
           regTips.text("");
           regTips.css("display","block");
           regTips.text("请输入有效的手机号！");
           regState.searchPhone=false;
           return;
       }
   });

    // 提示框定时器
    function tips(){
        var setTime;
        var timer=setTimeout(function(){
            regTips.show().delay(3000).fadeOut(300);
        },2000)
    }
    sPhone.click(function(){tips()});
    sCode.click(function(){tips()});
    sPwd.click(function(){tips()});
    srePwd.click(function(){tips()});
});



















