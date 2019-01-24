<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>公告</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/proclamation.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" style="top:0.15rem;" href="index"><img src="static/style_default/images/yongping_03.png"/></a>
				<i>公告</i>
			</header>
			<div class="listBox">
				<ul>
					<?php foreach ($a_view_data['notice'] as $key => $value): ?>
					<li class="noPic">
						<p class="time"><?php echo date('Y年m月d日 H:i:s', $value['notice_time']); ?></p>
						<a href="notice_detail-<?php echo $value['notice_id']; ?>">
							<div class="describe">
								<p class="title"><?php echo $value['notice_title']; ?></p>
								<div class="miao clearfix">
									<p class="wenzi">
									<?php
			                            $subject = strip_tags($value['notice_content']);//去除html标签
			                            $pattern = '/\s/';//去除空白
			                            $content = preg_replace($pattern, '', $subject);
			                            $seodata = mb_substr($content, 0, 100);//截取100个汉字
			                            echo $seodata;
									?>
									</p>
									<P class="jiantou"><img src="static/style_default/images/shezhi_03.png"/></P>
								</div>
							</div>
						</a>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</body>
</html>

<script>

var page = 1;
function notice_getmore() {
	page++;
	$.ajax({
		url: 'notice_getmore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			console.log(res);
			var append_content = '';
			$.each(res.data, function(index, el) {
				append_content += '<li class="noPic">';
				append_content += '<p class="time">'+el.notice_time+'</p>';
				append_content += '<a href="notice_detail-'+el.notice_id+'">';
				append_content += '<div class="describe">';
				append_content += '<p class="title">'+el.notice_title+'</p>';
				append_content += '<div class="miao clearfix">';
				append_content += '<p class="wenzi">'+el.notice_content+'</p>';
				append_content += '<P class="jiantou"><img src="static/style_default/images/shezhi_03.png"/></P>';
				append_content += '</div>';
				append_content += '</div>';
				append_content += '</a>';
				append_content += '</li>';
			});
			$('.listBox ul').append(append_content);
		}
	})
}

</script>