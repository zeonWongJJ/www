$(function(){
		
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
    
    // 点击全部状态显示下拉
	$('body').on('click','.optionBox .opTit',function(){
		//alert(0);
		$(this).toggleClass('down');
		$('.optionBox .stateSelect').toggle();
		$('.optionBox .zhe').toggle();
	})
	
	//点击空白下拉消失
	$('body').on('click',function(e){
    	var target = $(e.target);
    	if(target.closest('.optionBox .opTit').length == 0 && target.closest('.optionBox .stateSelect').length == 0 && target.closest('.optionBox .zhe').length == 0 ){
    		$('.optionBox .opTit').removeClass('down');
			$('.optionBox .stateSelect').hide();
			$('.optionBox .zhe').hide();
    	}
    })
	
	//选择下拉
	$('body').on('click','.optionBox .stateSelect a',function(){			
		var aText = $(this).text();
		$(this).parent().parent().siblings('.opTit').find('s').text(aText);
		$('.optionBox .stateSelect').hide();
		$('.optionBox .opTit').removeClass('down');
		$('.optionBox .zhe').hide();
	})

})

	

