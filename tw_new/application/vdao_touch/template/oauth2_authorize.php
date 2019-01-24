<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>授权登录</title>
</head>
<body>


<?php if (!empty($_SESSION['user_id'])) { ?>

<h1>使用已登录账号</h1>

<form method="post">

	<label>你确定要用此账号【<?php echo $_SESSION['user_name']; ?>】登录IM系统吗？</label><br /><br />
	<input type="hidden" name="is_login" value="1">
	<input type="submit" name="authorized" value="yes">
	<input type="submit" name="authorized" value="no">
</form>

<?php } else { ?>

<h1>登录并授权</h1>

<form method="post">
	用户名：<input type="text" name="user_name"><br>
	密码：<input type="text" name="user_password"><br>
	<input type="hidden" name="is_login" value="2">
	<input type="hidden" name="authorized" value="yes">
	<input type="submit" value="登录并授权">
</form>

<?php } ?>

</body>
</html>