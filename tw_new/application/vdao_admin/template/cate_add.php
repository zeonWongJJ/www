<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加分类</title>
</head>
<body>
	<h1>添加分类</h1>
	<form action="<?php echo $a_view_data['cate_add']; ?>" method='post'>
		分类名称：<input type="text" name="cate_name"><br>
		上级：
		<select name="pid_lev">
			<option value="0">顶级分类</option>
			<?php foreach ($a_view_data as $key => $value): ?>
				<option value="<?php echo $value['cate_id'] . '-' . $value['cate_level']; ?>"><?php echo str_repeat('--', $value['cate_level']) . $value['cate_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		是否显示：
		<input type="radio" name="is_show" value="1">显示
		<input type="radio" name="is_show" value="0">不显示<br>
		排序：<input type="text" name="cate_order"><br>
		<input type="submit" value="添加分类">
	</form>
</body>
</html>