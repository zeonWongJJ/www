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
				<a class="back" style="width:0.8rem;" href="user_score"><img src="static/style_default/images/yongping_03.png"/></a>
				<i>明细详情</i>
			</header>
			<div class="intBack clearfix">
				<p class="p1"><?php echo $a_view_data['score']['pl_item']; ?></p>
				<p class="p2">
				<?php if ($a_view_data['score']['pl_type'] == 1) {
					echo '+'.$a_view_data['score']['pl_variation'];
				} else {
					echo '-'.$a_view_data['score']['pl_variation'];
				} ?>
				</p>
				<p class="p3">交易成功</p>
			</div>
			<div class="detailList clearfix">
				<ul>
					<li>
						<span class="span1">变动说明</span>
						<span class="span2"><?php echo $a_view_data['score']['pl_item']; ?></span>
					</li>
					<li>
						<span class="span1">变动详情</span>
						<span class="span2"><?php echo $a_view_data['score']['pl_description']; ?></span>
					</li>
					<li>
						<span class="span1">账户盈余</span>
						<span class="span2"><?php echo $a_view_data['score']['pl_score']; ?></span>
					</li>
					<li>
						<span class="span1">变动时间</span>
						<span class="span2"><?php echo date('Y-m-d H:i:s', $a_view_data['score']['pl_time']); ?></span>
					</li>
				</ul>
			</div>
		</div>
	</body>
</html>
