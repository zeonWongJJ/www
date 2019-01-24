<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>服务者中心验证首页</title>
</head>
<body>
	<h1>服务者中心验证首页</h1>
	<a href="#">个人验证（跳转到会员中心身份验证）</a>
	<a href="<?php echo $this->router->url('certificate_verification'); ?>">证照验证</a> 
	<a href="<?php echo $this->router->url('company_verification'); ?>">企业验证</a>
</body>
</html>