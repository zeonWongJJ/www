<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改权限</title>
</head>
<body>
	<h1>添加权限</h1>
	<form action="<?php echo $this->router->url('auth_update'); ?>" method='post'>
		<input type="hidden" name="auth_id" value="<?php echo $a_view_data['detail']['auth_id']; ?>">
		权限名称：<input type="text" name="auth_name" value="<?php echo $a_view_data['detail']['auth_name']; ?>"><br />
		权限url: <input type="text" name="action_url" value="<?php echo $a_view_data['detail']['action_url']; ?>"><br />
		是否显示菜单：
		<select name="type">
			<option value="1" <?php if($a_view_data['detail']['type']==1){echo 'selected'; }; ?> >显示</option>
			<option value="2" <?php if($a_view_data['detail']['type']==2){echo 'selected'; }; ?> >不显示</option>
		</select>
		<br />
		权限上级：
		<select name="level_pid">
			<option value="0" <?php if($a_view_data['detail']['parent_id']==0){echo 'selected'; }; ?> >顶级权限</option>
			<?php foreach ($a_view_data['auth'] as $key => $value): ?>
				<option value="<?php echo $value['auth_id'] . '-' . $value['level']; ?>" <?php if($a_view_data['detail']['parent_id']==$value['auth_id']){echo 'selected'; }; ?>><?php echo str_repeat('--', $value['level']) . $value['auth_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br />
		<input type="submit" value="修改权限">
	</form>
</body>
</html>