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
        <link href="static/style_default/style/stageIndex.css" rel="stylesheet" type="text/css">
        <script src="static/style_default/script/flexible.js" type="text/javascript"></script>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
    </head>
    <body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
        <div class="main">
            <div class="pic">
                <img src="static/style_default/images/shouye_02.png"/>
                <a class="title1" href="product_category">不指定店铺预订咖啡</a>
                <a class="title2" href="javascript:;" onclick="store_showlist()">附近V稻店铺</a>
                <a class="title3" href="notice_showlist">公告</a>
                <a class="title4" href="news_showlist">新闻</a>
                <a class="title3" href="join_apply">加盟</a>
                <a class="title4" href="share_order">列表</a>
            </div>
        </div>
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

function store_showlist() {
    if (isAndroid) {
        openNearStoreList();
    } else if (isiOS){
        location.href = 'protocolHead://storeshowlist_?124';
    }
}

</script>