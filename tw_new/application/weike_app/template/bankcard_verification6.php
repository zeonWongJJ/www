<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>银行卡认证不通过</title>
</head>
<body>
	<h1>恭喜银行卡认证失败，银行卡信息错误</h1>
	<p>姓名：<?php echo $a_view_data['account_name']; ?></p>
	<p>开户银行：<?php echo $a_view_data['bank_name']; ?></p>
	<p>卡号：<?php echo $a_view_data['card_number']; ?></p>
	<p>开户支行：<?php echo $a_view_data['bank_address']; ?></p>
	<a href="<?php echo $this->router->url('bankcard_again'); ?>">重新认证</a>
</body>
</html>