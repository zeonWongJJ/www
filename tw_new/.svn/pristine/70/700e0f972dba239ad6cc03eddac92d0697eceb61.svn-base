<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>管理员列表</title>
	<style>
		table{
			border-collapse: collapse;
		}
		td,th{
			border:1px solid green;
			padding: 10px;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>管理员列表</h1>
	<table>
		<tr>
			<td>选择</td>
			<td>id</td>
			<td>用户名</td>
			<td>分组</td>
			<td>操作</td>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_'.$value['manager_id']; ?>">
			<td><input type="checkbox" name="manager_id[]" value="<?php echo $value['manager_id']; ?>"></td>
			<td><?php echo $value['manager_id']; ?></td>
			<td><?php echo $value['manager_name']; ?></td>
			<td><?php echo $value['group_name']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('manager_update',['id'=>$value['manager_id']]); ?>">修改</a> |
				<a href="#" onclick="manager_delete_one(<?php echo $value['manager_id']; ?>)">删除</a>
				<a href="#" id="<?php echo 'a_'.$value['manager_id']; ?>" onclick="manager_switch(<?php echo $value['manager_id']; ?>)" ><?php if($value['manager_state']==1){ echo '已开启'; }else{ echo '已停用'; } ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<button onclick="manager_delete_mony()">批量删除</button>
	<h1><a href="<?php echo $this->router->url('manager_add'); ?>">添加管理员</a></h1>
</body>
</html>

<script>

function manager_delete_one(manager_id) {
	if (confirm('你确定要删除这个管理员吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('manager_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {manager_id: manager_id, type: 1},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+manager_id).remove();
				}
			}
		})
	}
}

function manager_delete_mony() {
	var manager_ids = new Array();
	var i = 0;
	$("input:checkbox[name='manager_id[]']:checked").each(function(index, el) {
		manager_ids[i] = $(this).val();
		i++
	});
	if (confirm('你确定要删除这'+manager_ids.length+'个管理员吗')) {
		$.ajax({
			url: '<?php echo $this->router->url('manager_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {manager_ids: manager_ids, type: 2},
			success: function(res) {
				console.log(res);
				if (res.code==200) {
					for (var i = 0; i<manager_ids.length; i++) {
						$('#tr_'+manager_ids[i]).remove();
					}
				}
			}
		})
	}
}

function manager_switch(manager_id) {
	if (confirm('你确定更改状态吗')) {
		$.ajax({
			url: '<?php echo $this->router->url('manager_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {manager_id: manager_id},
			success : function(data) {
				console.log(data);
				if (data.code==200) {
					var msg = $('#a_'+manager_id).html();
					if (msg=='已开启') {
						 $('#a_'+manager_id).html('已停用');
					} else {
						 $('#a_'+manager_id).html('已开启');
					}
				}
			}
		})
	}
}

</script>