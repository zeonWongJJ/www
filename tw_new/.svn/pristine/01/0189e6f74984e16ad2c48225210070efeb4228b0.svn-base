$(function(){
	//暂停启用切换
	// $('body').on('click','.tableBox .open,.tableBox .close',function(){
	// 	if($(this).hasClass('open')){
	// 		$(this).removeClass('open').addClass('close');
	// 	}else if($(this).hasClass('close')){
	// 		$(this).removeClass('close').addClass('open');
	// 	}
	// })
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
	})

	//点击上面的全选
	allCheck('.tableBox .thead .gapCheck','.controlBox .gapCheck');

	//点击下面的全选
	allCheck('.controlBox .gapCheck','.tableBox .thead .gapCheck');

	//勾选男女
	$('body').on('click','.formBox .sexItn',function(){
		if($(this).attr("checked")){
			if($(this).next('.pattern').html()=='是'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_36.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_38.png)');
			}else if($(this).next('.pattern').html()=='否'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_38.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_36.png)');
			}
		}
	})

	//勾选角色权限
	$('body').on('click','.rRight a',function(){
		//$(this).toggleClass('gou');
		group_auth_all();
		if($(this).hasClass('gou')){
			$(this).removeClass('gou');
			var gouLen = $('.rRight a.gou').length;
			if(gouLen == 0){
				$(this).closest('.roleWrap').siblings('.red').show();
				$(this).closest('.roleWrap').siblings('.green').hide();
			}
		}else{
			$(this).addClass('gou');
			$(this).closest('.roleWrap').siblings('.red').hide();
			$(this).closest('.roleWrap').siblings('.green').show();
		}
	})

	function group_auth_all() {
	    var role_auth = new Array();
	    var i = 0;
	    // 组装权限ids
	    $('.rRight .gou').each(function(index, el) {
	        role_auth[i] = $(this).attr('value');
	        i++;
	    });
	    role_auth = role_auth.join('-')
	    $("input[name='group_auth']").val(role_auth);
	}

	//打开编辑角色弹框
	 // $('body').on('click','.tableBox a.edit',function(){
	 // 	$('.shade').show();
	 // 	$('.editBomb').show();
	 // 	$('.editBomb .h2 .title').text('编辑角色');
	 // })

	 //关闭编辑弹框
	 $('body').on('click','.editBomb .close',function(){
	 	// $('.deleSingle').show();
	 	// $('.deleSingle .p2 span').text('确定要退出吗');
	 	// $('.deleSingle .p3 span').text('已编辑的内容将不做保存');
	 	// $('.deleSingle .btnBox .sure').click(function(){
	 		// $('.deleSingle').hide();
	 		$('.shade').hide();
	 		$('.editBomb').hide();
	 	// })
	 	// $('.deleSingle .btnBox .think').click(function(){
	 	// 	$('.deleSingle').hide();
	 	// })
	 })

	 //打开添加角色弹框
	 $('body').on('click','.addBox a',function(){
	 	$('.shade').show();
	 	$('.editBomb').show();
	 	$('.editBomb .h2 .title').text('添加角色');
	 })

	 // //单个删除
	 // $('body').on('click','.tableBox .row .delete',function(){
	 // 	var _this = $(this);
	 // 	$('.deleSingle').show();
	 // 	$('.deleSingle .p2 span').text('确定要删除此角色吗');
	 // 	$('.deleSingle .p3 span').text('删除后不可恢复，删除后,此角色下的管理员账号将被停用 ');
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

	 // 批量删除
	 // $('.controlBox .deleBtn').click(function(){
	 // 	//alert(0);
	 // 	$('.batchDel').show();
	 // 	$('.batchDel .p2 span').text('确定要删除此部分角色吗');
	 // 	$('.batchDel .p3 span').text('删除后不可恢复，删除后,此角色下的管理员账号将被停用 ');
	 // 	//确定按钮
	 // 	$('.batchDel .btnBox .sure').click(function(){
	 // 		var greenLength = $('.tableBox .row .greenCheck').length;
	 // 		//var greenId = [];
	 // 		for(var i = 0; i < greenLength; i ++){
	 // 			var pushId = $('.tableBox .row .greenCheck:eq('+i+')').parent().parent().attr('id');
	 // 			greenId.push(pushId);
	 // 			$('.tableBox .row .greenCheck:eq('+i+')').parent().parent().remove();
	 // 		}
	 // 		alert(greenLength);
	 // 		$.ajax({
	 // 			type:"post",
	 // 			url:"",
	 // 			dataType:"json",
	 // 			data:{greenId:greenId},
	 // 			success:function(){
	 // 				for(var i = 0; i < greenLength; i ++){
		// 	 			$('.tableBox .row .greenCheck:eq('+i+')').parent().parent().attr('id');

		// 	 		}
	 // 			}
	 // 		});
	 // 	})
	 // })

	 //表单验证
	//角色名称
	$('.roleInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		htmlText = 20 - parseInt(val.length);
	 		$(this).siblings('.green').find('i').html(htmlText);
	 		$(this).data({'s':1});
	 	}
	 })
	//性别选择
	$('.sexItn').click(function(){
		$(this).parent().parent('.right').find ('.green').show();
		$(this).parent().parent('.right').find ('.red').hide();
		$("input[name='group_state']").val($(this).val());
	})
	//角色描述
	$('.txt').click(function(){
		roleFun();
	})
	 $('.txt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 	}
	 })

	 //点击确定按钮
	 $('.sureBox a').click(function(){
	 	//角色名称
	 	$('.roleInt').blur();
	 	//性别选择
	 	roleFun();
	 	//角色描述
	 	$('.txt').blur();
	 	//所属角色
	 	var tot = 0;
	 	$('.roleList .rRight').each(function(){
	 		var len = $(this).find('a.gou').length;
			if(len>0){
				tot+=1;
			}
	 	})
	 	var rLength = $('.roleList .rRight').length;
	 	if(tot < rLength){
	 		$('.choiceRole .right .red').show();
	 		$('.choiceRole .right .green').hide();
	 	}else if(tot == rLength){
	 		$('.choiceRole .right .green').show();
	 		$('.choiceRole .right .red').hide();
	 		$('#groupadd_form').submit();
	 	}
	 })
})

//角色判断
 function roleFun (){
 	sexLength = $('.sexItn:checked').length;
	if(sexLength == 0){
		$('.sex .red').show();
		$('.sex .green').hide();
	}
 }

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
