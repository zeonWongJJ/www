<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>消息</title>
		<link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css"/>
		<script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.body{font-size: .14rem;height: 100%;overflow-y: auto;}
			.header{display: flex;justify-content: space-between;align-items: center;padding: .15rem;border-bottom: 1px solid #f4f4f4;background: #fff;}
			.header .left{width: .1rem;height: .18rem;background: url(./static/style_default/images/back.png) no-repeat;background-size: .1rem .18rem;background-position: center;}
			.content .item{}
			.content .item .time{text-align: center;font-size: .11rem;color: #666666;padding: .1rem;}
			.content .item .info{background: #fff;padding:.15rem;font-size: .15rem;}
			.content .item .info:after{content: '';display: inline-block;border-radius: 50%;height: .05rem;width: .05rem;background: #ff3434;position: relative;top: -.1rem;}
		</style>
	</head>
	<body>
		<div class="body">
			<!--头部-->
			<div class="header">
				<a href="javascript:history.go(-1);" class="left"></a>
				<div>消息</div>
				<div></div>
			</div>
			
			<div class="content">
				<?php foreach ($a_view_data as $key => $value): ?>
				<div class="item">
					<div class="time"><?php echo date('m-d', $value['mess_time']); ?></div>
					<div class="info"><?php echo $value['content']; ?></div>
				</div>
			<?php endforeach ?>
			</div>
			
		</div>
	</body>
</html>