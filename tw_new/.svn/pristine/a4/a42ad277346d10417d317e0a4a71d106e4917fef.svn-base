<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加权限</title>
</head>
<body>
	<h1>添加权限</h1>
	<form action="<?php echo $this->router->url('auth_add'); ?>" method='post'>
		权限名称：<input type="text" name="auth_name"><br />
		权限url: <input type="text" name="auth_url"><br />
		权限上级：
		<select name="level_pid">
			<option value="0">顶级权限</option>
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['auth_id'] . '-' . $value['auth_level']; ?>"><?php echo str_repeat('--', $value['auth_level']) . $value['auth_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br />
		<input type="radio" name="auth_show" value="1">显示在菜单中
		<input type="radio" name="auth_show" value="0">不显示在菜单中
		<br>
		<input type="submit" value="添加权限">
	</form>
</body>
</html>