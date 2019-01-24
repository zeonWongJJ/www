$(function(){
	//1.一键注册
		//点击一键注册
		// $('.onekey_02_btn').click(function(){
		// 	$('#succeed').css('display','block').siblings().css('display','none')
		// })
		//点击个性注册
		$('.onekey_02_float i').click(function(){
			$('#personality').css('display','block').siblings().css('display','none')
		})
		//点击已有账号
		$('.onekey_01').click(function(){
			$('#test').css('display','block').siblings().css('display','none')
		})
		
	//2.注册成功
		//点击发送到手机
// 		$('.success_btn span').click(function(){
// 			$('#cell_phone').css('display','block').siblings().css('display','none')
			
// //			$('#cell_phone input').eq(0).focus();
			
// 		})
		//点击自动登录
// 		$('.Login').click(function(){
// 			console.log('登录成功');
// //			$('.onekey_02').submit();
// 		})
		
	//3.手机号码
		//点击确定发送
		// $('.phone_02').click(function(){
		// 	var oInp=$('#newly').val();
		// 	if(oInp==''){
		// 		alert('手机号不能为空');
		// 	}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(oInp)){
		// 		alert('手机格式不对');
		// 	}
			
		// 	$('#kindly_reminder').css('display','block').siblings().css('display','none')
		// })
		//点击删除
		$('.phone_01_float img').click(function(){
			$('#succeed').css('display','block').siblings().css('display','none')
		})
		
	//4.温馨提示
		//点击密码登录
		$('.Login_01').click(function(){
			$('#cryptogram').css('display','block').siblings().css('display','none')
		})
		//点击重新申请
		$('.ask_for').click(function(){
			$('#personality').css('display','block').siblings().css('display','none')
		})
		
	//5.个性注册
		//添加手机号和邮箱
		$('.kidney_register_add').click(function(){
			$('.add_most').show();
			$(this).hide();
		})
		$('.add_most p').click(function(){
			$('.add_most').hide();
			$('.kidney_register_add').show();
		})
		//点击取消
		$('.cancle').click(function(){
			$('#cryptogram').css('display','block').siblings().css('display','none')
		})
		//点击注册
		$('.Login_02').click(function(){
			var user=$('#user').val();
			var pw=$('#pw').val();
			var phone=$('#phone').val();
			var email=$('#email').val();
			//用户名/账号验证
			if(user==''){
				alert('用户名不能为空');
			}else if(/^[\u4e00-\u9fa5]|[a-zA-Z0-9]{4,18}$/.test(user)){
				console.log('用户名/账号输入正确');
			}
			//密码验证
			if(pw==''){
				console.log('密码不能为空');
			}else if(!/^[A-Z]|[a-z]|[0-9]|[~!@#$%^&*?]{6,16}$/.test(pw)){
				console.log('密码输入不正确');
			}
			//手机验证
			if(phone==''){
//				console.log('手机可不填');
			}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(phone)){
				console.log('手机格式不对');
			}
			//邮箱验证
			if(email==''){
//				console.log('邮箱可不填');
			}else if(!/^\w+@[a-z0-9]+(\.[a-z]+){1,3}$/.test(email)){
				console.log('邮箱格式不对');
			}
//			console.log('注册成功');
		})
		//点击一键注册
		$('.kidney i').click(function(){
			$('#registration').css('display','block').siblings().css('display','none')
		})
		
	//6.验证码登录
		//号码验证
		function tell(){
			var btn1=$('#btn1').val();
			if(btn1==''){
				alert('请输入手机号码');
			}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(btn1)){
				alert('手机号码格式不对');
			}
		}
		//点击获取验证码
		var validCode=true;
		$("#btn3").click (function  () {
			tell();
			var btn1=$('#btn1').val();
			if(btn1&&/^1[3|4|5|8][0-9]\d{8}$/.test(btn1)){
		        var time=60;
		        var code=$(this);
		        if (validCode) {
		            validCode=false;
//	                code.addClass("btn3");
			        var t=setInterval(function  () {
		                time--;
		                code.html(time+"S");
		                $('#btn1').attr('disabled',true);
		               
		                if (time==0) {
		                	clearInterval(t);
		                	code.html("获取验证码");
		                    validCode=true;
		                    $('#btn1').removeAttr('disabled');
//		                	code.removeClass("btn3");
		                }
			        },1000)
		        }
		        $.ajax({
		            type : "POST",
		            data : "mobile="+btn1,
		            url : 'verify.html',
				})
			}  
		})
		
		//点击密码登录
		$('.identifying_01_float i').click(function(){
			$('#cryptogram').css('display','block').siblings().css('display','none')
		})
		// //点击登录
		// $('.Login_03').click(function(){
		// 	var btn2=$('#btn2').val();
		// 	tell();
		// 	if(!btn2){
		// 		console.log('请输入验证码');
		// 	}else if(!/^[0-9]{4}$/.test(btn2)){
		// 		console.log('验证码格式不对');
		// 	}
		// })
	
	//7.密码登录
		//点击忘记密码
		$('.identifying_01_forget').click(function(){
			$('#resetting').css('display','block').siblings().css('display','none')
		})
		//点击注册账号
		$('.identifying_02').click(function(){
			$('#registration').css('display','block').siblings().css('display','none')
		})
		// //点击登录
		// $('.Login_04').click(function(){
		// 	var btn4=$('#btn4').val();
		// 	var pw=$('#btn5').val();
		// 	if(btn4==''){
		// 		alert('请输入手机号码');
		// 	}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(btn4)){
		// 		alert('手机号码格式不对');
		// 	}
		// 	if(pw==''){
		// 		console.log('密码不能为空');
		// 	}
		
		// })
		$(".s2").click(function(){
			$("#sub").submit();
			console.log("sss")
		})
		//点击验证码登录
		$('.verify').click(function(){
			$('#test').css('display','block').siblings().css('display','none')
		})
		//点击下拉框
		$('.oImage').toggle(function(){
			$('.xiala').show();
			$(this).attr('src','image/shang_03.jpg');
		},function(){
			$('.xiala').hide();
			$(this).attr('src','image/xiala_03.jpg');
		})
		
		
	//8.重置密码
		//点击取消
		$('.cancle').click(function(){
			$('#cryptogram').css('display','block').siblings().css('display','none')
		})
		//点击获取验证码
		$('#spot_02').click(function(){
			var sp=$('#spot').val();
			if(sp==''){
				alert('请输入手机号码');
			}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(sp)){
				alert('手机号码格式不对');
			}
			if(sp&&/^1[3|4|5|8][0-9]\d{8}$/.test(sp)){
			   	var time=60;
		        var code=$(this);
		        if (validCode) {
		            validCode=false;
//	                code.addClass("btn3");
			        var t=setInterval(function  () {
		                time--;
		                code.html(time+"S");
		                $('#spot').attr('disabled',true);
		               
		                if (time==0) {
		                	clearInterval(t);
		                	code.html("获取验证码");
		                    validCode=true;
		                    $('#spot').removeAttr('disabled');
//		                	code.removeClass("btn3");
		                }
			        },1000)
		        }
	         	$.ajax({
		            type : "POST",
		            data : "mobile="+sp,
		            url : 'verify.html',
				})
			}
		})
		//点击登录
		$('.Login_05').click(function(){
			var sp=$('#spot').val();
			var sp1=$('#spot_01').val();
			var sp3=$('#spot_03').val();
			if(sp==''){
				alert('请输入手机号码');
			}else if(!/^1[3|4|5|8][0-9]\d{8}$/.test(sp)){
				alert('手机号码格式不对');
			}
			if(!sp1){
				console.log('请输入验证码');
			}else if(!/^[0-9]{4}$/.test(sp1)){
				console.log('验证码格式不对');
			}
			if(!sp3){
				console.log('请输入新密码');
			}
		})
	
	//9.QQ登录方式
		$('.Login_ways_image img').click(function(){
			alert('QQ登录');
		})
	
})
