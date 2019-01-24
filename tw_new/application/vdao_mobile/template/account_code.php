<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/addCard.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/addzhifubao.js"></script>
    <title></title>
</head>
<body>

    <div class="contentContainer">
        <p class="pjoTitle">
            <a href="javascript:window.history.back();" style="top:0.45rem;"><img src="static/style_default/images/kefu_03.png" /></a>
            <span><?php if ($this->router->get(1) == 1) {
                echo '添加银行卡';
            } else if($this->router->get(1) == 3) {
                echo '添加微信号';
            } else {
                echo '添加支付宝';
            } ?></span>
        </p>
        <!-- 表单 -->
        <div class="formContainer">
            <form action="" method="post">
                <input type="hidden" id="user_phone" name="user_phone" value="<?php echo $a_view_data['user']['user_phone']; ?>">
                <input type="hidden" id="go_type" name="go_type" value="<?php echo $this->router->get(1); ?>">
                <dl>
                    <dt>为了您的账户安全，请完成身份验证</dt>
                    <dd>
                        <span>手机号</span>
                        <em>
                        <?php echo substr_replace($a_view_data['user']['user_phone'],'****',3,4); ?>
                        </em>
                    </dd>
                    <dd>
                        <span>验证码</span>
                        <input type="text" id="code" placeholder="请输入验证码" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />|
                        <input style="margin-left:0.4rem; color:#fbb400;" value="获取验证码" type="button" id="codeBtn" class="removeBtn">
                    </dd>
                </dl>
                <input type="button" id="codeSub" value="确定"/>
            </form>
        </div>
    </div>
    <div class="tips"></div>
</body>

</html>