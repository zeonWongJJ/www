$(function(){

	//---设置-修改用户名的JS---
	$('.submitBox1 .submit').click(function(){
		var txtLen = $('.intBox input').val();
		console.log(txtLen);
		if(txtLen == ''){
			$('.failBomb1').show();
			setTimeout(function(){
				$('.failBomb1').hide();
			},1000)
		}else{
			$.ajax({
				url: 'update_nickname',
				type: 'POST',
				dataType: 'json',
				data: {user_nickname: txtLen},
				success: function(res) {
					console.log(res);
					$('.successBomb1').show();
					setTimeout(function(){
						$('.successBomb1').hide();
					},1000)
				}
			})
		}
	})

})
