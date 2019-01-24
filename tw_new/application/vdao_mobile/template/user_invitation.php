<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <meta content="yes" name="apple-touch-fullscreen">
        <title>V稻前台首页</title>
        <link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
        <link href="static/style_default/style/friend.css" rel="stylesheet" type="text/css">
        <script src="static/style_default/script/flexible.js" type="text/javascript"></script>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="static/style_default/script/common.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="main">
            <p class="pjoTitle">
                <a href="nuser_center" style="top:0;">
                	<img style="width:0.7rem; margin-top:0.45rem;" src="static/style_default/images/yongping_03.png" alt=""/>
                </a>
                <span>邀请好友</span>
            </p>
            <div class="rec">
                <a>
                    <span>成功推荐<em><?php echo $a_view_data['referee_count']?></em>人</span>
                </a>
            </div>
            <a class="balance">
                <img src="static/style_default/images/bvaa_03.png" alt=""/>
            </a>
            <div class="activity">
                <dl>
                    <dt>
                        <a>
                            <img src="static/style_default/images/gfda.png" alt=""/>
                            <span>活动规则</span>
                        </a>
                    </dt>
                    <dd>
                        <i>1</i>
                        <span>邀请好友成功后，即永久锁定为你的推荐用户，赶紧先人一步，抢占好友 -》</span>
                    </dd>
                    <dd>
                        <i>2</i>
                        <span>当你成为移动店主后，邀请的好友消费，你将获得积分返利，一个积分价值一人民币，可以提现^_^</span>
                    </dd>
                </dl>
            </div>
            <div class="share">
                <a href="javascript:;" onclick="share_talk()">
                    <img src="static/style_default/images/wwx.png" alt=""/>
                    <span>分享给微信好友</span>
                </a>
                <a href="javascript:;" onclick="share_friends()">
                    <img src="static/style_default/images/ppa.png" alt=""/>
                    <span>分享给微信朋友圈</span>
                </a>
                <a href="javascript:;" onclick="">
                    <!--<img src="static/style_default/images/ppa.png" alt=""/>-->
                    <span style="color:#0ebd00">复制链接</span>
                </a>
            </div>
        </div>
    </body>
</html>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 分享到朋友圈
function share_friends() {
    if (isAndroid || isiOS) {
        var shareContent = "<?php echo get_config_item('domain').'/share?userid='. $_SESSION['user_id']; ?>";
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "friends",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : '好吃的流口水，尽在“V稻”',
            "content"       : "企擎旗下美味平台，自己吃省钱，分享能赚钱"
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
        var shareContent = "<?php echo get_config_item('domain').'/share?userid='. $_SESSION['user_id']; ?>";
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "talk",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : '好吃的流口水，尽在“V稻”',
            "content"       : "企擎旗下美味平台，自己吃省钱，分享能赚钱"
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
