<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>新闻详情</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/news_details.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="main">
			<header class="head">
				<a class="back" href="javascript:window.history.back();"><img src="static/style_default/images/yongping_03.png"/></a>
				<i>新闻详情</i>
			</header>
			<div class="titleBox clearfix">
				<p class="h2"><?php echo $a_view_data['news']['news_title']; ?></p>
				<p class="subhead">
					<span class="span1"><?php echo $a_view_data['cate']['cate_name']; ?></span>
					<span class="span2"><?php echo date('Y-m-d', $a_view_data['news']['news_time']); ?></span>
				</p>
			</div>
			<div class="describe">
				<?php echo $a_view_data['news']['news_content']; ?>
			</div>
		</div>
	</body>
</html>
