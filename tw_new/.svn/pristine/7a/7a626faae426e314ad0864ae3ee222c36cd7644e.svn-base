<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/invitation.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/flexible.js"></script>
    <title>邀请好友</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 邀请好友 -->
    <div class="invitation">
        <p class="pjoTitle">
            <img src="./static/style_default/images/kefu_03.png" onclick="javascript:window.location.href='user_center';" />
            <span>邀请好友</span>
        </p>
        <!-- 规则 -->
        <div class="rule">
            <div class="ruleContent">
                <p>
                    1.邀请您好友成为爽爽挝啡手机注册新用户，好友即可获赠10元优惠券（消费满20元可使用);
                </p>
                <p>
                    2.该好友成为爽爽挝啡用户且成功完成首次下单或充值(不低于10元消费)，您将获得25元优惠券(无最低消费限制)；
                </p>
                <p>
                    3.优惠券自当日领取即刻生效，有效时间为2个月；</p>
                <p>
                    4.本活动的最终解释权归爽爽挝啡所有。
                </p>
            </div>
            <p>活动时间：2017年10月1日-2017年10月31日</p>
        </div>
        <!-- 规则 -->
        <!-- 邀请方式 -->
        <div class="invitationMode">
            <p>
                <em></em>
                <span>邀请方式</span>
                <em></em>
            </p>
            <div class="modeContent">
                <a href="javascript:;" onclick="share_talk()">
                    <img src="./static/style_default/images/yh_03.png" />
                    <span>微信好友</span>
                </a>
                <a href="javascript:;" onclick="share_friends()">
                    <img src="./static/style_default/images/yh_05.png" />
                    <span>朋友圈</span>
                </a>
            </div>
        </div>
        <!-- 邀请方式 -->
    </div>
    <!-- 邀请好友 -->
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

// 分享到朋友圈
function share_friends() {
    if (isAndroid || isiOS) {
        var shareContent = "<?php echo get_config_item('domain').'/login?userid='. $_SESSION['user_id']; ?>";
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "friends",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : '快来和我一起赚钱',
            "content"       : "一键免费开店，无人自动化管理"
        }
    }
    if (isAndroid) {
        shareToThirdApp(json);
    } else if (isiOS){
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body: json,
            callback: '',
            command:'shareToThirdApp'
        });
    }
}

// 分享到好友
function share_talk() {
    if (isAndroid || isiOS) {
        var shareContent = "<?php echo get_config_item('domain').'/login?userid='. $_SESSION['user_id']; ?>";
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "talk",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : '快来和我一起赚钱',
            "content"       : "一键免费开店，无人自动化管理"
        }
    }
    if (isAndroid) {
        shareToThirdApp(json);
    } else if (isiOS){
       json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body: json,
            callback: '',
            command:'shareToThirdApp'
        });
    }
}

</script>