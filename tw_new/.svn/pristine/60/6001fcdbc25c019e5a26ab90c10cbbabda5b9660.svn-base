$(function(){
	//检测用户名==================
	$("form").find("input[name=username]:eq(0)").blur(function(){
		var user=$(this).val();

	});

	function CheckUser(user) {
	    var filter  = /^[a-zA-Z0-9_]{2,19}$/;
	    if (filter.test(user)) return true;
	    else {
	        $('.form_hint:first').show().css("background","#fe9d50").text('请输入2-20位字母、数字或中文，不含特殊字符。');
	        return false;
	    }
	};
	//=============================

	//检测密码====================
	$("form").find("input[name=passwd]:eq(0)").blur(function(){
		var pwd1=$(this).val();
		alert(CheckPwd(pwd1));
	});

	function CheckPwd(pwd) {
	    var filter  = /^[0-9a-zA-Z_.$#@^&]{6,14}$/;
	    if (filter.test(pwd)) return true;
	    else {
	        $('.form_hint').eq(1).show().css("background","#fe9d50").text('密码中必须包含字母、数字、特称字符，长度为6-14个字符');
	        return false;
	    }
	};
	//=============================

	//检测密码2===================
	$("form").find("input[name=passwd]:eq(1)").blur(function(){
		var pwd2=$(this).val();

		var pwd1=$("form").find("input[name=passwd]:eq(0)").val();

		if(CheckPwd(pwd2)){
			if(pwd1!=pwd2){
				$('.form_hint').eq(1).show().css("background","#fe9d50").text('两次密码不一致');
			}
		}
		
	});
	//==============================

$(document).on('click',".phone_code",function(){
	// $('.phone_code').click(function(){
		$('.phone_code').addClass('phone_captcha');
		$('.phone_code').removeClass('phone_code');
		timer();
		$.ajax({
            type : "POST",
            url : "billaddress",
            data: "address="+addressid,
            dataType : "json",
            success : function(data)
            {
            	
            }
        });
	}); 
	function timer(){
		var second = 90;
		var j = setInterval(function(){
			second--;
			$('.phone_captcha').text(second);
			if(second <= 0){
				$('.phone_captcha').addClass('phone_code');
				$('.phone_captcha').removeClass('phone_captcha');
				$('.phone_code').text('获取验证码');
				clearInterval(j);
			}
		}, 1000);

	}
})


