<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>门店管理员</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			width: 500px;
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>门店管理员列表</h1>
	<table>
		<tr>
			<th><input type="checkbox" name="all" /></th>
			<th>id</th>
			<th>用户名</th>
			<th>所属门店</th>
			<th>所属分组</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['manager_id']; ?>">
			<td><input type="checkbox" name="manager_id[]" value="<?php echo $value['manager_id'] . '-' . $value['group_id']; ?>"  ></td>
			<td><?php echo $value['manager_id']; ?></td>
			<td><?php echo $value['manager_name']; ?></td>
			<td><?php echo $value['store_name']; ?></td>
			<td><?php echo $value['group_name']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('manager_update',['id'=>$value['manager_id']]); ?>">修改</a> |
				<a href="#" onclick="del_manager_one(<?php echo $value['manager_id'] . ',' . $value['group_id']; ?>)">删除</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<button onclick="del_manager_mony()">批量删除</button>
	<br>
	<h2><a href="<?php echo $this->router->url('manager_add'); ?>">添加门店管理员</a></h2>
</body>
</html>

<script>

function del_manager_one(manager_id, group_id) {
	$.ajax({
		url: '<?php echo $this->router->url('manager_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {manager_id: manager_id, group_id: group_id, type: 1},
		success: function(data) {
			console.log(data);
			$('#tr_'+manager_id).remove();
		}
	})
}

function del_manager_mony() {
	var value_ids = new Array();
	var manager_ids = new Array();
	var group_ids = new Array();
	var i = 0;
	$("input:checkbox[name='manager_id[]']:checked").each(function(index, value) {
		value_ids[i]    = $(this).val();
		var value_array = value_ids[i].split('-');
		manager_ids[i]  = value_array[0];
		group_ids[i]     = value_array[1];
		i++;
	});
	$.ajax({
		url: '<?php echo $this->router->url('manager_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {manager_id: manager_ids, group_id: group_ids, type: 2},
		success: function(data) {
			console.log(data);
			for (var j=0; j<manager_ids.length; j++) {
				$('#tr_'+manager_ids[j]).remove();
			}
		}
	})
}


</script>
