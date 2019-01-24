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
		<link href="static/style_default/style/setUp_forgetPayPassword.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/setUp_forgetPayPassword.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_update"><img src="static/style_default/images/kefu_03.png"/></a><i>修改支付密码</i></header>
			<form id="paymentform" action="reset_payment" method="post">
			<input type="hidden" name="user_phone" value="<?php echo $a_view_data['user_phone']; ?>">
			<div class="typeBox">
				<!--第一步开始-->
				<div class="one">
					<div class="fillBox">
						<ul>
							<li class="callNum">验证码将发送到手机 <?php echo substr_replace($a_view_data['user_phone'], '****', 3, 4); ?></li>
							<li class="testCode">
								<input type="text" name="user_code" placeholder="验证码"/>
								<i class="send">发送验证码</i>
								<i class="sendAgain">重新发送</i>
								<i class="time"><s>60</s>S</i>
							</li>
						</ul>
					</div>
					<div class="submitBox">
						<a href="javascript:;" class="submit">下一步</a>
					</div>
				</div>
				<!--第一步结束-->
				<!--第二步开始-->
				<div class="two">
					<p class="tit">请输入新支付密码</p>
					<div class="intDiv clearfix">
						<input type="text" name="newone1" class="int" maxlength="1"/>
						<input type="text" name="newone2" class="int" maxlength="1"/>
						<input type="text" name="newone3" class="int" maxlength="1"/>
						<input type="text" name="newone4" class="int" maxlength="1"/>
						<input type="text" name="newone5" class="int" maxlength="1"/>
						<input type="text" name="newone6" class="int" maxlength="1"/>
					</div>
					<div class="submitBox">
						<a href="javascript:;" class="submit">下一步</a>
					</div>
				</div>
				<!--第二步结束-->
				<!--第三步开始-->
				<div class="three">
					<p class="tit">再次输入新支付密码</p>
					<div class="intDiv clearfix">
						<input type="text" name="newtwo1" class="int" maxlength="1"/>
						<input type="text" name="newtwo2" class="int" maxlength="1"/>
						<input type="text" name="newtwo3" class="int" maxlength="1"/>
						<input type="text" name="newtwo4" class="int" maxlength="1"/>
						<input type="text" name="newtwo5" class="int" maxlength="1"/>
						<input type="text" name="newtwo6" class="int" maxlength="1"/>
					</div>
					<div class="submitBox">
						<a href="javascript:$('#paymentform').submit();" class="submit">确定</a>
					</div>
				</div>
				<!--第三步结束-->
			</div>
			</form>
		</div>
	</body>
</html>
