$(function(){
	//清空消息
	$('.head .clean').click(function(){
		//alert(0);
		$('.shade').show();
		$('.cleanBomb').show();
		$('.cleanBomb .cancel').click(function(){//取消
		    $('.cleanBomb').hide();
		    $('.shade').hide();
		})
		$('.cleanBomb .remove').click(function(){//确定
			// 发送ajax请求
			$.ajax({
				url: 'moodmsg_clear',
				type: 'POST',
				dataType: 'json',
				success:function(data){
					console.log(data);
					if (data.code==200) {
					    $('.cleanBomb').hide();
					    $('.shade').hide();
					    $('.main .content ul').empty();
					    $('.cleanTips').show();
					    setTimeout(function(){
					    	$('.cleanTips').hide();
					    },1100)
					}
				}
			})

		})
	})
})
