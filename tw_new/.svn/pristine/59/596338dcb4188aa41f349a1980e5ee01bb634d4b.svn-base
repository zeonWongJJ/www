$(function(){
	//点击一级导航
	$('body').on('click','.navList>ul>li:lt(2)>a',function(){
		$(this).parent().addClass('navCur').siblings().removeClass('navCur');
	})
	$('body').on('click','.navList>ul>li:gt(1)>a',function(){
		if($(this).find('.suo').hasClass('shen')){
			$(this).find('.suo').removeClass('shen');
			$(this).next('ul').slideUp();
		}else{
			$(this).find('.suo').addClass('shen');
			$(this).next('ul').slideDown();
		}
	})
	//点击二级导航
	$('body').on('click','.navList>ul>li>ul>li>a',function(){
		$('.navList>ul>li>ul>li').removeClass('twoCur');
		$(this).parent().addClass('twoCur');
		$(this).parent().parent().parent('li').addClass('navCur').siblings().removeClass('navCur');
	})
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
    // 当前所在位置
//  $('.navList a').each(function(index, el) {
//  	var thisurl = window.location.href;
//  	if ($(this).attr('href') == thisurl) {
//  		$(this).parent('li').addClass('navCur');
//  	}
//  });
    
    $('.navList>ul>li:lt(2)>a').each(function(index,el){
    	var thisurl = window.location.href;
    	if ($(this).attr('href') == thisurl) {
    		$(this).parent('li').addClass('navCur');
    	}
    })
    
    $('.navList>ul>li>ul>li>a').each(function(index,el){
    	var thisurl = window.location.href;
    	if ($(this).attr('href') == thisurl) {
    		$(this).parent().addClass('twoCur');
    		$(this).parent().parent().show();
    		$(this).parent().parent().parent().addClass('navCur');
    		$(this).parent().parent().parent().find('.suo').addClass('shen');
    	}
    })
    
})
