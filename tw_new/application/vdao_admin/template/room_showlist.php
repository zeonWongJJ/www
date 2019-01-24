<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>房间列表</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>房间列表</h1>
	房间查询：<input type="text" name="room_search">&nbsp;<button onclick="room_search()">搜索</button>
	<br /><br />
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
			<th>操作</th>
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
			<td>
				<a href="<?php echo $this->router->url('room_update',['id'=>$value['room_id']]); ?>">修改</a> |
				<a href="#" onclick="del_room_one(<?php echo $value['room_id']; ?>)">删除</a> |
				<a href="#" id="<?php echo 'switch_' . $value['room_id']; ?>" onclick="room_switch(<?php echo $value['room_id']; ?>)"><?php if ($value['room_state']==1) { echo '启用'; } else { echo '停用'; } ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<h2><a href="<?php echo $this->router->url('room_add'); ?>">添加房间</a></h2>
	<button onclick="del_room_mony()">批量删除</button>
	<br>
	<div class="lay"></div>
</body>
</html>

<script>

function room_switch(room_id) {
	$.ajax({
		url: '<?php echo $this->router->url('room_switch'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {room_id: room_id},
		success: function (data) {
			console.log(data);
			if (data.code==200) {
				var msg = $('#switch_'+room_id).html();
				if (msg=='启用') {
					$('#switch_'+room_id).html('停用');
				} else {
					$('#switch_'+room_id).html('启用');
				}
			}
		}
	})
}


function del_room_one(room_id) {
	$.ajax({
		url: '<?php echo $this->router->url('room_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {room_id: room_id, type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				$('#tr_'+room_id).remove();
			}
		}
	})
}


function del_room_mony() {
	var room_ids = new Array();
	var i = 0;
	$("input:checkbox[name='room_id[]']:checked").each(function(index, el) {
		room_ids[i] = $(this).val();
		i++
	});
	$.ajax({
		url: '<?php echo $this->router->url('room_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {room_ids: room_ids, type: 2},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				for (var j=0; j<room_ids.length; j++) {
					$('#tr_'+ids[j]).remove();
				}
			}
		}
	})
}

function room_search() {
	var keywords = $("input[name='room_search']").val();
	var hosturl = window.location.host;
	$.ajax({
		url: '<?php echo $this->router->url('room_search'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {keywords: keywords},
		success: function(data) {
			console.log(data);
			if (data!=null) {
				$("#tablist tr").not(':eq(0)').remove();
				$.each(data,function(index, value) {
					var tr_content = "<tr id='tr_"+value.room_id+"'>";
					tr_content += '<td><input type="checkbox" name="room_id[]" value="'+value.room_id+'"></td>';
					tr_content += '<td>'+value.room_id+'</td>';
					tr_content += '<td><img style="width:100px;" src="'+value.room_mainpic+'"></td>';
					tr_content += '<td>'+value.room_name+'</td>';
					tr_content += '<td>'+value.type_name+'</td>';
					tr_content += '<td>'+value.device+'</td>';
					tr_content += '<td>'+value.room_size+'</td>';
					tr_content += '<td>'+value.room_seat+'</td>';
					tr_content += '<td>'+value.room_description+'</td>';
					tr_content += '<td><a href="http://'+hosturl+'/room_update-'+value.room_id+'">修改</a>| <a href="#" onclick="del_room_one('+value.room_id+')">删除 |</a>';
					if (value.room_state==1) {
						var state = '启用';
					} else {
						state = '停用';
					}
					tr_content += '<a href="#" id="switch_'+value.room_id+'" onclick="room_switch('+value.room_id+')">'+state+'</a></td>';
					tr_content += "</tr>";
					$("#tablist").append(tr_content)
				});
			}
		}
	})
}

</script>

