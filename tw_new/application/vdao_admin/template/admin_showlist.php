<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>管理员列表</title>
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
	<h1>管理员列表</h1>
	<table>
		<tr>
			<th><input type="checkbox" name="admin_id_all"></th>
			<th>id</th>
			<th>用户名</th>
			<th>姓名</th>
			<th>性别</th>
			<th>所属角色</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
			<tr id="<?php echo 'tr_' . $value['admin_id']; ?>">
				<td><input type="checkbox" name="admin_id[]" value="<?php echo $value['admin_id'] . '-' . $value['role_id']; ?>"></td>
				<td><?php echo $value['admin_id']; ?></td>
				<td><?php echo $value['admin_name']; ?></td>
				<td><?php echo $value['admin_realname']; ?></td>
				<td><?php if($value['admin_sex']==0){echo '未知';} else if($value['admin_sex']==1){echo '男';}else{echo "女";} ?></td>
				<td><?php echo $value['role_name']; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$value['register_time']); ?></td>
				<td>
					<a href="<?php echo $this->router->url('admin_update',['id'=>$value['admin_id']]); ?>">修改</a> |
					<a href="#" onclick="del_admin_one(<?php echo $value['admin_id'] . ',' . $value['role_id']; ?>)">删除</a>|
					<a href="#" id="<?php echo 'switch_'.$value['admin_id']; ?>" onclick="admin_switch(<?php echo $value['admin_id']; ?>)"><?php if($value['admin_state']==1){echo '启用';}else{echo '禁用';} ?></a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<br>
	<h1><a href="<?php echo $this->router->url('admin_add'); ?>">添加管理员</a></h1>
	<button onclick="del_admin_mony()">批量删除</button>
</body>
</html>

<script>

function del_admin_one(admin_id, role_id) {
	$.ajax({
		url: '<?php echo $this->router->url('admin_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {admin_id: admin_id, role_id: role_id, type: 1},
		success: function(data) {
			console.log(data);
			$('#tr_'+admin_id).remove();
		}
	})
}

function del_admin_mony() {
	var value_ids = new Array();
	var admin_ids = new Array();
	var role_ids = new Array();
	var i = 0;
	$("input:checkbox[name='admin_id[]']:checked").each(function(index, value) {
		value_ids[i]    = $(this).val();
		var value_array = value_ids[i].split('-');
		admin_ids[i]  = value_array[0];
		role_ids[i]     = value_array[1];
		i++;
	});
	$.ajax({
		url: '<?php echo $this->router->url('admin_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {admin_id: admin_ids, role_id: role_ids, type: 2},
		success: function(data) {
			console.log(data);
			for (var j=0; j<admin_ids.length; j++) {
				$('#tr_'+admin_ids[j]).remove();
			}
		}
	})
}

function admin_switch(admin_id) {
	if(confirm('你确定要更新这个管理员的状态吗？')){
		$.ajax({
			url: '<?php echo $this->router->url('admin_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {admin_id: admin_id},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					var msg = $('#switch_'+admin_id).html();
					if (msg=='启用') {
						$('#switch_'+admin_id).html('禁用');
					} else {
						$('#switch_'+admin_id).html('启用');
					}
				}
			}
		})
	}
}

</script>