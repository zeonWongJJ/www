<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的评价</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myAppraise.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/myAppraise.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_center"><img src="static/style_default/images/yongping_03.png"/></a><i>我的评价</i></header>
			<div class="content">
				<ul id="commentullist">
					<?php foreach ($a_view_data['comment'] as $key => $value): ?>
					<li id="comment_<?php echo $value['comment_id']; ?>">
						<div class="title">
							<span class="headPic">
							<?php if (empty($a_view_data['user']['user_pic'])) {
								echo '<img src="static/style_default/images/tou_03.png"/>';
							} else {
								echo '<img src="'.$a_view_data['user']['user_pic'].'"/>';
							} ?>
							</span>
							<span class="name"><?php echo $a_view_data['user']['user_name']; ?></span>
							<a class="sanjiao" id="<?php echo 'anonymous_'.$value['comment_id']; ?>" href="javascript:;" value="<?php echo $value['is_anonymous']; ?>" onclick="comment_anonymous(<?php echo $value['comment_id']; ?>)"><img src="static/style_default/images/pingjia_03.png"/></a>
						</div>
						<p class="aboutRoom"><?php echo date('Y-m-d H:i:s', $value['comment_time']); ?></p>
						<p class="serve">
						<i class="red">
						<?php if (!empty($value['comment_tags'])) {
							echo '['.str_replace(',', '、', $value['comment_tags']).']';
						} ?>
						</i>
						<?php echo $value['comment_content']; ?></p>
						<?php if (!empty($value['comment_pic'])) { ?>
						<div class="imgBox">
							<ul class="clearfix">
								<?php $comment_pics = explode(',', $value['comment_pic']); ?>
								<?php for ($i=0; $i < count($comment_pics); $i++) {
									echo '<li><img src="'.$comment_pics[$i].'"/></li>';
								} ?>
							</ul>
						</div>
						<?php } ?>
						<div class="article" onclick="store_detail(<?php echo $value['store_id']; ?>)">
							<div class="pic">
							<?php if (empty($value['store_touxiang'])) {
								echo '<img src="static/style_default/images/pingjia_07.png"/>';
							} else {
								echo '<img src="'.get_config_item('store_touxiang').$value['store_touxiang'].'"/>';
							} ?>
							</div>
							<div class="describe">
								<p class="p1"><?php echo $value['store_name']; ?></p>
								<p class="p2"><?php echo substr($value['store_introduction'], 0, 36); ?></p>
							</div>
						</div>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--匿名弹框开始-->
		<div class="sexBomb anonymousBomb">
		 	<div class="sex1">
				<a href="javascript:;" class="girl">不想匿名了</a>
				<a href="javascript:;" class="boy">删除评价</a>
			</div>
			<div class="cancelDiv">
				<a href="javascript:;" class="cancelBtn">取消</a>
			</div>
		</div>
		<!--匿名弹框结束-->
	</body>
</html>

<script>

function comment_anonymous(comment_id) {
	var thisanonymous = $('#anonymous_'+comment_id).attr('value');
	if (thisanonymous == 0) {
		$('.anonymousBomb .girl').html('我要匿名');
	} else {
		$('.anonymousBomb .girl').html('不想匿名了');
	}
	//点击三角显示弹框
	$('.shade').show();
	$('.anonymousBomb').show();
	$('.anonymousBomb .girl').click(function(event) {
		// 发送ajax请求
		$.ajax({
			url: 'comment_anonymous',
			type: 'POST',
			dataType: 'json',
			data: {comment_id: comment_id},
			success: function(res){
				console.log(res);
				if (res.code == 200) {
					if (thisanonymous == 0) {
						$('#anonymous_'+comment_id).attr('value','1');
					} else {
						$('#anonymous_'+comment_id).attr('value','0');
					}
				}
			}
		})
		$('.shade').hide();
		$('.anonymousBomb').hide();
	});
	// 删除评论
	$('.anonymousBomb .boy').click(function(event) {
		// 发送ajax请求
		$.ajax({
			url: 'comment_delete',
			type: 'POST',
			dataType: 'json',
			data: {comment_id: comment_id},
			success: function(res){
				console.log(res);
				if (res.code == 200) {
					$("#comment_"+comment_id).remove();
				}
			}
		})
		$('.shade').hide();
		$('.anonymousBomb').hide();
	});
	// 关闭
	$('.anonymousBomb .cancelBtn').click(function(){
		$('.shade').hide();
		$('.anonymousBomb').hide();
	})
}

// 获取更多评论
var page = 1;
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            comment_getmore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function comment_getmore() {
	page++;
	// 发送ajax请求
	$.ajax({
		url: 'comment_getmore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			console.log(res);
			recode = res.code;
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data.comment, function(index, el) {
					append_content += '<li>';
					append_content += '<div class="title">';
					append_content += '<span class="headPic">';
					if (res.data.user.user_pic == '') {
						append_content += '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						append_content += '<img src="'+res.data.user.user_pic+'"/>';
					}
					append_content += '</span>';
					append_content += '<span class="name">'+res.data.user.user_name+'</span>';
					append_content += '<a class="sanjiao" id="anonymous_'+el.comment_id+'" href="javascript:;" value="'+el.is_anonymous+'" onclick="comment_anonymous('+el.comment_id+')"><img src="static/style_default/images/pingjia_03.png"/></a>';
					append_content += '</div>';
					append_content += '<p class="aboutRoom">'+el.comment_time+'</p>';
					append_content += '<p class="serve">';
					append_content += '<i class="red">';
					if (el.comment_tags != '') {
						append_content += '['+el.comment_tags+']';
					}
					append_content += '</i>';
					append_content += el.comment_content;
					append_content += '<div class="article" onclick="store_detail('+el.store_id+')">';
					append_content += '<div class="pic">';
					append_content += el.store_touxiang;
					append_content += '</div>';
					append_content += '<div class="describe">';
					append_content += '<p class="p1">'+el.store_name+'</p>';
					append_content += '<p class="p2">'+el.store_introduction+'</p>';
					append_content += '</div>';
					append_content += '</div>';
					append_content += '</li>';
				});
				$("#commentullist").append(append_content);
			}
		}
	})
}

// 点击跳转门店详情
function store_detail(store_id) {
	window.location.href = "store_detail-"+store_id;
}

</script>