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
        <form action="login" method="post">
            <input type="text" id="user_name" name="name_or_tel" placeholder="用户名/手机号"/>
            <input type="password" id="user_pwd" name="user_password" placeholder="登录密码"/>
            <input type="hidden" name="oldurl" value="<?php echo $_GET['oldurl']; ?>">
            <a href="reset_password">忘记密码？</a>
            <input type="submit" id="loginSub" value="立即登录"/>
        </form>
        <!-- 其他方式登录 -->
        <div class="modeLogin" style="display:none;">
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
        <form action="register" method="post">
            <input type="hidden" name="user_referee" value="<?php if (!empty($_GET['userid'])) { echo $_GET['userid'];  } ?>">
            <input type="text" id="register_name" name="user_name" placeholder="用户名"/>
            <input type="text" id="user_phone" name="user_phone" placeholder="手机号"/>
            <input type="text" id="user_code" name="user_code" placeholder="验证码"/><input value="发送验证码" type="button" id="codeBtn" class="removeBtn">
            <input type="password" id="user_newPwd" name="user_password" placeholder="新登录密码"/>
            <input type="password" id="user_reNewPwd" name="user_password2" placeholder="重复输入登录密码"/>
            <input type="hidden" name="oldurl" value="<?php echo $_GET['oldurl']; ?>">
            <input type="submit" id="regSub" value="立即注册"/>
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
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>
$(".loginRegister").height( $(document).height() );

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
</script>