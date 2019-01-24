<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>门店详情</title>
	<script src='./script/jquery-1.8.2.min.js'></script>
	<script src="static/style_default/script/common.js" type="text/javascript"></script>
</head>
<body>
	<h1>门店详情</h1>
	<h2>门店名称：<?php echo $a_view_data['detail']['store_name']; ?></h2>
	<h3><a href="<?php echo $this->router->url('store_detail_more',['id'=>$a_view_data['detail']['store_id']]); ?>">查看更多</a></h3>
	<h3><a href="#" onclick="store_collect(<?php echo $a_view_data['detail']['store_id']; ?>)">收藏门店</a></h3>
	<h2>共享办公室</h2>
	<?php if(!empty($a_view_data['office'])){ ?>
	<?php foreach ($a_view_data['office'] as $key => $value): ?>
		<li><?php echo $value['room_name'].'&nbsp;&nbsp;&nbsp;'.$value['room_size'].'m<sup>2</sup>&nbsp;&nbsp;&nbsp;'.$value['device'].'&nbsp;&nbsp;&nbsp;可坐'.$value['room_seat'].'人'; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $this->router->url('office_detail',['id'=>$value['office_id']]); ?>">查看详情</a> |
		<a href="#" onclick="order_office(<?php echo $value['office_id']; ?>)">预约</a>
		</li>
	<?php endforeach ?>
	<?php }; ?>
	<h2>咖啡</h2>
	<?php foreach ($a_view_data['product'] as $key => $value): ?>
	<div id="product">
		<li>
			<?php echo $value['product_name']?>&nbsp;&nbsp;&nbsp;&nbsp;
		  	<a href="#" onclick="choose()">加入购物车</a>
		</li>
	<div id="choose" style="display:product;border:1px solid red; padding:10px;">
		规格：
		<select name="spec"  class="spec">
			<?php foreach ($a_view_data['cup'] as $cup) {
				if ($value['product_id'] == $cup['product_id']) {?>
				<option value="<?php echo $cup['price_id']?>"><?php echo $cup['cup_name']?></option>
			<?php }}?>
		</select>
		甜度：
		<select name="swee">
			<option value="无糖">无糖</option>
			<option value="少糖">少糖</option>
			<option value="常规糖">常规糖</option>
			<option value="多糖">多糖</option>
		</select>
		温度：
		<select name="temp">
			<option value="少冰">少冰</option>
			<option value="多冰">多冰</option>
			<option value="常温">常温</option>
			<option value="热">热</option>
		</select>
		<div id="price"></div>
		<button id='choose_ok' onclick="add_cart(<?php echo $value['product_id'].','.$a_view_data['detail']['store_id'].','.$value['price']; ?>)">确定</button>
	</div>
	</div>
	<?php endforeach ?>
	<div style="border:1px solid red; padding:10px;margin-top:10px;">购物车：
		共 <span id="price_total"><?php echo $a_view_data['cart']['money']; ?></span> 元&nbsp;&nbsp;
		共 <span id="count_total"><?php echo $a_view_data['cart']['count']; ?></span> 件
	</div>
</body>
</html>
<script>
$(".spec").click(function(){
	var id = $(this).val();
	console.log(id);
	$.ajax({
		url  : '<?php echo $this->router->url('list_price'); ?>',
		type : 'post',
		data: {'id':id},
		dataType: 'json',
		success: function(data){
			$('#price').html(data.price+"元");
		}
	})
})
function order_office(office_id) {
	$.ajax({
		url: '<?php echo $this->router->url('order_office_allow'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {type: 1},
		success: function(data) {
			console.log(data);
			if (data.code==200) {
				window.location.href="/order_office-"+office_id;
			} else if(data.code==400) {
				alert(data.msg);
			} else if(data.code==500){
				alert('请登录后再操作');
				window.location.href="/login";
			}
		}
	})
}
// function choose(product_id, store_id, price) {
// 	$('#choose').css('display','block');
// 	$('#choose_ok').attr('onclick',"add_cart("+product_id+","+store_id+','+price+")");
// }

function add_cart(product_id, store_id, price) {
	var spec = $("select[name='spec']").val();
	var swee = $("select[name='swee']").val();
	var temp = $("select[name='temp']").val();
	console.log(spec);
	console.log(swee);
	console.log(temp);
	$.ajax({
		url: '<?php echo $this->router->url('add_cart'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {id: product_id, store_id:store_id, spec:spec, swee:swee, temp:temp},
		success: function(data){
			if (data.code==20) {
				alert ("添加成功");
				var price_total = $('#price_total').html();
				var count_total = $('#count_total').html();
				$('#price_total').html(Number(price_total)+Number(price));
				$('#count_total').html(Number(count_total)+Number(1));
			} else if (data.code==500) {
				alert ("请先登录再操作");
                window.location.href = "http://wap.cm/login";
			};
		}
	})
}

function store_collect(store_id) {
	$.ajax({
		url: '<?php echo $this->router->url('store_collect'); ?>',
		type: 'POST',
		dataType: 'json',
		data: {store_id: store_id},
		success: function(data) {
			console.log(data);
			alert(data.msg);
		}
	})
}

</script>
