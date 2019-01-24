<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>登录与注册</title>
    <link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
    <link href="./static/style_default/style/APPlogin.css" rel="stylesheet" type="text/css">
    <script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="./static/style_default/script/APPlogin.js"></script>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 登录注册 -->
    <div class="loginRegister">
        <a href='index'><img src="./static/style_default/images/lore_03.png" alt=""/></a>
        <i class="logo"><img src="./static/style_default/images/llog_03.png" alt=""/></i>
        <div class="kip">
            <span>NATIONWIDE ENTREPRENEURSHIP</span>
            <h1>万众创新、全民创业.</h1>
            <div class="lgBox">
                <span class="loginBtn">登录</span>
                <span class="registerBtn">注册</span>
            </div>
        </div>
        <p>
            <span>*登录即表示您同意</span>
            <a>《用户服务协议》</a>
        </p>
    </div>
    <!-- 登录注册 -->

    <!-- 登录 -->
    <div class="login">
        <img class="closeLogin" src="./static/style_default/images/lore_11.png" alt=""/>
        <i><img src="./static/style_default/images/llog_03.png" alt=""/></i>

        <form  id="loginform" method="post">
            <input type="text" id="user_name" name="name_or_tel" placeholder="用户名/手机号"/>
            <ul class="userBox"></ul>
            <input type="password" id="user_pwd" name="user_password" placeholder="登录密码"/>
            <input type="hidden" name="oldurl" value="<?php echo $_GET['oldurl']; ?>">
            <input type="hidden" name="issave" value="0">
            <a href="reset_password">忘记密码？</a>
            <span class="remeberPwd">
            	<img src="./static/style_default/images/redbag_10.png" />
            	<span>记住密码</span>
            </span>
            <input type="submit" id="loginSub" class="loginsubmit" value="立即登录"/>
        </form>
        <!-- 其他方式登录 -->
        <div class="modeLogin">
            <p>-其他方式登录-</p>
            <a href='javascript:;' onclick="login_weixin()">微信登录</a>
            <a href="login_qq.html<?php if (!empty($_GET['userid']) && !empty($_GET['oldurl'])) {
                echo '?userid=' . $_GET['userid'].'&oldurl='.$_GET['oldurl'];
            } elseif (!empty($_GET['userid'])) {
                echo '?userid=' . $_GET['userid'];
            } elseif (!empty($_GET['oldurl'])) {
                echo '?oldurl=' . $_GET['oldurl'];
            } ?>">QQ登录</a>
        </div>
        <!-- 其他方式登录 -->
    </div>
    <!-- 登录 -->
    <!-- 注册 -->
    <div class="register">
        <img class="closeRegister" src="./static/style_default/images/lore_11.png"/>
        <i><img src="./static/style_default/images/llog_03.png" alt=""/></i>
        <form  id="regform" method="post">
            <input type="hidden" name="user_referee" value="<?php if (!empty($_GET['userid'])) { echo $_GET['userid'];  } ?>">
            <input type="text" id="register_name" name="user_name" placeholder="用户名"/>
            <input type="text" id="user_phone" name="user_phone" placeholder="手机号"/>
            <input type="text" id="user_code" name="user_code" placeholder="验证码"/><input value="发送验证码" type="button" id="codeBtn" class="removeBtn">
            <input type="password" id="user_newPwd" name="user_password" placeholder="新登录密码"/>
            <input type="password" id="user_reNewPwd" name="user_password2" placeholder="重复输入登录密码"/>
            <input type="hidden" name="oldurl" value="<?php echo $_GET['oldurl']; ?>">
            <input type="submit" id="regSub" class="registersubmit" value="立即注册"/>
        </form>
    </div>
    <!-- 注册 -->
    <!-- 提示层 -->
    <div class="tips"></div>
    <!-- 弹出层 -->
    <div class="lay"></div>
</body>
</html>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>


var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
// 跳转链接
var oldurl = $("input[name='oldurl']").val();
// 微信登录
function login_weixin() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(response){
   
            if (response != '') {
                $.ajax({
                    url: 'login_weixin',
                    type: 'POST',
                    dataType: 'json',
                    data: {response: response},
                    success: function (res) {
                    	
                        if (res.code == 200) {
                            if (oldurl != '') {
                                window.location.href = oldurl;
                            } else {
                                window.location.href = 'user_center';
                            }
                        }
                    }
                })
            }
        }
    }
    if (isAndroid) {
        wxAuthorizationLogin(callbackSuccess);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'wxAuthorizationLogin'
        });
    } else {
        window.location.href = "https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect";
    }
}



$(function(){
    /*$(document).live("click","#user_name",function(){
    	console.log("test");
    	choose_user();
    });*/
    choose_user();
})

function choose_user() {
    if (isAndroid || isiOS) {


        // var callbackSuccess = function(userArray) {
        //     // alert(userArray);
        //     // console.log(userArray);
        //     var myuserArray = JSON.parse(userArray);
        //     $(".userBox").children('li').remove();
        //     for (var i = 0; i < myuserArray.length; i++) {
        //
        //         $(".userBox").append('<li data-status="'+myuserArray[i].issave+'"  data-value="'+myuserArray[i].user_password+'" onclick="check_thisuser('+i+')" id="user_cook_'+i+'">'+myuserArray[i].user_name+'</li>');
        //
        //         // $(".userBox").append('<li name="userData" data-value="'+myuserArray[i].user_password+'" onclick="check_thisuser('+i+')" id="user_cook_'+i+'">'+myuserArray[i].user_name+'</li>');
        //         /*$('#user_cook_'+i).click(function () {
        //             //alert($('#user_cook_1')
        //             alert( $( "input[name='userData']" ) );
        //         });*/
        //
        //     }
        // }
    }
    if (isAndroid) {
        takeLocalUserList(callbackSuccess);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'takeLocalUserList'
        });
    }
}
//点击账号显示记住密码
$(".userBox>li").live("click",function(){
	if( $("input[name='issave']").val()=="0" ){
		$(".remeberPwd").removeClass("rwCur");
		$(".remeberPwd").children("img").attr("src","./static/style_default/images/redbag_10.png");
		$("input[name='issave']").val('0')
	}else{
		$(".remeberPwd").addClass("rwCur");
		$(".remeberPwd").children("img").attr("src","./static/style_default/images/redbag_06.png");
		$("input[name='issave']").val('1')
	}
	/*$(".remeberPwd").addClass("rwCur");
	$(".remeberPwd").children("img").attr("src","./static/style_default/images/redbag_06.png");
	$("input[name='issave']").val('1');*/
})

function check_thisuser(ui) {
    var thisuser = $("#user_cook_"+ui).text();
    var userpwd = $("#user_cook_"+ui).attr('data-value');
    var issave = $("#user_cook_"+ui).attr('data-status');
    $("#user_name").val(thisuser);
    $("#user_pwd").val(userpwd);
    if( userpwd=="" ){
    	$(".remeberPwd").removeClass("rwCur");
		$(".remeberPwd").children("img").attr("src","./static/style_default/images/redbag_10.png");
    	$("input[name='issave']").val('0');
    }else{
    	$(".remeberPwd").addClass("rwCur");
		$(".remeberPwd").children("img").attr("src","./static/style_default/images/redbag_06.png");
    	$("input[name='issave']").val('1');

    }

}
// function  AutoLogin(username,password){
//     // alert(password);
//     if(username != ""&& password !="" ) {
//         $.post(
//             'login',
//             'name_or_tel='+username+"&user_password="+password,
//             function(res){
                    
//                 if (res.status ==1) {
//                      window.location.href = 'user_center';
//                      return false;
//                 } 
              
//         },'json');
//     }
//     return false;
// }

    // 登陆post提交
$('.loginsubmit').click(function(){
        $.post(
            'login',
            $("#loginform").serialize(),
            function(res){
                    
                if (res.status ==1) {
                     window.location.href = 'user_center';
                     return false;
                } else {
                   alert(res.msg); 
                }
              
        },'json');
    return false;
});

// 注册post提交
$('.registersubmit').click(function(){
        $.post(
            'register',
            $("#regform").serialize(),
            function(res){
                    alert(res.msg);
                if (res.status ==1) {
                     window.location.href = 'login';
                     return false;
                }
              
        },'json');
    return false;
});


</script>