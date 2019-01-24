<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>办公室订单详情</title>
	<style>
		div {
			padding: 10px;
			border: 1px solid blue;
			margin:10px;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>办公室订单详情</h1>

	<div id="order_wait" <?php if($a_view_data['appointment_state']==1 || $a_view_data['appointment_state']==2){ echo "style='display:block'"; }else{ echo "style='display:none'"; } ?>>
		<h1>等待进店中</h1>
		<button onclick="appointment_cancel(<?php echo $a_view_data['appointment_id']; ?>)">取消订单</button>
		&nbsp;
		<button>电话延迟</button>
	</div>

	<div id="order_ing" <?php if($a_view_data['appointment_state']==3){ echo "style='display:block'"; }else{ echo "style='display:none'"; } ?>>
		<h1>订单进行中</h1>
		<button onclick="appointment_over(<?php echo $a_view_data['appointment_id']; ?>)">结束订单</button>
	</div>

	<div id="order_comment" <?php if($a_view_data['appointment_state']==4){ echo "style='display:block'"; }else{ echo "style='display:none'"; } ?>>
		<h1>订单待评价</h1>
		<a href="<?php echo $this->router->url('appointment_comment',['id'=>$a_view_data['appointment_id']]); ?>">立即评价</a>
	</div>

	<div id="order_over" <?php if($a_view_data['appointment_state']==5){ echo "style='display:block'"; }else{ echo "style='display:none'"; } ?>>
		<h1>订单已完成</h1>
	</div>

	<div id="order_cancel" <?php if($a_view_data['appointment_state']==6){ echo "style='display:block'"; }else{ echo "style='display:none'"; } ?>>
		<h1>订单已取消</h1>
	</div>

<div style="border:1px solid red;">
	<h3>店铺名称：<a href="<?php echo $this->router->url('store_detail',['id'=>$a_view_data['store_id']]); ?>"><?php echo $a_view_data['store_name']; ?></a></h3>
	<p>房间名：<?php echo $a_view_data['room_name']; ?></p>
	<p>座位：<?php echo $a_view_data['office_seatname']; ?></p>
	<p>基本信息：<?php echo $a_view_data['room_size'].'m<sup>2</sup> | '.$a_view_data['device'].' | 可坐'.$a_view_data['room_seat'].'人'; ?></p>
</div>

<div style="border:1px solid green;">
	<h3>订单详情：</h3>
	<p>订单号：<?php echo $a_view_data['appointment_number']; ?></p>
	<p>到达时间：<?php echo $a_view_data['arrival_time']; ?></p>
	<p>下单时间：<?php echo date('Y-m-d H:i:s',$a_view_data['appointment_time']); ?></p>
	<p>联系方式：<?php echo $a_view_data['linkman'].'&nbsp;'.$a_view_data['link_phone']; ?></p>
</div>

</body>
</html>

<script>

function appointment_cancel(appointment_id) {
	if (confirm('你确定要取消预约吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_cancel'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(data){
				console.log(data);
				alert(data.msg);
				if (data.code==200) {
					window.location.reload();
				}
			}
		})
	}
}

function appointment_over(appointment_id) {
	if (confirm('你确定要结束订单吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_over'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(data) {
				console.log(data);
				alert(data.msg);
				if (data.code==200) {
					window.location.reload();
				}
			}
		})
	}
}

</script>