<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>订单明细</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td {
			padding: 10px;
			border:1px solid gray;
		}
	</style>
</head>
<body>
	<h1>订单明细</h1>
	<table>
		<tr>
			<th>订单id</th>
			<th>下单用户</th>
			<th>订单号码</th>
			<th>下单时间</th>
			<th>数量</th>
			<th>总价</th>
		</tr>
		<?php foreach ($a_view_data['order'] as $key => $value): ?>
		<tr>
			<td><?php echo $value['order_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php echo $value['order_number']; ?></td>
			<td><?php echo date('Y-m-d H:i:s', $value['time_create']); ?></td>
			<td><?php echo $value['order_count']; ?></td>
			<td><?php echo $value['goods_amount']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('statistic_otherorder-'.$a_view_data['sta_id'].'-', [], false, false)); ?>
</body>
</html>