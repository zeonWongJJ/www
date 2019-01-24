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
    <link rel="stylesheet" href="static/style_default/style/accountManage.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/accountManage.js"></script>
    <title>收款账号管理</title>
</head>
<body>

    <div class="contentContainer">
        <p class="pjoTitle">
            <a href="javascript:window.history.back();" style="top:0.45rem;"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>收款账号管理</span>
        </p>
        <!-- 支付渠道 -->
        <div class="payChannel">
            <ul>
                <li class="">
                    <p>储蓄卡</p>
                    <?php if (empty($a_view_data['user']['bank_number'])) { ?>
                    <a href="account_code-1">
                        <span>+&nbsp;&nbsp;添加银行卡</span>
                    </a>
                    <?php } else { ?>
                    <a href="account_code-1" style="display:none;">
                        <span>+&nbsp;&nbsp;添加银行卡</span>
                    </a>
                    <span class="cardAdmin" value="1">管理</span>
                    <div class="payCard yinlian">
                        <i><img src="static/style_default/images/yinlian.png" /></i>
                        <em>
                            <h1><?php echo $a_view_data['user']['bank_name']; ?></h1>
                            <span>储蓄卡</span>
                        </em>
                        <span><?php echo $a_view_data['user']['bank_realname']; ?></span>
                        <p><?php echo $a_view_data['user']['bank_number']; ?></p>
                    </div>
                    <?php } ?>
                </li>
                <li class="">
                    <p>支付宝</p>
                    <?php if (empty($a_view_data['user']['alipay_number'])) { ?>
                    <a href="account_code-2" style="display:block;">
                        <span>+&nbsp;&nbsp;添加支付宝</span>
                    </a>
                    <?php } else { ?>
                    <a href="account_code-2" style="display:none;">
                        <span>+&nbsp;&nbsp;添加支付宝</span>
                    </a>
                    <span class="cardAdmin" value="2">管理</span>
                    <div class="payCard zhifubao">
                        <i><img src="static/style_default/images/zhifubao1.png" /></i>
                        <em>
                            <h1>支付宝</h1>
                        </em>
                        <span><?php echo $a_view_data['user']['alipay_realname']; ?></span>
                        <p><?php echo $a_view_data['user']['alipay_number']; ?></p>
                    </div>
                    <?php } ?>
                </li>
                 <!-- 支付渠道 -->
                 <!---微信渠道-->
                 <li class="">
                    <p>微信</p>
                    <?php if (empty($a_view_data['user']['wx_openid'])) { ?>
                    <a href="account_code-3" style="display:block;">
                        <span>+&nbsp;&nbsp;添加微信</span>
                    </a>
                    <?php } else { ?>
                    <a href="account_code-3" style="display:none;">
                        <span>+&nbsp;&nbsp;添加微信</span>
                    </a>
                    <span class="cardAdmin" value="3">管理</span>
                    <div class="payCard weixin">
                        <i><img src="static/style_default/images/wwwa.png" /></i>
                        <em>
                            <h1>微信</h1>
                        </em>
                        <span><?php echo $a_view_data['user']['wx_nickname']; ?></span>
                        <p><?php echo $a_view_data['user']['wx_openid']; ?></p>
                    </div>
                    <?php } ?>
                </li>
                <!---微信渠道-->                
            </ul>
        </div>
       
        <!-- 底部 -->
        <div class="popbottom">
            <p></p>
            <p class="relieve">解除绑定</p>
            <p class="cancel">取消</p>
        </div>
        <!-- 底部 -->
    </div>

    <div class="lay"></div>
    <div class="tips"></div>
</body>
<script type="text/javascript">

</script>
</html>