<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>绑定手机</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>绑定手机</h1>
	<form action="<?php echo $this->router->url('user_phone'); ?>" method="post">
		手机号码：<input type="text" name="user_phone"><button onclick="send_code()">点击发送验证码</button><br>
		验证码：<input type="text" name="user_code"><br>
		初始密码：<input type="password" name="user_password"><br>
		<input type="submit" value="验证后绑定新手机">
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