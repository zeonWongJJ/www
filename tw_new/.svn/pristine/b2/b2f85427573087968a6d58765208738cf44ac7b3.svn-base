<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户订单</title>
</head>
<style>
	a{text-decoration:none; color:#666;}
    ul li{list-style-type:none;}
</style>
<body>
	<h1>用户订单</h1>
	<h2>办公室订单</h2>
	<?php foreach ($a_view_data['office'] as $key => $value): ?>
		<p><?php echo $value['store_name'].'------'; if ($value['appointment_state']==1) { echo '待接单'; }elseif($value['appointment_state']==2){ echo '待服务'; }elseif($value['appointment_state']==3){ echo '服务中'; }else if($value['appointment_state']==4){ echo '待评价'; }else if($value['appointment_state']==5){ echo '已完成'; }else if($value['appointment_state']==6){ echo '已取消'; } ?></p>
		<p style="color:red;"><?php echo $value['room_name'].'---'.date('Y-m-d H:i:s', $value['appointment_time']) .'---订单号码：'. $value['appointment_number']; ?></p>
		<a href="<?php echo $this->router->url('appoint_detail',['id'=>$value['appointment_id']]); ?>">查看详情</a>
	<?php endforeach ?>
	<h2>咖啡订单</h2>
		<?php foreach ($a_view_data['product'] as $prod) { ?>
			<ul style="border: 1px solid green;">
			<a href="goods_list-<?php echo $prod['order_id']?>">
				<p><?php echo $prod['store_name']?></p>
				<?php foreach ($a_view_data['goods'] as $goods) {
					if ($goods['order_id'] == $prod['order_id']) {?>
			 	<li><img src="<?php echo $goods['pro_img']?>" style="width: 50px;"></li>
			 	<li>
			 		<p><?php echo $goods['product_name']?> &nbsp 等<?php echo $prod['order_count']?>件产品</p>
			 		<p><?php echo date('Y-m-d H-i-t', $prod['time_create']);?></p>
			 		<p>￥<?php echo $prod['order_price']?></p>
			 	</li>
			 	<?php }}?>
		 	</a>
			</ul>
		<?php }?>		
</body>
</html>