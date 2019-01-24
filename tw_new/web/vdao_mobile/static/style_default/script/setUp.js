$(function(){
	//---设置的JS---
	$('.setList .notice .off').click(function(){
		$(this).toggleClass('on');
		var thisstate = $(this).attr('value');
		var _this = $(this);
		// ajax请求
		$.ajax({
			url: 'user_ispush',
			type: 'POST',
			dataType: 'json',
			data: {thisstate: thisstate},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					if (thisstate == 1) {
						_this.attr('value', '2');
					} else {
						_this.attr('value', '1');
					}
				}
			}
		})
	})
})
