<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>动态详情</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myAct_details.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript" ></script>
		<script src="static/style_default/script/myAct_details.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="javascript:window.history.back();"><img src="static/style_default/images/kefu_03.png"/></a><i>动态详情</i></header>
			<div class="content clearfix">
				<!--头像开始-->
				<div class="picBox">
					<div class="pic">
						<?php if (empty($a_view_data['mood']['user_pic'])) {
							echo '<img src="static/style_default/images/tou_03.png"/>';
						} else {
							echo '<img src="'.$a_view_data['mood']['user_pic'].'"/>';
						} ?>
					</div>
					<div class="article">
						<p class="p1"><?php echo $a_view_data['mood']['user_name']; ?></p>
						<p class="p2">发布于<?php echo date('Y-m-d H:i:s', $a_view_data['mood']['mood_time']) ?></p>
					</div>
				</div>
				<!--头像结束-->
				<!--标题开始-->
				<p class="title"><?php echo $a_view_data['mood']['mood_content']; ?></p>
				<!--标题结束-->
				<!--图片开始-->
				<?php if (!empty($a_view_data['mood']['mood_pic'])) { ?>
				<?php $mood_pics = explode('&', $a_view_data['mood']['mood_pic']); ?>
				<div class="imgBox">
					<ul>
						<?php for ($i=0; $i<count($mood_pics); $i++) {
							echo '<li><img src="'.$mood_pics[$i].'"/></li>';
						} ?>
					</ul>
				</div>
				<?php } ?>
				<!--图片结束-->
				<!--点赞开始-->
				<div class="goodBox clearfix">
					<i class="icon" onclick="mood_like(<?php echo $a_view_data['mood']['mood_id']; ?>)"></i>
					<span class="num"><s id="thismoodlike"><?php echo $a_view_data['mood']['mood_good']; ?></s>人点赞</span>
					<div class="people">
						<ul>
							<?php $i=0; foreach ($a_view_data['like'] as $key => $value): ?>
							<li <?php if ($i>2) { echo 'style="display:none;"'; } ?>><img src="<?php echo $value['user_pic']; ?>"/></li>
							<?php $i++; endforeach ?>
							<?php if (count($a_view_data['like']) > 3) { ?>
							<li>+<?php echo count($a_view_data['like'])-3; ?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<!--点赞结束-->
				<!--转发开始-->
				<div class="goodBox shareBox clearfix">
					<i class="icon" onclick="mood_relay(<?php echo $a_view_data['mood']['mood_id']; ?>)"></i>
					<span class="num"><s><?php echo $a_view_data['mood']['mood_relay']; ?></s>人转发</span>
					<div class="people">
						<ul>
							<?php $i=0; foreach ($a_view_data['relay'] as $key => $value): ?>
							<li <?php if ($i>2) { echo 'style="display:none;"'; } ?>><img src="<?php echo $value['user_pic']; ?>"/></li>
							<?php $i++; endforeach ?>
							<?php if (count($a_view_data['relay']) > 2) { ?>
							<li>+<?php echo count($a_view_data['relay'])-3; ?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<!--转发结束-->
				<!--评论开始-->
				<div class="discussBox">
					<p class="ping">
						<i class="icon1" onclick="mood_comment()"></i>
						<span class="num1"><s><?php echo $a_view_data['mood']['mood_discuss']; ?></s>人评论</span>
					</p>
					<ul class="disList">
						<!--单个评论开始-->
						<?php foreach ($a_view_data['discuss_p'] as $key => $value): ?>
						<li>
							<div class="dLeft" onclick="discuss_at(<?php echo "'".$value['user_name']."'"; ?>,<?php echo $value['discuss_id']; ?>)">
								<?php if (empty($value['user_pic'])) {
									echo '<img src="static/style_default/images/dongtai_10.png"/>';
								} else {
									echo '<img src="'.$value['user_pic'].'"/>';
								} ?>
							</div>
							<div class="dRight">
								<p class="name">
									<a href="javascript:;">
									<?php if(empty($value['user_id'])) {
										echo '管理员';
									} else {
										echo $value['user_name'];
									} ?>
									</a>
									<span>
									<?php
										echo date('m-d', $value['discuss_time']);
									?>
									</span>
								</p>
								<p class="discuss">
									<a href="javascript:;"></a>
									<span><?php echo $value['discuss_content']; ?></span>
								</p>
							</div>
						</li>
						<?php foreach ($a_view_data['discuss_s'] as $k => $v): ?>
						<?php if ($value['discuss_id'] == $v['discuss_pid']) { ?>
						<li>
							<div class="dLeft" onclick="discuss_at(<?php echo "'".$v['user_name']."'"; ?>,<?php echo $value['discuss_id']; ?>)">
								<?php if (empty($v['user_pic'])) {
									echo '<img src="static/style_default/images/dongtai_10.png"/>';
								} else {
									echo '<img src="'.$v['user_pic'].'"/>';
								} ?>
							</div>
							<div class="dRight">
								<p class="name">
									<a href="javascript:;">
									<?php if(empty($v['user_id'])) {
										echo '管理员';
									} else {
										echo $v['user_name'];
									} ?>
									</a>
									<span>
									<?php echo date('m-d', $v['discuss_time']); ?>
									</span>
								</p>
								<p class="discuss">
									<a href="javascript:;" style="display:none;">@<?php echo $value['user_name']; ?></a>
									<span>
									<?php
										$index1 = strpos($v['discuss_content'], '@');
										$index2 = strpos($v['discuss_content'], ':');
										$str = substr($v['discuss_content'], $index1, $index2);
										echo str_replace($str,'<font color="#ff9da2">'.$str.'</font>', $v['discuss_content']); ?>
									</span>
								</p>
							</div>
						</li>
						<?php } ?>
						<?php endforeach ?>
						<?php endforeach ?>
						<!--单个评论结束-->
					</ul>
				</div>
				<!--评论结束-->
			</div>
			<!--评论输入框开始-->
			<div class="intBox">
				<span class="tu" onclick="mood_discuss()"></span>
				<textarea name="discuss_content" class="txt" placeholder="来说两句吧..." id="tValue" style="overflow-y:hidden; height:20px;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'"></textarea>
			</div>
			<!--评论输入框结束-->
		</div>
	</body>
</html>

<script>


// 评论动态
function mood_discuss() {
	var mood_id = "<?php echo $a_view_data['mood']['mood_id']; ?>";
	var discuss_content = $("textarea[name='discuss_content']").val();
	if (discuss_content != '') {
		// 判断内容开头是否有@
		if (discuss_content.charAt(0) == '@') {
			var discuss_id = at_discuss;
		} else {
			var discuss_id = 0;
		}
		// 发送ajax请求
		$.ajax({
			url: 'mood_discuss',
			type: 'POST',
			dataType: 'json',
			data: {discuss_content: discuss_content, mood_id: mood_id, discuss_id: discuss_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					var append_content = '<li>';
					append_content += '<div class="dLeft">';
					if (res.data.user_pic == '') {
						append_content += '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						append_content += '<img src="'+res.data.user_pic+'">';
					}
					append_content += '</div>';
					append_content += '<div class="dRight">';
					append_content += '<p class="name">';
					append_content += '<a href="javascript:;">'+res.data.user_name+'</a>';
					append_content += '<span>刚刚</span>';
					append_content += '</p>';
					append_content += '<p class="discuss">';
					append_content += '<a href="javascript:;"></a>';
					append_content += '<span>'+discuss_content+'</span>';
					append_content += '</p>';
					append_content += '</div>';
					append_content += '</li>';
					$('.disList').append(append_content);
					$('.txt').val('');
					$('.num1 s').html(res.newcount);
				}
			}
		})
	}
}


// @某个人
var at_discuss = 0;
function discuss_at(user_name, discuss_id) {
	if (user_name == '') {
		user_name = '管理员';
	}
	$("textarea[name='discuss_content']").val('@'+user_name+':  ');
	at_discuss = discuss_id;
}



function mood_relay(mood_id) {
	window.location.href="mood_relay-"+mood_id;
}


function mood_comment() {
	$('#tValue').focus();
}

function mood_like(mood_id) {
	$.ajax({
		url: 'mood_like',
		type: 'POST',
		dataType: 'json',
		data: {mood_id: mood_id},
		success : function (res) {
			console.log(res)
			if (res.code == 200) {
				$('#thismoodlike').html(res.data);
			}
		}
	})
}

</script>