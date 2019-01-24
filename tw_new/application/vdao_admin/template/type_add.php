<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加办公室类型</title>
</head>
<body>
	<h1>添加办公室类型</h1>
	<form action="<?php echo $this->router->url('type_add'); ?>" method="post">
		类型名称：<input type="text" name="type_name"><br>
		类型上级：
		<select name="pid_lev">
		<option value="999">顶级类型</option>
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['type_id'] . '-' .$value['type_level']; ?>"><?php echo str_repeat('--',$value['type_level']) . $value['type_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		类型描述：
		<textarea name="type_description"></textarea>
		<br>
		是否开放：<input type="radio" name="type_state" value="1">是
		<input type="radio" name="type_state" value="0">否
		<br>
		排序：<input type="text" name="type_order">
		<br>
		<input type="submit" value="添加类型">
	</form>
</body>
</html>