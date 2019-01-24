<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加门店管理员</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
</head>
<body>
	<h1>添加门店管理员</h1>
	<form action="<?php echo $this->router->url('manager_add'); ?>" method='post'>
		用户名：<input type="text" name="manager_name"><br>
		密码：<input type="password" name="manager_password"><br>
		所属门店：
		<select name="store_id" onchange="get_role(this.value)">
			<?php foreach ($a_view_data['store'] as $key => $value): ?>
				<option value="<?php echo $value['store_id']; ?>"><?php echo $value['store_name']; ?></option>
			<?php endforeach ?>
		</select>
		<br>
		所属分组：
		<select name="group_id" disabled>
			<option>请先选择所属门店</option>
		</select>
		<br>
		手机号码：<input type="text" name="manager_phone"><br>
		邮箱：<input type="text" name="manager_email"><br>
		<input type="submit" name="添加门店管理员"><br>
	</form>
</body>
</html>

<script>

function get_role(store_id) {
	$.ajax({
		url: '<?php echo $this->router->url('manager_add'); ?>',
		type: 'post',
		dataType: 'json',
		data: {store_id: store_id},
		success: function(data) {
			$("select[name='group_id']").removeAttr('disabled');
			$("select[name='group_id']").html('');
			$.each(data,function(index, value) {
				$("select[name='group_id']").append("<option value='"+value.group_id+"'>"+value.group_name+"</option>");
			});
		}
	})
}
</script>

