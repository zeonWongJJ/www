/**
 * Created by 7du-29 on 2017/11/28.
 */
$(function(){

    $(".login").hide();
    $(".register").hide();
    $(".lay").hide();

    $(".loginBtn").click(function(){
        $(".lay").show();
        $(".login").show(200);
    });

    $(".registerBtn").click(function(){
        $(".lay").show();
        $(".register").show(200);
    });

    $(".closeLogin").click(function(){
        $(".login").hide(200);
        $(".lay").hide();
    });

    $(".closeRegister").click(function(){
        $(".register").hide(200);
        $(".lay").hide();
        $("#user_phone,#user_code,#user_newPwd,#user_reNewPwd").val("");
        clearInterval(t);
        m=60;
        $("#codeBtn").attr("disabled",false);
        $("#codeBtn").val("发送验证码");
    });

    //注册
    var registerInit={
        name:false,
        phone:false,
        code:false,
        pwd:false,
        rePwd:false,
        phoneHave:false,
        nameHave:false,
    };
    var registerReg={
//      name:/^\w{3,15}$/,
		name:/[\u4e00-\u9fa5_a-zA-Z0-9_]{3,10}/,//至少三位(可以包含中英文数字)
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/,//手机号
        pwd:/^[a-zA-Z0-9]{6,15}$///必须且只含有数字和字母，6-15位
    };

    $("#register_name").blur(function(){
        var val=$(this).val();
        if( registerReg.name.test(val) ){
            registerInit.name=true;
            // 发送ajax请求验证用户名是否被占用
            $.ajax({
                url: 'register_check',
                type: 'POST',
                dataType: 'json',
                data: {nameOrphone: val, type: 2},
                success: function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        $(".tips").html("该用户名已经存在，请更换");
                        $(".tips").stop().show(100).delay(3000).hide(250);
                        registerInit.nameHave=false;
                    } else {
                        registerInit.nameHave=true;
                    }
                }
            })
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("至少三位(可以包含中英文数字)");
            registerInit.name=false;
        }
        if( val=="" ){
            console.log("不能为空");
            registerInit.name=false;
        }
    });

    $("#user_phone").blur(function(){
        var val=$(this).val();
        if( registerReg.phone.test(val) ){
            registerInit.phone=true;
            // 发送ajax请求验证手机号码是否被占用
            $.ajax({
                url: 'register_check',
                type: 'POST',
                dataType: 'json',
                data: {nameOrphone: val, type: 1},
                success: function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        $(".tips").html("该手机号码已被占用");
                        $(".tips").stop().show(100).delay(3000).hide(250);
                        registerInit.phoneHave=false;
                    } else {
                        registerInit.phoneHave=true;
                    }
                }
            })
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
            registerInit.phone=false;
        }
        if( val=="" ){
            console.log("不能为空");
            registerInit.phone=false;
        }
    });

    $("#user_code").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            console.log("no");
            registerInit.code=false;
        }else{
            console.log("ok");
            registerInit.code=true;
        }
    });
    $("#user_newPwd").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            console.log("no");
            registerInit.pwd=false;
        }
        if( registerReg.pwd.test(val) ){
            console.log("ok");
            registerInit.pwd=true;
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
            registerInit.pwd=false;
        }
    });
    $("#user_reNewPwd").blur(function(){
        var val=$(this).val();
        var pwd=$("#user_newPwd").val()
        if( val=="" ){
            console.log("no");
            registerInit.rePwd=false;
        }
        if( val==pwd ){
            console.log("ok");
            registerInit.rePwd=true;
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("密码不一致！");
            registerInit.rePwd=false;
        }
    });

    $("#regSub").click(function(){
        if( registerInit.name && registerInit.phone && registerInit.code && registerInit.pwd && registerInit.rePwd && registerInit.phoneHave && registerInit.nameHave){
            $(this).submit();
        }else{
            if (registerInit.name == true && registerInit.nameHave == false) {
                $(".tips").html("用户名已经存在，请更换");
            } else if (registerInit.phone == true && registerInit.phoneHave == false) {
                $(".tips").html("手机号码已被占用，请更换");
            } else {
                $(".tips").html("格式错误或有选项未填！");
            }
            $(".tips").stop().show(100).delay(3000).hide(100);
            return false;
        }
    });

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
        if( registerReg.phone.test(phone) ){
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
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
        }
    });

    //登录
    var loginInit={
        userName:false,
        userPwd:false,
        userHave:false,
    };

    var loginReg={
        num:/^\w{3,15}$/,//用户名正则 至少输入3个数字、下划线或字母字符
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/,//手机号
        pwd:/^[a-zA-Z0-9]{6,15}$/                 //必须且只含有数字和字母，6-15位
    };

	function userName(){
		var val=$("#user_name").val();
        if( loginReg.num.test(val) || loginReg.phone.test(val) ){
            console.log("ok");
            loginInit.userName=true;
            // if (loginReg.phone.test(val)) {
            //     var mytype = 1;
            // } else if (loginReg.num.test(val)) {
            //     var mytype = 2;
            // }
            // // 发送ajax请求
            // $.ajax({
            //     url: 'register_check',
            //     type: 'POST',
            //     dataType: 'json',
            //     data: {nameOrphone: val, type: mytype},
            //     success: function (res) {
            //         console.log(res);
            //         if (res.code == 400) {
            //             $(".tips").html("账号不存在");
            //             $(".tips").stop().show(100).delay(3000).hide(100);
            //             loginInit.userHave=false;
            //         } else {
            //             loginInit.userHave=true;
            //         }
            //     }
            // })
        }else{
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
            loginInit.userName=false;
        }
        if( val=="" ){
            console.log("不能为空");
            loginInit.userName=false;
        }
	}

    $("#user_name").blur(function(){
//     	userName();
    });

	function userPwd(){
		var val=$(this).val();
        if( loginReg.pwd.test(val) ){
            loginInit.userPwd=true
        }else{
            console.log("ok");
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("格式错误！");
            loginInit.userPwd=false;
        }
	}
    $("#user_pwd").blur(function(){
//     	userPwd();
    });

    $("#loginSub").click(function(){
    	userName();
    	userPwd();
        if( loginInit.userName && loginInit.userPwd){
            $(this).submit();
        }else{
            $(".tips").html("格式错误或有选项未填！");
            $(".tips").stop().show(100).delay(3000).hide(100);
            return false;
        }
    });
});



