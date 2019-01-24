<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>门店结算</title>
	<script src="./script/jquery-1.8.2.min.js"></script>
	<style>
	table{
		border-collapse: collapse;
	}
	td,th{
		border:1px solid green;
		padding: 10px;
	}
	</style>
</head>
<body>
	<h1>门店结算</h1>
	<h2>
		筛选：
		时间：
		<select name="account_time" onchange="account_store()">
			<option value="999">全部</option>
			<?php foreach ($a_view_data['month'] as $key => $value): ?>
				<option value="<?php echo $value; ?>"><?php echo date('Y年m月', $value); ?></option>
			<?php endforeach ?>
		</select>
		&nbsp;&nbsp;状态：
		<select name="account_state" onchange="account_store()">
			<option value="999">全部</option>
			<option value="0">待核算</option>
			<option value="1">待结算</option>
			<option value="2">已结算</option>
		</select>
	</h2>
	<table>
		<tr>
			<th>主键id</th>
			<th>门店id</th>
			<th>店铺名称</th>
			<th>店长</th>
			<th>联系电话</th>
			<th>月销售咖啡笔数</th>
			<th>月销售咖啡数量</th>
			<th>月销售金额</th>
			<th>结算状态</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
		<?php foreach ($a_view_data['account'] as $key => $value): ?>
		<tr>
			<td><?php echo $value['account_id']; ?></td>
			<td><?php echo $value['store_id']; ?></td>
			<td><?php echo $value['store_name']; ?></td>
			<td><?php echo $value['store_linkman']; ?></td>
			<td><?php echo $value['store_contact']; ?></td>
			<td><?php echo $value['order_count']; ?></td>
			<td><?php echo $value['product_count']; ?></td>
			<td><?php echo $value['money_count']; ?></td>
			<td><?php if($value['account_state']==0){ echo '待核算'; } else if($value['account_state']==1) { echo '待结算'; } else { echo '已结算'; }; ?></td>
			<td><?php echo date('Y年m月', $value['account_time']); ?></td>
			<td><a href="<?php echo $this->router->url('account_detail',['id'=>$value['account_id']]); ?>">查看明细</a></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $this->pages->link_style_one($this->router->url('account_store-', [], false, false)); ?>
</body>
</html>

<script>
function account_store() {
	// 获取筛选条件
	var account_time = $("select[name='account_time']").val();
	var account_state = $("select[name='account_state']").val();
	$.ajax({
		url: '<?php echo $this->router->url('account_store'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {account_time: account_time, account_state: account_state },
		success:function(res){
			console.log(res);
			$("table tr").not(':eq(0)').remove();
			var append_content = '';
			$.each(res,function(index, v) {
				append_content += "<tr>";
				append_content += "<td>"+v.account_id+"</td>";
				append_content += "<td>"+v.store_id+"</td>";
				append_content += "<td>"+v.store_name+"</td>";
				append_content += "<td>"+v.store_linkman+"</td>";
				append_content += "<td>"+v.store_contact+"</td>";
				append_content += "<td>"+v.order_count+"</td>";
				append_content += "<td>"+v.product_count+"</td>";
				append_content += "<td>"+v.money_count+"</td>";
				append_content += "<td>"+v.account_state+"</td>";
				append_content += "<td>"+v.account_time+"</td>";
				append_content += "<td><a href='/account_detail-"+v.account_id+"'>查看明细</a></td>";
				append_content += "</tr>";
			});
			$("table").append(append_content);
		}
	})
}
</script>