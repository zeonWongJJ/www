<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>提现</title>
</head>
<body>
	<h1>提现</h1>
	<p>小提示：请确保已经绑定了银行卡或者支付宝及设置了提现密码</p>
	<form action="<?php echo $this->router->url('balance_withdraw'); ?>" method="post">
		提现金额：<input type="text" name="balance_number"> <br>
		提现到：
		<input type="radio" name="withdraw_type" value="1">支付宝
		<input type="radio" name="withdraw_type" value="2">银行卡<br>
		提现密码：<input type="password" name="store_password" autocomplete="off"><br>
		<input type="submit" value="确定提现">
	</form>
</body>
</html>