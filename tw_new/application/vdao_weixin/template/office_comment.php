<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>办公室评价</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/officeAppraise.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/officeAppraise.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="store_detail-<?php echo $a_view_data['office_id']; ?>"><img src="./static/style_default/images/yongping_03.png"/></a>
				<i><?php echo $a_view_data['room']['room_name']; ?></i>
			</header>
			<div class="tagBox">
				<ul>
					<li <?php if ($a_view_data['thistag'] == 'all') { echo 'class="allClick"'; } ?>><a href="office_comment-<?php echo $a_view_data['office_id'].'-all' ?>">全部</a></li>
					<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
					<li <?php if ($a_view_data['thistag'] == $value['comtag_name']) { echo 'class="otherClick"'; } ?>><a href="office_comment-<?php echo $a_view_data['office_id'].'-'.$value['comtag_name']; ?>"><?php echo $value['comtag_name']; ?>(<i><?php echo $value['comment_count']; ?></i>)</a></li>
					<?php endforeach ?>
					<li <?php if ($a_view_data['thistag'] == 'tu') { echo 'class="allClick"'; } ?>><a href="office_comment-<?php echo $a_view_data['office_id'].'-tu' ?>">有图(<i><?php echo $a_view_data['tu_count']; ?></i>)</a></li>
				</ul>
			</div>
			<div class="appList">
				<ul class="clearfix">
					<?php foreach ($a_view_data['comment'] as $key => $value): ?>
					<li>
						<div class="picL">
							<?php if (empty($value['user_pic'])) {
								echo '<img src="./static/style_default/images/tou_03.png"/>';
							} else {
								echo '<img src="'.$value['user_pic'].'"/>';
							} ?>
						</div>
						<div class="describeR">
							<p class="name">
								<span class="ming"><?php echo $value['user_name']; ?></span>
								<span class="shijian"><?php echo date('m-d', $value['commetn_time']); ?></span>
							</p>
							<p class="product">产品：<?php echo $a_view_data['roomtype']['type_name'].$a_view_data['room']['room_name']; ?></p>
							<p class="discuss"><i class="red">
							<?php if (!empty($value['comment_tags'])) {
								echo '[' . str_replace(',','、', $value['comment_tags']) . ']';
							} ?>
							</i><?php echo $value['comment_content']; ?></p>
							<div class="imgBox">
								<?php if (!empty($value['comment_pic'])) {
									$comment_pic = explode(',', $value['comment_pic']);
									for ($i=0; $i < count($comment_pic); $i++) {
										echo '<img src="'.$comment_pic[$i].'"/>';
									}
								} ?>
							</div>
						</div>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</body>
</html>
