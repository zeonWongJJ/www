/**
 * Created by 7du-29 on 2017/10/12.
 */
$(function(){
    //编辑用户资料
    //正则
    var userReg={
        userAccount:/^[0-9a-zA-Z\u4e00-\u9fa5_]{3,15}$/,//账户名
        userPhone:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,//手机号码
        userMail:/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/, //邮箱
        userPwd:/^[a-zA-Z0-9_-]{6,16}$///密码
    };
    //初始化提交状态
    var userState={
        userAccount:true,//账户名
        userSex:true,//性别
        userPhone:true,//手机号码
        userMail:true, //邮箱
        userWeChat:true,//微信
        userQQ:true,//qq
        userPwd:true,//密码
        userRePwd:true,//二次密码
        userPoint:true,//积分
        userBalance:true//余额
    };


    //账户名
    $("#user_name").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".userName>em").removeClass("hide");
            $(".userName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userName>em>span").html("不能为空");
            userState.userAccount=false;
            return false;
        }
        if( userReg.userAccount.test(val) ){
            $(".userName>em").removeClass("hide");
            $(".userName>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userName>em>span").html("");
            userState.userAccount=true;
            return true;
        }else{
            $(".userName>em").removeClass("hide");
            $(".userName>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userName>em>span").html("格式错误");
            userState.userAccount=false;
            return false;
        }
    });

    //性别
    $(".userSex>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.userSex").find(".man>img").attr("src","/static/style_default/image/pro_36.png");
            $(".userSex>em.wom>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".userSex>em").not($(this)).removeClass("choice");
        }else if($(this).index()==2){
            $(this).parent("li.userSex").find(".wom>img").attr("src","/static/style_default/image/pro_36.png");
            $(".userSex>em.man>img").attr("src","/static/style_default/image/pro_38.png");
            $(this).addClass("choice");
            $(".userSex>em").not($(this)).removeClass("choice");
        }
        $("input[name='user_sex']").val($(this).attr('value'));
        $(".userSex>img").removeClass("hide");
        userState.userSex=true;
    });
    //手机号码
    $("#user_phone").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".userPhone>em").removeClass("hide");
            $(".userPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userPhone>em>span").html("不能为空");
            userState.userPhone=false;
            return false;
        }
        if( userReg.userPhone.test(val) ){
            $(".userPhone>em").removeClass("hide");
            $(".userPhone>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userPhone>em>span").html("");
            userState.userPhone=true;
            return true;
        }else{
            $(".userPhone>em").removeClass("hide");
            $(".userPhone>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userPhone>em>span").html("格式错误");
            userState.userPhone=false;
            return false;
        }
    });
    //微信
    $("#user_weChat").blur(function(){
        var val=$(this).val();
        if( $(this).val()=="" ){
            $(".userWeChat>em").removeClass("hide");
            $(".userWeChat>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userWeChat>em>span").html("不能为空");
            userState.userWeChat=false;
            return false;
        }else{
            $(".userWeChat>em").removeClass("hide");
            $(".userWeChat>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userWeChat>em>span").html("");
            console.log(userState.userWeChat=true)
            userState.userWeChat=true;
            return true;
        }
    });
    //qq
    $("#user_QQ").blur(function(){
        var val=$(this).val();
        if( $(this).val()=="" ){
            $(".userQQ>em").removeClass("hide");
            $(".userQQ>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userQQ>em>span").html("不能为空");
            userState.userQQ=false;
            return false;
        }else{
            $(".userQQ>em").removeClass("hide");
            $(".userQQ>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userQQ>em>span").html("");
            userState.userQQ=true;
            return true;
        }
    });
    //积分
    $("#user_point").blur(function(){
        var val=$(this).val();
        if( $(this).val()=="" ){
            $(".userPoint>em").removeClass("hide");
            $(".userPoint>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userPoint>em>span").html("不能为空");
            userState.userPoint=false;
            return false;
        }else{
            $(".userPoint>em").removeClass("hide");
            $(".userPoint>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userPoint>em>span").html("");
            userState.userPoint=true;
            return true;
        }
    });
    //余额
    $("#user_balance").blur(function(){
        var val=$(this).val();
        if( $(this).val()=="" ){
            $(".userBalance>em").removeClass("hide");
            $(".userBalance>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userBalance>em>span").html("不能为空");
            userState.userBalance=false;
            return false;
        }else{
            $(".userBalance>em").removeClass("hide");
            $(".userBalance>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userBalance>em>span").html("");
            userState.userBalance=true;
            return true;
        }
    });
    //邮箱
    $("#user_mail").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".userMail>em").removeClass("hide");
            $(".userMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userMail>em>span").html("不能为空");
            userState.userMail=false;
            return false;
        }
        if( userReg.userMail.test(val) ){
            $(".userMail>em").removeClass("hide");
            $(".userMail>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userMail>em>span").html("");
            userState.userMail=true;
            return true;
        }else{
            $(".userMail>em").removeClass("hide");
            $(".userMail>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userMail>em>span").html("格式错误");
            userState.userMail=false;
            return false;
        }
    });

    //密码
    $("#user_pwd").blur(function(){
        var val=$(this).val();
        if(val==""){
            $(".userPwd>em").removeClass("hide");
            $(".userPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userPwd>em>span").html("不能为空");
            userState.userPwd=false;
            return false;
        }
        if( userReg.userPwd.test(val) ){
            $(".userPwd>em").removeClass("hide");
            $(".userPwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userPwd>em>span").html("");
            userState.userPwd=true;
            return true;
        }else{
            $(".userPwd>em").removeClass("hide");
            $(".userPwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userPwd>em>span").html("格式错误");
            userState.userPwd=false;
            return false;
        }
    });

    //二次密码
    $("#user_rePwd").blur(function(){
        var pwdVal=$("#user_pwd").val();
        var rePwd=$(this).val();
        if( pwdVal!==rePwd ){
            $(".userRePwd>em").removeClass("hide");
            $(".userRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userRePwd>em>span").html("密码不一致");
            userState.userRePwd=false;
            return false;
        }else if( rePwd=="" ){
            $(".userRePwd>em").removeClass("hide");
            $(".userRePwd>em>img").attr("src","/static/style_default/image/f_03.png");
            $(".userRePwd>em>span").html("不能为空");
            userState.userRePwd=false;
            return false;
        }else{
            $(".userRePwd>em").removeClass("hide");
            $(".userRePwd>em>img").attr("src","/static/style_default/image/t_03.png");
            $(".userRePwd>em>span").html("");
            userState.userRePwd=true;
            return true;
        }
    });

    //提交
    $("#userSub").click(function(){
        if( userState.userAccount && userState.userSex && userState.userPhone && userState.userMail && userState.userPwd && userState.userRePwd && userState.userPoint && userState.userBalance ){
            $(this).submit();
        }else{
            alert("填写的格式有误或有选项未选择！");
            return false;
        }
    })

});















