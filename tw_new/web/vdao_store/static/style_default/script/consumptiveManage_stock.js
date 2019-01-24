$(function(){
	
	//库存量变红
	stockRed();
	
	//点击显示修改预警值弹框
	$('body').on('click','.tableBox .row .edit',function(){	
		var id = $(this).attr("value");
		var _this = $(this);
		var oldText = $(this).parent().siblings('.warning').text();//原预警值
		$('.seatName .oldNum').text(oldText);
		$('.seatName').show();
		$('.seatName .inputBox .newNum').keydown(function(){
			$('.seatName .inputBox .red').hide();
		})
		//弹窗的确定按钮		
		$('.seatName .sureBox a').unbind('click').click(function(){			
			var newText = $('.seatName .inputBox .newNum').val();//修改后预警值
			console.log(newText);
			if(newText == ''){
				$('.seatName .inputBox .red').show();
			}else{				
				$.ajax({
					type : 'post',
					url  : 'consumable_uptate',
					data : {id:id,oute:newText},
					dataType : 'json',
					sueecss  : function(data) {

					}
				})
				$('.seatName .inputBox .red').hide();
				_this.parent().siblings('.warning').text(newText);
				$('.seatName').hide();			
				$('.seatName .inputBox .newNum').val('');
			}
		})
		//弹窗的取消按钮
		$('body').on('click','.seatName .close',function(){
			$('.seatName').hide();
			$('.seatName .newNum').val('');
			$('.seatName .inputBox .red').hide();
		})
	})
	
	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

})

	//库存量变红	
	function stockRed(){
		var rowLen = $('.tableBox .row').length;
		for(var i = 0; i < rowLen; i ++){
			var warningText = parseInt($('.tableBox .row:eq('+i+')').find('.warning').html())//预警值
			var stockText = parseInt($('.tableBox .row:eq('+i+')').find('.stock').html());//库存值			
			if(stockText < warningText){
				$('.tableBox .row:eq('+i+')').find('.stock').css('color','red');
			}else{
				$('.tableBox .row:eq('+i+')').find('.stock').css('color','#333333');
			}
		}
	}
	

