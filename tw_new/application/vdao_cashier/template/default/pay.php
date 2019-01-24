<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>提交订单</title>
		<link rel="stylesheet" href="static/default/style/common.css"/>
		<link rel="stylesheet" href="static/default/style/submitOrder.css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/default/script/common.js" type="text/javascript"></script>
		<script src="static/default/script/submitOrder.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="main">
			<!--左边导航开始-->
			<?php $this->view->display('menu_system');?>
			<!--左边导航结束-->
			<!--中间订单模块开始-->
			<div class="middle">
				<p class="bTitle">订单详情</p>
				<p class="sTitle">共<i><?php echo $a_view_data['product_num'] ? $a_view_data['product_num'] : 0;?></i>件</p>
				<!--订单列表开始-->
				<div class="orderList">
					<ul>
					<?php
					foreach ($a_view_data['cart'] as $a_data) {
						$s_attr = '';
						if (isset($a_data['attr']) && is_array($a_data['attr'])) {
							foreach ($a_data['attr'] as $a_attr) {
								$s_attr .= $a_attr['attr_name'] . '/';
							}
						}
						$s_attr = rtrim($s_attr, '/');
					?>
						<li>
							<span class="span1"><?php echo $a_data['product_name'];?><i>(<?php echo $a_data['cup_name'];?>)</i><i><?php echo $s_attr ? "({$s_attr})" : '';?></i></span>
							<span class="span2">×<?php echo $a_data['num'];?></span>
							<span class="span3">￥<?php echo $a_data['price'];?></span>
						</li>
					<?php
					}
					?>
					</ul>
				</div>
				<!--订单列表结束-->
				<!--金额开始-->
				<div class="money">
					<p class="p2">应收金额：<i><?php echo $a_view_data['product_money'] ? $a_view_data['product_money'] : 0;?></i></p>
				</div>
				<!--金额结束-->
			</div>
			<!--中间订单模块结束-->
			<!--右边支付模块开始-->
			<div class="right">
				<!--会员号开始-->
				<div class="vip">
					<span class="vLeft">请输入会员号：</span>
					<div class="vRight">
						<input class="int" id="member_id" type="text" placeholder="" />
						<a href="javascript:;" class="tu"><img src="static/default/images/submit_03.png"/></a>
					</div>
				</div>
				<!--会员号结束-->
				<!--现金支付开始-->
				<div class="cashPay">
					<p class="cTit">现金支付</p>
					<div class="payBox">
						<p class="shouldP shouldP1">
							<span>应收</span>
							<a href="javascript:;" id="moeny_amount"><?php echo $a_view_data['product_money'] ? $a_view_data['product_money'] : 0;?></a>
						</p>
						<p class="shouldP realityP">
							<span>实收</span>
							<input id="money_receive" type="text" />
						</p>
						<p class="shouldP backP">
							<span>找零</span>
							<a href="javascript:;" id="moeny_back">0.00</a>
						</p>
					</div>
				</div>
				<!--现金支付结束-->
				<!--支付宝开始-->
				<div class="alipay alipay">
					<p class="aTit">支付宝支付</p>
					<div class="aliBox">
						<span class="aImg"><img src="static/default/images/submit_11.png"/></span>
						<div class="aScan">
							<input class="aInt" id="pay_alipay" type="text" placeholder="" />
							<a href="javascript:;" class="aTu"><img src="static/default/images/submit_03.png"/></a>
						</div>
					</div>
				</div>
				<!--支付宝结束-->
				<!--微信支付开始-->
				<div class="alipay weixinPay">
					<p class="aTit">微信支付</p>
					<div class="aliBox">
						<span class="aImg"><img src="static/default/images/submit_15.png"/></span>
						<div class="aScan">
							<input class="aInt" id="pay_weixin" type="text" placeholder="" />
							<a href="javascript:;" class="aTu"><img src="static/default/images/submit_03.png"/></a>
						</div>
					</div>
				</div>
				<!--微信支付结束-->

				<div class="btnBox">
					<div class="finishBtn"><a href="<?php echo $this->router->url('pay_finsh');?>" onclick="return confirm('确认此订单已完成支付吗？')">订单支付完成</a></div>
					<div class="finishBtn canner_order_button"><a href="<?php echo $this->router->url('pay_cancel');?>" onclick="return confirm('确认要关闭此订单吗？')">取消订单</a></div>
				</div>
			</div>
			<!--右边支付模块结束-->
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--支付成功弹框开始-->
		<div class="successBomb">
			<p class="sClose"><img src="static/default/images/submit_07.gif"/></p>
			<p class="sZhi">支付成功</p>
			<a class="sSure" href="<?php echo $this->router->url('index');?>">确定</a>
		</div>
		<!--支付成功弹框结束-->

<script>
// 验证函数存在后调用
function is_func(func) {
	try	{
		if(typeof(eval(func))=="function") {
			return true;
		}
	} catch(e) {
		return false;
	}
}
// 设置用户id
$("#member_id").change(function(){
	$.ajax({
		url: "<?php echo $this->router->url('set_order_member');?>",
		type: "post",
		data: "member_id=" + $("#member_id").val(),
		dataType: "json",
		success: function(result) {

		},
		  error:function(msg){
			alert('设置用户id错误');
		}
	});
});
// 定义一个变量，用来控制是否显示支付成功的弹窗
var is_show_success = true;
// 现金支付
$("#money_receive").change(function(){
	var amount = Number($("#moeny_amount").html());
	var receive = Number($("#money_receive").val());
	var back = String((receive - amount).toFixed(2));
	$("#moeny_back").html(String(back));
	// 开启钱箱
	if (is_func('openCashBoxMachine')) {
		openCashBoxMachine();
	}
	if (back >= Number(0)) {
		
		// 先关闭支付成功的弹窗
		is_show_success = false;
		// 取消轮询，不显示完成弹窗
		// window.clearInterval(polling_obj);
		// 设置为已付款
		// alert(122);
		$.ajax({
			url: "<?php echo $this->router->url('pay_money');?>",
			type: "post",
			data: "",
			dataType: "json",
			success: function(result) {
				$(".canner_order_button>a").css("background",'#999');
				$(".canner_order_button>a").removeAttr('onclick');
				$(".canner_order_button >a").attr("href","javascript:;");
				// alert(result);
				alert("现金收款成功");
			},
			error:function(msg){
				alert('现金支付报错！');
			}
		});
	}
});
// 支付宝支付
$("#pay_alipay").change(function(){
	is_show_success = true;
	$.ajax({
		url: "<?php echo $this->router->url('pay_alipay');?>",
		type: "post",
		data: "auth_code=" + $("#pay_alipay").val(),
		dataType: "json",
		success: function(result) {
				$(".canner_order_button>a").css("background",'#999');
				$(".canner_order_button>a").removeAttr('onclick');
				$(".canner_order_button >a").attr("href","javascript:;");
		},
		error:function(msg){
			alert('支付宝支付错误');
		}
	});
});
// 微信支付
$("#pay_weixin").change(function(){
	is_show_success = true;
	// console.log(id);
	$.ajax({
		url: "<?php echo $this->router->url('pay_weixin');?>",
		type: "post",
		data: "auth_code=" + $("#pay_weixin").val(),
		dataType: "text",
		success: function(result) {
					$(".canner_order_button>a").css("background",'#999');
				$(".canner_order_button>a").removeAttr('onclick');
				$(".canner_order_button >a").attr("href","javascript:;");
		},
		error:function(msg){
			alert('微信支付错误');
		}
	});
});
var mycount = 0;
function polling() {
	$.ajax({
		url: "<?php echo $this->router->url('pay_result');?>",
		type: "post",
		data: "",
		dataType: "json",
		success: function(result) {
			// console.log(result);
			// alert(result.);
			if (result.pay_result == 'success') {
				if (is_show_success) {
					$(".successBomb").css("display", "block");
				}
				// window.clearInterval(polling_obj);
				if (mycount == 0) {
					// 小票打印
					// if (is_func('printTextBySmallPaperMoneyMachine')) {
						printTextBySmallPaperMoneyMachine(result);
					// }
					// 不干胶打印
					// if (is_func('printTextBySmallPaperMoneyMachine')) {
						printContextByThermosensitiveDryGlueMachine(result);
					// }
					mycount++;
				}
			}
		},
		error:function(msg){
			// alert('查询支付结果出错！');
		}
	});
}
$(document).ready(function() {
	// 调用副屏
	if (is_func('show_vice_screen')) {
		show_vice_screen();
	} else {

	}
})
// 启动轮询
var polling_obj = window.setInterval(polling, 3000);
</script>
<?php
// 调用安卓
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
<script>
function show_vice_screen() {
	var txt={"url":"<?php echo $this->router->url('cart_list');?>"};
	loadViceScreenPageByUrl(txt);
}
</script>
<?php
}
?>
	</body>
</html>
