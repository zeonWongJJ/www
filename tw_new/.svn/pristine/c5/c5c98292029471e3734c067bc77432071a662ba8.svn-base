<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改管理员信息</title>
</head>
<body>
	<h1>修改管理员信息</h1>
	<form action="<?php echo $this->router->url('admin_update'); ?>" method='post'>
		<input type="hidden" name="admin_id" value="<?php echo $a_view_data['admin']['admin_id']; ?>">
		<input type="hidden" name="original_role" value="<?php echo $a_view_data['admin']['role_id']; ?>">
		用户名：<input type="text" name="admin_name" value="<?php echo $a_view_data['admin']['admin_name']; ?>"><br>
		密码：<input type="password" name="admin_password" placeholder="留空表示不修改"><br>
		确认密码：<input type="password" name="admin_password2" placeholder="留空表示不修改"><br>
		手机号码：<input type="text" name="admin_phone" value="<?php echo $a_view_data['admin']['admin_phone']; ?>"><br>
		邮箱：<input type="text" name="admin_email" value="<?php echo $a_view_data['admin']['admin_email']; ?>"><br>
		姓名：<input type="text" name="admin_realname" value="<?php echo $a_view_data['admin']['admin_realname']; ?>"><br>
		性别：<input type="radio" name="admin_sex" value="1" <?php if($a_view_data['admin']['admin_sex']==1){ echo "checked"; } ?>>男
			  <input type="radio" name="admin_sex" value="2" <?php if($a_view_data['admin']['admin_sex']==2){echo "checked";}?>>女<br>
		所属角色：
		<select name="role_id">
			<?php foreach ($a_view_data['role'] as $key => $value): ?>
				<option value="<?php echo $value['role_id']; ?>" <?php if ($a_view_data['admin']['role_id']==$value['role_id']) { echo 'selected'; } ?> ><?php echo $value['role_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		<input type="submit" value="确认修改">
	</form>
</body>
</html>