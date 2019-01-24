<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>办公室订单</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			border:1px solid pink;
			padding: 10px;
		}
	</style>
	<script src="./script/jquery-1.8.2.min.js"></script>
</head>
<body>
	<h1>办公室订单</h1>
	搜索：<input type="text" name="search">&nbsp;<button onclick="appointment_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th>id</th>
			<th>门店</th>
			<th>房型</th>
			<th>房间</th>
			<th>座位</th>
			<th>联系人</th>
			<th>手机</th>
			<th>到达时间</th>
			<th>下单时间</th>
			<th>订单号码</th>
			<th>订单状态</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr>
			<td><?php echo $value['appointment_id']; ?></td>
			<td><?php echo $value['store_name']; ?></td>
			<td><?php echo $value['room_name']; ?></td>
			<td><?php echo $value['office_id']; ?></td>
			<td><?php echo $value['office_seatname']; ?></td>
			<td><?php echo $value['linkman']; ?></td>
			<td><?php echo $value['link_phone']; ?></td>
			<td><?php echo $value['arrival_time']; ?></td>
			<td><?php echo date('Y-m-d H:i:s', $value['appointment_time']); ?></td>
			<td><?php echo $value['appointment_number']; ?></td>
			<td><?php if ($value['appointment_state'] == 1) {
				echo '预约中';
			} elseif ($value['appointment_state'] == 2) {
				echo '进行中';
			} elseif ($value['appointment_state'] == 3) {
				echo '已完成';
			} elseif ($value['appointment_state'] == 4) {
				echo '已取消';
			} elseif ($value['appointment_state'] == 5) {
				echo '待评价';
			} ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('order_office-', [], false, false)); ?>
</body>
</html>

<script>

function appointment_search() {
	var keywords = $("input[name='search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function (res) {
				console.log(res);
				if (res.code == 400) {
					alert('未搜索到相关内容');
				} else {
					$("table tr").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, v) {
						append_content += "<tr>";
						append_content += "<td>"+v.appointment_id+"</td>";
						append_content += "<td>"+v.store_name+"</td>";
						append_content += "<td>"+v.room_name+"</td>";
						append_content += "<td>"+v.office_id+"</td>";
						append_content += "<td>"+v.office_seatname+"</td>";
						append_content += "<td>"+v.linkman+"</td>";
						append_content += "<td>"+v.link_phone+"</td>";
						append_content += "<td>"+v.arrival_time+"</td>";
						append_content += "<td>"+v.appointment_time+"</td>";
						append_content += "<td>"+v.appointment_number+"</td>";
						append_content += "<td>"+v.appointment_state+"</td>";
						append_content += "</tr>";
					});
					$("table").append(append_content);
				}
			}
		})
	} else {
		alert('关键词不能为为空');
	}
}

</script>