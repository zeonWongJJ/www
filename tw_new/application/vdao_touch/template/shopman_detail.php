<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>移动店主详情</title>
</head>
<body>
	<h1>移动店主详情</h1>
	<?php foreach ($a_view_data as $key => $value): ?>
		<li><?php echo $value['user_name']; ?></li>
	<?php endforeach ?>
</body>
</html>