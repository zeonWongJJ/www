<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1″ />
        <meta http-equiv="Cache-Control" content="max-age=7200" />
        <title></title>
        <link rel="stylesheet" href="./style/reset.css">
        <script type="text/javascript" src="script/jquery-1.8.3.js"></script>
    </head>

    <body>
         
    <div class="top">
     <div class="top_con">
     <div class="top_l"><img src="image/images/user.png" style="width:96px; height:96px;" ></div><div style="float:left; margin-top:25px; width: 1px;height: 50px; background: #383838;"></div><span class="yonghu">用户中心</span>
    
    <div class="top_r">
   <div> <ul>
    <li style="border:1px solid #5a5a5a; border-radius:3px; -moz-box-shadow: 10px 10px 5px #404040;
box-shadow: 5px 5px 5px #404040; ">登录</li>
    <li>注册</li>
    </ul></div>
    </div>
    </div>
    </div>
    
    <div class="content">
    <div style="font-size:18px; margin-top:18px; font-weight:bold; margin-left:20px; font-family:Microsoft YaHei; color:#5e5e5e">忘记密码</div> <div class="content_m"><img src="image/images/progress1.png"  style="margin:0px; width:908px; height:45px;"><div class="progress">
    <ul>
    <li style=" color:#1781ae; margin-left:35px;"">输入用户名 </li>
    <li style=" margin-left:162px;">验证身份 </li>
   <li style=" margin-left:165px;">重置密码 </li>
    <li style=" margin-left:175px; width:30px;">完成 </li>
    
    </ul>
    </div>
    <form class="contact_form" action="<?php echo $this->router->url('reset');?>" method="post" name="contact_form">
                    <ul>
                        <li>
                            <input type="text" name="username" class="userName" placeholder="请输入用户名"  value="" autocomplete="off" required style=" width:180px; height:23px;" />
                            <span class="form_hint">请输入2-20位字母、数字或中文，不含特殊字符。</span>
                        </li>
     <li>
                            <input type="text" name="captcha" class="yanzhengma" placeholder="验证码" autocomplete="off" required style="float:left; width:95px; height:23px;" /><span style="margin-left:90px; margin-top:1px;" class="form_hint" >请输入图中的4位字符，不区分大小写</span>
                            <img onclick="this.src='<?php echo $this->router->url('captcha');?>#'+Math.random();" src="<?php echo $this->router->url('captcha');?>" alt="验证码" style=" margin-left:6px; border-radius:25px; height:31px; width:81px; overflow:hidden;">
                            </li>
                        <li>
                            <button class="submit" type="submit" value="下一步">下一步</button>
                            
                        </li>
                    </ul>

                </form></div></div>
     <div class="footer">
	 <div class="liebiao">
     <ul>
    <li style="border:none;">关于我们 </li>
    <li>联系方式 </li>
    <li>对外合作 </li>
    <li> 服务条款 </li>
    <li> 隐私政策 </li>
    <li> 版权声明 </li>
    <li>招贤纳士 </li>
    <li>问题建议 </li>
    </ul></div>
    <hr style="width:1200px; margin:0 auto;" />
            <p> ICP备10094607号-10 粤卫网审（2012）325号 </p>
    </div>
       
       
    </body>

</html>
<script>
//检查用户名函数
function CheckUser(user) {
    var filter  = /^[a-zA-Z0-9_]{2,19}$/;
    if (filter.test(user)){
        $('.form_hint:first').show().css("background","#43d854").text('用户名符合填写要求');
    } 
    else {
        $('.form_hint:first').show().css("background","#fe9d50").text('请输入2-20位字母、数字或中文，不含特殊字符。');
    }
};

//验证用户名是否符合要求

$("input[name=username]").change(function(){
    var username = $("input[name=username]").val();
    CheckUser( username );
});

</script>