<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>银行卡认证</title>
</head>
<body>
	<h1>银行卡认证</h1>
	<form action="<?php echo $this->router->url('bankcard_verification'); ?>" method='post'>
		开户行：
		<select name="bank">
			<option value="">请选择银行</option>
			<?php foreach($a_view_data['bank'] as $k=>$v){ ; ?>
				<option value="<?php echo $v['bank_name']; ?>"><?php echo $v['bank_name']; ?></option>
			<?php }; ?>
		</select><br />
		账户名：<input type="text" name="account_name" value="<?php echo $a_view_data['realname']; ?>"><br />
		银行卡号：<input type="text" name="bank_number"><br />
		开户支行：<input type="text" name="bank_address"><br />
		<input type="submit" value="提交审核">
	</form>
</body>
</html>