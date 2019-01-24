<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>设备列表</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			width: 700px;
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>设备列表</h1>
	搜索设备：<input type="text" name="device_search">&nbsp;<button onclick="device_search()">搜索</button>
	<br><br>
	<table id="tablist">
		<tr>
			<th>选中</th>
			<th>设备</th>
			<th>名称</th>
			<th>型号</th>
			<th>描述</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['device_id']; ?>">
			<td><input type="checkbox" name="device_id[]" value="<?php echo $value['device_id']; ?>"></td>
			<td><img src="<?php echo $value['device_mainpic']; ?>" style='width:100px; height:100px;'></td>
			<td><?php echo $value['device_name']; ?></td>
			<td><?php echo $value['device_version']; ?></td>
			<td><?php echo $value['device_description']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('device_update',['id'=>$value['device_id']]); ?>">修改</a> |
				<a href="#" onclick="del_device_one(<?php echo $value['device_id']; ?>)">删除</a> |
				<a href="#" id="<?php echo 'switch_' . $value['device_id']; ?>" onclick="device_switch(<?php echo $value['device_id']; ?>)"><?php if ($value['device_state']==1) {echo '启用';} else { echo '停用'; } ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<h2><a href="<?php echo $this->router->url('device_add'); ?>">添加设备</a></h2>
	<br>
	<button onclick="del_device_mony()">批量删除</button>
</body>
</html>

<script>

function del_device_one(device_id) {
	$.ajax({
		url: '<?php echo $this->router->url('device_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {device_id: device_id, type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				$('#tr_'+device_id).remove();
			}
		}
	})
}

function del_device_mony() {
	var device_ids = new Array();
	var i = 0;
	$("input:checkbox[name='device_id[]']:checked").each(function(index, el) {
		device_ids[i] = $(this).val();
		i++
	});
	$.ajax({
		url: '<?php echo $this->router->url('device_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {device_ids: device_ids, type: 2},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				for (var j=0; j<device_ids.length; j++) {
					$('#tr_'+device_ids[j]).remove();
				}
			}
		}
	})
}

function device_search() {
	var keywords = $("input[name='device_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('device_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(data) {
				console.log(data);
				var hosturl = window.location.host;
				if (data != null) {
					$("#tablist tr").not(':eq(0)').remove();
					var tr_content = '';
					$.each(data,function(index, value) {
						tr_content += "<tr id='tr_"+value.device_id+"'>";
						tr_content += '<td><input type="checkbox" name="device_id[]" value="'+value.device_id+'"></td>';
						tr_content += '<td><img src="'+value.device_mainpic+'" style="width:100px; height:100px;"></td>';
						tr_content += '<td>'+value.device_name+'</td>';
						tr_content += '<td>'+value.device_version+'</td>';
						tr_content += '<td>'+value.device_description+'</td>';
						tr_content += '<td><a href="http://'+hosturl+'/device_update-'+value.device_id+'">修改</a>|<a href="#" onclick="del_device_one('+value.device_id+')">删除</a></td>';
						tr_content += "</tr>";
						$("#tablist").append(tr_content);
					});
				}
			}
		})
	}
}


function device_switch(device_id) {
	if (confirm('你确定更改此设备的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('device_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {device_id: device_id},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					var msg = $('#switch_'+device_id).html();
					if (msg=='启用') {
						$('#switch_'+device_id).html('停用');
					} else {
						$('#switch_'+device_id).html('启用');
					}
				}
			}
		})
	}
}

</script>
