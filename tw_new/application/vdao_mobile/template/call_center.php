<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>客服中心</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/serviceCenter.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/common.js" type="text/javascript"></script>

	</head>
	<body>
        <!-- 拉框开始 -->
        <?php echo $this->display('head'); ?>
        <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="javascript:history.back(-1);"><img src="static/style_default/images/yongping_03.png"/></a><i>客服中心</i></header>
			<div class="online clearfix" >
				<a onclick="openCustomServiceWindow()">
				<div class="picBox"></div>
				<p class="h2">在线客服</p>
				<p class="h3">工作时间10:00-22:00</p>
				</a>
			</div>
			<div class="online phone clearfix">

				<a href="tel:18998301449" >
					<div class="picBox"></div>
					<p class="h2">电话客服</p>
					<p class="h3">工作时间10:00-22:00</p>
				</a>
			</div>
		</div>
	</body>
</html>
<script language="javascript" src="http://lyt.zoosnet.net/JS/LsJS.aspx?siteid=LYT42657310&lng=cn"></script>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script >
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    //调用原生窗口打开链接
    function openCustomServiceWindow() {
        //href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310"
        if (isAndroid) {
            var obj={"url":"http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310","showTitleType":2}
            createNewWindow(obj);
        } else if (isiOS) {
            var obj={"url":"http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310","showTitleType":2}
            obj = JSON.stringify(obj);
            window.webkit.messageHandlers.vdao.postMessage({
                body: obj,
                callback: '',
                command:'createNewWindow'
            });
        }
    }
</script>
