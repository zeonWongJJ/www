<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>删除足迹</title>
</head>
<body>
	<form action="<?php echo $this->router->url('delete_footprint'); ?>" method="post">
		<input type="checkbox" name="id[]" value="1">足迹一
		<input type="checkbox" name="id[]" value="2">足迹二
		<input type="checkbox" name="id[]" value="3">足迹三
		<input type="checkbox" name="id[]" value="4">足迹四
		<input type="checkbox" name="id[]" value="5">足迹五
		<input type="checkbox" name="id[]" value="6">足迹六
		<input type="submit" value="删除">
	</form>
</body>
</html>