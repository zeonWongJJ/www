<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>资金变动列表</title>
	<style>
		table{
			border-collapse: collapse;
		}
		th,td{
			border:1px solid #009688;
			padding: 10px;
		}
		#page_div {
			overflow: hidden;
			height: 50px;
			margin-top: 20px;
		}
		#page_div a {
			width: 50px;
			height: 30px;
			border-right:1px dotted #fff;
			text-decoration: none;
			color: #FFF;
			background-color: #009688;
			padding: 5px;
			line-height: 30px;
			text-align: center;
			font-size: 14px;
		}
	</style>
	<script src='./script/jquery-1.8.2.min.js'></script>
</head>
<body>
	<h1>资金变动列表</h1>
	<h2>总资金：
		<span style="color:red;"><?php echo $a_view_data['store']['store_balance']; ?></span>
		<a href="<?php echo $this->router->url('balance_withdraw'); ?>">提现</a>
	</h2>
	筛选：
	<select name="balance_type" onchange="balance_showlist(this.value)">
		<option value="999">全部</option>
		<option value="1">进账</option>
		<option value="2">支出</option>
	</select>
	<br>
	<table>
		<tr>
			<th>id</th>
			<th>变动金额</th>
			<th>时间</th>
			<th>备注</th>
		</tr>
		<?php foreach ($a_view_data['balance'] as $key => $value): ?>
		<tr>
			<td><?php echo $value['balance_id']; ?></td>
			<td>
				<?php
					if ($value['balance_type']==1) {
						echo "<span style='color:green;'>+".$value['balance_number']."</span>";
					} else {
						echo "<span style='color:#FF5722;'>-".$value['balance_number']."</span>";
					}
				?>
			</td>
			<td><?php echo date('Y-m-d H:i:s',$value['balance_time']); ?></td>
			<td><?php echo $value['balance_description']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<div id="page_div">
		<?php echo $this->pages->link_style_one($this->router->url('balance_showlist-', [], false, false)); ?>
	</div>
</body>
</html>

<script>
function balance_showlist(balance_type) {
	$.ajax({
		url: '<?php echo $this->router->url('balance_showlist'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {balance_type: balance_type},
		success: function(res) {
			console.log(res);
			if (res.code==400) {
				alert('没有相关数据');
			} else {
				$("table tr").not(':eq(0)').remove();
				var append_content = '';
				$.each(res.data, function(index, v) {
					append_content += "<tr>";
					append_content += "<td>"+v.balance_id+"</td>";
					if (v.balance_type==1) {
						append_content += "<td><span style='color:green;'>+"+v.balance_number+"</span></td>";
					} else {
						append_content += "<td><span style='color:#FF5722;'>-"+v.balance_number+"</span></td>";
					}
					append_content += "<td>"+v.balance_time+"</td>";
					append_content += "<td>"+v.balance_description+"</td>";
					append_content += "</tr>";
				});
				$("table").append(append_content);
			}
		}
	})
}
</script>