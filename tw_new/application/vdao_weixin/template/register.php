<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户注册</title>
</head>
<body>
	<h1>用户注册</h1>
	<form action="<?php echo $this->router->url('register'); ?>" method='post'>
		用户名：<input type="text" name="user_name"><br>
		密码：<input type="password" name="user_password"><br>
		确认密码：<input type="password" name="user_password2"><br>
		手机号码：<input type="text" name="user_phone"><br>
		验证码：<input type="text" name="user_code"><br>
		<input type="submit" value="注册">
	</form>
</body>
</html>