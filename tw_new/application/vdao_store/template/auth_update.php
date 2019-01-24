<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改权限</title>
</head>
<body>
	<h1>修改权限</h1>
	<form action="<?php echo $this->router->url('auth_update'); ?>" method='post'>
		<input type="hidden" name="auth_id" value="<?php echo $a_view_data['detail']['auth_id']; ?>">
		<input type="hidden" name="original_url" value="<?php echo $a_view_data['detail']['auth_url']; ?>">
		权限名称：<input type="text" name="auth_name" value="<?php echo $a_view_data['detail']['auth_name']; ?>"><br />
		权限url: <input type="text" name="auth_url" value="<?php echo $a_view_data['detail']['auth_url']; ?>"><br />
		权限上级：
		<select name="level_pid">
			<option value="0" <?php if($a_view_data['detail']['auth_pid']==0){echo 'selected'; }; ?> >顶级权限</option>
			<?php foreach ($a_view_data['auth'] as $key => $value): ?>
				<option value="<?php echo $value['auth_id'] . '-' . $value['auth_level']; ?>" <?php if($a_view_data['detail']['auth_pid']==$value['auth_id']){echo 'selected'; }; ?>><?php echo str_repeat('--', $value['auth_level']) . $value['auth_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br />
		<input type="radio" name="auth_show" value="1" <?php if($a_view_data['detail']['auth_show']==1){ echo 'checked'; } ?>>显示在菜单中
		<input type="radio" name="auth_show" value="0" <?php if($a_view_data['detail']['auth_show']==0){ echo 'checked'; } ?>>不显示在菜单中
		<br>
		<input type="submit" value="修改权限">
	</form>
</body>
</html>