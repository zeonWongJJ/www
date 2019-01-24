<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加门店产品</title>
	<style>
		a{text-decoration:none; color:#666;}
		table{
			border-collapse: collapse;
		}
		th,td{
			padding: 5px;
			border: 1px solid green;
		}
	</style>
	<script src='script/jquery-1.8.2.min.js'></script>
</head>
<body>
<h1 style="float: right;"><a href="store_product" style="font-size:22px;">我的门店产品</a></h1>
	<h1>添加产品</h1>
	<table id="tablist">
		<tr>
			<th>选中</th>
			<th>图片</th>
			<th>名称</th>
			<th>分类</th>
			<th>大杯价格</th>
			<th>中杯价格</th>
			<th>小杯价格</th>
			<th>产品详情</th>
			<th>要消耗的材料</th>
			<th>添加</th>
		</tr>
		<?php foreach ($a_view_data['product'] as $product): ?>
		<tr>
			<td><input type="checkbox" name="product_id[]" value="<?php echo $product['product_id']; ?>"></td>
			<td><img style="width:100px;" src="<?php echo $product['pro_img']; ?>" /></td>
			<td><?php echo $product['product_name']; ?></td>
			<td><?php echo $product['prot_name']; ?></td>
			<td><?php echo $product['jorum_money']; ?></td>
			<td><?php echo $product['short_money']; ?></td>
			<td><?php echo $product['tassie_money']; ?></td>
			<td><?php echo $product['pro_details']; ?></td>
			<td><?php echo $product['pro_id']; ?></td>
			<td>
				<a href="#" onclick="product_add_one(<?php echo $product['product_id']; ?>)">添加</a>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php echo $a_view_data['pages']?>
	<button onclick="product_add_mony()">批量添加</button>
</body>
</html>

<script>

function product_add_one(product_id) {
	con=confirm("你确定要添加这个产品吗？?");
    if(con==true) {
		$.ajax({
			url: '<?php echo $this->router->url('product_add'); ?>',
			type: 'POST',
			dataType: 'json',
			data: {product_id: product_id, type: 1},
			success:function(data) {
				if (data.code == 22) {
					alert('添加产品成功！');
				} else if (data.code == 33) {
					alert('产品已添加过！');
				} else {
					alert('产品添加失败！');
				};
			}
		});
	}
}

function product_add_mony() {
	var goods_id = new Array();
	var i = 0;
	$("input:checkbox[name='product_id[]']:checked").each(function(index, el) {
		goods_id[i] = $(this).val();
		i++;
	});
	if (goods_id.length<1) {
		alert('请选择需要添加的产品');
	} else {
		con=confirm('你确定要添加这'+goods_id.length+'个产品吗？');
    	if(con==true) {
			$.ajax({
				url: '<?php echo $this->router->url('product_add'); ?>',
				type: 'POST',
				dataType: 'json',
				data: {goods_id: goods_id, type: 2},
				success:function(data) {
					if (data.code == 22) {
						alert('添加产品成功！');
					} else {
						alert('产品添加失败！');
					};
				}
			})
		}
	}
}

</script>