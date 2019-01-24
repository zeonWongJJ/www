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
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="user_center"><img src="static/style_default/images/yongping_03.png"/></a>
				<i>我的积分</i>
				<a class="explain" href="score_explain">？</a>
			</header>
			<div class="currentInt clearfix">
				<p class="p1">当前积分</p>
				<p class="p2"><?php echo $a_view_data['user']['user_score']; ?></p>
			</div>
			<div class="detailList">
				<ul>
					<li class="title">
						<a href="javascript:;">
							<p class="type">积分明细</p>
							<i class="yellow"></i>
						</a>
					</li>
					<?php foreach ($a_view_data['score'] as $key => $value): ?>
					<li>
						<a href="score_detail-<?php echo $value['pl_id']; ?>">
							<p class="type"><?php echo $value['pl_item']; ?></p>
							<p class="time"><?php echo date('Y-m-d H:i:s', $value['pl_time']); ?></p>
							<p class="num"><?php if ($value['pl_type'] == 1) { echo '+'.$value['pl_variation']; } else { echo '-'.$value['pl_variation']; } ?></p>
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
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            user_scoremore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function user_scoremore() {
	page++;
	$.ajax({
		url: 'user_scoremore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			console.log(res);
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li>';
					append_content += '<a href="score_detail-'+el.pl_id+'">';
					append_content += '<p class="type">'+el.pl_item+'</p>';
					append_content += '<p class="time">'+el.pl_time+'</p>';
					append_content += '<p class="num">';
					if (el.pl_type == 1) {
						append_content += '+'+el.pl_variation;
					} else {
						append_content += '-'+el.pl_variation;
					}
					append_content += '</p>';
					append_content += '</a>';
					append_content += '</li>';
				});
				$('.detailList ul').append(append_content);
			}
		}
	})
}

</script>