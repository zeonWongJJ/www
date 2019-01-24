<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改用户信息</title>
</head>
<body>
	<h1>修改用户信息</h1>
	<form action="<?php echo $this->router->url('user_update'); ?>" method='POST'>
		<input type="hidden" name="user_id" value="<?php echo $a_view_data['user_id']; ?>">
		用户名：<input type="text" name="user_name" value="<?php echo $a_view_data['user_name']; ?>"><br>
		性别：
		<select name="user_sex">
			<option value="1" <?php if ($a_view_data['user_sex'] == 1) { echo 'selected'; } ?>>男</option>
			<option value="2" <?php if ($a_view_data['user_sex'] == 2) { echo 'selected'; } ?>>女</option>
		</select>
		<br>
		年龄：<input type="number" name="user_age" value="<?php echo $a_view_data['user_age']; ?>"><br>
		手机：<input type="number" name="user_phone" value="<?php echo $a_view_data['user_phone']; ?>"><br>
		邮箱：<input type="text" name="user_email" value="<?php echo $a_view_data['user_email']; ?>"><br>
		积分：<input type="text" name="integral" value="<?php echo $a_view_data['user_score']; ?>"><br>
		<input type="submit" value="确定修改">
	</form>
</body>
</html>