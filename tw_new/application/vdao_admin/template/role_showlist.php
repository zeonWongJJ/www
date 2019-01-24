<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>角色列表</title>
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
	<h1>角色列表</h1>
	<table>
		<tr>
			<th></th>
			<th>id</th>
			<th>角色名</th>
			<th>角色备注</th>
			<th>添加时间</th>
			<th>分配权限</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' .$value['role_id']; ?>">
			<td><input type="checkbox" name="role_id[]" value="<?php echo $value['role_id']; ?>"></td>
			<td><?php echo $value['role_id']; ?></td>
			<td><?php echo $value['role_name']; ?></td>
			<td><?php echo $value['role_description']; ?></td>
			<td><?php echo date('Y-m-d H:i:s',$value['add_time']); ?></td>
			<td><a href="<?php echo $this->router->url('role_distribute',['id'=>$value['role_id']]); ?>">分配权限</a></td>
			<td>
				<a href="<?php echo $this->router->url('role_update',['id'=>$value['role_id']]); ?>">修改</a> |
				<a href="#" onclick="del_role_one(<?php echo $value['role_id']; ?>)">删除</a> |
				<a href="#" id="<?php echo 'switch_'.$value['role_id']; ?>" onclick="role_switch(<?php echo $value['role_id']; ?>)"><?php if($value['role_state']==1){echo '启用';}else{echo '禁用';} ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<button onclick="del_role_mony()">批量删除</button>
	<br>
	<h2><a href="<?php echo $this->router->url('role_add'); ?>">添加角色</a></h2>
</body>
</html>


<script>

function del_role_one(role_id) {
	$.ajax({
		url: '<?php echo $this->router->url('role_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {role_id: role_id, type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				$('#tr_'+role_id).remove();
			}
		}
	})
}

function del_role_mony() {
	var role_ids = new Array();
	var i = 0;
	$("input:checkbox[name='role_id[]']:checked").each(function(index, value) {
		role_ids[i] = $(this).val();
		i++;
	});
	$.ajax({
		url: '<?php echo $this->router->url('role_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {role_id: role_ids, type: 2},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				for (var j=0; j<role_ids.length; j++) {
					$('#tr_'+role_ids[j]).remove();
				}
			}
		}
	})
}

function role_switch(role_id) {
	if (confirm('你确定要修改此角色的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('role_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {role_id: role_id},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					var msg = $('#switch_'+role_id).html();
					if (msg=='启用') {
						$('#switch_'+role_id).html('禁用');
					} else {
						$('#switch_'+role_id).html('启用');
					}
				}
			}
		})
	}
}

</script>