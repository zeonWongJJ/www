$(function(){

	//---设置-账户与安全的JS---

	// 解除QQ绑定
	$('.account .qq a').click(function(){
		var _this = $(this);
		var is_empty = $(this).attr('value');
		if (is_empty == 1) {
			// 跳转到QQ绑定
			window.location.href = 'login_qq';
		} else {
			$('.shade').show();
			$('.qqBomb1').show();
			$('.qqBomb1 .cancel').click(function(){ //取消
				$('.qqBomb1').hide();
				$('.shade').hide();
			});
			$('.qqBomb1 .remove').click(function(){ //解除绑定
				// 发送ajax 解除绑定
				$.ajax({
					url: 'user_unbind',
					type: 'POST',
					dataType: 'json',
					data: {type: 1},
					success: function(res) {
						$('.qqBomb1').hide();
						$('.shade').hide();
						_this.find('b').addClass('off');
						_this.find('b').text('未绑定');
						window.location.reload();

					}
				})
			})
		}
	})

	// //解除微信绑定
	// $('.account .weixin a').click(function(){
	// 	var _this = $(this);
	// 	var is_empty = $(this).attr('value');
	// 	if (is_empty == 1) {
	// 		window.location.href = 'https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect';
	// 	} else {
	// 		$('.shade').show();
	// 		$('.weixinBomb').show();
	// 		$('.weixinBomb .cancel').click(function(){ //取消
	// 			$('.weixinBomb').hide();
	// 			$('.shade').hide();
	// 		});
	// 		$('.weixinBomb .remove').click(function(){ //解除绑定
	// 			// 发送ajax 解除绑定
	// 			$.ajax({
	// 				url: 'user_unbind',
	// 				type: 'POST',
	// 				dataType: 'json',
	// 				data: {type: 2},
	// 				success: function(res) {
	// 					console.log(res);
	// 					$('.weixinBomb').hide();
	// 					$('.shade').hide();
	// 					_this.find('b').addClass('off');
	// 					_this.find('b').text('未绑定');
	// 				}
	// 			})
	// 		})
	// 	}
	// })

	//选择性别
	$('.information .sex a').click(function(){
		var _this = $(this);
		$('.shade').show();
		$('.sexBomb1').show();
		$('.sexBomb1 .cancelBtn').click(function(){//取消
			$('.shade').hide();
			$('.sexBomb1').hide();
		})
		$('.sexBomb1 .sex1 a').click(function(){//取消
			// 发送ajax请求修改性别
			var my_sex = $(this).attr('value');
			console.log(my_sex);
			$.ajax({
				url: 'update_sex',
				type: 'POST',
				dataType: 'json',
				data: {user_sex: my_sex},
				success: function(res) {
					console.log(res);
				}
			})
			var aText = $(this).text();
			_this.find('s').text(aText);
			$('.shade').hide();
			$('.sexBomb1').hide();
		})
	})

	// 选择图片
	$('.headPic').click(function(event) {
		$('.shade').show();
		$('.photoBomb').show();
		$(".photoBomb .cancelDiv .cancelBtn").click(function(event) {
			$('.shade').hide();
			$('.photoBomb').hide();
		});
	});


})
