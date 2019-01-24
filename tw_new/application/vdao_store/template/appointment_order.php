<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>预约办公室的订单</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
	<style>
		table {
			border-collapse: collapse;
		}
		th,td {
			border:1px solid green;
			text-align: center;
			padding: 8px;
		}
	</style>
</head>
<body>
	<h1>预约办公室的订单</h1>
	搜索：<input type="text" name="search">&nbsp;<button onclick="appointment_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>房型</th>
			<th>房间</th>
			<th>座位</th>
			<th>联系人</th>
			<th>手机</th>
			<th>到达时间</th>
			<th>下单时间</th>
			<th>订单号码</th>
			<th>订单状态</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_'.$value['appointment_id']; ?>">
			<td><input type="checkbox" name="appointment_id[]" value="<?php echo $value['appointment_id']; ?>"></td>
			<td><?php echo $value['appointment_id'] ?></td>
			<td><?php echo $value['room_name'] ?></td>
			<td><?php echo $value['office_id'] ?></td>
			<td><?php echo $value['office_seatname'] ?></td>
			<td><?php echo $value['linkman'] ?></td>
			<td><?php echo $value['link_phone'] ?></td>
			<td><?php echo $value['arrival_time'] ?></td>
			<td><?php echo date('Y-m-d H:i:s',$value['appointment_time']) ?></td>
			<td><?php echo $value['appointment_number']; ?></td>
			<td id="<?php echo 'state_'.$value['appointment_id']; ?>"><?php if($value['appointment_state']==1){ echo '预约中'; }else if($value['appointment_state']==2){ echo '进行中'; }else if($value['appointment_state']==3){ echo '已完成'; } else if($value['appointment_state']==4){ echo '已取消'; }else if($value['appointment_state']==5){ echo '待评价'; } ?></td>
			<td>
				<?php if($value['appointment_state']==1){ echo "<a id='arrive_".$value['appointment_id']."' href='#' onclick='office_arrive(".$value['appointment_id'].")'>设置已到店</a>"; } ?>
				&nbsp;
				<?php if($value['appointment_state']==1 || $value['appointment_state']==2) { echo '<a href="#" id="over_'.$value["appointment_id"].'" onclick="appointment_over('.$value["appointment_id"].')">设置订单完成</a>';} ?>
				<a href="#" onclick="appointment_delete_one(<?php echo $value['appointment_id']; ?>)">删除</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<button onclick="appointment_delete_mony()">批量删除</button>
	<br>
	<?php echo $this->pages->link_style_one($this->router->url('appointment_order-', [], false, false));  ?>
</body>
</html>

<script>

function office_arrive(appointment_id) {
	if(confirm('你确定要将状态更改为已到店吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_arrive'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id},
			success: function(data) {
				console.log(data);
				$('#arrive_'+appointment_id).remove();
				$('#state_'+appointment_id).html('进行中');
			}
		})
	}
}

function appointment_over(appointment_id) {
	var complete_msg = prompt('请输入备注信息','');
	if (confirm('设置后订单将进入待评价状态')) {
		if (complete_msg != '') {
			$.ajax({
				url: '<?php echo $this->router->url('appointment_over'); ?>',
				type: 'POST',
				dataType: 'json',
				data: {appointment_id: appointment_id,complete_msg:complete_msg},
				success: function(data){
					console.log(data);
					if (data.code==200) {
						$('#over_'+appointment_id).remove();
						$('#arrive_'+appointment_id).remove();
						$('#state_'+appointment_id).html('待评价');
					}
				}
			})
		}
	}
}

function appointment_delete_one(appointment_id) {
	if (confirm('你确定要删除这条订单记录吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {appointment_id: appointment_id, type: 1},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+appointment_id).remove();
				}
			}
		})
	}
}

function appointment_delete_mony() {
	var appointment_ids = new Array();
	var i = 0;
	$("input:checkbox[name='appointment_id[]']:checked").each(function(index, el) {
		appointment_ids[i] = $(this).val();
		i++
	});
	if (appointment_ids.length != 0) {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {appointment_ids: appointment_ids, type: 2},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					for (var j=0; j<appointment_ids.length; j++) {
						$('#tr_'+appointment_ids[j]).remove();
					}
				}
			}
		})
	} else {
		alert('请先选择需要删除的订单');
	}
}

function appointment_search() {
	var keywords = $("input[name='search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('appointment_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(res) {
				console.log(res);
				if (res.code == 400) {
					alert('未搜索到任何数据');
				} else {
					$("table tr").not(':eq(0)').remove();
					var append_content = '';
					$.each(res.data, function(index, v) {
						append_content += "<tr>";
						append_content += '<td><input type="checkbox" name="appointment_id[]"/></td>';
						append_content += "<td>"+v.appointment_id+"</td>";
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
		alert('关键不能为空');
	}
}

</script>