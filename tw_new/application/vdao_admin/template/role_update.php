<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改角色</title>
</head>
<body>
	<h1>给<b style="color:red;"><?php echo $a_view_data['role']['role_name']; ?></b>分配权限</h1>
	<form action="<?php echo $this->router->url('role_update'); ?>" method='post'>
		<input type="hidden" name="role_id" value="<?php echo $a_view_data['role']['role_id']; ?>">
		权限名称：<input type="text" name="role_name" value="<?php echo $a_view_data['role']['role_name']; ?>"><br />
		权限名称：<input type="text" name="role_description" value="<?php echo $a_view_data['role']['role_description']; ?>"><br />
		权限列表：<br />
		<?php foreach ($a_view_data['auth'] as $key => $value): ?>
			<input type="checkbox" name="role_auth[]" value="<?php echo $value['auth_id']; ?>"
			<?php foreach ($a_view_data['present'] as $k => $v): ?>
				<?php if($value['auth_id']==$v) { echo 'checked'; } ?>
			<?php endforeach ?> >
			<?php echo $value['auth_name']; ?>
		<?php endforeach ?><br />
		<input type="submit" value="分配权限">
	</form>
</body>
</html>