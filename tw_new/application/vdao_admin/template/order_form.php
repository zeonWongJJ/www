<html>
<head>
	<title>订单管理</title>
</head>
<style>
    a{text-decoration:none; color:#666;}
	table{
		width: 800px;
		border-collapse: collapse;
	}
	th,td{
		padding: 5px;
		border: 1px solid green;
	}
</style>
<body>
	<h1>订单管理</h1>
	<table>
		<tr>
			<th>下单用户</th>
			<th>订单数量</th>
			<th>订单总价</th>
			<th>订单生成时间</th>
			<th>付款时间</th>
			<th>订单编号</th>
			<th>订单状态</th>
		</tr>
		<?php foreach ($a_view_data['order'] as $order): ?>
			<tr>
				<td><?php echo $order['user_name']; ?></td>
				<td><?php echo $order['order_count']; ?></td>
				<td><?php echo $order['order_price']; ?></td>
				<td><?php echo date('Y-m-d H:i', $order['time_create'])?></td>
				<td><?php echo date('Y-m-d H:i', $order['order_time'])?></td>
				<td><?php echo $order['order_number']; ?></td>
				<td><?php if ($order['order_state'] == 0) {
					echo 已取消;
				} else if ($order['order_state'] == 40) {
					echo 代付款;
				} else if ($order['order_state'] == 25) {
					echo 代发货;
				} else if ($order['order_state'] == 30) {
					echo 代确认;
				} else if ($order['order_state'] == 50) {
					echo 待退款;
				} else if ($order['order_state'] == 55) {
					echo 退款成功;
				} else if ($order['order_state'] == 10) {
					echo 待评价;
				} else if ($order['order_state'] == 80) {
					echo 完成;
				} else if ($order['order_state'] == 20) {
					echo 待接单;
				}?></td>
			</tr>
		<?php endforeach ?>
	</table>
	<br>
	 <?php echo $a_view_data['page']?>
</body>
</html>