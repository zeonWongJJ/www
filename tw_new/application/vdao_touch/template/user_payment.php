<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>支付密码</title>
</head>
<body>
	<h1>设置支付密码</h1>
	<form action="<?php echo $this->router->url('user_payment'); ?>" method='post'>
		手机号码：<input type="text" name="user_phone"><br>
		验证码：<input type="text" name="user_code"><button onclick="send_code()">点击发送验证码</button><br>
		请输入支付密码：<input type="text" name="payment_code"><br>
		请确认支付密码：<input type="text" name="payment_code2"><br>
		<input type="submit" value="保存">
	</form>
</body>
</html>

<script>

function send_code() {
	var user_phone = $("input[name='user_phone']").val();
	$.ajax({
		url: '<?php echo $this->router->url('send_code'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {user_phone: user_phone},
		success: function(data) {
			console.log(data);
		}
	})
}

</script>