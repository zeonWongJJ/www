<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>办公室详情</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/officeDetails.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/officeDetails.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head" style="height:6.8rem; padding-top:0;">
				<div class="img">
				<?php if (empty($a_view_data['room']['room_mainpic'])) {
					echo '<img src="./static/style_default/images/banxiang_02.png"/>';
				} else {
					echo '<img src="'.get_config_item('wofei_admin').$a_view_data['room']['room_mainpic'].'">';
				} ?>
				</div>
				<a class="back" href='javascript:window.history.back();'><img src="./static/style_default/images/vbf.png"/></a>
				<p class="control">
					<a class="collect" href="javascript:;" onclick="office_collection(<?php echo $a_view_data['office_id']; ?>)" value="<?php echo $a_view_data['is_collection']; ?>">
					<?php if ($a_view_data['is_collection'] == 2) {
						echo '<img src="./static/style_default/images/fa.png"/>';
					} else {
						echo '<img src="./static/style_default/images/unfavourite.png"/>';
					} ?>
					</a>
					<a class="share" href="javascript:;"><img src="./static/style_default/images/saf.png"/></a>
				</p>
				<div class="ding">
					<?php if (!empty($a_view_data['recentlyappoint'])) { ?>
					<p class="newBook">最新预定:&nbsp;<?php echo date('Y-m-d', $a_view_data['recentlyappoint']); ?></p>
					<?php } ?>
					<p class="page">
					<?php if (!empty($a_view_data['room']['room_otherpic'])) {
						$room_otherpic = explode(',', $a_view_data['room']['room_otherpic']);
						echo '1/' . count($room_otherpic);
					} else {
						echo '0/0';
					} ?>
					</p>
				</div>
			</header>
			<div class="title">
				<p class="h3"><?php echo $a_view_data['type']['type_name'].$a_view_data['room']['room_name']; ?></p>
				<p class="start">
					<?php for ($i=0; $i < round($a_view_data['star']); $i++) {
						echo '<i></i>';
					} ?>
					<?php for ($i=0; $i <5-round($a_view_data['star']); $i++) {
						echo '<i class="harfStart"></i>';
					} ?>
					<span><?php echo round($a_view_data['star'],1); ?></span>
				</p>
				<a class="book" href="javascript:;" onclick="office_appoint(<?php echo $a_view_data['office_id']; ?>)">预定</a>
			</div>
			<div class="describe">
				<p class="biao">办公室描述</p>
				<p class="miao"><?php echo $a_view_data['room']['room_description']; ?></p>
			</div>
			<!--设施服务开始-->
			<div class="serve">
				<span class="she">设施服务<i>+<?php echo count($a_view_data['device'])+2; ?></i></span>
				<ul class="clearfix">
					<li>
						<a href="javascript:;">
							<div class="pic">
								<img src="./static/style_default/images/banxiang_05.png"/>
							</div>
							<p class="tit"><?php echo $a_view_data['room']['room_seat']; ?>人</p>
						</a>
					</li>
					<li>
						<a href="javascript:;">
							<div class="pic">
								<img src="./static/style_default/images/banxiang_07.png"/>
							</div>
							<p class="tit"><?php echo $a_view_data['room']['room_size']; ?>㎡</p>
						</a>
					</li>
					<?php foreach ($a_view_data['device'] as $key => $value): ?>
					<li>
						<a href="javascript:;">
							<div class="pic">
								<?php if (empty($value['device_mainpic'])) {
									echo '<img src="./static/style_default/images/banxiang_13.png"/>';
								} else {
									echo '<img src="'.get_config_item('wofei_admin').$value['device_mainpic'].'"/>';
								} ?>
							</div>
							<p class="tit"><?php echo $value['device_name']; ?></p>
						</a>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
			<!--设施服务结束-->
			<!--评价开始-->
			<div class="appraise">
				<p class="aTit">
					<span class="ping">评价<i>+<?php echo $a_view_data['comment_total']; ?></i></span>
					<a class="seeMore" href="office_comment-<?php echo $a_view_data['office_id']; ?>">查看更多</a>
				</p>
				<ul class="clearfix">
					<?php foreach ($a_view_data['comtag'] as $key => $value) { ?>
					<li><a href="office_comment-<?php echo $a_view_data['office_id'].'-'.$value; ?>"><?php echo $value; ?></a></li>
					<?php } ?>
				</ul>
			</div>
			<!--评价结束-->
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--分享弹框开始-->
		<div class="shareBomb">
			<p class="fenxiang">分享到</p>
			<ul class="clearfix">
				<li>
					<a href="javascript:;">
						<div class="pic">
							<img src="./static/style_default/images/fenxiang_03.png"/>
						</div>
						<p class="tit">微博</p>
					</a>
				</li>
				<li>
					<a href="javascript:;" onclick="share_talk()">
						<div class="pic">
							<img src="./static/style_default/images/fenxiang_05.png"/>
						</div>
						<p class="tit">微信好友</p>
					</a>
				</li>
				<li>
					<a href="javascript:;" onclick="share_friends()">
						<div class="pic">
							<img src="./static/style_default/images/fenxiang_07.png"/>
						</div>
						<p class="tit">微信朋友圈</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<div class="pic">
							<img src="./static/style_default/images/fenxiang_09.png"/>
						</div>
						<p class="tit">QQ好友</p>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<div class="pic">
							<img src="./static/style_default/images/fenxiang_12.png"/>
						</div>
						<p class="tit">QQ空间</p>
					</a>
				</li>
			</ul>
			<div class="cancel">
				<a href="javascript:;">取消</a>
			</div>
		</div>
		<!--分享弹框结束-->
		<!--图片弹框开始-->
		<div class="picBomb">
			<div class="close2">
				<a href="javascript:;"><img src="./static/style_default/images/putin_06.png"/></a>
			</div>
			<div class="picWrap">
				<div class="picShow">
					<ul class="clearfix">
						<?php if (!empty($a_view_data['room']['room_otherpic'])) {
							$room_otherpic = explode(',', $a_view_data['room']['room_otherpic']);
							for ($i=0; $i < count($room_otherpic); $i++) {
								echo '<li><img src="'.get_config_item('wofei_admin').$room_otherpic[$i].'"/></li>';
							}
						} else {
							echo '<li><img src="static/style_default/images/banxiang_02.png"/></li>';
						} ?>
					</ul>
				</div>
				<a class="left" href="javascript:;"><img src="./static/style_default/images/left.png"/></a>
				<a class="right" href="javascript:;"><img src="./static/style_default/images/right.png"/></a>
			</div>
		</div>
		<!--图片弹框结束-->
	</body>
</html>

<script>

function office_appoint(office_id) {
	// 发送ajax请求 判断是否有资格预定办公室
	$.ajax({
		url: 'order_office_allow',
		type: 'POST',
		dataType: 'json',
		success: function(res) {
			console.log(res);
			if (res.code == 500) {
				window.location.href = "login.html?oldurl=" + window.location.href;
			} else if (res.code == 200) {
				window.location.href = 'office_appoint-'+office_id;
			} else {
				alert(res.msg);
			}
		}
	})
}

// 收藏和取消收藏
function office_collection(office_id) {
	var is_collection = $('.collect').attr('value');
    $.ajax({
        url: 'office_collection',
        type: 'POST',
        dataType: 'json',
        data: {office_id: office_id},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
            	if (is_collection == 1) {
            		$('.collect').attr('value','2');
            		$('.collect').html('<img src="./static/style_default/images/fa.png"/>');
            	} else {
            		$('.collect').attr('value','1');
            		$('.collect').html('<img src="./static/style_default/images/unfavourite.png"/>');
            	}
            }
        }
    })
}

</script>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 分享的链接
var shareContent = "<?php echo $this->router->get_url(); ?>";
// 分享的标题
var title = "<?php echo $a_view_data['room']['room_name']; ?>";
// 分享的描述
var content = "<?php echo $a_view_data['room']['room_description']; ?>";

// 分享到微信好友
function share_talk() {
	if (isAndroid || isiOS) {
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "talk",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : title,
            "content"       : content
        }
	}
	if (isAndroid) {
        shareToThirdApp(json);
	} else if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
	}
}

// 分享到微信朋友圈
function share_friends() {
	if (isAndroid || isiOS) {
        var json = {
            "whatTypeShare" : "wx",
            "whoToShare"    : "friends",
            "shareType"     : "url",
            "shareContent"  : shareContent,
            "title"         : title,
            "content"       : content
        }
	}
	if (isAndroid) {
        shareToThirdApp(json);
	} else if (isiOS) {
        json = JSON.stringify(json);
        window.webkit.messageHandlers.vdao.postMessage({
            body    : json,
            callback: '',
            command : 'shareToThirdApp'
        });
	}
}

</script>