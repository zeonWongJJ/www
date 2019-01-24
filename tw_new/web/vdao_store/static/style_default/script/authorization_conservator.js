$(function(){
	//暂停启用切换
	// $('body').on('click','.tableBox .open,.tableBox .close',function(){
	// 	if($(this).hasClass('open')){
	// 		$(this).removeClass('open').addClass('close')
	// 	}else if($(this).hasClass('close')){
	// 		$(this).removeClass('close').addClass('open')
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

	// 勾选男女
	$('body').on('click','.formBox .sexItn',function(){
		if($(this).attr("checked")){
			if($(this).next('.pattern').html()=='男'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_36.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_38.png)');
			}else if($(this).next('.pattern').html()=='女'){
				$('.ding1').css('background-image','url(/static/style_default/images/pro_38.png)');
				$('.ding2').css('background-image','url(/static/style_default/images/pro_36.png)');
			}
		}
	})

	//勾选角色权限
	$('body').on('click','.role a',function(){
		$(this).addClass('gou').siblings().removeClass('gou');
	})

	//打开编辑角色弹框
	 // $('body').on('click','.tableBox a.edit',function(){
	 // 	$('.shade').show();
	 // 	$('.editBomb').show();
	 // 	$('.editBomb .h2 .title').text('编辑管理员账号');
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

	 // //打开添加角色弹框
	 $('body').on('click','.addBox a',function(){
	 	$('.shade').show();
	 	$('.editBomb').show();
	 	$('.editBomb .h2 .title').text('添加管理员账号');
	 })

	 //单个删除
	 // $('body').on('click','.tableBox .row .delete',function(){
	 // 	var _this = $(this);
	 // 	$('.deleSingle').show();
	 // 	$('.deleSingle .p2 span').text('确定要删除此角色吗');
	 // 	$('.deleSingle .p3 span').text('删除后不可恢复，删除后,此角色下的管理员账号将被停用 ');
	 // 	// 确定按钮
	 // 	$('.deleSingle .btnBox .sure').click(function(){
	 // 		var removeId = _this.parent().parent().attr('id');
	 // 		$.ajax({
	 // 			type:"",
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

	 //表单验证
	 // 账户名
	 $('.accountInt').blur(function(){
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
	// 姓名
	$('.nameInt').blur(function(){
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
		$("input[name='manager_sex']").val($(this).attr('value'));
	})

	// 手机号码
	$('.phoneInt').click(function(){
		sexLength = $('.sexItn:checked').length;
		if(sexLength == 0){
			$('.sex .red').show();
			$('.sex .green').hide();
			$('.sexItn').data({'s':0})
		}
	})
	$('.phoneInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red1').show();
	 		$(this).siblings('.red2').hide();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else if(!(/^1[34578]\d{9}$/.test(val))){
	 		$(this).siblings('.green').hide();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//  邮箱
	$('.email').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red1').show();
	 		$(this).siblings('.red2').hide();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else if(!(/^\w+@\w+\.\w+$/.test(val))){
	 		$(this).siblings('.green').hide();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//密码
	$('.passInt').blur(function(){
	 	val = $(this).val();
	 	if(val==''){
	 		$(this).siblings('.red').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//确认密码
	$('.againInt').blur(function(){
	 	val = $(this).val();
	 	passVal = $('.passInt').val();
	 	if(val==''){
	 		$(this).siblings('.red1').show();
	 		$(this).siblings('.red2').hide();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else if(val!=passVal){
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').show();
	 		$(this).siblings('.green').hide();
	 		$(this).data({'s':0});
	 	}else{
	 		$(this).siblings('.green').show();
	 		$(this).siblings('.red1').hide();
	 		$(this).siblings('.red2').hide();
	 		$(this).data({'s':1});
	 	}
	 })
	//所属角色
	$('.roleRight .role a').click(function(){
		$('.roleRight .green').show();
		$('.roleRight .red').hide();
		$(this).data({'s':1});
		$("input[name='group_id']").val($(this).attr('value'));
		//$(this).siblings().data({'s':0});
	})
	//点击确定按钮
	$('.sureBox a').click(function(){
		var tot = 0;
		// 账号聚焦
		$('.accountInt').blur();
		//姓名聚焦
		$('.nameInt').blur();
		//性别
		sexLength = $('.sexItn:checked').length;
		if(sexLength == 0){
			$('.sex .red').show();
			$('.sex .green').hide();
		}else{
			tot+=1;
		}
		//手机号码
		$('.phoneInt').blur();
		//邮箱
		$('.email').blur();
		//密码
		 $('.passInt').blur();
		//确认密码
		$('.againInt').blur();
		//所属角色
		roleLength = $('.roleRight .role a.gou').length;
		if(roleLength == 0){
			$('.roleRight .red').show();
		}else{
			tot+=1;
		}
		//计算data
		$('.total').each(function(){
			tot+=$(this).data('s');
		})
		if(tot==8){
			$('#add_form').submit();
		}
	})
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
