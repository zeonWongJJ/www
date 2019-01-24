<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>已搁置列表</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
</head>
<body>
	<h1>已搁置列表</h1>
	搜索店主：<input type="text" name="shopman_search">&nbsp;<button onclick="shopman_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th>选中</th>
			<th>id</th>
			<th>用户昵称</th>
			<th>性别</th>
			<th>手机号码</th>
			<th>推荐人数</th>
			<th>消费总金额</th>
			<th>推荐人消费总金额</th>
			<th>注册时间</th>
			<th>申请时间</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr id="<?php echo 'tr_'.$value['user_id']; ?>">
			<td><input type="checkbox" name="user_id[]" value="<?php echo $value['user_id']; ?>"></td>
			<td><?php echo $value['user_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php if($value['user_sex']==1){ echo '男'; }else if($value['user_sex']==2) { echo "女"; } else { echo "未知"; } ?></td>
			<td><?php echo $value['user_phone']; ?></td>
			<td><?php echo $value['referee_count']; ?></td>
			<td><?php echo $value['user_consume']; ?></td>
			<td><?php echo $value['referee_consume']; ?></td>
			<td><?php echo date('Y-m-d',$value['user_regtime']); ?></td>
			<td><?php echo date('Y-m-d',$value['shopman_regtime']); ?></td>
			<td>
				<a href="<?php echo $this->router->url('shopman_detail',['id'=>$value['user_id']]); ?>">查看</a> |
				<a href="#" onclick="shopman_accept(<?php echo $value['user_id']; ?>)">接受</a> |
				<a href="#" onclick="shopman_delete_one(<?php echo $value['user_id']; ?>)">删除</a>
			</th>
		</tr>
		<?php endforeach ?>
	</table>
	<br>
	<button onclick="shopman_delete_mony()">批量删除</button>
</body>
</html>

<script>

function shopman_delete_one(user_id) {
	if (confirm('你确定要删除这个店主吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id, type: 1},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					$('#tr_'+user_id).remove();
				}
			}
		})
	}
}

function shopman_delete_mony() {
	var user_ids = new Array();
	var i = 0;
	$("input:checkbox[name='user_id[]']:checked").each(function(index, el) {
		user_ids[i] = $(this).val();
		i++;
	});
	if (confirm('你确定要删除这'+user_ids.length+'位店主吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_delete'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_ids: user_ids, type: 2},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					for (var j=0; j<user_ids.length; j++) {
						$("#tr_"+user_ids[j]).remove();
					}
				}
			}
		})
	}
}

//接受申请
function shopman_accept(user_id) {
	if (confirm('你确定要接受申请吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_accept'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id},
			success: function(data) {
				console.log(data);
				if (data.code==200) {
					$("#tr_"+user_id).remove();
				}
			}
		})
	}
}

function shopman_search() {
	var keywords = $("input[name='shopman_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords, is_shopman: 4, type: 1},
			success: function(data) {
				console.log(data);
			}
		})
	}
}

</script>