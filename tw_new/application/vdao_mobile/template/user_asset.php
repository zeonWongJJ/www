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
    <link rel="stylesheet" href="static/style_default/style/asset.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/common.js" type="text/javascript"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>用户资产</title>
 
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 总资产 -->
    <div class="asset">
        <p class="pjoTitle">
            <!--<img style="width:0.9rem; margin-top" src="static/style_default/images/yongping_03.png" onclick="javascript:window.location.href='user_center';" />-->
            <a onclick="javascript:window.location.href='user_center';"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>总资产</span>
        </p>
        <!-- 可用资产 -->
        <div class="assetContent">
            <a class="available">
                <p>可用资产（元）</p>
                <span><?php echo $a_view_data['user']['user_balance']; ?></span>
            </a>
            <a class="availBalance">
                <p>可用余额（元）</p>
                <span><?php echo $a_view_data['user']['user_balance']; ?></span>
            </a>
            <a class="availPoint">
                <p>可用积分（个）</p>
                <span><?php echo $a_view_data['user']['user_score']; ?></span>
            </a>
        </div>
        <!-- 可用资产 -->
        <!-- 金额体现 -->
        <div class="moneyNav">
            <a href="balance_recharge">
                <img src="static/style_default/images/zin_06.png" />
                <p>余额充值</p>
            </a>
            <a href="new_withdraw_balance-2">
                <img src="static/style_default/images/zin_03.png" />
                <p>余额提现</p>
            </a>
            <a href="new_withdraw_score-1">
                <img src="static/style_default/images/zin_09.png" />
                <p>积分提现</p>
            </a>
        </div>
        <!-- 金额体现 -->
    </div>
    <!-- 总资产 -->
    
    <!-- 底部导航 -->
    <?php echo $this->display('bottom'); ?>
    <!-- 底部导航 -->
   
</body>
 	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
	<?php } ?>
<script >
    //是否显示标题
    initTitleBarLayoutIsVisible(0); 
</script>
</html>