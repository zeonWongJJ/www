<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<?php foreach ($a_view_data as $key => $value): ?>
		时间：<?php echo $value['variation_time'].'<br />'; ?>
		变化：<?php echo $value['variation'].'积分<br />'; ?>
		原因：<?php echo $value['change_hints'].'<hr />'; ?>
	<?php endforeach ?>
</body>
</html>