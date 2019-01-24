$(function(){
	
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
    
	// 点击全部状态显示下拉
	$('body').on('click','.tableBox .thead .staTitle',function(){
		//alert(0);
		$(this).parent().toggleClass('down');
		$('.tableBox .state .stateSelect').toggle();
		$('.tableBox .state .zhe').toggle();
	})
	
	//点击空白下拉消失
	$('body').on('click',function(e){
    	var target = $(e.target);
    	if(target.closest('.tableBox .thead .staTitle').length == 0 && target.closest('.tableBox .state .stateSelect').length == 0 && target.closest('.tableBox .state .zhe').length == 0 ){
    		$('.tableBox .state').removeClass('down');
			$('.tableBox .state .stateSelect').hide();
			$('.tableBox .state .zhe').hide();
    	}
    })
	
	//选择下拉
	$('body').on('click','.tableBox .state .stateSelect a',function(){			
		var aText = $(this).text();
		$(this).parent().parent().siblings('.staTitle').find('s').text(aText);
		$('.tableBox .state .stateSelect').hide();
		$('.tableBox .state').removeClass('down');
		$('.tableBox .state .zhe').hide();
	})
	
	//查看已拒绝显示弹框
	//openBomb('.tableBox .refLook','.refuseBomb');
	//关闭
	closeBomb('.refuseBomb .close','.refuseBomb');
	
	//查看已通过显示弹框
	//openBomb('.tableBox .look','.passBomb');
	//关闭
	closeBomb('.passBomb .close','.passBomb');
	
	//打开取消耗材弹框
	// openBomb('.tableBox .cancel','.cancelBomb');
	//关闭
	closeBomb('.cancelBomb .think','.cancelBomb');
	
	//隔行显示表格颜色
	colorFun();
})

//显示弹框
function  openBomb (par1,par2){
	$('body').on('click',''+par1+'',function(){
		$(''+par2+'').show();
	})
}
//关闭弹框
function  closeBomb (par1,par2){
	$(''+par1+'').click(function(){
		$(''+par2+'').hide();
	})
}

//隔行显示表格颜色
function colorFun(){
	$('.tableBox span.material i:even').css('background','#f6f9fa');
	$('.tableBox span.number i:even').css('background','#f6f9fa');
}

	
	

