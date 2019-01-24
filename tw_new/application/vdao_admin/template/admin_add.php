<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加管理员</title>
</head>
<body>
	<h1>添加管理员</h1>
	<form action="<?php echo $this->router->url('admin_add'); ?>" method='post'>
		用户名：<input type="text" name="admin_name"><br>
		密码：<input type="password" name="admin_password"><br>
		确认密码：<input type="password" name="admin_password2"><br>
		姓名：<input type="text" name="admin_realname"><br>
		性别：<input type="radio" name="admin_sex" value="1">男  
 			  <input type="radio" name="admin_sex" value="2">女<br>
		手机号码：<input type="number" name="admin_phone"><br>
		邮箱：<input type="text" name="admin_email"><br>
		所属角色：
		<select name="role_id">
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['role_id']; ?>"><?php echo $value['role_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		<input type="submit" value="添加管理员">
	</form>
</body>
</html>