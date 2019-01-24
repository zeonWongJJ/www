$(function(){
	//导航切换
	$('.rightNav li').click(function(){
		$(this).addClass('current').siblings().removeClass('current');
		var ind = $(this).index();
		if(ind == 1){
			$(this).children('a').css('border-left','1px solid #e8e8e8');
			$('.wrapBox .basicBox').hide();
			$('.wrapBox .accountBox').show();
		}else if(ind == 0){
			$('.wrapBox .basicBox').show();
			$('.wrapBox .accountBox').hide();
		}
	})

	// 显示原有的门店图片
	upload_update();

	//输入文字减少
	$('.traffic .txt').keydown(function(){
		var len = $(this).val().length;
		var num = 200 - len;
		$(this).siblings('.num').children('span:eq('+0+')').text(num);
		$(this).siblings('.num').children('span:eq('+0+')').css('color','red');
	})

	//显示地图弹框
	$('.mapLi .position').click(function(){
		$('.mapLi .mapBox').show();
	})
	//关闭
	$('.mapLi .mapBox .guan,.mapLi .mapBox .guanbi').click(function(){
		$('.mapLi .mapBox').hide();
	})
})


