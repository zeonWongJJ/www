<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>查看明细</title>
	<style>
	table{
		border-collapse: collapse;
	}
	td,th{
		border:1px solid green;
		padding: 10px;
	}
	</style>
	<script src="./script/jquery-1.8.2.min.js"></script>
</head>
<body>
	<h1>查看明细</h1>
	<div style="border:1px solid red; padding:10px;">
		<h2>分店信息</h2>
		<p>分店id：<?php echo $a_view_data['detail']['store_id']; ?></p>
		<p>分店名：<?php echo $a_view_data['detail']['store_name']; ?></p>
		<p>店长：<?php echo $a_view_data['detail']['store_linkman']; ?></p>
		<p>联系电话：<?php echo $a_view_data['detail']['store_contact']; ?></p>
		<p>地址：<?php echo $a_view_data['detail']['store_address']; ?></p>
	</div>
	<div style="border:1px solid green; margin-top:10px; padding:10px;">
		<h2>最近三个月结算状态</h2>
		<?php foreach ($a_view_data['recently'] as $key => $value): ?>
			<div style="margin:10px;">
				<span>时间：<?php echo date('Y年m月', $value['account_time']); ?></span>&nbsp;&nbsp;
				<span>金额：<?php echo $value['money_count']; ?></span>&nbsp;&nbsp;
				<span><a href="<?php echo $this->router->url('account_detail',['id'=>$value['account_id']]); ?>">前去结算</a></span>&nbsp;&nbsp;
			</div>
		<?php endforeach ?>
	</div>
	<div style="border:1px solid pink; margin-top:10px; padding:10px;">
		<h2>当月订单</h2>
		<table>
			<tr>
				<th>序号</th>
				<th>订单号</th>
				<th>下单时间</th>
				<th>成交时间</th>
				<th>咖啡数量</th>
				<th>总金额</th>
			</tr>
			<?php foreach ($a_view_data['order'] as $key => $value): ?>
			<tr>
				<td><?php echo $value['order_id']; ?></td>
				<td><?php echo $value['order_number']; ?></td>
				<td><?php echo date('Y-m-d H:i:s',$value['time_create']); ?></td>
				<td><?php echo date('Y-m-d H:i:s',$value['order_time']); ?></td>
				<td><?php echo $value['order_count']; ?></td>
				<td><?php echo $value['goods_amount']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		<?php echo $this->pages->link_style_one($this->router->url('account_detail-'.$a_view_data['detail']['account_id'].'-', [], false, false)); ?>
	</div>
	<div style="border:1px solid #cccccc; margin-top:10px; padding:10px;">
		<?php if ($a_view_data['detail']['account_state']==0) { echo '系统核算金额为：'.$a_view_data['detail']['money_count'].'&nbsp;&nbsp;'.'<a href="#" onclick="account_update_show('.$a_view_data['detail']['account_id'].')">去核算</a>'; } else if($a_view_data['detail']['account_state']==1) { echo '结算金额为：'.$a_view_data['detail']['money_update'].'&nbsp;&nbsp;备注：'.$a_view_data['detail']['remark_update'].'&nbsp;&nbsp;<a href="#" onclick="account_statement()">去结算</a>'; } else { echo '已结算金额：'.$a_view_data['detail']['money_update']; } ?>

	</div>
	<div id="div_update" style="border:1px solid green; margin-top:10px; padding:10px; display:none;">
		<h3>确认核算金额</h3>
		系统核算金额：<span style="color:red;"><?php echo $a_view_data['detail']['money_count']; ?></span><br>
		系统核算金额是否正确：<input type="radio" name="is_correct" value="1">核算正确
					  		  <input type="radio" name="is_correct" value="2">核算有误<br>
		修改核算金额：<input type="text" name="account_moey" onBlur="change_span()" value="<?php echo $a_view_data['detail']['money_count']; ?>" >
		原核算金额为：<span id="box2"><?php echo $a_view_data['detail']['money_count']; ?></span>
		<br>
		备注：<input type="text" name="remark_update"><br>
		<button onclick="account_update()">确定核算</button>
	</div>
</body>
</html>

<script>

function account_update_show(account_id) {
	var div_display = $('#div_update').css('display');
	if (div_display== 'block') {
		 $('#div_update').css('display', 'none');
	} else {
		 $('#div_update').css('display', 'block');
	}
}

function change_span() {
	var old_value = "<?php echo $a_view_data['detail']['money_count']; ?>";
	var new_value = $("input[name='account_moey']").val();
	if ((new_value - old_value) > 0) {
		$('#box2').html(old_value+'，增加了'+(new_value-old_value)+'元');
	} else {
		$('#box2').html(old_value+'，减少了'+(old_value-new_value)+'元');
	}
}

function account_update() {
	var account_id = "<?php echo $a_view_data['detail']['account_id']; ?>";
	var new_value = $("input[name='account_moey']").val();
	var remark_update = $("input[name='remark_update']").val();
	var is_correct = $("input[name='is_correct']").val();
	if (remark_update != '') {
		$.ajax({
			url: '<?php echo $this->router->url('account_update'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {account_id: account_id, new_value: new_value, remark_update: remark_update, is_correct: is_correct},
			success: function(data){
				console.log(data);
				window.location.reload();
			}
		})
	}
}


function account_statement() {
	var account_id = "<?php echo $a_view_data['detail']['account_id']; ?>";
	var money_update = "<?php echo $a_view_data['detail']['money_update']; ?>";
	if (confirm('结算金额为'+money_update+'元，确定现在结算吗？')) {
		$.ajax({
			url: '<?php echo $this->router->url('account_statement'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {account_id: account_id},
			success: function(res) {
				console.log(res);
				alert(res.msg);
				if (res.code==200) {
					window.location.reload();
				}
			}
		})
	}
}

</script>