$(function(){
	
	//睁眼闭眼切换
	$('.fillBox li .closeEye').click(function(){//睁眼
		$(this).siblings('.openEye').show();
		$(this).siblings('.int').prop('type','text');
		$(this).hide();
	})
	$('.fillBox li .openEye').click(function(){//闭眼
		$(this).siblings('.closeEye').show();
		$(this).siblings('.int').prop('type','password');
		$(this).hide();
	})
	
})
