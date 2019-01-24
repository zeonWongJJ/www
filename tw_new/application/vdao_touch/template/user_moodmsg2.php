<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的动态-动态消息</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myAct_message.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/myAct_message.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" style="top:0.2rem;" href="user_mood"><img src="static/style_default/images/kefu_03.png"/></a>
				<i>动态消息</i>
				<a class="clean" style="top:0.2rem;" href="javascript:;">清空</a>
			</header>
			<div class="content">
				<ul>
					<!--图片描述开始-->
					<?php foreach ($a_view_data['msg'] as $key => $value): ?>
					<li onclick="umood_detail(<?php echo $value['mood_id']; ?>)">
						<div class="picBox">
							<?php if (empty($value['user_pic'])) {
								echo '<img src="static/style_default/images/tou_03.png"/>';
							} else {
								echo '<img src="'.$value['user_pic'].'"/>';
							} ?>
						</div>
						<div class="describeBox">
							<p class="name"><?php echo $value['user_name']; ?></p>
							<span class="finger"></span>
							<p class="time"><?php echo date('Y-m-d H:i:s', $value['msg_time']); ?></p>
						</div>
						<div class="rightBox1">
							<?php if (!empty($value['mood_pic'])) {
								$mood_pics = explode('&', $value['mood_pic']);
								echo '<img src="'.$mood_pics[0].'"/>';
							} else {
								echo $value['msg_content'];
							} ?>
						</div>
					</li>
					<?php endforeach ?>
					<!--图片描述结束-->
				</ul>
			</div>
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--清除消息弹框开始-->
		<div class="qqBomb cleanBomb">
			<p class="p1">注意</p>
			<p class="p2">确定要清空消息吗?</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove">确定</a>
			</p>
		</div>
		<!--清除消息弹框结束-->
		<!--清除消息成功提示开始-->
		<div class="blackTips cleanTips">动态消息清空成功</div>
		<!--清除消息成功提示开始-->
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
            user_moodmsgmore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function user_moodmsgmore() {
	page++;
	$.ajax({
		url: 'user_moodmsgmore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			console.log(res);
			recode = res.code;
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li onclick="umood_detail('+el.mood_id+')">';
					append_content += '<div class="picBox">';
					if (el.user_pic == '') {
						append_content += '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						append_content += '<img src="'+el.user_pic+'"/>';
					}
					append_content += '</div>';
					append_content += '<div class="describeBox">';
					append_content += '<p class="name">'+el.user_name+'</p>';
					append_content += '<span class="finger"></span>';
					append_content += '<p class="time">'+el.msg_time+'</p>';
					append_content += '</div>';
					append_content += '<div class="rightBox1">';
					if (el.mood_pic != '') {
						var mood_pics = el.mood_pic.split(',');
						append_content += '<img src="'+mood_pics[0]+'"/>';
					} else {
						append_content += el.mood_content;
					}
					append_content += '</div>';
					append_content += '</li>';
				});
				$(".content ul").append(append_content);
			}
		}
	})
}

function umood_detail(mood_id) {
	window.location.href = "umood_detail-"+mood_id;
}


</script>