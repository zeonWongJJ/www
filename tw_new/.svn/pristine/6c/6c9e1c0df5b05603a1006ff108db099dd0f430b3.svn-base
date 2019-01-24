<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="back_two" method="post">
		<input type="text" name="user_name" class="userName" placeholder="请输入用户名"  value="" autocomplete="off" required />
		<!-- <span>12</span> -->
		<br>
		<input type="text" name="mod_phone" placeholder="请输入手机号码"  value="" autocomplete="off" required />
		<span></span>
		<br>
		<input type="text" name="captcha" class="yanzhengma" placeholder="验证码" autocomplete="off" required  style="width:80px;" />
		<img onclick="this.src='<?php echo $this->router->url('captcha');?>#'+Math.random();" src="<?php echo $this->router->url('captcha');?>" alt="验证码" style=" margin-left:6px; padding:0px; border-radius:25px; height:53px; width:100px; overflow:hidden;">
		<button type="submit" value="提交">提交</button>
	</form>
</body>
</html>