$(function(){
	
    
	//暂停启用切换
	$('body').on('click','.tableBox .open,.tableBox .close',function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open').addClass('close')
		}else if($(this).hasClass('close')){
			$(this).removeClass('close').addClass('open')
		}
	})
	//鼠标经过显示灰勾
	$('.tableBox .gapCheck').hover(function(){
		$(this).addClass('grayCheck');
	},function(){
		$(this).removeClass('grayCheck');
	})

	$('.controlBox .gapCheck').hover(function(){
		$(this).addClass('grayCheck');
	},function(){
		$(this).removeClass('grayCheck');
	})

	//单击选择取消
	$('body').on('click','.tableBox .row .gapCheck',function(){
		if($(this).hasClass('greenCheck')){
			$(this).removeClass('greenCheck');
			$('.tableBox .thead .gapCheck').removeClass('greenCheck');
			$('.controlBox .gapCheck').removeClass('greenCheck');
		}else{
			var tot = 0;
			$(this).addClass('greenCheck');
			$('.tableBox .row .gapCheck').each(function(){
				if($(this).hasClass('greenCheck')){
					tot+=1;
				}
			})
			var rowLength = $('.row .gapCheck').length;
			if(tot==rowLength){
				$('.tableBox .thead .gapCheck').addClass('greenCheck');
			    $('.controlBox .gapCheck').addClass('greenCheck');
			}
		}
	});
	
	

	//点击上面的全选
	allCheck('.tableBox .thead .gapCheck','.controlBox .gapCheck');

	//点击下面的全选
	allCheck('.controlBox .gapCheck','.tableBox .thead .gapCheck');

	//单个删除
	 // $('body').on('click','.tableBox .row .delete',function(){
	 // 	var _this = $(this);
	 // 	$('.deleSingle').show();
	 // 	$('.deleSingle .p2 span').text('确定要删除此房间吗');
	 // 	$('.deleSingle .p3 span').text('删除后不可恢复');
	 // 	// 确定按钮
	 // 	$('.deleSingle .btnBox .sure').click(function(){
	 // 		var removeId = _this.parent().parent().attr('id');
	 // 		$.ajax({
	 // 			type:"post",
	 // 			url:"",
	 // 			dataType:"json",
	 // 			data:{removeId:removeId},
	 // 			success:function(){
	 // 				$('.deleSingle').hide();
	 // 				_this.parent().parent().remove();
	 // 			}
	 // 		});
	 // 	})
	 // 	//取消按钮
	 // 	$('.deleSingle .btnBox .think').click(function(){
	 // 		$('.deleSingle').hide();
	 // 	})
	 // })
})

// 点击上下的全选
 function allCheck (par1,par2){
 	$('body').on('click',''+par1+'',function(){
		if($(this).hasClass('greenCheck')){
			$(this).removeClass('greenCheck');
			$('.tableBox .row .gapCheck').removeClass('greenCheck');
		    $(''+par2+'').removeClass('greenCheck');
		}else{
			$(this).addClass('greenCheck');
			$('.tableBox .row .gapCheck').addClass('greenCheck');
		    $(''+par2+'').addClass('greenCheck');
		}
	})
 }