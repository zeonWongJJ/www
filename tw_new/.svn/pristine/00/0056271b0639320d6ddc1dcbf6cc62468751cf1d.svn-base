<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>分组列表</title>
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
	<h1>分组列表</h1>
	<table>
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>分组名称</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_'.$value['group_id']; ?>">
			<td><input type="checkbox" name="group_id[]" value="<?php echo $value['group_id']; ?>"></td>
			<td><?php echo $value['group_id']; ?></td>
			<td><?php echo $value['group_name']; ?></td>
			<td>
				<a href="<?php echo $this->router->url('group_update',['id'=>$value['group_id']]); ?>">修改</a> |
				<a href="#" onclick="group_delete_one(<?php echo $value['group_id']; ?>)">删除</a> |
				<a id="<?php echo 'a_'.$value['group_id']; ?>" href="#" onclick="group_switch(<?php echo $value['group_id']; ?>)"><?php if ($value['group_state'] == 1) { echo '启用'; } else { echo '停用'; } ?></a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br><br>
	<button onclick="group_delete_mony()">批量删除</button>
</body>
</html>

<script>

function group_delete_one(group_id) {
	if (confirm('你确定要删除这条分组信息吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('group_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {group_id: group_id, type: 1},
			success: function(data){
				console.log(data);
				if (data.code==200) {
					$('#tr_'+group_id).remove();
				}
			}
		})
	}
}

function group_delete_mony() {
	var group_ids = new Array();
	var i = 0;
	$("input:checkbox[name='group_id[]']:checked").each(function(index, el) {
		group_ids[i] = $(this).val();
		i++
	});
	if (confirm('你确定要删除这'+group_ids.length+'个分组')) {
		$.ajax({
			url: '<?php echo $this->router->url('group_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {group_ids: group_ids, type: 2},
			success: function(res) {
				console.log(res);
				if (res.code==200) {
					var a_result = res.data;
					for (var i = 0; i<a_result.length; i++) {
						$('#tr_'+a_result[i]).remove();
					}
				}
			}
		})
	}
}

function group_switch(group_id) {
	if (confirm('你确定要更改此分组的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('group_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {group_id: group_id},
			success:function(data){
				console.log(data);
				if (data.code==200) {
					var msg = $("#a_"+group_id).html();
					if (msg=='停用') {
						$("#a_"+group_id).html('启用');
					} else {
						$("#a_"+group_id).html('停用');
					}
				}
			}
		})
	}
}

</script>