<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-修改支付密码</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_revisePayPassword1.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/setUp_revisePayPassword1.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_update"><img src="static/style_default/images/kefu_03.png"/></a><i>修改支付密码</i></header>
			<form id="paymentform" action="update_payment" method="post">
			<div class="typeBox">
				<!--输入原密码开始-->
				<div class="one">
					<p class="tit">请输入原支付密码</p>
					<div class="intDiv clearfix">
						<input type="text" name="old1" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')" />
						<input type="text" name="old2" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="old3" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="old4" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="old5" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="old6" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
					</div>
					<div class="submitBox clearfix">
						<a href="javascript:;" class="submit">下一步</a>
					</div>
					<a href="reset_payment" class="forget">忘记支付密码</a>
				</div>
				<!--输入原密码结束-->
				<!--输入新密码开始-->
				<div class="two">
					<p class="tit">请输入新支付密码</p>
					<div class="intDiv clearfix">
						<input type="text" name="newone1" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newone2" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newone3" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newone4" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newone5" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newone6" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
					</div>
					<div class="submitBox">
						<a href="javascript:;" class="submit">下一步</a>
					</div>
				</div>
				<!--输入新密码结束-->
				<!--再次输入新密码开始-->
				<div class="three">
					<p class="tit">再次输入新支付密码</p>
					<div class="intDiv clearfix">
						<input type="text" name="newtwo1" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newtwo2" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newtwo3" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newtwo4" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newtwo5" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
						<input type="text" name="newtwo6" class="int" maxlength="1" onkeyup="value=value.replace(/[^\d]/g,'')"/>
					</div>
					<div class="submitBox">
						<a href="javascript:$('#paymentform').submit();" class="submit">确定</a>
					</div>
				</div>
				<!--再次输入新密码结束-->
			</div>
			</form>
		</div>
	</body>
</html>
