<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<p>账户总金额：<?php echo $a_view_data['total']; ?></p>
	<?php foreach ($a_view_data['detail'] as $key => $value): ?>
		<?php echo '交易时间：'.date('Y-m-d H:i:s', $value['variation_time']).'<br />'; ?>
		<?php echo '变化值：'.$value['variation'].'<br />'; ?>
		<?php echo '提示：'.$value['change_hints'].'<hr />'; ?>
	<?php endforeach ?>
</body>
</html>