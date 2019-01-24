<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="yes" name="apple-touch-fullscreen">
		<title>好友分享</title>
		<link rel="stylesheet" type="text/css" href="static/style_default/style/common.css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<title></title>
		<style>
			.box {
				width: 100%;
				height: 100%;
				background-image: url(./static/style_default/images/friBg.png);
				background-repeat: no-repeat;
				background-size: 100% 100%;
				font-size: 0.16rem;
			}
			.bottom{
				width:100%;
				position: absolute;
				bottom:0.4rem;
				text-align: center;
			}
			.reg{
				width:3.42rem;
				height:0.5rem;
				line-height: 0.5rem;
				margin:0 auto;
				display: block;
				font-size: 0.2rem;
				color:white;
				background: #ff9800;
				border-radius: 0.4rem;
			}
			.hrBox>hr{
				width:0.8rem;
				height:1px;
				display: inline-block;
				border:none;
				background:black;
			}
			.hrBox{
				margin:0.1rem 0;
			}
			.hrBox>span{
				margin:0 0.15rem;
			}
			.hrBox>hr,.hrBox>span{
				vertical-align: middle;
			}
			.keyDw{
				width:3.42rem;
				margin:0 auto;
				font-size: 0;
			}
			.keyDw>a{
				display: inline-block;
				vertical-align: top;
				height:0.5rem;
				line-height: 0.5rem;
				text-align: center;
				color:white;
			}
			.code{
				width:60%;
				background:#ffb355;
				font-size:0.14rem;
				border-top-left-radius: 0.4rem;
				border-bottom-left-radius: 0.4rem;
			}
			.copyDw{
				width:40%;
				background: #ff9800;
				font-size:0.14rem;
				border-top-right-radius: 0.4rem;
				border-bottom-right-radius: 0.4rem;
			}
		</style>
	</head>

	<body>
		<div class="box">
			<div class="bottom">
				<a class="reg" href="nregister?userId=<?php echo $a_view_data['user_id']?>">立即注册</a>
				<div class="hrBox">
					<hr />
					<span>或</span>
					<hr />
				</div>
				<div class="keyDw">
					<a class="code">邀请码：AJTAMAJ</a>
					<a class="copyDw">复制并下载APP</a>
				</div>
			</div>

		</div>

	</body>

</html>