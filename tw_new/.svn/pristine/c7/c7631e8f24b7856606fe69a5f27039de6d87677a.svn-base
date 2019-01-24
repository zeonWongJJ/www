<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<script src="./script/jquery-1.8.2.min.js"></script>
	<title>用户列表</title>
	<style>
		table {
			border-collapse: collapse;
			border: 1px solid green;
		}
		table td,th {
			padding: 0 10px;
			height: 35px;
			border: 1px solid green;
		}
	</style>
</head>
<body>

	<input type="text" name="keywords" onkeydown="KeyDown()">
	<button onclick="search()">搜索</button><br><br>

	<table id="tablist">
		<tr>
			<th>选择</th>
			<th>id</th>
			<th>用户名</th>
			<th>手机</th>
			<th>邮箱</th>
			<th>积分</th>
			<th>余额</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
			<tr id="<?php echo 'tr_' . $value['user_id']; ?>">
				<td><input type="checkbox" name="user_id[]" value="<?php echo $value['user_id']; ?>"></td>
				<td><?php echo $value['user_id']; ?></td>
				<td><?php echo $value['user_name']; ?></td>
				<td><?php echo $value['user_phone']; ?></td>
				<td><?php echo $value['user_email']; ?></td>
				<td><?php echo $value['user_score']; ?></td>
				<td><?php echo $value['user_balance']; ?></td>
				<td>
					<a href="<?php echo $this->router->url('user_update',['id'=>$value['user_id']]); ?>">修改</a> |
					<a href="#" onclick="user_delete_one(<?php echo $value['user_id']; ?>)">删除</a> |
					<a href="#" id="<?php echo "switch_".$value['user_id'];?>" onclick="user_switch(<?php echo $value['user_id']; ?>)"><?php if($value['user_state']==1){ echo "已启用"; } else if($value['user_state']==2) { echo "已禁用"; } else if($value['user_state']==0) { echo "待审核"; } ?></a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<br>
	<br>
	<button onclick="user_delete_mony()">批量删除</button>
	<br>
	<h2><a href="<?php echo $this->router->url('user_add'); ?>">添加用户</a></h2>

</body>
</html>

<script>

function search() {
	var keywords = $("input[name='keywords']").val();
	$.ajax({
		url: '<?php echo $this->router->url('user_search'); ?>',
		type: 'post',
		data: {'keywords':keywords},
		dataType: 'json',
		success: function(data){
			console.log(data);
			//将数据遍历到表格
			if (data==null) {
				alert('未搜索到任何数据');
			} else {
				$("#tablist tr").not(':eq(0)').remove();
				$.each(data, function (n, value) {
		              $('#tablist').append("<tr><td>"+value.user_id+"</td><td>"+value.user_name+"</td><td>"+value.user_phone+"</td><td>"+value.user_email+"</td></tr>")
		        });
			}
		}
	});
}

function KeyDown(){
	if (event.keyCode == 17){
		search();
	}
}


function user_switch(user_id) {
	if (confirm('你确定要更改些用户的状态吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('user_switch'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id},
			success:function(data) {
				console.log(data);
				if (data.code==200) {
					var msg = $('#switch_'+user_id).html();
					if (msg=='已启用') {
						$('#switch_'+user_id).html('已禁用');
					} else {
						$('#switch_'+user_id).html('已启用');
					}
				}
			}
		})
	}
}


function user_delete_one(user_id) {
	if (confirm('你确定要删除这个用户吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('user_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id, type: 1},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					$("#tr_"+user_id).remove();
				}
			}
		})
	}
}


function user_delete_mony() {
	var user_ids = new Array();
	var i = 0;
	$("input:checkbox[name='user_id[]']:checked").each(function(index, el) {
		user_ids[i] = $(this).val();
		i++
	});
	if (confirm('你确定要删除这'+user_ids.length+'个用户吗?')) {
		$.ajax({
			url: '<?php echo $this->router->url('user_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_ids: user_ids, type: 2},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					for (var j=0; j<user_ids.length; j++) {
						$('#tr_'+user_ids[j]).remove();
					}
				}
			}
		})
	}
}

</script>


