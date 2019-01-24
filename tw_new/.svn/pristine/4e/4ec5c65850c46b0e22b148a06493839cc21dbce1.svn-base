<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/AuthenNameSuccess.css"/>
    <title></title>
</head>
<body>
    <!--  实名认证成功 -->
    <div class="authNameSucc">
        <i class="">
            <img src="../img/authnameSucc.png" alt=""/>
        </i>
        <div class="authInfo">
            <h3>恭喜！银行卡认证成功</h3>
        </div>
        <ul>
            <li>
                <span>认证身份:</span>
                <em>个人</em>
            </li>
            <li>
                <span>真实姓名:</span>
                <em><?php echo $a_view_data['realname']; ?></em>
            </li>
            <li>
                <span>证件号:</span>
                <em><?php echo $a_view_data['id_number']; ?></em>
            </li>
            <li>
                <span>手持身份证照片:</span>
                <em>已做隐私处理，不显示具体内容</em>
            </li>
        </ul>
        <div class="authFun">
            <a href="<?php echo $this->router->url('bankcard_verification'); ?>">
                <span>去绑定银行卡</span>
            </a>
            <a href="<?php echo $this->router->url('user_index'); ?>">
                <i>
                    <img src="../img/border.png" alt=""/>
                    <span>返回个人中心</span>
                </i>
            </a>
        </div>
    </div>
    <!--  实名认证成功 -->
</body>
</html>