<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>新闻</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/news.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/news.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a style="top:0.15rem;" class="back" href="javascript:window.history.back();"><img src="static/style_default/images/yongping_03.png"/></a>
				<i class="xinwen"><?php echo $a_view_data['thiscate']; ?><s class="down"></s></i>
				<!--查询指定分类开始-->
				<div class="classify">
					<p class="tit">查询指定分类</p>
					<div class="claList">
						<ul>
							<li <?php if ($a_view_data['type'] == 'all') { echo 'class="current"'; } ?>><a href="news_showlist">全部</a></li>
							<?php foreach ($a_view_data['cate'] as $key => $value): ?>
							<li <?php if ($a_view_data['type'] == $value['cate_id']) { echo 'class="current"'; } ?>><a href="news_showlist-<?php echo $value['cate_id']; ?>"><?php echo $value['cate_name']; ?></a></li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
				<!--查询指定分类结束-->
			</header>
			<div class="content">
				<ul>
					<!--没图片开始-->
					<?php foreach ($a_view_data['news'] as $key => $value): ?>
					<li>
						<p class="time"><?php echo date('Y-m-d H:i:s', $value['news_time']); ?></p>
						<div class="newsBox">
							<div class="news">
								<a href="news_detail-<?php echo $value['news_id']; ?>">
									<p class="title"><?php echo $value['news_title']; ?></p>
									<p class="miao">
									<?php
			                            $subject = strip_tags($value['news_content']);//去除html标签
			                            $pattern = '/\s/';//去除空白
			                            $content = preg_replace($pattern, '', $subject);
			                            $seodata = mb_substr($content, 0, 100);//截取100个汉字
			                            echo $seodata;
									?>
									</p>
								</a>
							</div>
							<div class="seeDetail">
								<a href="javascript:;">查看详情<i class="jiantou"><img src="static/style_default/images/shezhi_03.png"/></i></a>
							</div>
						</div>
					</li>
					<?php endforeach ?>
					<!--没图片结束-->
				</ul>
			</div>
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
	</body>
</html>

<script>

var page = 1;
var type = "<?php echo $a_view_data['type']; ?>";
function news_getmore() {
	page++;
	$.ajax({
		url: 'news_getmore',
		type: 'POST',
		dataType: 'json',
		data: {page: page, type: type},
		success: function(res) {
			console.log(res);
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li>';
					append_content += '<p class="time">'+el.news_time+'</p>';
					append_content += '<div class="newsBox">';
					append_content += '<div class="news">';
					append_content += '<a href="news_detail-'+el.news_id+'">';
					append_content += '<p class="title">'+el.news_title+'</p>';
					append_content += '<p class="miao">'+el.news_content+'</p>';
					append_content += '</a>';
					append_content += '</div>';
					append_content += '<div class="seeDetail">';
					append_content += '<a href="javascript:;">查看详情<i class="jiantou"><img src="static/style_default/images/shezhi_03.png"/></i></a>';
					append_content += '</div>';
					append_content += '</div>';
					append_content += '</li>';
				});
				$('.content ul').append(append_content);
			}
		}
	})
}

</script>