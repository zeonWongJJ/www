$(function(){
	//点击切换导航
	$('body').on('click','.nav li a',function(){
		$(this).parent().addClass('current').siblings().removeClass('current');
		var type_id = $(this).attr('value');
		if (type_id == 'all') {
			$('.content .clearfix li').show();
			//动态获取UL的宽度
			var len = $('.content ul li').length;
			ulWidth = len*95;
			$('.content ul').css('width',''+ulWidth+'%');
		} else {
			var i = 0;
			$('.content .clearfix li').each(function(index, el) {
				if ($(this).attr('value') == type_id) {
					$(this).show();
					i++;
				} else {
					$(this).hide();
				}
			});
			ulWidth = i*95;
			$('.content ul').css('width',''+ulWidth+'%');
		}
	})
	//动态获取UL的宽度
	var len = $('.content ul li').length;
	//alert(len);
	ulWidth = len*95;
	$('.content ul').css('width',''+ulWidth+'%');
})
