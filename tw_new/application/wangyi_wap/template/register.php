<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1″ />
        <meta http-equiv="Cache-Control" content="max-age=7200" />
        <title></title>
        <link rel="stylesheet" href="style/style.css">
        <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    </head>

    <body>
        <h1 class="header_1">免费注册</h1>
        <div class="container w3">
 
           
         <div class="formFields">
                <form class="contact_form" action="<?php echo $this->router->url('register_auth');?>" method="post" name="contact_form">
                    <ul>
                      <li style=" margin-top:0px; border-color:#43d854;">

                          <input type="text" name="username" class="userName" placeholder="请输入用户名"  value="" autocomplete="off" required style="border:2px solid #43d854;" />
                          <span class="form_hint">请输入2-20位字母、数字或中文，不含特殊字符。</span>    
<!--<ul class="list"> <li>	 推荐您使用:</li>  
 <li style="margin-top:0px;	padding-left:30px;">
<input style=" border:none; vertical-align:middle; margin-top:-1px; margin-bottom:1px; margin-left:30px; width:18px; height:18px; " name="userName1" type="radio" value="" /><span>用户名1</span>
</li>
<li style=" margin-top:0px; 	padding-left:30px;">
<input  style="  border:none; vertical-align:middle; margin-top:-1px; margin-bottom:1px; margin-left:30px; width:18px; height:18px;"  name="userName1" type="radio" value="" /><span>用户名1</span>
</li>
</ul>-->
                        </li>
                        <li>
                            <input type="password" name="passwd1" class="userPassw" placeholder="请输入密码" value="" required />
                            <span class="form_hint">密码中必须包含字母、数字、特称字符，长度为6-14个字符</span>
                        </li>
                        <li>

                            <input type="password" name="passwd2" class="userPassw" placeholder="请确认密码" value="" required  />
                            <span class="form_hint">请再次输入密码</span>
                        </li>
                        <li>

                            <input type="email" name="email" class="userEmail" placeholder="请输入邮箱" value="" autocomplete="off" required />
                            <span class="form_hint_err">正确格式为：myemail@163.com</span>
                        </li>

                        <li >
                            <input type="text" name="captcha" class="yanzhengma" placeholder="验证码" autocomplete="off" required  style="width:80px;" /><span style="margin-left:97px; margin-top:1px;" class="form_hint" >请输入图中的4位字符，不区分大小写</span> 
                            <img onclick="this.src='<?php echo $this->router->url('captcha');?>#'+Math.random();" src="<?php echo $this->router->url('captcha');?>" alt="验证码" style=" margin-left:6px; padding:0px; border-radius:25px; height:53px; width:100px; overflow:hidden;"> </li>
                        <li style="padding-top:0px; margin-top:10px;">
                            <div class="rem-for-agile">
                                <input type="checkbox" name="" required style=" float:left; margin-left:6px; line-height:20px; width:20px; height:20px; border:none;">
                                <font style=" padding:0px;  height:26px; line-height:26px; color:#fff;" >我同意</font>
                                <font style=" padding:0px;  height:26px; line-height:26px; color:#fe9d50;" >
                                    <a href="#"> 《网医用户注册协议》</a>
                                </font>
                            </div>
                        </li>
                        <li>
                            <button class="submit" type="submit" value="免费注册">免费注册</button>
                        </li>
                    </ul>
                </form>  </div>
				<div class="signup">
		<h3>已有账户？<font color="#fe9d50">  <a href="<?php echo $this->router->url('login');?>"> 立即登录</a></font></h3>
		<div class="or">——————— &nbsp;  or &nbsp;  ———————</div>
		<div class="social-w3ls">
		<ul class="social-icons">
			<li><a href="#"><img src="image/qq.png" width="26" height="26" border="none">QQ登陆</a></li>
			<li><a href="#"><img src="image/wechat.png" width="26" height="26" border="none">微信登陆</a></li>
			<li><a href="#"><img src="image/weibo.png" width="26" height="26" border="none">微博登陆</a></li>
		</ul>
		</div>
	</div>                
        </div>
     <p class="copyright"> ICP备10094607号-10 粤卫网审（2012）325号&nbsp; |&nbsp;Copyright © <a href="http://www.wangyi120.com/" target="_blank">www.wangyi120.com</a>, All Rights Reserved </p>     
    </body>
</html>
<script type="text/javascript" src="js/register.js"></script>
<script>
    //AJAX提交查看用户是否被注册
    $("input[name=username]").change(function(){
        var username = $(this).val();
        if( CheckUser(username) ){
            $.ajax({
                    type : "POST",
                    url : "<?php echo $this->router->url('name_exists');?>",
                    data: "username="+username,
                    dataType : "json",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    success : function(data)
                    {
                        if( data > 0) $('.form_hint:first').show().css("background","#fe9d50").text('用户已经被注册');
                        else $('.form_hint:first').show().css("background","#43d854").text('用户没有被注册');
                    }
                });
            }
    });
    //AJAX提交查看邮箱是否被注册
    $("input[name=email]").change(function(){
    email = $(this).val();
    //判断是否是邮箱，如果是ajax提交判断该邮箱是否存在
    if( CheckMail(email) ){
        $.ajax({
            type : "POST",
            url : "<?php echo $this->router->url('email_exists');?>",
            data: "email="+email,
            dataType : "json",
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            success : function(data)
            {
                if( data > 0){
                    $(".form_hint_err").css("background","#fe9d50").text('邮箱已经被注册');
                }else{
                    $(".form_hint_err").css("background","#43d854").text('邮箱没有被注册');
                }
            }
        });
    }
    });
</script>