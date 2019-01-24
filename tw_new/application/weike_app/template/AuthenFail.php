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
    <link rel="stylesheet" href="../css/AuthenFail.css"/>
    <title></title>
</head>
<body>
    <!-- 银行卡验证失败 -->
    <div class="authFail">
        <i class="">
            <img src="../img/fail.png" alt=""/>
        </i>
        <div class="authInfo">
            <h3>银行卡认证不通过！</h3>
            <h4 style="color:#666666">原因：银行卡信息错误</h4>
        </div>
        <ul>
            <li>
                <span>认证身份:</span>
                <em>个人</em>
            </li>
            <li>
                <span>真实姓名:</span>
                <em><?php echo $a_view_data['account_name']; ?></em>
            </li>
            <li>
                <span>开户行:</span>
                <em><?php echo $a_view_data['bank_name']; ?></em>
            </li>
            <li>
                <span>开户卡号:</span>
                <em><?php echo $a_view_data['card_number']; ?></em>
            </li>
            <li>
                <span>开户支行:</span>
                <em><?php echo $a_view_data['bank_address']; ?></em>
            </li>
        </ul>
        <div class="authFun">
            <a href="<?php echo $this->router->url('bankcard_again'); ?>">
                <span>重新认证</span>
            </a>
            <a href="">
                <i>
                    <img src="../img/border.png" alt=""/>
                    <span>暂不认证</span>
                </i>
            </a>
        </div>
    </div>
    <!-- 银行卡验证失败 -->
</body>
</html>