<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加角色</title>
</head>
<body>
	<h1>添加角色</h1>
	<form action="<?php echo $this->router->url('role_add'); ?>" method='post'>
		角色名称：<input type="text" name="role_name"><br />
		角色权限：<br />
		<?php foreach ($a_view_data as $key => $value): ?>
			<input type="checkbox" name="auth[]" value="<?php echo $value['auth_id']; ?>">
			<?php echo $value['auth_name']; ?>
		<?php endforeach ?>
		<br />
		<input type="submit" value="新增角色">
	</form>
</body>
</html>