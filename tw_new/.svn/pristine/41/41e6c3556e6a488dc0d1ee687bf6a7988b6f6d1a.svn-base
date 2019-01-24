<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户中心-设置-账户与安全</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/setUp_safe.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/script/setUp_safe.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head"><a href="user_set"><img src="static/style_default/images/kefu_03.png"/></a><i>账户与安全</i></header>
			<div class="information">
				<ul>
					<li class="headPic"><a href="javascript:;">头像<i></i><b>
					<?php if (empty($a_view_data['user']['user_pic'])) {
						echo '<img src="static/style_default/images/tou_03.png"/>';
					} else {
						echo '<img src="'.$a_view_data['user']['user_pic'].'"/>';
					} ?>
					</b></a></li>
					<li class="vipName"><a href="javascript:;">会员名<s><?php echo $a_view_data['user']['user_name'];  ?></s></a></li>
					<li class="nickname"><a href="update_nickname">昵称<i></i><b><?php echo $a_view_data['user']['user_nickname'];  ?></b></a></li>
					<li class="erweima"><a href="user_erweima">我的二维码<i></i><b><img src="static/style_default/images/erwei_03.png"/></b></a></li>
					<li class="sex"><a href="javascript:;">性别<i></i><s>
					<?php if ($a_view_data['user']['user_sex'] == 1) {
						echo '男';
					} else if ($a_view_data['user']['user_sex'] == 2) {
						echo '女';
					} else {
						echo "未知";
					} ?>
					</s></a></li>
				</ul>
			</div>
			<!--账号绑定开始-->
			<div class="information account">
				<ul>
					<li class="accNum"><a href="javascript:;">账号绑定</a></li>
					<li class="phone"><a href="user_phone" style="border-bottom:none;">手机号<i></i><b>
					<?php if (empty($a_view_data['user']['user_phone'])) {
						echo '未绑定';
					} else {
						echo substr_replace($a_view_data['user']['user_phone'], '****', 3, 4);
					} ?>
					</b></a></li>
					<li class="qq" style="display:none;"><a href="javascript:;" value="<?php if (empty($a_view_data['user']['qq_openid'])) { echo '1'; } else { echo '2'; }; ?>" >QQ<i></i><b <?php if (empty($a_view_data['user']['qq_openid'])) { echo 'class="off"'; } ?>>
					<?php if (empty($a_view_data['user']['qq_openid'])) {
						echo "点击绑定";
					} else {
						echo '已绑定';
					} ?>
					</b></a></li>
					<li class="weixin" style="display:none;"><a href="javascript:;" value="<?php if (empty($a_view_data['user']['weixin_openid'])) { echo '1'; } else { echo '2'; }; ?>">微信<i></i><b <?php if (empty($a_view_data['user']['weixin_openid'])) { echo 'class="off"'; } ?>>
					<?php if (empty($a_view_data['user']['weixin_openid'])) {
						echo "点击绑定";
					} else {
						echo '已绑定';
					} ?>
					</b></a></li>
				</ul>
			</div>
			<!--账号绑定结束-->
			<!--安全设置开始-->
			<div class="information safety">
				<ul>
					<li class="safeSet"><a href="javascript:;">安全设置</a></li>
					<li class="landPass"><a href="javascript:;" onclick="update_password(<?php if (empty($a_view_data['user']['user_password'])) { echo '1'; } else { echo '2'; }; ?>)">登录密码<i></i></a></li>
					<li class="payPass"><a href="javascript:;" onclick="user_payment(<?php if (empty($a_view_data['user']['payment_code'])) { echo '1'; } else { echo '2'; }; ?>)">支付密码<i></i></a></li>
				</ul>
			</div>
			<!--安全设置结束-->
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--解除QQ号绑定弹框开始-->
		<div class="qqBomb qqBomb1">
			<p class="p1">解除绑定</p>
			<p class="p2">确定要解除账号与QQ的关联吗?</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove">解除绑定</a>
			</p>
		</div>
		<!--解除QQ号绑定弹框结束-->
		<!--解除微信绑定弹框开始-->
		<div class="qqBomb weixinBomb">
			<p class="p1">解除绑定</p>
			<p class="p2">确定要解除账号与微信的关联吗?</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove">解除绑定</a>
			</p>
		</div>
		<!--解除微信绑定弹框结束-->
		<!--未安装微信，无法绑定弹框开始-->
		<div class="unboundBomb">未安装微信，无法绑定</div>
		<!--未安装微信，无法绑定弹框结束-->
		<!--修改性别弹框开始-->
		<div class="sexBomb sexBomb1">
		 	<div class="sex1">
				<a href="javascript:;" class="boy" value="1">男</a>
				<a href="javascript:;" class="girl" value="2">女</a>
			</div>
			<div class="cancelDiv">
				<a href="javascript:;" class="cancelBtn">取消</a>
			</div>
		</div>
		<!--修改性别弹框结束-->
		<!--上传照片弹框开始-->
		<div class="sexBomb photoBomb">
		 	<div class="sex1">
				<a href="javascript:;" class="boy" onclick="userpic_camera()">拍照</a>
				<a href="javascript:;" class="girl" onclick="userpic_photo()">从手机相册选择</a>
			</div>
			<div class="cancelDiv">
				<a href="javascript:;" class="cancelBtn">取消</a>
			</div>
		</div>
		<!--上传照片弹框结束-->
		<!--选择修改密码方式弹框开始-->
		<div class="sexBomb passwordBomb">
		 	<div class="sex1">
				<a href="javascript:;" class="boy">通过旧密码方式</a>
				<a href="javascript:;" class="girl">通过手机验证方式</a>
			</div>
			<div class="cancelDiv">
				<a href="javascript:;" class="cancelBtn">取消</a>
			</div>
		</div>
		<!--选择修改密码方式弹框结束-->
	   	<!-- 弹窗 -->
	    <div class="popAppTips" style="position:fixed;">
	    	<p>请下载app客户端使用此功能</p>
	    	<div class="tipsBtn">
	    		<a href="http://vdao_mobile.7dugo.com/vdao.apk" class="goDW">下载</a>
	    		<a class="cancelDw">取消</a>
	    	</div>
	    </div>
	</body>
</html>

<!-- 引用安卓js -->
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="http://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://qiduvdaolink.js"></script>
<?php } ?>

<script>

var u = navigator.userAgent;
var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

// 拍照
function userpic_camera() {
    $(".lay").show();
    $(".popAppTips").show();
	// if (isAndroid || isiOS) {
	// 	var callbackSuccess = function(url) {
	//         $('.headPic a b').html('<img src="'+url+'">');
	// 		$('.shade').hide();
	// 		$('.photoBomb').hide();
	//      }
	// }
	// if (isAndroid) {
	// 	openCameraTokePhoto(callbackSuccess);
	// } else if (isiOS) {
	//     window.webkit.messageHandlers.vdao.postMessage({body: '', callback: callbackSuccess+'',command:'openCameraTokePhoto'});
	// };
}

// 打开相册
function userpic_photo() {
    $(".lay").show();
    $(".popAppTips").show();
	// if (isAndroid || isiOS) {
	// 	var callbackSuccess = function(url) {
	//         $('.headPic a b').html('<img src="'+url+'">');
	// 		$('.shade').hide();
	// 		$('.photoBomb').hide();
	//     }
	// }
	// if (isAndroid) {
	// 	openPhotoTokePhoto(callbackSuccess);
	// } else if (isiOS) {
 //     	window.webkit.messageHandlers.vdao.postMessage({body: '', callback: callbackSuccess+'',command:'openPhotoTokePhoto'});
 //    };
}

// 修改密码
function update_password(user_password) {
	var user_phone = "<?php echo $a_view_data['user']['user_phone']; ?>";
	if (user_password == 1) {
		window.location.href = "reset_password";
	} else if (user_phone == '') {
		window.location.href = "user_password-1";
	} else {
		// 显示选择框
		$('.passwordBomb').show();
		$('.shade').show();
		$('.passwordBomb .cancelDiv .cancelBtn').click(function(event) {
			/* 取消选择 */
			$('.shade').hide();
			$('.passwordBomb').hide();
		});
		$('.passwordBomb .sex1 .boy').click(function(event) {
			/* 通过旧密码找回 */
			window.location.href = "user_password-1";
		});
		$('.passwordBomb .sex1 .girl').click(function(event) {
			/* 通过手机验证码找回 */
			window.location.href = "user_password-2";
		});
	}
}

// 修改支付密码
function user_payment(user_payment) {
	if (user_payment == 1) {
		// 为空则前往设置支付密码
		window.location.href = "user_payment";
	} else {
		// 显示选择框
		$('.passwordBomb .sex1 .boy').html('已忘记支付密码');
		$('.passwordBomb .sex1 .girl').html('修改支付密码');
		$('.passwordBomb').show();
		$('.shade').show();
		$('.passwordBomb .cancelDiv .cancelBtn').click(function(event) {
			/* 取消选择 */
			$('.shade').hide();
			$('.passwordBomb').hide();
		});
		$('.passwordBomb .sex1 .boy').click(function(event) {
			/* 重置支付密码 */
			window.location.href = "reset_payment";
		});
		$('.passwordBomb .sex1 .girl').click(function(event) {
			/* 修改支付密码 */
			window.location.href = "update_payment";
		});
	}
}


//解除微信绑定
$('.account .weixin a').click(function(){
	var _this = $(this);
	var is_empty = $(this).attr('value');
	if (is_empty == 1) {
		if (isAndroid || isiOS) {
	        var callbackSuccess = function(response){
	            if (response != '') {
	                $.ajax({
	                    url: 'login_weixin',
	                    type: 'POST',
	                    dataType: 'json',
	                    data: {response: response},
	                    success: function (res) {
	                        if (res.code == 200) {
	                        	$('.weixin b').html('已绑定');
	                        } else {
	                        	$('.weixin b').html('绑定失败');
	                        }
	                    }
	                })
	            } else {
	            	$('.weixin b').html('绑定失败');
	            }
	        }
		}
		if (isAndroid) {
	        wxAuthorizationLogin(callbackSuccess);
		} else if (isiOS) {
	        window.webkit.messageHandlers.vdao.postMessage({
	            body: '',
	            callback: callbackSuccess+'',
	            command:'wxAuthorizationLogin'
	        });
		}
	} else {
		$('.shade').show();
		$('.weixinBomb').show();
		$('.weixinBomb .cancel').click(function(){ //取消
			$('.weixinBomb').hide();
			$('.shade').hide();
		});
		$('.weixinBomb .remove').click(function(){ //解除绑定
			// 发送ajax 解除绑定
			$.ajax({
				url: 'user_unbind',
				type: 'POST',
				dataType: 'json',
				data: {type: 2},
				success: function(res) {
					console.log(res);
					$('.weixinBomb').hide();
					$('.shade').hide();
					_this.find('b').addClass('off');
					_this.find('b').text('未绑定');
				}
			})
		})
	}
})

</script>