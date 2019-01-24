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
    <link rel="stylesheet" href="static/style_default/style/shopkeeper.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>我是店主</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我是店主 -->
    <div class="shopkeeper">
        <p class="pjoTitle">
            <!--<img src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_center';" />-->
            <a class="back" onclick="javascript:window.location.href='user_center';"><img src="static/style_default/images/yongping_03.png" /></a>
            <span>我是店主</span>
            <a class="yaoqing" href="user_referee">我的邀请</a>
        </p>
        <!-- 消费总额 -->
        <div class="spendingContent">
            <a class="available">
                <p>今日消费总额</p>
                <span><?php echo $a_view_data['today_mony']; ?></span>
            </a>
            <a class="availBalance">
                <p>月订单消费总额(元)</p>
                <span><?php echo $a_view_data['month_mony']; ?></span>
            </a>
            <a class="availPoint">
                <p>月积分总数（分）</p>
                <span><?php echo $a_view_data['month_score']; ?></span>
            </a>
        </div>
        <!-- 消费总额 -->
        <!-- 资金明细 -->
        <div class="capital">
            <dl>
                <dt>
                    <span>本月积分明细</span>
                    <a href="javascript:;" onclick="change_month()">
                        <span>查看其他月份</span>
                        <img src="static/style_default/images/shezhi_03.png" />
                    </a>
                </dt>
                <?php foreach ($a_view_data['order'] as $key => $value): ?>
                <dd>
                    <a href="javascript:;">
                        <?php if (empty($value['user_pic'])) {
                            echo '<img src="static/style_default/images/tou_03.png" />';
                        } else {
                            echo '<img src="'.$value['user_pic'].'" />';
                        } ?>
                        <em>
                            <span><?php echo $value['user_name']; ?>消费</span>
                            <em><?php echo date('Y-m-d', $value['time_create']); ?></em>
                        </em>
                        <dfn>
                            <span>+<?php echo $value['order_commission']; ?></span>
                            <em><?php echo $value['order_commission']; ?></em>
                        </dfn>
                    </a>
                </dd>
                <?php endforeach ?>
            </dl>
        </div>
        <!-- 资金明细 -->
    </div>
    <!-- 我是店主 -->
</body>
</html>


<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

function change_month() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(json){
            var myjson =  JSON.parse(json);
            var mytime = (myjson.timeStamp)/1000;
            // 页面跳转
            window.location.href = 'shopman_income-'+mytime;
        }
    }
    if (isAndroid) {
        showTimePicker(callbackSuccess);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'showTimePicker'
        });
    }
}


</script>