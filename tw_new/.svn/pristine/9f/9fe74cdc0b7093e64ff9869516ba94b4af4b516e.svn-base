<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>所有推荐人</title>
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
	<h1>所有推荐人</h1>
	搜索：<input type="text" name="shopman_search">&nbsp;<button onclick="shopman_search()">搜索</button>
	<br><br>
	<table>
		<tr>
			<th>选中</th>
			<th>id</th>
			<th>用户昵称</th>
			<th>性别</th>
			<th>手机号码</th>
			<th>消费总金额</th>
			<th>提成</th>
			<th>注册时间</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data['referee'] as $key => $value): ?>
		<tr>
			<td><input type="checkbox" name="user_id[]" value="<?php echo $value['user_id']; ?>"></td>
			<td><?php echo $value['user_id']; ?></td>
			<td><?php echo $value['user_name']; ?></td>
			<td><?php if($value['user_sex']==1){ echo '男'; }else if($value['user_sex']==2) { echo "女"; } else { echo "未知"; } ?></td>
			<td><?php echo $value['user_phone']; ?></td>
			<td><?php echo $value['user_consume']; ?></td>
			<td><?php echo $value['user_commission']; ?></td>
			<td><?php echo date('Y-m-d',$value['user_regtime']); ?></td>
			<td>
				<a href="<?php echo $this->router->url('shopman_referee_detail',['uid'=>$value['user_id']]); ?>">查看明细</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<br><br>
	<?php echo $this->pages->link_style_one($this->router->url('shopman_referee', ['uid'=>$a_view_data['user_id'],''], false, false)); ?>
</body>
</html>

<script>
function shopman_search() {
	var keywords = $("input[name='shopman_search']").val();
	if (keywords != '') {
		$.ajax({
			url: '<?php echo $this->router->url('shopman_search'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {keywords: keywords, user_id: <?php echo $a_view_data['user_id']; ?>, type: 2},
			success: function(data) {
				console.log(data);
			}
		})
	}
}
</script>