<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/common.js"></script>
		<script src="static/style_default/script/setUp.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="nuser_center"><img src="static/style_default/images/yongping_03.png"/></a><i>设置</i></header>
			<div class="setList">
				<ul>
					<li class="safe"><a href="user_update">账户与安全<i></i></a></li>
					<li class="cache"><a href="javascript:;" onclick="dele();">清除图片缓存<s></s></a></li>
					<li class="suggestion"><a href="user_feedback">意见与反馈<i></i></a></li>
					<li class="suggestion"><a href="naddress">收货地址<i></i></a></li>
					<li class="notice clearfix">
						<a href="javascript:;">
							<p class="p1">推送通知</p>
							<p class="p2">包含订单状态、优惠促销等重要信息的推送</p>
							<b class="off <?php if ($a_view_data['user_ispush'] == 1) { echo 'on'; } ?>" value='<?php echo $a_view_data['user_ispush']; ?>'></b>
						</a>
					</li>
					<li class="about"><a href="about_our">关于v稻<i></i></a></li>
				</ul>
			</div>
			<div class="out">
				<a href="loginout">退出登录</a>
			</div>
		</div>
		<!--已清理缓存弹框开始-->
		<div class="cacheBomb">已清理缓存</div>
		<!--已清理缓存弹框结束-->
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
	function dele() {
		if (isAndroid) {
	        clearWebViewCache();
	    } else if (isiOS) {
	        window.webkit.messageHandlers.vdao.postMessage({
	            body: '',
	            callback: '',
	            command:'clearWebViewCache'
	        });
	    }
	}
</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script >
    //是否显示标题
    initTitleBarLayoutIsVisible(0);

    function loginout() {

    if (isAndroid || isiOS) {
        //获取账号列表
        var callbackSuccess = function(){
        	
        }
    }
    if (isAndroid) {
    	var  obj={"user_id":1}
        loginOut(obj,callbackSuccess);

    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'takeLocalUserList'
        });
    }
}
</script>