<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>店铺评价</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/shopAppraise.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/shopAppraise.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="store_detail-<?php echo $a_view_data['store_id']; ?>"><img src="./static/style_default/images/yongping_03.png"/></a>
				<i>店铺评价</i>
			</header>
			<!--商家评分开始-->
			<div class="sellerScore">
				<div class="sLeft">
					<p class="shu"><?php echo $a_view_data['all_score']; ?></p>
					<p class="shang">商家评分</p>
				</div>
				<div class="sRight">
					<p class="manner manner1">
						<span class="taidu">服务态度</span>
						<span class="xing">
							<?php for ($i=0; $i < round($a_view_data['service_score']); $i++) {
								echo '<i></i>';
							} ?>
							<?php for ($i=0; $i < 5-round($a_view_data['service_score']); $i++) {
								echo '<i class="halfStar"></i>';
							} ?>
						</span>
						<span class="fen"><?php echo $a_view_data['service_score']; ?></span>
					</p>
					<p class="manner quality">
						<span class="taidu">服务质量</span>
						<span class="xing">
							<?php for ($i=0; $i < round($a_view_data['goods_score']); $i++) {
								echo '<i></i>';
							} ?>
							<?php for ($i=0; $i < 5-round($a_view_data['goods_score']); $i++) {
								echo '<i class="halfStar"></i>';
							} ?>
						</span>
						<span class="fen"><?php echo $a_view_data['goods_score']; ?></span>
					</p>
				</div>
			</div>
			<!--商家评分结束-->
			<div class="tagBox">
				<!--导航开始-->
				<div class="nav">
					<a class="cafe <?php if ($a_view_data['comment_type'] == 2) { echo 'current'; } ?>" href="store_comment-<?php echo $a_view_data['store_id'].'-2'; ?>">咖啡评价</a>
					<a class="office <?php if ($a_view_data['comment_type'] == 1) { echo 'current'; } ?>" href="store_comment-<?php echo $a_view_data['store_id'].'-1'; ?>">办公室评价</a>
				</div>
				<!--导航结束-->
				<ul>
					<li <?php if ($a_view_data['thistag'] == 'all') { echo 'class="allClick"'; } ?>><a href="store_comment-<?php echo $a_view_data['store_id'].'-'.$a_view_data['comment_type']; ?>">全部</a></li>
					<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
					<li <?php if ($a_view_data['thistag'] == $value['comtag_name']) { echo 'class="otherClick"'; } ?>><a href="store_comment-<?php echo $a_view_data['store_id'].'-'.$a_view_data['comment_type'].'-'.$value['comtag_name']; ?>"><?php echo $value['comtag_name']; ?>(<i><?php echo $value['comment_count']; ?></i>)</a></li>
					<?php endforeach ?>
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
								<span class="shijian"><?php echo date('m-d', $value['comment_time']); ?></span>
							</p>
							<p class="product">产品：<?php echo $value['proname']; ?></p>
							<p class="discuss">
							<i class="red">
							<?php if (!empty($value['comment_tags'])) {
								echo '[' . str_replace(',','、', $value['comment_tags']) . ']';
							} ?>
							</i>
							<?php echo $value['comment_content']; ?>
							</p>
							<div class="imgBox">
								<?php if (!empty($value['comment_pic'])) {
									$comment_pics = explode(',', $value['comment_pic']);
									for ($i=0; $i < count($comment_pics); $i++) {
										echo '<img src="'.$comment_pics[$i].'"/>';
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

<script>

var page = 1;
function storecomment_getmore() {
	page++
	var store_id = "<?php echo $a_view_data['store_id']; ?>";
	var comment_type = "<?php echo $a_view_data['comment_type']; ?>";
	var thistag = "<?php echo $a_view_data['thistag']; ?>";
	// 发送ajax请求获取更多
	$.ajax({
		url: 'storecomment_getmore',
		type: 'POST',
		dataType: 'json',
		data: {store_id: store_id, comment_type: comment_type, thistag: thistag, page: page},
		success: function (res) {
			console.log(res);
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li>';
					append_content += '<div class="picL">';
					if (el.user_pic == '') {
						append_content += '<img src="./static/style_default/images/tou_03.png"/>';
					} else {
						append_content += '<img src="'+el.user_pic+'"/>';
					}
					append_content += '</div>';
					append_content += '<div class="describeR">';
					append_content += '<p class="name">';
					append_content += '<span class="ming">'+el.user_name+'</span>';
					append_content += '<span class="shijian">'+el.comment_time+'</span>';
					append_content += '</p>';
					append_content += '<p class="product">产品：'+el.proname+'</p>';
					append_content += '<p class="discuss">';
					append_content += '<i class="red">';
					append_content += '['+el.comment_tags+']';
					append_content += '</i>';
					append_content += el.comment_content;
					append_content += '</p>';
					append_content += '<div class="imgBox">';
					if (el.comment_pic != '') {
						var comment_pics = el.comment_pic.split(',');
						for(var i=0; i<comment_pics.length; i++) {
							append_content += '<img src="'+comment_pics[i]+'">';
						}
					}
					append_content += '</div>';
					append_content += '</div>';
					append_content += '</li>';
				});
				$('.appList .clearfix').append(append_content);
			}
		}
	})
}

</script>