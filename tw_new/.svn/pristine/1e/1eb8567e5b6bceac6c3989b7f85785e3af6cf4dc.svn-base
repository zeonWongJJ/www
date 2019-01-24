<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>追加服务费用</title>
</head>
<body>
	<h1>追加服务费用</h1>
	<h3><?php echo $a_view_data['title']; ?></h3>
	<form action="<?php echo $this->router->url('server_inservice_append'); ?>" method='post'>
		<input type="hidden" name="bid_id" value="<?php echo $a_view_data['selected_bid']; ?>">
		<input type="hidden" name="demand_id" value="<?php echo $a_view_data['demand_id']; ?>">
		<input type="hidden" name="demand_state" value="<?php echo $a_view_data['state']; ?>">
		追加费用的原因：<textarea name="append_why" id="" cols="30" rows="10"></textarea>
		<br>
		追加费用金额: <input type="text" name="append_money">
		<br>
		<input type="submit" value="确认追加费用">
	</form>
</body>
</html>