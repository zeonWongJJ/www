<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>结算列表</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 10px;
			border:1px solid pink;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>结算列表</h1>
	筛选：
	<select name="account_state" onchange="account_state(this.value)">
		<option value="999">全部</option>
		<option value="0">待核算</option>
		<option value="1">待结算</option>
		<option value="2">已结算</option>
	</select>
	<br><br>
	<table>
		<tr>
			<th>id</th>
			<th>结算时间</th>
			<th>订单总数</th>
			<th>销售餐饮总数</th>
			<th>系统核算金额</th>
			<th>实际打款金额</th>
			<th>打款备注</th>
			<th>结算状态</th>
			<th>查看明细</th>
		</tr>
		<?php foreach ($a_view_data as $key => $value): ?>
		<tr>
			<td><?php echo $value['account_id']; ?></td>
			<td><?php echo date('Y年m月', $value['account_time']); ?></td>
			<td><?php echo $value['order_count']; ?></td>
			<td><?php echo $value['product_count']; ?></td>
			<td><?php echo $value['money_count']; ?></td>
			<td><?php echo $value['money_update']; ?></td>
			<td><?php echo $value['remark_update']; ?></td>
			<td><?php if($value['account_state']==0){ echo '待核算'; } else if ($value['account_state']==1) { echo '待结算'; } else if ($value['account_state']==2) { echo '已结算'; } ?></td>
			<td><a href="<?php echo $this->router->url('account_detail',['id'=>$value['account_id']]); ?>">查看明细</a></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('account_showlist-', [], false, false)); ?>
</body>
</html>

<script>
function account_state(account_state) {
	$.ajax({
		url: '<?php echo $this->router->url('account_showlist'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {account_state: account_state},
		success: function(res) {
			console.log(res);
			if (res.code == 400) {
				alert('没有相关数据');
			} else {
				$("table tr").not(':eq(0)').remove();
				var append_content = '';
				$.each(res.data, function(index, v) {
					append_content += "<tr>";
					append_content += "<td>"+v.account_id+"</td>";
					append_content += "<td>"+v.account_time+"</td>";
					append_content += "<td>"+v.order_count+"</td>";
					append_content += "<td>"+v.product_count+"</td>";
					append_content += "<td>"+v.money_count+"</td>";
					append_content += "<td>"+v.money_update+"</td>";
					append_content += "<td>"+v.remark_update+"</td>";
					append_content += "<td>"+v.account_state+"</td>";
					append_content += "<td><a href='/account_detail-"+v.account_id+"'>查看明细</a></td>";
					append_content += "</tr>";
				});
				$("table").append(append_content);
			}
		}
	})
}
</script>