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
    <link rel="stylesheet" href="static/style_default/style/income.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/flexible.js"></script>
    <title>月度收支明细</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 我的邀请 -->
    <div class="income">
        <p class="pjoTitle">
            <img src="static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='shopman_detail';" />
            <span>月度收支明细</span>
        </p>
        <div class="incomeInfo">
            <dl>
                <dt><?php echo date('Y-m', $a_view_data['time']); ?></dt>
                <dd>
                    <em>月消费</em>

                    <span>¥<?php echo $a_view_data['month_mony']; ?></span>
                </dd>
                &nbsp;
                <dd>
                    <em>月积分</em>

                    <span><?php echo $a_view_data['month_score']; ?></span>
                </dd>
            </dl>
            <a href="javascript:;" onclick="change_month()">
                <span>查看其他月份</span>
                <img src="static/style_default/images/shezhi_03.png" />
            </a>
        </div>
        <!-- 资金明细 -->
        <div class="incomeList">
            <dl>
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
    <!-- 我的邀请 -->
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
            myjson =  JSON.parse(json);
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
            command: 'showTimePicker'
        });
    }
}


</script>