<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>银行卡验证</title>
</head>
<body>
	<p>姓名：<?php echo $a_view_data['account_name']; ?></p>
	<p>开户银行：<?php echo $a_view_data['bank_name']; ?></p>
	<p>卡号：<?php echo $a_view_data['card_number']; ?></p>
	<p>开户支行：<?php echo $a_view_data['bank_address']; ?></p>
	<form action="<?php echo $this->router->url('bankcard_two'); ?>" method='post'>
		收到金额：<input type="text" name="amount">
		<input type="submit" value="提交审核">
	</form>
</body>
</html>