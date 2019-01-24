<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>点餐</title>
		<link rel="stylesheet" href="static/default/style/common.css"/>
		<link rel="stylesheet" href="static/default/style/order.css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/default/script/common.js" type="text/javascript"></script>
		<script src="static/default/script/order.js" type="text/javascript"></script>
		<script src="static/default/ajax/cart.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="main">
			<!--左边导航开始-->
			<?php $this->view->display('menu_system');?>
			<!--左边导航结束-->
			<!--中间订单详情开始-->
			<div class="middle">
				<p class="title">订单详情</p>
				<!--订单列表开始-->
				<div class="orderList">
					<ul>
						
					</ul>
				</div>
				<!--订单列表结束-->
				<!--结算开始-->
				<div class="account">
					<p>共计：<span id="cart_product_num">0</span> 件商品</p>
					<p>订单金额：<span id="cart_product_money">0</span></p>
				</div>
				<!--结算结束-->
				<div class="submit">
					<a href="<?php echo $this->router->url('create_order');?>">提交订单</a>
				</div>
			</div>
			<!--中间订单详情结束-->
			<!--右边菜单列表开始-->
			<div class="right">
				<div class="rNav">
					<ul>
						<li>今日订单<i>(<?php echo $a_view_data['i_time_today'];?>)</i></li>
						<li>昨日订单<i>(<?php echo $a_view_data['i_time_yesterday'];?>)</i></li>
						<li>本月订单<i>(<?php echo $a_view_data['i_time_month'];?>)</i></li>
					</ul>
				</div>
				<div class="rDown">
					<div class="rdL">
						<div class="lNav">
							<ul class="clearfix">
								<li>
									<div class="lImg"></div>
									<div class="lDes">
										<p class="p1"><?php echo $a_view_data['passenger_flow']['content'][0]['in'];?></p>
										<p class="p2"><i>进店人数</i></p>
									</div>
								</li>
								<li>
									<div class="lImg"></div>
									<div class="lDes">
										<p class="p1"><?php $i_stay = $a_view_data['passenger_flow']['content'][0]['in'] - $a_view_data['passenger_flow']['content'][0]['out']; echo ($i_stay >= 0) ? $i_stay : 0;?></p>
										<p class="p2"><i>在店人数</i></p>
									</div>
								</li>
								<li>
									<div class="lImg"></div>
									<div class="lDes">
										<p class="p1"><?php echo $a_view_data['passenger_flow']['content'][0]['out'];?></p>
										<p class="p2"><i>离店人数</i></p>
									</div>
								</li>
							</ul>
						</div>
						<!--菜单列表开始-->
						<div class="lList">
							<ul class="clearfix">
							<?php
							if ($a_view_data['i_cate_curr'] == 'i') {
								if(empty($a_view_data['product'])) { echo "无产品";} else {foreach ($a_view_data['product'] as $i_key => $a_product) {
							?>
								<li product_id="<?php echo $a_product['product_id'];?>" price_id="<?php echo $a_product['price_id'];?>">
									<a href="store_meal-i-<?php echo $a_product['product_id'];?>">
										<div class="lPic"><img src="<?php echo $a_product['pro_img'];?>"/></div>
										<p class="lName"><?php echo $a_product['product_name'];?></p>
										<p class="price">￥<?php echo $a_product['price'];?></p>
										<span class="red" id="select_num_<?php echo $a_product['product_id'];?>" style="display:none">0</span>
									</a>
								</li>
							<?php 
								} } } else {if(empty($a_view_data['product'])) { echo "无产品";} else {foreach ($a_view_data['product'] as $i_key => $a_product) {
							?>
								<li class="produc" product_id="<?php echo $a_product['product_id'];?>" price_id="<?php echo $a_product['price_id'];?>">
									<a href="javascript:;">
										<div class="lPic"><img src="<?php echo $a_product['pro_img'];?>"/></div>
										<p class="lName"><?php echo $a_product['product_name'];?></p>
										<p class="price">￥<?php echo $a_product['price'];?></p>
										<span class="red" id="select_num_<?php echo $a_product['product_id'];?>" style="display:none">0</span>
									</a>
								</li>
							<?php
							} } }
							?>
							</ul>
						</div>
						<!--菜单列表结束-->
						<div class="page">
						<?php echo $this->pages->link_style_one($this->router->url('index-'.$a_view_data['i_cate_curr'].'-', [], false, false));?>
						</div>
					</div>
					<div class="rdR">
						<ul>
						<?php
						foreach ($a_view_data['category'] as $i_key => $a_cate) {
						?>
							<li <?php if ($a_cate['pro_id'] == $a_view_data['i_cate_curr']) {?>class="rCurrent"<?php } ?>><a href="<?php echo $this->router->url('index', ['cate_id' => $a_cate['pro_id']]);?>"><?php echo $a_cate['pro_name'];?></a></li>
						<?php
						}
						?>
						<li <?php if ($a_view_data['i_cate_curr'] == 'i') {?>class="rCurrent"<?php } ?>><a href="<?php echo $this->router->url('index', ['cate_id' => 'i']);?>">套餐</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!--右边菜单列表结束-->
		</div>
		
		<!--详情弹框开始-->
		<div class="detailBomb">
			<p class="dTit">
				<span class="chan">产品详情</span>
				<a class="dClose" href="javascript:;"></a>
			</p>
			<div class="describe clearfix">
				<div class="imgBox">
					<img src="static/default/images/tankuang_07.png"/>
				</div>
				<!--选择类型开始-->
				<div class="chooseBox">
					<label></label>
					<div class="single number">
						<span class="biao">数量：</span>
						<div class="xuan">
							<select name="" id="yonhe">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
					</div>
					<div class="cPrice">价格：<span id="product_price"></span></div>
					<!--确定按钮开始-->
					<div class="btnBox">
						<a href="javascript:;" id="submit_btn">确定</a>
					</div>
					<!--确定按钮结束-->
				</div>
				<!--选择类型结束-->
				
			</div>
		</div>
		<!--详情弹框结束-->

<script>
// 保存产品id
var submit_product_id = 0;
// 保存产品类型id
var submit_price_id = 0;
// 保存产品属性id，用“|”分隔
var submit_attr = '';
// 保存产品数量
var submit_num = 1;

var a_product = [];
<?php
foreach ($a_view_data['product'] as $i_key => $a_product) {
?>
a_product[<?php echo $a_product['product_id'];?>] = [];
a_product[<?php echo $a_product['product_id'];?>]['detail'] = '<div class="single component">' +
					'<span class="biao">类型：</span>' +
					'<div class="xuan">' +
						'<ul class="clearfix">' +
						<?php
						foreach ($a_product['type'] as $i_key => $a_type) {
						?>
							'<li <?php echo $i_key ? '' : 'class="xCurrent"';?> product_id="<?php echo $a_product['product_id'];?>" price_id="<?php echo $a_type['price_id'];?>" price="<?php echo $a_type['price'];?>"><a href="javascript:;"><?php echo $a_type['cup_name'];?></a></li>' +
						<?php
						}
						?>
						'</ul>' +
					'</div>' +
				'</div>' +
				'<div class="single temperature">' +
					<?php
					foreach ($a_product['attr'] as $i_key => $a_attr) {
					?>
					'<div>'+
					'<span class="biao"><?php echo $a_attr['attri_name']?>：</span>' +
					'<div class="xuan">' +
						'<ul class="clearfix">' +
							<?php
							foreach ($a_product['shux'] as $i_ke => $shux) {
								if ($i_key == $i_ke) {
								foreach ($shux as $val) {
							?>
							'<li class="<?php echo $i_ke; ?>" <?php echo $i_ke ? '' : '';?> product_id="<?php echo $a_product['product_id'];?>" attr_id="<?php echo $val['attri_id'];?>"><a href="javascript:;"><?php echo $val['attri_name'];?></a></li>' +
							<?php 
							}}}
							?>
						'</ul>' +
					'</div>' +
					'</div>' +
					<?php
					}
					?>
				'</div>';
a_product[<?php echo $a_product['product_id'];?>]['img'] = "<?php echo $a_product['pro_img'];?>";
<?php
}
?>
function cart_add_subtract(index, method) {
	if (method == "less") {
		method = 'subtract';
	} else {
		method = 'add';
	}
	$.ajax({
		url: "<?php echo $this->router->url('cart_add_subtract');?>",
		type: "post",
		data: "index=" + index + "&method=" + method,
		dataType: "json",
		success: function(result) {
			cart_data(result);
		},
		error:function(msg){
			alert(msg);
		}
	});
}

function cart_data(data) {
	$(".lList .clearfix li a span").css("display", "none");
	var html = '';
	$.each(data.cart, function(i, res) {

		html += '<li>' + 
				'<div class="oLeft">' + 
					'<p class="name"><a>' + res.product_name + '</a><i>(' + res.cup_name ;
						/*if (res.shux != undefined) {
							html += res.shux;
						};*/
					html += ')</i></p>' + 
					'<p class="num">￥' + res.price + '</p>' + 
				'</div>' + 
				'<div class="oRight">' + 
					'<a class="less" href="javascript:;" product_index="' + i + '" product_id="' + res.product_id + '" price_id="' + res.price_id + '" attr="' + res.attr + '"><img src="static/default/images/diancan_07.png"/></a>' + 
					'<span class="shu">' + res.num + '</span>' + 
					'<a class="more" href="javascript:;" product_index="' + i + '" product_id="' + res.product_id + '" price_id="' + res.price_id + '" attr="' + res.attr + '"><img src="static/default/images/diancan_09.png"/></a>' + 
				'</div>' + 
			'</li>';
		$("#select_num_" + res.product_id).css("display", "block");
		$("#select_num_" + res.product_id).html(res.num);
	});
	refresh_vice_screen();
	$(".orderList ul").html(html);
	$("#cart_product_num").html(data.product_num);
	$("#cart_product_money").html(data.product_money);
}

// 刷新副屏
function refresh_vice_screen() {
	try	{ 
		if(typeof(eval(show_vice_screen))=="function") {
			show_vice_screen();
		}
	} catch(e) {
		//alert("not function"); 
	}
}

$(document).ready(function() {
	// 显示副屏
	refresh_vice_screen();
	
	// 加载购物车商品到页面
	$.ajax({
		url: "<?php echo $this->router->url('cart_data');?>",
		type: "post",
		data: "",
		dataType: "json",
		success: function(result) {
			console.log(result);
			cart_data(result);
		},
		error:function(msg){
			alert(msg);
		}
	});
	
	// 添加产品到购物车
	$("#submit_btn").click(function(e) {
		var ouer = $('#yonhe').attr('value');
		$.ajax({
			url: "<?php echo $this->router->url('cart_add');?>",
			type: "post",
			data: "product_id=" + submit_product_id + "&price_id=" + submit_price_id + "&attr=" + submit_attr + "&num=" + ouer,
			dataType: "json",
			success: function(result) {
				console.log(result)
				if (result.msg == "product_not") {
					alert('添加错误：产品不存在！');
				} else if (result.msg == "price_not") {
					alert('添加错误：价格不存在！');
				} else if (result.msg == "success") {
					cart_data(result);
					$('#yonhe').attr('value', 1);
				}
			},
			error:function(msg){
				alert(msg);
			}
		});
		// 关闭窗口
		$('.detailBomb').hide();
	});
});
</script>

<?php
// 调用安卓
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
<script>
var show_vice_screen = function() {
	var txt={"url":"<?php echo $this->router->url('cart_list');?>"};
	loadViceScreenPageByUrl(txt);
}
</script>
<?php
}
?>
	</body>
</html>
