<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>办公室类型</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			width: 700px;
			border-collapse: collapse;
		}
		th,td{
			padding: 10px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>办公室类型</h1>
	搜索类型：<input type="text" name="type_search">&nbsp;<button onclick="type_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th></th>
			<th>id</th>
			<th>类型名称</th>
			<th>排序</th>
			<th>类型描述</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['type_id']; ?>">
			<td><input type="checkbox" name="type_id[]" value="<?php echo $value['type_id']; ?>"></td>
			<td><?php echo $value['type_id']; ?></td>
			<td>
			<?php echo str_repeat('&nbsp;', $value['type_level']*4) . $value['type_name']; ?>
			</td>
			<td><?php echo $value['type_order']; ?></td>
			<td><?php echo $value['type_description']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('type_update',['id'=>$value['type_id']]); ?>">修改</a> |
				<a href="#" onclick="del_type_one(<?php echo $value['type_id']; ?>)">删除</a> |
				<a href="#" id="<?php echo "switch_" . $value['type_id']; ?>" onclick="type_switch(<?php echo $value['type_id']; ?>)"><?php if($value['type_state']==1){echo '开启';}else{echo '关闭';} ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<button onclick="del_type_mony()">批量删除</button>
	<br>
	<h2><a href="<?php echo $this->router->url('type_add'); ?>">添加类型</a></h2>
</body>
</html>

<script>

function del_type_one(type_id) {
	$.ajax({
		url: '<?php echo $this->router->url('type_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {type_id: type_id, type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				$('#tr_'+type_id).remove();
			}
		}
	})
}

function del_type_mony() {
	var type_ids = new Array();
	var i = 0;
	$("input:checkbox[name='type_id[]']:checked").each(function(index, el) {
		type_ids[i] = $(this).val();
		i++
	});
	$.ajax({
		url: '<?php echo $this->router->url('type_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {type_ids: type_ids, type: 2},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				for (var j=0; j<type_ids.length; j++) {
					$('#tr_'+type_ids[j]).remove();
				}
			}
		}
	})
}

function type_switch(type_id){
	if (confirm('你确定更改此类型的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('type_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {type_id: type_id},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					var msg = $('#switch_'+type_id).html();
					if (msg=='开启') {
						$('#switch_'+type_id).html('关闭');
					} else {
						$('#switch_'+type_id).html('开启');
					}
				}
			}
		})
	}
}

function type_search() {
	var keywords = $("input[name='type_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('type_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords},
			success: function(data){
				console.log(data);
			}
		})
	}
}

</script>