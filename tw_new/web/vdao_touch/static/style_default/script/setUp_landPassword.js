$(function(){
	//点击发送验证码
	var num = 60;
	var timer = null;
	$('.fillBox .testCode .send').click(function(){
		var user_phone = $("input[name='user_phone']").val();
		console.log(user_phone);
		// 发送获取验证码的请求
		$.ajax({
			url: 'send_code',
			type: 'POST',
			dataType: 'json',
			data: {user_phone: user_phone},
			success: function(res) {
				console.log(res);
			}
		})

		$('.fillBox .testCode .time').show();
		$(this).hide();
		timer=setInterval(function(){
			num--;
			$('.fillBox .testCode .time s').text(num);
			if(num == 0){
				clearInterval(timer);
				$('.fillBox .testCode .time').hide();
				$('.fillBox .testCode .sendAgain').show();
			}
		},1000)
	})
	//睁眼闭眼切换
	$('.fillBox .password .closeEye').click(function(){//睁眼
		$(this).siblings('.openEye').show();
		$(this).siblings('.int').prop('type','text');
		$(this).hide();
	})
	$('.fillBox .password .openEye').click(function(){//闭眼
		$(this).siblings('.closeEye').show();
		$(this).siblings('.int').prop('type','password');
		$(this).hide();
	})

})
