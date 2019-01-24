/**
 * Created by 7du-29 on 2017/6/7.
 */

$(function(){
    var user=$("#user");
    var pwd=$("#pwd");
    var sub=$(".sub");
    var loginHeight=parseInt(($(".loginBg").height())/2);
    var regTips=$(".regTips");

    // 正则
    var reg={
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//验证130-139,150-159,180-189号码段的手机号码
        username: /^[a-zA-Z][a-zA-Z0-9_]{5,20}$/,//用户名
        pwd:/^\w{6,16}$///密码
    }

    // 初始化正则状态 默认为为false
    var regState={
        userPhone:false,
        username: false,
        pwd:false
    }

    // 动画
    function topAnimate(){
        $(".loginBg").animate({"top":"-"+loginHeight},300);
        $(".login").animate({"top":"-"+loginHeight},300);
        event.stopPropagation();
    }
    function bottomAnimate(){
        $(".loginBg").animate({"top":0},300);
        $(".login").animate({"top":0},300);
        event.stopPropagation();
    }

    $("#user,#pwd").click(function(){
        topAnimate();
    })
    // 除了user,pwd 点击最外层容器.loginBox
    $(".loginBox").not(user,pwd).click(function(){
        bottomAnimate();
    })

    // 用户名/手机号验证匹配
    user.blur(function(){
        var userVal=$(this).val();
        if(userVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号/用户名不能为空！");
            regState.username=false;
            return;
        }
        if((reg.userPhone.test(userVal))||(reg.username.test(userVal))){
            console.log("通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("OK！");
            regState.userPhone=true;
            regState.username=true;
            return;
        }else{
            console.log("不通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("请输入正确的手机号/用户名！");
            regState.username=false;
            return;
        }
    });


   /* pwd.focus(function(){
        regTips.text("");
        regTips.css("display","block");
        regTips.text("请输入密码");
    })*/
    // 密码验证匹配
    pwd.blur(function(){
        var pwdVal=$(this).val();
        if(pwdVal==""){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码不能为空！");
            regState.userPwd=false;
            return;
        }
        if((reg.pwd).test(pwdVal)){
            regTips.text("");
            regTips.css("display","block");
            regTips.text("OK！");
            regState.userPwd=true;
            return;
        }else{
            console.log("不通过");
            regTips.text("");
            regTips.css("display","block");
            regTips.text("密码错误！");
            regState.userPwd=false;
            return;
        }
    })

    // 提交页面
    sub.click(function(){
        tips();
        if((regState.userPhone || regState.username) && regState.userPwd){
            $(".login>form").submit();
            regTips.text("");
            regTips.css("display","block");
            regTips.text("登录成功");
        }else{
            regTips.text("");
            regTips.css("display","block");
            regTips.text("手机号/用户名或密码错误！");
            return false;
        }
    });

    /* 提示框 */
    function tips(){
        var setTime;
        var timer=setTimeout(function(){
            regTips.show().delay(3000).fadeOut(300);
        },2000)
    }
    user.click(function(){tips()});
    pwd.click(function(){tips()});
})


