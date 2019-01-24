<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
<?php
	require_once(PROJECTPATH . "/libraries/weibo/config.php");
	require_once(PROJECTPATH . "/libraries/weibo/saetv2.ex.class.php");
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
	$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录</title>
</head>
<body>
	<h1>登录</h1>
	<form action="<?php echo $this->router->url('login'); ?>" method='post'>
		用户名：<input type="text" name="name_or_tel" placeholder="用户名或手机号码"><br>
		密码：<input type="password" name="user_password"><br>
		<input type="submit" value="登录">
	</form>
	<br>
	<a href="#" onclick="javascript:window.location.href='<?php echo $this->router->url('login_qq'); ?>'"><img src="./static/style_default/image/Connect_logo_7.png"></a>
	<br>
	<a href="#" onclick="javascript:window.location.href='https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect'"><img src="./static/style_default/image/icon24_wx_button.png">微信登录</a>
	<br>
	<a href="<?=$code_url?>"><img src="./static/style_default/image/weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" /></a>
	<br>
	<a href="<?php echo $this->router->url('register'); ?>">注册</a>
	<?php echo $_SESSION['user_name']; ?>
	<?php echo $_SESSION['user_id']; ?>
</body>
</html>