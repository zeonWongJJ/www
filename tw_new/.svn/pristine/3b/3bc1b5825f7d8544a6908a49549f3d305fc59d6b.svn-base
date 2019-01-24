<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加房间</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>添加房间</h1>
	<table id="tablist">
		<tr>
			<th>选中</th>
			<th>id</th>
			<th>图片</th>
			<th>名称</th>
			<th>分类</th>
			<th>设备</th>
			<th>大小</th>
			<th>座位</th>
			<th>描述</th>
			<th>添加</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['room_id']; ?>">
			<td><input type="checkbox" name="room_id[]" value="<?php echo $value['room_id']; ?>"></td>
			<td><?php echo $value['room_id']; ?></td>
			<td><img style="width:100px;" src="<?php echo $value['room_mainpic']; ?>" /></td>
			<td><?php echo $value['room_name']; ?></td>
			<td><?php echo $value['type_name']; ?></td>
			<td><?php echo $value['device']; ?></td>
			<td><?php echo $value['room_size']; ?></td>
			<td><?php echo $value['room_seat']; ?></td>
			<td><?php echo $value['room_description']; ?></td>
			<td id="<?php echo 'add_td' . $value['room_id']; ?>">
				<a href="#" onclick="office_add_one(<?php echo $value['room_id']; ?>)">单个添加</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<button onclick="office_add_mony()">批量添加</button>
</body>
</html>

<script>

function office_add_one(room_id) {
	if (confirm('你确定要添加这个房间吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('office_add'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {room_id: room_id, type: 1},
			success:function(data) {
				console.log(data);
				if (data.code==200) {
					alert('一个房间添加成功，你还可以继续添加房间');
				}
			}
		})
	}
}

function office_add_mony() {
	var room_ids = new Array();
	var i = 0;
	$("input:checkbox[name='room_id[]']:checked").each(function(index, el) {
		room_ids[i] = $(this).val();
		i++;
	});
	if (room_ids.length<1) {
		alert('请选择需要添加的房型');
	} else {
		if (confirm('你确定要添加这'+room_ids.length+'个房间吗？')) {
			$.ajax({
				url: '<?php echo $this->router->url('office_add'); ?>',
				type: 'POST',
				dataType: 'json',
				data: {room_ids: room_ids, type: 2},
				success:function(data) {
					console.log(data);
					if (data.code==200) {
						alert(room_ids.length+'个房间添加成功，你还可以继续添加房间');
					}
				}
			})
		}
	}
}

</script>