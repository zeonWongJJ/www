<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1″ />
        <meta http-equiv="Cache-Control" content="max-age=7200" />
        <title></title>
 	<link rel="stylesheet" href="style/style.css">
    </head>

    <body class="body1">
        <h1 class="header1">欢迎登陆 </h1>
        <div class="container1">
                <form class="contact_form1" action="/login_auth" method="post" name="contact_form">
                    <ul>
                      <li style=" margin-top:0px; border-color:#43d854;">

                          <input type="text" name="username" class="userName" placeholder="请输入用户名"  value="" autocomplete="off" required  />
                          
                        </li>
                        <li>

                            <input type="password" name="passwd" class="userPassw" placeholder="请输入密码" value="" required />
                            
                        </li>
                       
                       
                       
                        <li style="padding-top:0px; margin-top:10px;">
                            <div class="rem-for-agile1">
                                <input type="checkbox" name="keep" style=" float:left; margin-left:6px; line-height:20px; width:20px; height:20px; border:none;">
                                <font style=" padding:0px;  height:26px; line-height:26px; color:#fff;" >记住用户(保持登录状态)
</font>
                                <font style=" padding:0px;  height:26px; line-height:26px; color:#fe9d50; float:right; margin-right:7px;" >
                                    <a href="<?php echo $this->router->url('reset');?>"> 忘记密码？</a>
                                </font>
                            </div>
                        </li>
                        <li>
                            <button class="submit1" type="submit" value="立即登录">立即登录</button>
                        </li>
                         <li style="height:12px; margin-top:55px;">
                            <div class="LoginMethod">
                            <ul>
                                <li style="width:55px;"><a onclick='window.open("<?php echo $this->router->url('qq_index');?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");' href="javascript:void(0);"><img src="image/qq.png" width="24" height="24" border="none">QQ</a></li>
                    			<li><a href="#"><img src="image/wechat.png" width="24" height="24" border="none">微信</a> </li>
                    			<li><a onclick='window.open("<?php echo $this->router->url('wblogin'); ?>")'><img src="image/weibo.png" width="24" height="24"  border="none">微博</a></li>
                            </ul>
                            </div>
                         <div class="SignUp"><a href="<?php echo $this->router->url('register');?>"><img src="image/register.png" width="18" height="18" border="none">立即注册</a></div>
                        </li>
                    </ul>

                </form> 
           
           
        </div>

     <p class="copyright"> ICP备10094607号-10 粤卫网审（2012）325号&nbsp; |&nbsp;Copyright © <a href="http://www.wangyi120.com/" target="_blank">www.wangyi120.com</a>, All Rights Reserved </p>
    
       
    </body>

</html>
