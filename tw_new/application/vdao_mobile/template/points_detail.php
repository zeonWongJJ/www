<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的积分-明细详情</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myIntegral_details.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="javascript:;"><img src="static/style_default/images/kefu_03.png"/></a>
				<i>明细详情</i>
			</header>
			<div class="intBack clearfix">
				<p class="p1"><?php if($a_view_data['log']['pl_status'] == 1) { echo '积分提现';} else if($a_view_data['log']['pl_status'] == 2) { echo '积分返还';} else if($a_view_data['log']['pl_status'] == 3) { echo '推荐人返积分';} else if($a_view_data['log']['pl_status'] == 4) { echo '积分退款';}?></p>
				<p class="p2"><?php echo $a_view_data['log']['pl_points']?></p>
				<p class="p3">交易成功</p>
			</div>
			<div class="detailList clearfix">
				<ul>
					<li>
						<span class="span1"><?php if ($a_view_data['log']['pl_status'] == 2 || $a_view_data['log']['pl_status'] == 4) {
							echo '收入说明';
						} else { echo '支出说明';}?></span>
						<span class="span2"><?php echo $a_view_data['log']['pl_stage']?></span>
					</li>
					<?php if ($a_view_data['log']['pl_status'] == 1) {?>
						<li class="progress">
							<span class="span1">处理进度</span>
							<span class="span2">
								<?php foreach ($a_view_data['reim'] as $reim) {?>
									<i class="one one1">
										<s class="s1"></s>
										<s class="s2"><?php echo $reim['reimburse']?></s>
										<s class="s3"><?php echo date('m-d H:i', $reim['time'])?></s>
										<s class="s4"></s>
									</i>
								<?php }?>
							</span>
						</li>
						<li>
							<span class="span1">提现到</span>
							<span class="span2"><?php echo $a_view_data['reim'][1]['difan']?></span>
						</li>
					<?php } elseif ($a_view_data['log']['pl_status'] == 2) {?>
						<?php if (empty($a_view_data['log']['user_referee_id'])) {?>
							<li>
								<span class="span1">返利账户</span>
								<span class="span2">我的账户</span>
							</li>
							<li>
								<span class="span1">商品说明</span>
								<span class="span2"><?php echo $a_view_data['goods'][0]['product_name']?>(<?php echo $a_view_data['goods'][0]['cup_name']?>) 等<?php echo $a_view_data['goods'][0]['order_count']?>杯</span>
							</li>
						<?php } else if ( ! empty($a_view_data['log']['user_referee_id'])) {?>
							<li>
								<span class="span1">返利账户</span>
								<span class="span2"><?php echo $a_view_data['log']['user_referee']?></span>
							</li>
						<?php }?>
					<?php } elseif ($a_view_data['log']['pl_status'] == 3) {?>
						<li>
							<span class="span1">商品说明</span>
							<span class="span2"><?php echo $a_view_data['goods'][0]['product_name']?>(<?php echo $a_view_data['goods'][0]['cup_name']?>) 等<?php echo $a_view_data['goods'][0]['order_count']?>杯</span>
						</li>
						<li>
							<span class="span1">收货地址</span>
							<span class="span2"><?php echo $a_view_data['goods'][0]['addres']?></span></span>
						</li>
					<?php } elseif ($a_view_data['log']['pl_status'] == 4) {?>
						<li class="progress">
							<span class="span1">处理进度</span>
							<span class="span2">
							<?php foreach ($a_view_data['reim'] as $reim) {?>
								<i class="one one1">
									<s class="s1"></s>
									<s class="s2"><?php echo $reim['reimburse']?></s>
									<s class="s3"><?php echo date('m-d H:i', $reim['time'])?></s>
									<s class="s4"></s>
								</i>
							<?php }?>
							</span>
						</li>
						<li>
							<span class="span1">退款到</span>
							<span class="span2">积分</span>
						</li>
					<?php }?>
					<li>
						<span class="span1">创建时间</span>
						<span class="span2"><?php echo date('m月d日 H:i:s', $a_view_data['log']['pl_points'])?></span>
					</li>
					<li>
						<span class="span1">订单号</span>
						<span class="span2"><?php echo $a_view_data['log']['order_number']?></span>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>
