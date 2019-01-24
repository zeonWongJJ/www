/**
 * Created by 7du-29 on 2017/6/12.
 */
$(function(){
    var sPhone=$("#searchPhone");//手机号
    var sCode=$("#searchCode");//验证码输入栏
    var sPwd=$("#searchPwd");//密码
    //var srePwd=$("#searchRePwd");//二次密码
    var searchRegTips=$(".searchRegTips");//提示框
    var getCode=$(".getCode");//获取验证码
    // 正则
    var searchPwdReg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        userPwd:/^\w{6,16}$/,//密码
        userCode:/^\d{4}$///验证码
    }
    // 初始化正则状态 默认为false
    var searchPwdRegState={
        searchPhone:false,
        searchCode:false,
        searchPwd1:false,
        search2:false
    }

    //点击 获取验证码 验证手机号并获取验证码
    getCode.click(function(){
        var sPhoneVal=sPhone.val();
        console.log( $(".searchUserCode>b"));
        if((searchPwdReg.userPhone).test(sPhoneVal)){//如果手机号验证成功就禁止用户输入
            console.log("ok");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("ok");
            searchRegTips.attr("disabled",true);
            $(this).hide();
            $(".searchUserCode>b").css("display","inline");
            timer();
            searchPwdRegState.searchPhone=true;
            return;
        }else if(sPhoneVal==""){
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("手机号不能为空！");
            searchPwdRegState.searchPhone=false;
            return;
        } else{
            console.log("no");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("请输入有效的手机号！");
            searchPwdRegState.searchPhone=false;
            return;
        }
    });
    // 重新获取验证码
    $(".searchUserCode>em").click(function(event){
        var sPhoneVal=sPhone.val();
        if((searchPwdReg.userPhone).test(sPhoneVal)){//如果手机号验证成功就禁止用户输入
            sPhone.attr("disabled",true);//重新获取后在次验证手机号如果成功就禁止输入
            console.log("ok");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("ok");
            sPhone.attr("disabled",true);
            $(".searchUserCode>b").css("display","inline");
            $(".searchUserCode>b").text("2s");
            timer();
            $(this).hide();
            searchPwdRegState.searchPhone=true;
            return;
        }else if(sPhoneVal==""){
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("手机号不能为空！");
            searchPwdRegState.searchPhone=false;
            return;
        } else{
            console.log("no");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("请输入有效的手机号！");
            searchPwdRegState.searchPhone=false;
            return;
        }
        event.stopPropagation();

    })
    // 倒计时
    function timer(){
        var setTime;
        var timer=parseInt($(".searchUserCode>b").text());
        setTime=setInterval(function(){
            if(timer<=0){
                clearInterval(setTime);
                $(".searchUserCode>em").css("display","inline");
                $(".searchUserCode>b").css("display","none");
                sPhone.attr("disabled",false);
                return;
            }
            timer--;
            $(".searchUserCode>b").text(timer+"s");
        },1000);
    }
    // 验证码
    sCode.blur(function(){
        var sCodeVal=$(this).val();
        if((searchPwdReg.userCode).test(sCodeVal)){
            console.log("ok");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("ok");
            searchPwdRegState.searchCode=true;
            return;
        }else if(sCodeVal==""){
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("验证码不能为空！");
            searchPwdRegState.searchCode=false;
            return;
        } else{
            console.log("no");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("请输入正确的验证码！");
            searchPwdRegState.searchCode=false;
            return;
        }
    });
    // 密码验证
    sPwd.blur(function(){
        var sPwdVal=$(this).val();
        if((searchPwdReg.userPwd).test(sPwdVal)){
            console.log("ok");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("ok");
            searchPwdRegState.searchPwd1=true;
            return;
        }else if(sPwdVal==""){
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("密码不能为空！");
            searchPwdRegState.searchPwd1=false;
            return;
        }
        else{
            console.log("no");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("密码格式错误！");
            searchPwdRegState.searchPwd1=false;
            return;
        }
    });
    // 二次密码焦点事件
   /*srePwd.focus(function(){
        searchRegTips.text("");
        searchRegTips.css("display","block");
        searchRegTips.text("请输入一致的密码！");
    });
    //二次密码验证
    srePwd.blur(function(){
        var sPwdVal=sPwd.val();
        var srePwdVal=srePwd.val();
        if(sPwdVal!==srePwdVal){
            console.log("no");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("输入的密码不一致！");
            searchPwdRegState.searchPwd2=false;
            return;
        }else if(srePwdVal==""){
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("不能为空！");
            searchPwdRegState.searchPwd2=false;
            return;
        }else{
            console.log("ok");
            searchRegTips.text("");
            searchRegTips.css("display","block");
            searchRegTips.text("ok");
            searchPwdRegState.searchPwd2=true;
            return;
        }
    });*/

   //  提交
   $(".searchSub>img").click(function(){
       var sPhoneVal=$(this).val();
       // 如果注册账户的几个选项都为true的时候才提交表单，否则阻止提交
       if( searchPwdRegState.searchPhone && searchPwdRegState.searchCode&& searchPwdRegState.searchPwd1 ){
           $(".validate>form").submit();
           searchRegTips.text("");
           searchRegTips.css("display","block");
           searchRegTips.text("ok");
           return;
       }else{
           searchRegTips.text("");
           searchRegTips.css("display","block");
           searchRegTips.text("格式错误!");
           return false;
       };
       //再次验证手机号
       if((searchPwdReg.userPhone).test(sPhoneVal)){
           console.log("ok");
           searchRegTips.text("");
           searchRegTips.css("display","block");
           searchRegTips.text("ok");
           searchPwdRegState.searchPhone=true;
           return;
       }else if(sPhoneVal==""){
           searchRegTips.text("");
           searchRegTips.css("display","block");
           searchRegTips.text("手机号不能为空！");
           searchPwdRegState.searchPhone=false;
           return;
       } else{
           console.log("no");
           searchRegTips.text("");
           searchRegTips.css("display","block");
           searchRegTips.text("请输入有效的手机号！");
           searchPwdRegState.searchPhone=false;
           return;
       }
   });

    // 提示框定时器
    function searchTips(){
        var setTime;
        var timer=setTimeout(function(){
            searchRegTips.show().delay(3000).fadeOut(300);
        },2000)
    }
    sPhone.click(function(){searchTips()});
    sCode.click(function(){searchTips()});
    sPwd.click(function(){searchTips()});
    //srePwd.click(function(){searchTips()});
});



















