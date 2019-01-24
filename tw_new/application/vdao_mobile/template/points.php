<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的积分</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myIntegral.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>		
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="javascript:;"><img src="static/style_default/images/kefu_03.png"/></a>
				<i>我的积分</i>
				<a class="explain" href="points_point">？</a>
			</header>
			<div class="currentInt clearfix">
				<p class="p1">当前积分</p>
				<p class="p2"><?php echo $a_view_data['name']['user_score']?></p>
			</div>
			<div class="detailList">
				<ul>
					<li class="title">
						<a href="javascript:;">
							<p class="type">积分明细</p>	
							<i class="yellow"></i>
						</a>
					</li>
					<?php foreach ($a_view_data['points'] as $points) {?>
					<li>
						<a href="points_detail-<?php echo $points['pl_id']?>">
							<p class="type"><?php echo $points['pl_stage']?></p>
							<p class="time"><?php echo date('Y-m-d', $points['pl_time_create'])?></p>
							<p class="num"><?php echo $points['pl_points']?></p>
						</a>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>				
	</body>
</html>
