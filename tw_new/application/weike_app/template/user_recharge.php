<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>充值</title>
</head>
<body>
	<form action="<?php echo $this->router->url('bankcard_verification'); ?>" method='post'>
		充值金额：<input type="text" name="money">
		<input type="submit" value="立即充值">
	</form>
</body>
</html>