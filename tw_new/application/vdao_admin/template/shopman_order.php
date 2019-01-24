<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>所有推荐人订单</title>
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
	<h1>所有推荐人订单</h1>
	搜索：<input type="text" name="shopman_search">&nbsp;<button onclick="shopman_search()">搜索</button>
	<br><br>
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
			<th>提成</th>
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
	<br><br>
	<?php echo $this->pages->link_style_one($this->router->url('shopman_order', ['uid'=>$a_view_data['user_id'],''], false, false)); ?>
</body>
</html>


<script>
function shopman_search() {
	var keywords = $("input[name='shopman_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords, user_id: <?php echo $a_view_data['user_id']; ?>, type: 3},
			success: function(res) {
				console.log(res);
			}
		})
	}
}
</script>