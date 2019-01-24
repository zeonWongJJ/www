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
    <link rel="stylesheet" href="static/style_default/style/balance1.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/flexible.js"></script>
    <script src="static/style_default/script/balance1.js"></script>
    <title>余额提现</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 余额提现  -->
    <div class="balanceCash">
        <p class="pjoTitle">
            <!--<img src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_asset';" />-->
            <a class="back" onclick="javascript:window.location.href='user_center';"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>总资产</span>
        </p>
        <!-- 支付方式 -->
        <a class="payMethod">
            <em class="zhifubao">
                <img src="static/style_default/images/zhifubao_03.png" />
                <span>支付宝</span>
            </em>
            <img src="static/style_default/images/shezhi_03.png" />
        </a>
        <!-- 支付方式 -->
        <!-- 提现积分 -->
        <form action="withdraw_score" method="post">
            <input type="hidden" name="withdraw_type" value="1">
            <div class="balanceContent">
                <h1>提现积分（提现金额不得小于0.1元）</h1>
                <input type="text" name="withdraw_score" id="point" onkeyup="value=value.replace(/[^\d]/g,'')"/>
                <p>
                    <span>可提现积分<?php echo $a_view_data['user']['user_score']; ?> (1积分=<?php echo $a_view_data['set']; ?>元)</span>
                    <a href="javascript:;" onclick="withdraw_all(<?php echo $a_view_data['user']['user_score']; ?>)">全部提现</a>
                </p>
            </div>

           <ul class="payList">
                <li class="withdraw_account">
                    <span>提现账号：</span>
                    <input type="text" name="withdraw_account">
                </li>
                <li class="withdraw_name">
                    <span>真实姓名：</span>
                    <input type="text" name="withdraw_name">
                </li>
                <li class="payment_code">
                    <span>支付密码：</span>
                    <input type="text" name="payment_code">
                </li>
                <li class="open_bank">
                    <span>开户行名称：</span>
                    <input type="text" name="open_bank">
                </li>
                <li class="prov">
                    <span>收款人开户行所在省:</span>
                    <input type="text" name="prov">
                </li>
                <li class="city">
                    <span>收款人开户行所在地区:</span>
                    <input type="text" name="city">
                </li>
                <li class="sub_bank">
                    <span>开户支行名称:</span>
                    <input type="text" name="sub_bank">
                </li>
           </ul>

            <p class="balanceText">预计2小时内到账</p>
            <input type="submit" id="balanceSub" value="确定"/>
        </form>
        <!-- 提现积分 -->

        <!-- 选择收款账户 -->
        <div class="lay"></div>
        <div class="choiceAccout">
            <dl>
                <dt>
                    <span>选择收款账户</span>
                    <img class="closeAccount" src="static/style_default/images/y_03.png" />
                </dt>
                <dd class="zhifubao" value="1">
                    <img src="static/style_default/images/zhifubao_03.png" />
                    <span>支付宝</span>
                </dd>
                <dd class="yinhangka" value="2">
                    <img src="static/style_default/images/y_07.png" />
                    <span>银行卡</span>
                </dd>
                <dd class="weixin" style="display:none;">
                    <img src="static/style_default/images/weChat_03.png" />
                    <span>微信</span>
                </dd>
            </dl>
        </div>
        <!-- 选择收款账户 -->
    </div>
    <!-- 余额提现  -->
</body>
</html>

<script>

function withdraw_all(withdraw_score) {
    $("input[name='withdraw_score']").val(withdraw_score);
}

</script>