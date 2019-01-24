$(function(){
	//点击左边导航
	$('.main .left .message').click(function(){
		$(this).addClass('current').siblings().removeClass('current');
	})
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
})
