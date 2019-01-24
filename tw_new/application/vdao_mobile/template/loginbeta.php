<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>登录</title>
    <link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
    <link href="./static/style_default/style/loginBeta.css" rel="stylesheet" type="text/css">
    <script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    <!--<script src="script/APPlogin.js"></script>-->
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 登录 -->
    <div class="login">
        <!--<img class="closeLogin" src="images/lore_11.png" alt=""/>-->
        <i><img src="images/llog_03.png" alt=""/></i>
        <form action="login" method="post">
            <input type="text" id="user_name" name="user_name" placeholder="用户名/手机号"/>
            <input type="password" id="user_pwd" name="user_password" placeholder="登录密码"/>
            <a href="reset_password">忘记密码？</a>
            <input type="submit" id="loginSub" value="立即登录"/>
        </form>
        <!-- 其他方式登录 -->
        <div class="modeLogin">
            <p>-其他方式登录-</p>
            <a href='https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect'>微信登录</a>
            <a href="login_qq">QQ登录</a>
        </div>
        <!-- 其他方式登录 -->
    </div>
    <!-- 登录 -->
    <!-- 提示层 -->
    <div class="tips"></div>
    <!-- 弹出层 -->
    <!--<div class="lay"></div>-->
</body>
</html>