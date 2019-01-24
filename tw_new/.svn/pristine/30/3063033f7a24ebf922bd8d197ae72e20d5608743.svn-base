<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加管理员</title>
</head>
<body>
	<h1>添加管理员</h1>
	<form action="<?php echo $this->router->url('manager_add'); ?>" method='post'>
		用户名：<input type="text" name="manager_name"><br>
		密码：<input type="password" name="manager_password"><br>
		手机号码：<input type="text" name="manager_phone"><br>
		邮箱：<input type="text" name="manager_email"><br>
		分组：
		<select name="group_id">
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['group_id']; ?>"><?php echo $value['group_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		<input type="submit" value="提交">
	</form>
</body>
</html>