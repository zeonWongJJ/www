<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-修改用户名</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_reviseName.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/setUp_reviseName.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="javascript:window.history.back();"><img src="static/style_default/images/kefu_03.png"/></a><i>修改用户名</i></header>
			<div class="intBox"><input type="text" name="user_nickname" placeholder="点击这里修改" value="<?php echo $a_view_data['user']['user_nickname']; ?>" /></div>
			<div class="submitBox1">
				<a href="javascript:;" class="submit">提交</a>
			</div>
		</div>
		<!--提交成功弹框开始-->
		<div class="successBomb1">提交成功</div>
		<!--提交成功弹框结束-->
		<!--提交失败弹框开始-->
		<div class="failBomb1">你还没输入用户名</div>
		<!--提交失败弹框结束-->

	</body>
</html>