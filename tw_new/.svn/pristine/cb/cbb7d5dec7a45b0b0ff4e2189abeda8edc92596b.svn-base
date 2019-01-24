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
    <link rel="stylesheet" href="../css/AuthenWait.css"/>
    <title></title>
</head>
<body>
    <!-- 银行卡已提交审核 等待中-->
    <div class="authWait">
        <div class="waitInfo">
            <p>您的银行卡认证已提交审核</p>
            <p>请耐心等待...</p>
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
        <!-- 返回个人中心 -->
        <div class="backToCenter">
            <a href="<?php echo $this->router->url('user_index'); ?>">
                <span>返回个人中心</span>
            </a>
        </div>
        <!-- 返回个人中心 -->
    </div>
    <!-- 银行卡已提交审核 等待中-->
</body>
</html>