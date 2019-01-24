<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>权限列表</title>
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
	<h1>权限列表</h1>
	<h2><a href="<?php echo $this->router->url('auth_add'); ?>">添加权限</a></h2>
	<table>
		<tr>
			<th><input type="checkbox" name="check_all"></th>
			<th>id</th>
			<th>权限名称</th>
			<th>权限url</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['auth_id']; ?>">
			<td><input type="checkbox" name="auth_id[]" value="<?php echo $value['auth_id']; ?>"></td>
			<td><?php echo $value['auth_id']; ?></td>
			<td><?php echo str_repeat('&nbsp;', $value['auth_level']*4); ?>
			<?php if($value['auth_pid']==0){ echo '<b>'. $value['auth_name'] . '</b>'; } else { echo $value['auth_name']; } ?></td>
			<td><?php echo $value['auth_url']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('auth_update',['id'=>$value['auth_id']]); ?>">修改</a> |
				<a href="#" onclick="del_auth_one(<?php echo $value['auth_id']; ?>)">删除</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<br>

</body>
</html>

<script>

function del_auth_one(auth_id) {
	$.ajax({
		url: '<?php echo $this->router->url('auth_delete'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {auth_id: auth_id, type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				$('#tr_'+auth_id).remove();
			}
		}
	})
}

</script>