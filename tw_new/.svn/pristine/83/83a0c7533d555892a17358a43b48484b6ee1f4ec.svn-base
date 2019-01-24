<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的动态</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myAct.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/myAct.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<!--头部及头像背景开始-->
			<div class="top">
				<header class="head">
					<a href="user_center" class="back"><img src="static/style_default/images/dri_03.png"/></a>
					<i>我的动态</i>
					<a href="user_moodmsg" class="news"><img src="static/style_default/images/dongtai_03.png"/></a>
				</header>
				<div class="headPic">
					<span class="pic">
					<?php if (empty($a_view_data['user']['user_pic'])) {
						echo '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						echo '<img src="'.$a_view_data['user']['user_pic'].'"/>';
					} ?>
					</span>
					<span class="nickname"><?php echo $a_view_data['user']['user_name']; ?></span>
				</div>
				<div class="camera">
					<a href="mood_add"><img src="static/style_default/images/dongtai_07.png"/></a>
				</div>
			</div>
			<!--头部及头像背景结束-->
			<!--新消息开始-->
			<?php if ($a_view_data['msgcount'] != 0) { ?>
			<div class="newMessage">
				<a href="user_moodmsg">
					<div class="photo">
						<img src="static/style_default/images/dongtai_10.png"/>
					</div>
					<span class="message"><?php echo $a_view_data['msgcount']; ?>条新消息</span>
				</a>
			</div>
			<?php } ?>
			<!--新消息结束-->
			<!--动态列表开始-->
			<div class="actList" style="margin-top:30px;">
				<ul id="mymoodlist">
					<?php foreach ($a_view_data['mood'] as $key => $value): ?>
					<li id="<?php echo 'mo_' . $value['mood_id']; ?>">
						<div class="title">
							<span class="date"><?php echo date('m-d', $value['mood_time']); ?></span>
							<span class="round"></span>
							<span class="tit"><a href="umood_detail-<?php echo $value['mood_id']; ?>"><?php echo $value['mood_content']; ?></a></span>
						</div>
						<?php if (!empty($value['mood_pic'])) { ?>
						<div class="imgBox">
							<div class="bigImg">
								<?php $mood_pics = explode('&', $value['mood_pic']); ?>
								<img src="<?php echo $mood_pics[0]; ?>"/>
							</div>
							<div class="smallImg" <?php if(count($mood_pics) < 2){ echo 'style="display:none;"'; } ?>>
								<ul>
									<?php
									for ($i=1; $i<4; $i++) {
										echo '<li><img src="'.$mood_pics[$i].'"></li>';
									}
									?>
								</ul>
								<div class="grey" <?php if (count($mood_pics) < 5) { echo 'style=display:none;'; } ?>>+<i class="shu"><?php echo count($mood_pics)-4; ?></i></div>
							</div>
						</div>
						<?php } ?>
						<!--加的转发开始-->
						<?php if ($value['mood_type'] == 2) { ?>
                        <div class="transmit clearfix">
                        	<div class="tPic">
                        		<a href="javascript:;">
                        		<?php if (empty($value['replay_upic'])) {
                        			echo '<img src="static/style_default/images/tou_03.png"/>';
                        		} else {
                        			echo '<img src="'.$value['replay_upic'].'"/>';
                        		} ?>
                        		</a>
                        	</div>
                        	<div class="tDescribe">
                        		<p class="tMing"><a href="umood_detail-<?php echo $value['replay_mid']; ?>">@<?php echo $value['relay_uname']; ?></a></p>
                        		<p class="tMiao"><a href="umood_detail-<?php echo $value['replay_mid']; ?>"><?php echo $value['replay_mcon']; ?></a></p>
                        	</div>
                        </div>
                        <?php } ?>
                        <!--加的转发结束-->
						<div class="controlBox">
							<a onclick="mood_like(<?php echo $value['mood_id']; ?>)" class="giveBood"><i class="tu"></i><i class="num" id="moodlike_<?php echo $value['mood_id']; ?>"><?php echo $value['mood_good']; ?></i></a>
							<a href="umood_detail-<?php echo $value['mood_id']; ?>" class="discuss"><i class="tu"></i><i class="num"><?php echo $value['mood_discuss']; ?></i></a>
							<a href="mood_relay-<?php echo $value['mood_id']; ?>" class="share"><i class="tu"></i><i class="num"><?php echo $value['mood_relay']; ?></i></a>
							<a href="javascript:;" class="delete" onclick="mood_delete(<?php echo $value['mood_id']; ?>)">删除</a>
						</div>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
			<!--动态列表结束-->
		</div>
	</body>
</html>

<script>


// 动态点赞
function mood_like(mood_id) {
    $.ajax({
        url: 'mood_like',
        type: 'POST',
        dataType: 'json',
        data: {mood_id: mood_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                $('#moodlike_'+mood_id).html(res.data);
            }
        }
    })
}


var page = 1;
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
    totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){
        if (stop == true) {
            mood_getmore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function mood_getmore() {
	page++;
	$.ajax({
		url: 'mood_getmore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			console.log(res);
			recode = res.code;
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li id="mo_'+el.mood_id+'">';
					append_content += '<div class="title">';
					append_content += '<span class="date">'+el.mood_time+'</span>';
					append_content += '<span class="round"></span>';
					append_content += '<span class="tit"><a href="umood_detail-'+el.mood_id+'">'+el.mood_content+'</a></span>';
					append_content += '</div>';
					if (el.mood_pic != '') {
						var mood_pics = el.mood_pic.split('&');
						append_content += '<div class="imgBox">';
						append_content += '<div class="bigImg">';
						append_content += '<img src="'+mood_pics[0]+'"/>';
						append_content += '</div>';
						append_content += '<div class="smallImg">';
						append_content += '<ul>';
						length1 = mood_pics.length;
						for(var i=1; i<length1-1; i++){
							if (i < 4) {
								append_content += '<li><img src="'+mood_pics[i]+'"></li>';
							} else {
								append_content += '<li style="display:none;"><img src="'+mood_pics[i]+'"></li>';
							}
						}
						append_content += '</ul>';
						if (mood_pics.length > 3) {
							append_content += '<div class="grey">+<i class="shu">'+(mood_pics.length-4)+'</i></div>';
						}
						append_content += '</div>';
						append_content += '</div>';
					}
					if (el.mood_type == 2) {
						append_content += '<div class="transmit clearfix">';
						append_content += '<div class="tPic">';
						append_content += '<a href="javascript:;">';
						if (el.replay_upic == '') {
							append_content += '<img src="static/style_default/images/tou_03.png"/>';
						} else {
							append_content += '<img src="'+el.replay_upic+'"/>';
						}
						append_content += '</a>';
						append_content += '</div>';
						append_content += '<div class="tDescribe">';
						append_content += '<p class="tMing"><a href="umood_detail-'+el.replay_mid+'">@'+el.relay_uname+'</a></p>';
						append_content += '<p class="tMiao"><a href="umood_detail-'+el.replay_mid+'">'+el.replay_mcon+'</a></p>';
						append_content += '</div>';
						append_content += '</div>';
					}
					append_content += '<div class="controlBox">';
					append_content += '<a href="javascript:;" class="giveBood"><i class="tu"></i><i class="num">'+el.mood_good+'</i></a>';
					append_content += '<a href="javascript:;" class="discuss"><i class="tu"></i><i class="num">'+el.mood_discuss+'</i></a>';
					append_content += '<a href="javascript:;" class="share"><i class="tu"></i><i class="num">'+el.mood_relay+'</i></a>';
					append_content += '<a href="javascript:;" class="delete" onclick="mood_delete('+el.mood_id+')">删除</a>';
					append_content += '</div>';
					append_content += '</li>';
				});
				$('#mymoodlist').append(append_content);
			}
		}
	})
}


// 删除动态
function mood_delete(mood_id) {
	$.ajax({
		url: 'mood_delete',
		type: 'POST',
		dataType: 'json',
		data: {mood_id: mood_id},
		success: function(res) {
			console.log(res);
			if (res.code == 200) {
				$('#mo_'+mood_id).remove();
			}
		}
	})
}

</script>
