<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>订单管理-咖啡订单</title>
	<link rel="stylesheet" href="static/style_default/style/common.css"/>
	<link rel="stylesheet" href="static/style_default/style/header.css"/>
	<link rel="stylesheet" href="static/style_default/style/order_detail.css"/>
	<script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
	<script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
	<script src="static/style_default/script/order_detail.js" type="text/javascript" charset="utf-8"></script>
	<?php if ($a_view_data['result']['status_code'] == 20000) {echo $a_view_data['result']['map_code_head']; }?>
</head>
<body>
<!-- 头部 开始-->
<?php echo $this->display('top'); ?>
<!-- 头部结束 -->
<div class="bottom clearfix">
	<!-- 导航 开始-->
	<?php echo $this->display('left'); ?>
	<!-- 导航结束-->
	<!--右边内容开始-->
	<div class="rightSide">
		<!--小导航开始-->
		<div class="smallNav">
			<i></i>
			<a href="javascript:;">订单管理/</a><a class="cur" href="javascript:;">餐饮订单</a>
		</div>
		<!--小导航结束-->

		<!-- 内容 -->
		<div class="content">
			<!--订单详情弹框开始-->
			<div class="detailBomb">
				<div class="messageBox">
					<div class="numberBox">
						<p class="dingdan"><i></i>订单编号</p>
						<div class="cont">
							<p><?php echo $a_view_data['order'][0]['order_number']?></p>
						</div>
						<span class="shang"></span>
						<span class="xia"></span>
					</div>
					<div class="numberBox timeBox">
						<p class="dingdan"><i></i>下单时间/预约时间</p>
						<div class="cont">
							<p><?php echo date('Y-m-d H:i', $a_view_data['order'][0]['time_create'])?>/<?php echo $a_view_data['order'][0]['time_delay']?></p>
						</div>
						<span class="shang"></span>
						<span class="xia"></span>
					</div>
					<div class="numberBox takeBox">
						<p class="dingdan"><i></i>收货信息</p>
						<div class="cont">
							<p>联系人：<?php echo $a_view_data['order'][0]['reciver_name']?></p>
							<p>联系电话：<?php echo $a_view_data['order'][0]['mob_phone']?></p>
							<p>联系地址：<?php echo $a_view_data['order'][0]['addres']?></p>
						</div>
						<span class="shang"></span>
						<span class="xia"></span>
					</div>
					<div class="numberBox proBox">
						<p class="dingdan"><i></i>下单产品</p>
						<div class="cont">
							<ul>
								<?php foreach ($a_view_data['order'] as $order) {?>
								<li>
									<i class="wen1"><?php echo $order['product_name']?>(<?php echo $order['spec']?>)</i>
									<i class="wen2">x<?php echo $order['goods_num']?></i>
									<i class="wen3">¥<?php echo $order['money']?></i>
								</li>
								<?php }?>
							</ul>
							<p class="redPaper">
								<i class="red">积分优惠</i>
								<i class="money">-¥<?php echo $a_view_data['order'][0]['use_points']?></i>
							</p>
							<p class="redPaper carryM">
								<i class="red">配送费</i>
								<i class="money">¥<?php echo $a_view_data['order'][0]['shipping_fee']?></i>
							</p>
						</div>
					</div>
				</div>
				<div class="payBox">
					<span class="payType"><?php if ($a_view_data['order'][0]['payment_code'] == 'offline') {
	                       echo '微信付款';
	                    } else if ($a_view_data['order'][0]['payment_code'] == 'online') {
	                       echo '在线支付';
	                    } else if ($a_view_data['order'][0]['payment_code'] == 'alipay') {
	                       echo '支付宝';
	                    } else if ($a_view_data['order'][0]['payment_code'] == 'unionpay') {
	                       echo '银联网关支付';
	                    } else if ($a_view_data['order'][0]['payment_code'] == 'cashier') {
	                       echo '线下支付';
	                    };?></span>
					<span class="allMon">¥<?php echo $a_view_data['order'][0]['actual_pay']?></span>
				</div>
			</div>
			<!--订单详情弹框结束-->
			<!-- 配送物流 -->
			<div class="log">
				<ul>
					<?php foreach ($a_view_data['ordert'] as $ordert) {?>
					<li class="logList">
						<span class="point">
							<i></i>
							<hr/>
						</span>
						<dl class="logInfo">
							<dt>
								<span><?php echo $ordert['name']?></span>
								<em><?php echo date('Y-m-d H:i', $ordert['time'])?></em>
							</dt>
							<dd>
								<span>订单编号:</span>
								<em><?php echo $ordert['order_number']?></em>
							</dd>
						</dl>
					</li>
					<?php }?>
					<?php if ($a_view_data['result']['status_code'] == 20000) {?>
					<li class="logList">
						<span class="point">
							<i></i>
							<hr class="mapHr"/>
						</span>
						<dl class="logInfo">
							<dt>
								<span><?php echo $a_view_data['result']['statusMsg']?></span>
								<em><?php echo $a_view_data['result']['acceptTime'];?></em>
							</dt>
							<dd>
								<span>配送员:<?php echo $a_view_data['result']['transporterName']?></span>
								<em><?php echo $a_view_data['result']['transporterPhone']?></em>
								
								<?php echo $a_view_data['result']['map_code_body']?>
								
							</dd>
						</dl>
					</li>
					<?php }?>
				</ul>
			</div>
			<!-- 配送物流 -->
		</div>
		<!-- 内容 -->
	</div>

	<!--右边内容结束-->



</body>
</html>
