<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>服务者中心首页</title>
</head>
<body>
	<h1>服务者中心首页</h1>
	用户名：<?php echo $_SESSION['user_name']; ?>
	<br /><br />
	<a href="<?php echo $this->router->url('service_chenghao'); ?>" target="new">称号</a> <br />
	<a href="<?php echo $this->router->url('service_verification'); ?>" target="new">验证</a> <br />
	<a href="<?php echo $this->router->url('service_mydate'); ?>" target="new">我的排班表</a> <br />
	<a href="<?php echo $this->router->url('service_mybid'); ?>" target="new">竞标中的订单</a> <br />
	<a href="<?php echo $this->router->url('service_toconfirmed'); ?>" target="new">待确认的的订单</a> <br />
	<a href="<?php echo $this->router->url('service_toconfirmed_detail',['id'=>1]); ?>" target="new">待确认的的订单详情（地址栏传id）</a> <br />
	<a href="<?php echo $this->router->url('service_confirmed',['id'=>4]); ?>" target="new">待确认的订单之确认订单操作（地址栏传id）</a> <br />
	<a href="<?php echo $this->router->url('service_cancel',['id'=>4]); ?>" target="new">待确认订单之放弃订单操作（地址栏传id）</a> <br />
	<a href="<?php echo $this->router->url('service_inservice'); ?>" target="new">正在服务中的订单</a> <br />
	<a href="<?php echo $this->router->url('service_complete',['id'=>4]); ?>" target="new">正在服务中的订单之确定完成订单操作</a> <br />
	<a href="<?php echo $this->router->url('service_addmoney',['id'=>4]); ?>" target="new">增加服务费用</a> <br />
	<a href="<?php echo $this->router->url('service_tocomment'); ?>" target="new">待评价的订单</a> <br />
</body>
</html>