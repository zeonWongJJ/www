<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改密码</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>修改密码-通过旧密码方式</h1>
	<form action="<?php echo $this->router->url('user_password'); ?>" method='POST'>
		旧密码：<input type="password" name="password_old"><br>
		新密码：<input type="password" name="password_new"><br>
		<input type="hidden" name="type" value="1">
		<input type="submit" value="确认修改">
	</form>
</body>
</html>
