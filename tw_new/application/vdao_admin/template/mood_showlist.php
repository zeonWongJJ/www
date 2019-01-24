<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>帖子列表</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 10px;
			border: 1px solid green;
		}
	</style>
	<script src="./script/jquery-1.8.2.min.js"></script>
</head>
<body>
	<h1>帖子列表</h1>
	<table>
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>内容</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_' . $value['mood_id']; ?>">
			<td><input type="checkbox" name="mood_id[]" value="<?php echo $value['mood_id']; ?>"></td>
			<td><?php echo $value['mood_id']; ?></td>
			<td><?php echo $value['mood_content']; ?></td>
			<td>
				<a href="#" onclick="mood_switch(<?php echo $value['mood_id']; ?>)"><?php if($value['mood_state']==1) { echo '已审核'; } else { echo '待审核'; } ?></a> |
				<a href="#" onclick="mood_delete(<?php echo $value['mood_id'] ?>)">删除</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>

	<button onclick="mood_delete_mony()">批量删除</button>
</body>
</html>

<script>
function mood_switch(mood_id){
	if(confirm('你确定要更改此帖子的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('mood_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {mood_id: mood_id},
			success: function(data) {
				console.log(data);
			}
		})
	}
}

function mood_delete(mood_id){
	if(confirm('你确定要删除这篇帖子吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('mood_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {mood_id: mood_id, type: 1},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					$('#tr_'+mood_id).remove();
				}
			}
		})
	}
}

function mood_delete_mony() {
	var mood_ids = new Array();
	var i = 0;
	$("input:checkbox[name='mood_id[]']:checked").each(function(index, value) {
		mood_ids[i] = $(this).val();
		i++;
	});
	$.ajax({
		url: '<?php echo $this->router->url('mood_delete'); ?>',
		type: 'post',
		dataType: 'json',
		data: {type: 2, mood_ids:mood_ids},
		success: function(data) {
			console.log(data);
			for (var j = 0; j<mood_ids.length; j++) {
				$('#tr_'+mood_ids[j]).remove();
			}
		}
	})
}

</script>