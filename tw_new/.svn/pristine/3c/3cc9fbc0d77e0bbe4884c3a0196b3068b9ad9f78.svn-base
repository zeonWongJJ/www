<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改分类</title>
</head>
<body>

<h1>修改分类</h1>
<form action="<?php echo $this->router->url('cate_update'); ?>" method='post'>
	<input type="hidden" name="cate_id" value="<?php echo $a_view_data['self']['cate_id']; ?>">
	分类名称：<input type="text" name="cate_name" value="<?php echo $a_view_data['self']['cate_name']; ?>"><br>
	上级：
	<select name="pid_lev">
		<option value="999">顶级分类</option>
		<?php foreach ($a_view_data['all'] as $key => $value): ?>
			<option value="<?php echo $value['cate_id'] . '-' . $value['cate_level']; ?>"  <?php if ($a_view_data['self']['cate_pid'] == $value['cate_id']) { echo 'selected'; } ?> ><?php echo str_repeat('--', $value['cate_level']) . $value['cate_name']; ?></option>
		<?php endforeach ?>
	</select>
	<br>
	是否显示：
	<input type="radio" name="is_show" value="1" <?php if($a_view_data['self']['is_show']==1){ echo 'checked'; } ?>>显示
	<input type="radio" name="is_show" value="0" <?php if($a_view_data['self']['is_show']==0){ echo 'checked'; } ?>>不显示<br>
	排序：<input type="text" name="cate_order" value="<?php echo $a_view_data['self']['cate_order']; ?>"><br>
	<input type="submit" value="确定修改">
</form>

</body>
</html>