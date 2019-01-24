<?php
    $seconds_to_cache = 1800;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    header("Expires: $ts"); header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");
?>
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
    <link rel="stylesheet" href="static/style_default/style/amountRechange.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/flexible.js"></script>
    <script src="static/style_default/script/amountRechange.js"></script>
    <title>余额充值</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 余额充值  -->
    <div class="amountRechange">
        <p class="pjoTitle">
            <!--<img style="margin-top:0.4rem;" src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_balance';" />-->
            <a class="back" onclick="javascript:window.location.href='user_center';"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>余额充值</span>
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
        <!-- 充值金额 -->
        <form action="balance_recharge" method="post">
            <div class="rechangeContent">
                <input type="hidden" name="pay_type" value="1">
                <h1>充值金额</h1>
                <span>￥</span>
                <!-- <input type="text" name="recharge_money" id="rechange" onkeyup="value=value.replace(/[^\d]/g,'')"/> -->
                <input type="text" id="rechange" name="recharge_money" onkeyup="clearNoNum(this)" />
            </div>
            <input type="submit" id="rechangeSub" value="确定"/>
        </form>
        <!-- 充值金额 -->

        <!-- 选择支付方式 -->
        <div class="lay"></div>
        <div class="choiceAccout">
            <dl>
                <dt>
                    <span>选择支付方式</span>
                    <img class="closeAccount" src="static/style_default/images/y_03.png" />
                </dt>
                <dd class="zhifubao" value="1">
                    <img src="static/style_default/images/zhifubao_03.png" />
                    <span>支付宝</span>
                </dd>
                <dd class="weixin" value="2">
                    <img src="static/style_default/images/weChat_03.png" />
                    <span>微信</span>
                </dd>
                <dd class="yinhangka" value="3">
                    <img src="static/style_default/images/y_07.png" />
                    <span>银行卡</span>
                </dd>
            </dl>
        </div>
        <!-- 选择支付方式 -->
    </div>
    <!-- 余额充值   -->
</body>
</html>

<script>

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


$(function(){
    var timer = window.setInterval("weixin_ispay()", 1000);
    $(".amountRechange").height( $(document).height() );
})

function weixin_ispay(){
    var pay_type = $("input[name='pay_type']").val();
    if (pay_type == 2) {
        $.ajax({
            url: 'weixin_ispay_ban',
            type: 'POST',
            dataType: 'json',
            data: {pay_type: pay_type},
            success: function(res) {
                console.log(res.code)
                if (res.code == 200) {
                    window.location.href = "user_balance";
                }
            }
        })
    }
}

</script>