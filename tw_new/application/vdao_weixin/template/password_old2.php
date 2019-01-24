<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-修改密码</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_revisePassword1.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/setUp_revisePassword1.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_update"><img src="static/style_default/images/kefu_03.png"/></a><i>修改密码</i></header>
			<div class="fillBox">
				<form id="passwordform" action="user_password" method="post">
				<input type="hidden" name="type" value="1">
				<ul>
					<li>
						<div>
							<span>输入旧密码</span>
							<input type="password" class="int" name="password_old" placeholder="请输入旧密码"/>
							<i class="openEye"><img src="static/style_default/images/huiyan_03.png"/></i>
							<i class="closeEye"><img src="static/style_default/images/huiyan_06.png"/></i>
						</div>
					</li>
					<li>
						<div>
							<span>输入新密码</span>
							<input type="password" class="int" name="password_new" placeholder="请输入新密码"/>
							<i class="openEye"><img src="static/style_default/images/huiyan_03.png"/></i>
							<i class="closeEye"><img src="static/style_default/images/huiyan_06.png"/></i>
						</div>
					</li>
				</ul>
				</form>
			</div>
			<div class="forget clearfix">
				<a href="reset_password">忘记登录密码</a>
			</div>
			<div class="submitBox">
				<a href="javascript:$('#passwordform').submit();" class="submit">确定</a>
			</div>
		</div>

	</body>
</html>
