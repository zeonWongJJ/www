$(function(){
	//点击发送验证码
	var num = 60;
	var timer = null;
	$('.fillBox .testCode .send').click(function(){
		// ajax发送短信
		var user_phone = $("input[name='user_phone']").val();
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

	//鼠标聚焦第一个
	$('.intDiv .int:first-child').focus();
	//输入密码自动跳去下一个
	$('.intDiv .int').keyup(function(){
		var valLen = $(this).val().length;
		var tIndex = $(this).index();
		if(valLen == 1){
			$(this).next('.int').focus();
		}
		if(tIndex == 5){
			$(this).blur();
		}
	})

	//点击第一步的下一步
	$('body').on('click','.typeBox .one .submit',function(){
		$('.typeBox .two').show();
		$('.typeBox .one').hide();
	})
	//点击第二步的下一步
	$('body').on('click','.typeBox .two .submit',function(){
		$('.typeBox .three').show();
		$('.typeBox .two').hide();
	})
})
