<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>会员注册</title>
		<link rel="stylesheet" type="text/css" href="static/style_default/style/common.css"/>
		<script src="static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.box{background: #fff;height: 100%;font-size: .16rem;text-align: center;display: flex;flex-direction: column;justify-content: center;align-items: center;}
			.box .logo{width: 1.165rem;height: 1.165rem;}
			.bog .logo img{width: 100%;height: auto;}
			.box input{font-size: .16rem;}
			.tel,.password{border: 1px solid #cbcbcb;width: 3.1rem;height: .45rem;padding: 0 .1rem;border-radius: .225rem;margin: .2rem auto;}
			.verifyCode{border: 1px solid #cbcbcb;width: 3.1rem;height: .45rem;margin: .2rem auto;border-radius: .225rem;position: relative;}
			.verifyCode>input{height: 100%;width: 100%;border-radius: .225rem;padding: 0 .1rem;}
			.verifyCode>.getCode{position: absolute;height: 100%;width: 1rem;color: #ff6633;font-size: .12rem; right: 0;top: 0;border-radius:0 .225rem .225rem 0;text-align: center;line-height: .45rem;}
			.verifyCode>.getCode.click{color: #888888;}
			.submit{background: #ff6633; width: 3.1rem;height: .45rem;padding: 0 .1rem;border-radius: .225rem;margin: .2rem;color: #fff;}
			.tips{ width:100%; position:absolute; top:50%; left:0rem; text-align:center; padding:0.15rem 0; font-size:0.14rem; background:#303030; color:white; border-radius:0rem; display:none; z-index:3; }
		</style>
	</head>
	<body>
		<div class="box">
			<div class="logo">
				<img src="./static/style_default/images/logo.png" alt="">
			</div>
			<form id="regform" action="" method="post">
				<input class="tel"  type="text" name="user_name" placeholder="请输入手机号">
				<div class="verifyCode">
					<input type="text" name="user_code" placeholder="请输入验证码">
					<div class="getCode" onclick="getCode()">获取验证码</div>
				</div>
				 <input type="hidden" value="3" name="reg_type">
				<input class="password" type="password" name="user_password" placeholder="密码是8-20位数字和字母组合">
				<input type="hidden" name="user_referee" value="<?php echo $a_view_data['user_id']?>">
				<input class="submit" type="button" id="register_sub" value="注册"/>
			</form>
		</div>
		 <div class="tips"></div>
	</body>

	<script type="text/javascript">

		    //注册
    var registerInit={
        //name:false,
        phone:false,
        code:false,
        pwd:false,
        //rePwd:false,
        phoneHave:false,
      
    };
       var registerReg={
        //name:/^\w{3,15}$/,
        //name:/[\u4e00-\u9fa5_a-zA-Z0-9_]{3,10}/,//至少三位(可以包含中英文数字)
        phone:/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/,//手机号
        pwd:/^[a-zA-Z0-9]{6,15}$///必须且只含有数字和字母，6-15位
    };
		payTime = true;
		var interval = null;
		function getCode(type){
			if(payTime && type){
				$('.getCode').addClass('click')
				timer(parseInt(59));
			}

		}
		function timer(intDiff){
			interval = window.setInterval(function(){
			var day=0,
				hour=0,
				minute=0,
				second=0;//时间默认值        
			if(intDiff > 0){
				day = Math.floor(intDiff / (60 * 60 * 24));
				hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
				minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
				second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
			}
			
			if(second == 0){
				payTime = true;
				$('.getCode').html('重新获取验证码').removeClass('click');
				window.clearInterval(interval)
			}else{
				if (minute <= 9) minute = '0' + minute;
				if (second <= 9) second = '0' + second;
			//     $('#day_show').html(day+"天");
			//     $('#hour_show').html('<s id="h"></s>'+hour+'时');
				// $('#minute_show').html('<s></s>'+minute+'分');
				$('.getCode.click').html(second+'秒');
			}
			
			intDiff--;
			
			}, 1000);
			payTime = !payTime
		}


	 $("input[name='user_name']").blur(function(){
        var val=$(this).val();
        if( registerReg.phone.test(val) ){
            // 发送ajax请求验证用户名是否被占用
            $.ajax({
                url: 'register_check',
                type: 'POST',
                dataType: 'json',
                data: {nameOrphone: val, type: 1},
                success: function (res) {
                    if (res.code == 200) {
                        $(".tips").html("该手机号已经存在，请更换");
                        $(".tips").stop().show(100).delay(2000).hide(250);
                        registerInit.phone=false;
                         registerInit.phoneHave = true;
                    } else {
                    	
                        registerInit.phone=true;
                    }
                }
            })
        }else{
            $(".tips").html("手机号码格式错误！");
           $(".tips").stop().show(100).delay(2000).hide(100);
           
            registerInit.phone=false;
        }
    });

  $(".getCode").click(function(){
         var phone=$("input[name='user_name']").val();
        if(registerInit.phone) {
                getCode( registerInit.phone);
                if( registerReg.phone.test(phone) ){
                    // ajax发送验证码请求
                    $.ajax({
                        url: 'send_code',
                        type: 'POST',
                        dataType: 'json',
                        data: {user_phone: phone},
                        success: function(res) {
                        }
                    })
                }else{
                    $(".tips").stop().show(100).delay(2000).hide(100);
                   
                    	$(".tips").html("手机号码格式错误！");
                    registerInit.phone=false;
                }
            }else{
                  if(!registerInit.phoneHave){
                    	$(".tips").html("手机号码格式错误！");
                    }else{
                    	$(".tips").html("该手机号已经存在，请更换!");
                    }
            }
    }); 

      //提交注册
    $("#register_sub").click(function() {
        // userPwd();
        // console.log($("#regform").serialize());return;
      $.post('register',$("#regform").serialize(),function(res)
        {       
                if (res.status ==1) {
               	 $(".tips").html("注册成功！");
                $(".tips").stop().show(100).delay(5000).hide(100);
                
                 window.location.href="nuser_center" ;    

                }else{
                $(".tips").stop().show(100).delay(2000).hide(100);
                $(".tips").html(res.msg);                          
                }

        },'json');
    });

        function userPwd(){
        var val=$("input[name='user_password']").val();
        if( registerReg.pwd.test(val) ){
            registerInit.pwd=true;
        }else{
            $(".tips").stop().show(100).delay(2000).hide(100);
            $(".tips").html("密码格式错误！");
            registerInit.pwd=false;
        }
     
    }  
	</script>
</html>
