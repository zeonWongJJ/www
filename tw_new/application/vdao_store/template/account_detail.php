<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>查看明细</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 10px;
			border:1px solid #ccc;
		}
	</style>
</head>
<body>
	<h1><?php echo $a_view_data['detail']['account_time']; ?>订单</h1>
	<table>
		<tr>
			<th>订单id</th>
			<th>订单号</th>
			<th>下单时间</th>
			<th>成交时间</th>
			<th>咖啡数量</th>
			<th>总金额</th>
		</tr>
		<?php foreach ($a_view_data['order'] as $key => $value): ?>
		<tr>
			<td><?php echo $value['order_id']; ?></td>
			<td><?php echo $value['order_number']; ?></td>
			<td><?php echo date('Y-m-d H:i:s',$value['time_create']); ?></td>
			<td><?php echo date('Y-m-d H:i:s',$value['order_time']); ?></td>
			<td><?php echo $value['order_count']; ?></td>
			<td><?php echo $value['goods_amount']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('account_detail-'.$a_view_data['detail']['account_id'].'-', [], false, false)); ?>
</body>
</html>