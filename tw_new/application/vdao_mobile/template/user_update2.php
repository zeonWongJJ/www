<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="yes" name="apple-touch-fullscreen">
		<title>账户安全</title>
        <link href="static/style_default/style/common/common.css" rel="stylesheet" type="text/css">

        <link href="static/style_default/style/style.css" rel="stylesheet" type="text/css">
<!--        <link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">-->

        <script src="static/style_default/script/rem.js" type="text/javascript"></script>
        <script src="static/style_default/script/jquery-1.8.2.min.js" type="text/javascript"></script>
<!--		<script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>-->
		<script src="script/rem.js" type="text/javascript" charset="utf-8"></script>
<!--        <link href="static/style_default/style/setUp_safe.css" rel="stylesheet" type="text/css" />-->
        <script src="static/style_default/script/common.js"></script>
		<style type="text/css">
			.body {
				position: relative;
				height: 100%;
				font-size: 0.16rem;
			}
            body,html{
                height: 100%;
                overflow: auto;
                margin: 0 auto;
                font-size: 12px;
                font-family: "Helvetica Neue", Helvetica, STHeiTi, sans-serif;
            }
			.box {
				background: #f7f7f7;
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				height: 100%;
				overflow: auto;
			}
			
			.kg {
				height: .1rem;
				width: 100%;
				background: #f7f7f7;
			}
			
			.head {
				height: 0.44rem;
				display: flex;
				justify-content: space-between;
				padding: 0 .15rem;
				font-size: .18rem;
				background: #fff;
			}
			
			.head div {
				line-height: .44rem;
				color: #000000;
			}
			
			.head .left {
				flex: 0 0 .1rem;
				background: url(static/style_default/images/back.png) no-repeat;
				background-size: .1rem .18rem;
				background-position: center;
			}
			
			.content .item {
				padding: .15rem;
				background: #fff;
				display: flex;
				justify-content: space-between;
				align-items: center;
				color: #888888;
				font-size: .16rem;
			}
			
			.content .item+.item {
				border-top: 1px solid #eeeeee;
			}
			
			.content .item:nth-child(1) {
				font-size: .14rem;
			}
			
			.content .item>div:nth-child(1) {
				color: #000000;
			}
			
			.content .item>div:nth-child(2) {
				color: #ff6633;
			}
			
			.content .item>div.check {
				color: #888888;
			}
			
			.content .item .right {
				width: .07rem;
				height: .125rem;
				background: url(static/style_default/images/more_gray.png) no-repeat;
				background-size: .07rem .125rem;
				background-position: center;
			}
			
			.bg_gray {
				background: rgba(0, 0, 0, .4);
				font-size: 0.14rem;
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				z-index: 9999;
				display: none;
				align-items: center;
				justify-content: center;
			}
			
			.bg_gray .selectBox {
				background: #fff;
				border-radius: .1rem;
				text-align: center;
				font-size: .16rem;
			}
			
			.bg_gray .selectBox .title {
				padding: .15rem;
				font-weight: 700;
			}
			
			.bg_gray .selectBox .info {
				font-size: .12rem;
				padding: .15rem .3rem;
			}
			
			.bg_gray .selectBox .footer {
				display: flex;
				border-top: 1px solid #eeeeee;
				text-align: center;
				color: #ff6633;
			}
			
			.bg_gray .selectBox .footer>div {
				flex: 1;
				padding: .1rem;
			}
			
			.bg_gray .selectBox .footer>div+div {
				border-left: 1px solid #eeeeee;
			}
			
			.c_gray {
				color: #666666;
			}
            /*修改性别弹框*/
            .sexBomb{
                width: 9.333333rem;
                position: fixed;
                bottom: 0;
                left: 50%;
                margin-left: -4.666666rem;
            }
            .sexBomb .sex1 a,
            .sexBomb .cancelDiv a.cancelBtn{
                display: block;
                width: 9.333333rem;
                height: 1.466666rem;
                background: white;
                font-size: 0.453333rem;
                color: #333333;
                text-align: center;
                line-height: 1.466666rem;
                box-sizing: border-box;
            }
            .sexBomb .sex1 a.boy{
                border-bottom: 1px solid #eeeeee;
                border-radius: 0.213333rem 0.213333rem 0 0;
            }
            .sexBomb .sex1 a.girl{
                border-radius:0 0 0.213333rem 0.213333rem;
            }
            .sexBomb .cancelDiv a.cancelBtn{
                border-radius: 0.213333rem;
                margin: 0.266666rem 0;
            }
            .sexBomb1{
                display: none;
            }
            .photoBomb{
                display: none;
            }
            .passwordBomb{
                display: none;
            }
        /*****************************************************************/
            .bg_gray_sex {
                background: rgba(0, 0, 0, .4);
                font-size: 0.14rem;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                display: none;
                flex-direction: column-reverse;
                align-items: center;
            }

            .bg_gray_sex .select {
                display: none;
            }

            .bg_gray_sex .select>div {
                background: #fff;
                text-align: center;
                width: 3.45rem;
                border-radius: .05rem;
                font-size: .16rem;
            }

            .bg_gray_sex .select .type>div {
                height: .55rem;
                line-height: .55rem;
            }

            .bg_gray_sex .select .type>div+div {
                border-top: 1px solid rgba(0, 0, 0, .4);
            }

            .bg_gray_sex .cancel {
                margin-top: .15rem;
                height: .55rem;
                line-height: .55rem;
            }
		</style>
	</head>

	<body>
		<!--办公室订单-->
		<div class="body">
			<div class="box">
				<div class="head">
                    <div class="left" id="safe_back_set"></div>
					<div>账户安全</div>
					<div></div>
				</div>
				<div class="kg"></div>
				<div class="content">
					<div class="item">账号绑定</div>
					<div class="item">
						<div>手机</div>
						<div id="user_phone"><?= $a_view_data['user']['user_phone']?
                        substr($a_view_data['user']['user_phone'], 0,3).'*****'.substr($a_view_data['user']['user_phone'], 8):'未绑定';?></div>
					</div>
					<div class="item">
						<div class="wq" id="weixin">微信</div>
						<!--添加class="check"表示已绑定，type:1 ==>微信 2==>QQ-->
                        <?= empty($a_view_data['user']['weixin_openid'])?'<div class="" type="1" value="0" >未绑定</div>':"<div class='check' type='1' value='1'>{$a_view_data['user']['wx_nickname']}</div>"; ?>
					</div>
					<div class="item">
						<div class="wq">QQ</div>
                        <?= empty($a_view_data['user']['qq_openid'])?'<div class="" type="2" value="0">未绑定</div>':"<div class='check' type='2' value='1'>{$a_view_data['user']['qq_nickname']}</div>"; ?>
					</div>
				</div>
				<div class="kg"></div>
				<div class="content">
					<div class="item">安全设置</div>
					<div class="item" onclick="update_password(<?php if (empty($a_view_data['user']['user_password'])) { echo '1'; } else { echo '2'; }; ?>)">
						<div>登录密码</div>
						<div class="right" ></div>
					</div>
					<div class="item" onclick="user_payment(<?php if (empty($a_view_data['user']['payment_code'])) { echo '1'; } else { echo '2'; }; ?>)">
						<div>支付密码</div>
						<div class="right" ></div>
					</div>
				</div>
            <div class="bg_gray_sex passwordBomb">
                <div class="select selectSex">
                    <div class="type sex1">
                        <div class="boy">通过旧密码方式</div>
                        <div class="girl">通过手机验证方式</div>
                    </div>
                    <div class="cancel">取消</div>
                </div>
            </div>
			</div>
            <!---->


            <!--选择修改密码方式弹框开始-->


<!--            <div class="sexBomb passwordBomb" id="passwordBomb">-->
<!--                <div>-->
<!--                    <div class="sex1">-->
<!--                        <div class="boy" >通过旧密码方式</div>-->
<!--                        <div class="girl" >通过手机验证方式</div>-->
<!--                    </div>-->
<!--                    <div class="cancelBtn" >取消</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            选择修改密码方式弹框结束-->
			<!---->
			<div class="bg_gray">
				<div class="selectBox">
					<div class="title">解除绑定</div>
					<div class="info">确定要解除账号与<span class="type"></span>的关联吗？</div>
					<div class="footer">
						<div class="left">取消</div>
						<div class="right" id="cancel_bind">解除绑定</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript">
    // 性别
    $('.sexBox').click(function() {
        $('.bg_gray_sex').css('display', 'flex').find('.selectSex').show();
    });
    // 取消按钮
    $('.bg_gray_sex,.bg_gray_sex .cancel').click(function() {
        $('.bg_gray_sex').hide().find('.select').hide();
    });
	$(function() {
		//解除绑定
		// $('.check').click(function() {
		// });

		// 隐藏
		$('.bg_gray').click(function(){
			$('.bg_gray').hide().find('.select').hide();
		});

	})

    $('#safe_back_set').click(function(){
        window.location.href = "nuser_center";
    })

    // $('.tobind').click(function(){
    //     if (isAndroid) {
    //         wxAuthorizationLogin(callbackSuccess);
    //
    //     } else if (isiOS) {
    //         window.webkit.messageHandlers.vdao.postMessage({
    //             body: '',
    //             callback: callbackSuccess+'',
    //             command:'wxAuthorizationLogin'
    //         });
    //     } else {
    //         window.location.href = "https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect";
    //     }
    // })

    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

    $('.wq').next().click(function(){
            var _this = $(this);
            var is_empty = $(this).attr('value');
            var type_val = $(this).attr('type');

            //判断type值是多少，1为改变微信的绑定状态，2为改变QQ的绑定状态
            if (type_val == 2) {
                // 0为未绑定,1则执行解绑
                if (is_empty == 0) {
                    // 跳转到QQ绑定
                    window.location.href = 'login_qq';
                } else {
                    var type = $(this).attr('type');
                    $('.bg_gray').css('display', 'flex').find('.info .type').text(type == '1' ? '微信号' : 'QQ').val(type);
                }
            } else if (type_val == 1) {
                // 0为未绑定,1则执行解绑
                if (is_empty == 0) {
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
                                            var nickname = JSON.parse(response).nickname;
                                            $('#weixin').next().html(nickname);
                                            $('#weixin').next().addClass('check');
                                            $('#weixin').next().attr('value', '1');
                                        } else {
                                            alert(res.msg);
                                            $('#weixin').next().html('未绑定');
                                        }
                                    }
                                })
                            } else {
                                $('#weixin').next().html('绑定失败');
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
                    var type = $(this).attr('type');
                    $('.bg_gray').css('display', 'flex').find('.info .type').text(type == '1' ? '微信号' : 'QQ').val(type);
                    // $('.shade').show();
                    // $('.weixinBomb').show();
                    // $('.weixinBomb .cancel').click(function(){ //取消
                    //     $('.weixinBomb').hide();
                    //     $('.shade').hide();
                    // });
                    // $('.weixinBomb .remove').click(function(){ //解除绑定
                    //     // 发送ajax 解除绑定
                    //     $.ajax({
                    //         url: 'user_unbind',
                    //         type: 'POST',
                    //         dataType: 'json',
                    //         data: {type: 2},
                    //         success: function(res) {
                    //             $('.weixinBomb').hide();
                    //             $('.shade').hide();
                    //             _this.find('b').addClass('off');
                    //             _this.find('b').text('未绑定');
                    //             window.location.reload();
                    //         }
                    //     })
                    // })
                }
            }
    })

    $('#cancel_bind').click(function(){
        var type = $('.bg_gray').find('.info .type').val();
        $.post('user_unbind', {type:type}, function(data){
                data = JSON.parse(data);

                if (data.code == 200) {
                    $("div[type="+type+"]").html('未綁定').attr('value', '0');
                    $("div[type="+type+"]").removeClass('check');
                }
        })
    })


    // 修改密码
    function update_password(user_password) {
        var user_phone = "<?php echo $a_view_data['user']['user_phone']; ?>";
        if (user_password == 1) {
            window.location.href = "reset_password";
        } else if (user_phone == '') {
            window.location.href = "user_password-1";
        } else {
            $('.passwordBomb .sex1 .boy').html('通过旧密码方式');
            $('.passwordBomb .sex1 .girl').html('通过手机验证方式');
            $('.bg_gray_sex').css('display', 'flex').find('.selectSex').show();

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
            $('.passwordBomb .sex1 .boy').html('已忘记支付密码');
            $('.passwordBomb .sex1 .girl').html('修改支付密码');
            $('.bg_gray_sex').css('display', 'flex').find('.selectSex').show();
            // 显示选择框
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

    $('#user_phone').click(function(){
        window.location.href = "user_phone";
    })



    // 拍照
    // function userpic_camera() {
    //     if (isAndroid || isiOS) {
    //         var callbackSuccess = function(url) {
    //             $('.headPic a b').html('<img src="'+url+'">');
    //             $('.shade').hide();
    //             $('.photoBomb').hide();
    //         }
    //     }
    //     if (isAndroid) {
    //         openCameraTokePhoto(callbackSuccess);
    //     } else if (isiOS) {
    //         window.webkit.messageHandlers.vdao.postMessage({body: '', callback: callbackSuccess+'',command:'openCameraTokePhoto'});
    //     };
    // }

    // 打开相册
    // function userpic_photo() {
    //     if (isAndroid || isiOS) {
    //         var callbackSuccess = function(url) {
    //             $('.headPic a b').html('<img src="'+url+'">');
    //             $('.shade').hide();
    //             $('.photoBomb').hide();
    //         }
    //     }
    //     if (isAndroid) {
    //         openPhotoTokePhoto(callbackSuccess);
    //     } else if (isiOS) {
    //         window.webkit.messageHandlers.vdao.postMessage({body: '', callback: callbackSuccess+'',command:'openPhotoTokePhoto'});
    //     };
    // }

</script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script >
    //是否显示标题
    // initTitleBarLayoutIsVisible(0);
</script>
</script>