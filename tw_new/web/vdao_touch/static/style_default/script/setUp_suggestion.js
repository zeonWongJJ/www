$(function(){

	//---设置-意见反馈的JS---
		//输入文字减少
	$('.import .txt').keydown(function(){
		var len = $(this).val().length;
		var num = 200 - len;
		$(this).siblings('.num').children('span:eq('+0+')').text(num);
		$(this).siblings('.num').children('span:eq('+0+')').css('color','red');
	})
		//提交
	$('.submitBox .submit').click(function(){
		var txtLen = $('.import .txt').val().length;
		if(txtLen < 10){
			$('.failBomb').show();
			setTimeout(function(){
				$('.failBomb').hide();
			},1000)
		}else{
			$('.successBomb').show();
			// $('.import .txt').val('');
			setTimeout(function(){
				$('.successBomb').hide();
			},1000)
		}
	})

})
