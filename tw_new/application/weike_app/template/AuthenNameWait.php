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
    <link rel="stylesheet" href="../css/AuthenNameWait.css"/>
    <title></title>
</head>
<body>
    <!-- 实名认证已提交 请等待 -->
    <div class="authNameWait">
        <div class="waitInfo">
            <p>您的实名认证已提交审核</p>
            <p>请耐心等待...</p>
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
        <!-- 返回个人中心 -->
        <div class="backToCenter">
            <a href="<?php echo $this->router->url('user_index'); ?>">
                <span>返回个人中心</span>
            </a>
        </div>
        <!-- 返回个人中心 -->
    </div>
    <!-- 实名认证已提交 请等待 -->
</body>
</html>