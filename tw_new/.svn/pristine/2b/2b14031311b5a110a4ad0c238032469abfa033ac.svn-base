$(function(){
	//点击变颜色
	//门
	// clickFun('.door','doorCol');
	// //窗
	// clickFun('.window','windowCol');
	// //过
	// clickFun('.gangway','gangwayCol');
	// //座
	// //clickFun('.seat','seatCol');
	// //空
	// clickFun('.empty','emptyCol');

	// 刷新表格数据
	update_page();

	// 刷新格子id
	update_li();

	//增加列
	$('body').on('click','.controlBox .addColumn',function(){
		var rowLength = $('.table .row').length;
		//alert(rowLength);
		for(var i = 0; i < rowLength; i ++){
			$('.table .row:eq('+i+')').find('ul').append(
				'<li type="0" seatname="0">'
					+'<p class="wen"><span>空</span></p>'
					+'<p class="nameList">'
						+'<a href="javascript:;" class="door" onclick="set_door()">门</a>'
						+'<a href="javascript:;" class="window" onclick="set_window()">窗</a>'
						+'<a href="javascript:;" class="gangway" onclick="set_gangway()">过</a>'
						+'<a href="javascript:;" class="seat" onclick="set_seat()">座</a>'
						+'<a href="javascript:;" class="empty" onclick="set_empty()">空</a>'
					+'</p>'
				+'</li>'
			)
		}
		// 刷新表格数据
		update_page();
		// 刷新格子id
		update_li();
	})

	//增加行
	$('body').on('click','.controlBox .addRow',function(){
		var columnLength = $('.table .row:first-child').find('li').length;
		var content = '<div class="row"><ul>';
		for(var i = 0; i < columnLength; i ++){
			content+='<li type="0" seatname="0"><p class="wen"><span>空</span></p><p class="nameList">	<a href="javascript:;" class="door" onclick="set_door()">门</a><a href="javascript:;" class="window" onclick="set_window()">窗</a><a href="javascript:;" class="gangway" onclick="set_gangway()">过</a><a href="javascript:;" class="seat" onclick="set_seat()">座</a><a href="javascript:;" class="empty" onclick="set_empty()">空</a></p></li>'
		}
		content += '</ul></div>';
		$('.table').append(content);
		// 刷新表格数据
		update_page();
		// 刷新格子id
		update_li();
	})

	//减少行
	$('body').on('click','.controlBox .lessRow',function(){
		var rowLength = $('.table .row').length;
		if(rowLength > 2){
			$('.table .row:last-child').remove();
		}else{
			alert('不能再减少了');
		}
		// 刷新表格数据
		update_page();
		// 刷新格子id
		update_li();
	})

	//减少列
	$('body').on('click','.controlBox .lessColumn',function(){
		var columnLength = $('.table .row:first-child').find('li').length;
		var rowLength = $('.table .row').length;
		//alert(columnLength)
		if(columnLength > 2){
			for(var i = 0; i < rowLength; i ++){
				$('.table .row:eq('+i+') ul li:last-child').remove();
			}
		}else{
			alert('不能再减少了');
		}
		// 刷新表格数据
		update_page();
		// 刷新格子id
		update_li();
	})

	//点击座显示添加座位名称弹框
	// $('body').on('click','.row .nameList .seat',function(){
	// 	var _this = $(this);
	// 	if(_this.parent().parent().hasClass('seatCol')){
	// 		//alert(0);
	// 		_this.parent().parent().removeClass('seatCol');
	// 		_this.parent().siblings('.wen').find('span').text('空');

	// 	}else{
	// 		$('.seatName').show();
	// 		//添加座位名称弹框确定按钮
	// 		$('body').on('click','.seatName .sureBox a',function(){
	// 			var val = $('.seatName .inputBox .int').val();
	// 			alert(val);
	// 			if(val == ''){
	// 				$('.seatName .inputBox .red').show();
	// 			}else{
	// 				$('.seatName .inputBox .red').hide();
	// 				$('.seatName').hide();
	// 				$('.seatName .inputBox .int').val('');
	// 				_this.parent().siblings('.wen').find('span').text(val);
	// 				_this.parent().parent().addClass('seatCol');
	// 				_this.parent().parent().removeClass('doorCol windowCol gangwayCol emptyCol')
	// 			}
	// 		})
	// 		//添加座位名称弹框的关闭按钮
	// 		$('.seatName .close').click(function(){
	// 			$('.seatName').hide();
	// 		})
	// 	}
	// })

	//点击保存后预览
	$('body').on('click','.rightDown .controlBox .preview',function(){

		var row_lehgth = $('.table .row').length;
		var col_length = $('.table .row:first-child').find('li').length;
		var seat_arr = new Array();
		var i = 0;
		$('#mainbox .row li').each(function(index, el) {
			seat_arr[i] = $(this).attr('type');
			i++;
		});
		var append_content = '';
		var m = 0;
		for (var i=0; i<row_lehgth; i++) {
			append_content += '<div class="row"><ul>';
			for(var j=0; j<col_length; j++) {
				if (seat_arr[m] == 0) {
					append_content += '<li></li>';
				} else if (seat_arr[m] == 1) {
					append_content += '<li class="doorPic"></li>';
				} else if (seat_arr[m] == 2) {
					append_content += '<li class="windowPic"></li>';
				} else if (seat_arr[m] == 3) {
					append_content += '<li class="gangwayPic">过道</li>';
				} else if (seat_arr[m] == 4) {
					append_content += '<li class="seatPic"></li>';
				}
				m++;
			}
			append_content += '</ul></div>';
		}
		$(".previewBox .tableBox").html(append_content);

		$('.previewBox').show();
		//增加预览图的行
		//var columnLength = $('.table .row:first-child').find('li').length;
//		var rowLength = $('.table .row').length;
//		alert(rowLength);
//		if(rowLength>7){
//			for(i = 6; i < rowLength - 1; i ++){
//				$('.previewBox .tableBox .row:eq('+i+')').append(
//					'<div class="row">'
//      				+'<ul>'
//      					+'<li>1</li>'
//      					+'<li>2</li>'
//      					+'<li>3</li>'
//      					+'<li>4</li>'
//      					+'<li>5</li>'
//      					+'<li>6</li>'
//      					+'<li>7</li>'
//      					+'<li>8</li>'
//      				+'</ul>'
//      			+'</div>'
//				);
//			}
//		}else if(rowLength < 7 && rowLength == 7){
//			$('.previewBox .tableBox .row:gt(6)').remove();
//		}

		//预览图自适应高
		var rowLength = $('.table .row').length;
		//alert(rowLength);
		var newLen = rowLength - 7;
		if(rowLength > 7){
			var tableHen = rowLength * 32 + 2;
			var previewHen = newLen * 32 + 340;
			var marginTop = -(previewHen/2);
			$('.previewBox .tableBox').css({'height':''+tableHen+'px'});
			$('.previewBox').css({'height':''+previewHen+'px','margin-top':''+marginTop+'px'});
		}else if(rowLength < 7 || rowLength == 7){
			//alert(0);
			$('.previewBox .tableBox').css({'height':'226px'});
			$('.previewBox').css({'height':'340px','margin-top':'-170px'});
		}

		//预览图自适应宽
		var columnLength = $('.table .row:first-child').find('li').length;
		//alert(columnLength);
		var newCol = columnLength - 7;
		if(columnLength > 7){
			var tableWid = (columnLength + 1) * 37 + 2;
			var previewWid = newCol * 37 + 440;
			var marginLeft = -(previewWid/2);
			$('.previewBox .tableBox').css({'width':''+tableWid+'px'});
			$('.previewBox').css({'width':''+previewWid+'px','margin-left':''+marginLeft+'px'});
		}else if(columnLength < 7 || columnLength == 7){
			//alert(0);
			$('.previewBox .tableBox').css({'width':'298px'});
			$('.previewBox').css({'width':'440px','margin-left':'-220px'});
		}

	})
	//关闭预览图
	$('body').on('click','.previewBox .close',function(){
		$('.previewBox').hide();
	})

})

//点击变颜色
function clickFun (par1,par2){
	$('body').on('click','.row .nameList '+par1+'',function(){
		var className= $(this).attr('class');
		//alert(className);
		if(className == 'door'){
			$(this).parent().parent().removeClass('windowCol gangwayCol emptyCol seatCol')
			$(this).parent().parent().toggleClass(''+par2+'');
		}else if(className == 'window'){
			$(this).parent().parent().removeClass('doorCol gangwayCol emptyCol seatCol')
			$(this).parent().parent().toggleClass(''+par2+'');
		}else if(className == 'gangway'){
			$(this).parent().parent().removeClass('doorCol windowCol emptyCol seatCol')
			$(this).parent().parent().toggleClass(''+par2+'');
		}else if(className == 'empty'){
			$(this).parent().parent().removeClass('doorCol windowCol gangwayCol seatCol')
			$(this).parent().parent().toggleClass(''+par2+'');
		}

	})
}
