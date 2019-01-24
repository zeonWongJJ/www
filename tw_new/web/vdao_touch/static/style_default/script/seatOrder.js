$(function(){
	//点击切换导航
	$('.nav li a').click(function(){
		$(this).parent('li').addClass('current').siblings().removeClass('current');
	})
	//取消订单
	$('body').on('click','.content .control a.cancel',function(){
		var _this = $(this);
		$('.shade').show();
		$('.cancelBomb').show();
		$('.cancelBomb .wait').unbind('click').click(function(){//再等会
			$('.shade').hide();
			$('.cancelBomb').hide();
		})
		$('.cancelBomb .remove').unbind('click').click(function(){//立即取消
			_this.parent().siblings('.tit').find('.span2').addClass('hasCancel');
			_this.parent().siblings('.tit').find('.span2').text('已取消');
			$('.shade').hide();
			$('.cancelBomb').hide();
			_this.parent('.control').append('<a href="javascript:;" class="bookAgain">再次预约</a>');
			_this.remove();

			$('.cancelTip').show();
			setTimeout(function(){
				$('.cancelTip').hide();
			},1100)
		})
	})
	//结束办公	
	$('body').on('click','.content .control .overOffic',function(){
		var _this = $(this);
		$('.shade').show();
		$('.overBomb').show();
		$('.overBomb .wait').unbind('click').click(function(){//再等会
			$('.shade').hide();
			$('.overBomb').hide();
		})
		$('.overBomb .remove').unbind('click').click(function(){//立即取消			
			_this.parent().siblings('.tit').find('.span2').text('待入店');
			$('.shade').hide();
			$('.overBomb').hide();
			_this.parent('.control').append('<a href="javascript:;" class="cancel">取消订单</a>');
			_this.remove();
			$('.overTip').show();
			setTimeout(function(){
				$('.overTip').hide();
			},1100)
		})
	})
})
