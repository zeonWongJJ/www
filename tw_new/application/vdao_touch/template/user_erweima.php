<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-账户与安全-我的二维码</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_erweima.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_update"><img src="static/style_default/images/kefu_03.png"/></a><i>我的二维码</i></header>
			<div class="content clearfix">
				<div class="title">
					<p class="pic">
					<?php if (empty($a_view_data['user_pic'])) {
						echo '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						echo '<img src="'.$a_view_data['user_pic'].'"/>';
					} ?>
					</p>
					<div class="des">
						<p class="p1"><?php echo $a_view_data['user_name']; ?></p>
						<p class="p2">
						<?php if ($a_view_data['user_sex'] == 1) {
							echo '男';
						} else if ($a_view_data['user_sex'] == 2) {
							echo '女';
						} else {
							echo "未知";
						} ?>
						</p>
					</div>
				</div>
				<div class="erweima">
					<img src="<?php echo $a_view_data['user_erweima']; ?>"/>
				</div>
				<p class="zai">在门店下单付款前，扫描二维码可积累积分</p>
			</div>
		</div>
	</body>
</html>
