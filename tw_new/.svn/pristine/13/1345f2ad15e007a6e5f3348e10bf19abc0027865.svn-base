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
        <form action="withdraw_balance" method="post">
            <input type="hidden" name="withdraw_type" value="1">
            <div class="balanceContent">
                <h1>提现金额（提现金额不得小于0.1元）</h1>
        <!--         <input type="text" name="withdraw_money" id="point" onkeyup="value=value.replace(/[^\d]/g,'')"/> -->
                <input type="text" name="withdraw_money" id="point" onkeyup="clearNoNum(this)" />
                <p>
                    <span>可提现金额<?php echo $a_view_data['user']['user_balance']; ?></span>
                    <a href="javascript:;" onclick="withdraw_all(<?php echo $a_view_data['user']['user_balance']; ?>)">全部提现</a>
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

function withdraw_all(withdraw_money) {
    $("input[name='withdraw_money']").val(withdraw_money);
}


function clearNoNum(obj){
    // 修复第一个字符是小数点 的情况.
    if(obj.value !='' && obj.value.substr(0,1) == '.'){
        obj.value="";
    }
    obj.value = obj.value.replace(/^0*(0\.|[1-9])/, '$1'); //解决 粘贴不生效
    obj.value = obj.value.replace(/[^\d.]/g,"");  // 清除“数字”和“.”以外的字符
    obj.value = obj.value.replace(/\.{2,}/g,"."); // 只保留第一个. 清除多余的
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); // 只能输入两个小数
    if(obj.value.indexOf(".") < 0 && obj.value !=""){
        // 以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
        if(obj.value.substr(0,1) == '0' && obj.value.length == 2){
            obj.value= obj.value.substr(1,obj.value.length);
        }
    }
}

</script>