<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改分组</title>
</head>
<body>
	<h1>修改分组</h1>
	<form action="<?php echo $this->router->url('group_update'); ?>" method='post'>
		<input type="hidden" name="group_id" value="<?php echo $a_view_data['detail']['group_id']; ?>">
		分组名称：<input type="text" name="group_name" value="<?php echo $a_view_data['detail']['group_name']; ?>"><br>
		分组描述：<input type="text" name="group_description" value="<?php echo $a_view_data['detail']['group_description']; ?>"><br>
		分组权限：
		<?php foreach ($a_view_data['auth'] as $key => $value): ?>
			<input type="checkbox" name="group_auth[]" value="<?php echo $value['auth_id']; ?>"
			<?php foreach ($a_view_data['present'] as $k => $v): ?>
				<?php if($value['auth_id']==$v) { echo 'checked'; } ?>
			<?php endforeach ?> >
			<?php echo $value['auth_name']; ?>
		<?php endforeach ?><br />
		<br>
		<input type="submit" value="确定">
	</form>
</body>
</html>