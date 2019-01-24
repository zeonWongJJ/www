<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>店主详情</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			width: 800px;
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>店主详情</h1>
	<h2>订单列表</h2>
	<table>
		<tr>
			<th>选中</th>
			<th>id</th>
			<th>用户昵称</th>
			<th>性别</th>
			<th>手机号码</th>
			<th>店铺名称</th>
			<th>数量</th>
			<th>总价</th>
			<th>总提成</th>
			<th>下单时间</th>
		</tr>
		<?php foreach ($a_view_data['order'] as $key => $value): ?>
		<tr>
			<td><input type="checkbox" name="order_id[]" value="<?php echo $value['order_id']; ?>"></td>
			<td><?php echo $value['order_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php if($value['user_sex']==1){ echo '男'; }else if($value['user_sex']==2) { echo "女"; } else { echo "未知"; } ?></td>
			<td><?php echo $value['user_phone']; ?></td>
			<td><?php echo $value['store_name']; ?></td>
			<td><?php echo $value['order_count']; ?></td>
			<td><?php echo $value['goods_amount']; ?></td>
			<td><?php echo $value['order_commission']; ?></td>
			<td><?php echo date('Y-m-d',$value['time_create']); ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<a href="<?php echo $this->router->url('shopman_order',['uid'=>$a_view_data['user_id']]); ?>">查看所有订单</a>
	<h2>推荐人列表</h2>
	<table>
		<tr>
			<th>选中</th>
			<th>id</th>
			<th>用户昵称</th>
			<th>性别</th>
			<th>手机号码</th>
			<th>消费总金额</th>
			<th>提成</th>
			<th>注册时间</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data['referee'] as $key => $value): ?>
		<tr>
			<td><input type="checkbox" name="user_id[]" value="<?php echo $value['user_id']; ?>"></td>
			<td><?php echo $value['user_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php if($value['user_sex']==1){ echo '男'; }else if($value['user_sex']==2) { echo "女"; } else { echo "未知"; } ?></td>
			<td><?php echo $value['user_phone']; ?></td>
			<td><?php echo $value['user_consume']; ?></td>
			<td><?php echo $value['user_commission']; ?></td>
			<td><?php echo date('Y-m-d',$value['user_regtime']); ?></td>
			<td>
				<a href="<?php echo $this->router->url('shopman_referee_detail',['uid'=>$value['user_id']]); ?>">查看明细</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<a href="<?php echo $this->router->url('shopman_referee',['uid'=>$a_view_data['user_id']]); ?>">查看所有推荐人</a>
</body>
</html>