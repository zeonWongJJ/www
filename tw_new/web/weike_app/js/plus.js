$(document).ready(function(){
	$(document).on('click',".phone_code",function(){
	// $('.phone_code').click(function(){
		$('.phone_code').addClass('phone_captcha');
		$('.phone_code').removeClass('phone_code');
		timer();
		// $.ajax({
  //           type : "POST",
  //           url : "billaddress",
  //           data: "address="+addressid,
  //           dataType : "json",
  //           success : function(data)
  //           {
            	
  //           }
  //       });
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
			console.log(second);
		}, 1000);

	}
});