<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改管理员</title>
</head>
<body>
	<h1>修改管理员</h1>
	<form action="<?php echo $this->router->url('manager_update'); ?>" method='post'>
		<input type="hidden" name="manager_id" value="<?php echo $a_view_data['detail']['manager_id']; ?>">
		<input type="hidden" name="original_name" value="<?php echo $a_view_data['detail']['manager_name']; ?>">
		<input type="hidden" name="original_group" value="<?php echo $a_view_data['detail']['group_id']; ?>">
		用户名：<input type="text" name="manager_name" value="<?php echo $a_view_data['detail']['manager_name']; ?>"><br>
		密码：<input type="password" name="manager_password" placeholder="留空表示不修改"><br>
		手机号码：<input type="text" name="manager_phone" value="<?php echo $a_view_data['detail']['manager_phone']; ?>" ><br>
		邮箱：<input type="text" name="manager_email" value="<?php echo $a_view_data['detail']['manager_email']; ?>" ><br>
		分组：
		<select name="group_id">
			<?php foreach ($a_view_data['group'] as $key => $value): ?>
				<option value="<?php echo $value['group_id']; ?>" <?php if($value['group_id']==$a_view_data['detail']['group_id']){ echo 'selected'; } ?> ><?php echo $value['group_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		<input type="submit" value="确认修改">
	</form>
</body>
</html>