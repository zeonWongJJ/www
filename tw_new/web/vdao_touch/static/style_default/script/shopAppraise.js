$(function(){
	//选择评价类型
	$('body').on('click','.tagBox li a',function(){
		var liIndex = $(this).parent().index();
		if(liIndex == 0){
			$(this).parent().addClass('allClick').siblings().removeClass('otherClick');
		}else{
			$(this).parent().addClass('otherClick').siblings().removeClass('otherClick');
			$('.tagBox li:eq(0)').removeClass('allClick');
		}
	})
	//导航切换
	$('.tagBox .nav a').click(function(){
		$(this).addClass('current').siblings().removeClass('current');
	})
})
