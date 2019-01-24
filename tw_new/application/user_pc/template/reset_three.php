<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1″ />
        <meta http-equiv="Cache-Control" content="max-age=7200" />
        <title></title>
        <link rel="stylesheet" href="style/reset.css">
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
    <div style="font-size:18px; margin-top:18px; font-weight:bold; margin-left:20px; font-family:Microsoft YaHei; color:#5e5e5e">忘记密码</div> <div class="content_m"><img src="image/images/progress3.png"  style="margin:0px; width:908px; height:45px;"><div class="progress">
    <ul>
    <li style=" color:#1781ae; margin-left:35px;"">输入用户名 </li>
    <li style=" color:#1781ae; margin-left:162px;">验证身份 </li>
    <li style=" color:#1781ae; margin-left:165px;">重置密码 </li>
    <li style=" margin-left:175px; width:30px;">完成 </li>
    
    </ul>
    </div><div class="list1" style=" margin-left:200px; padding-top:50px;" >请输入您的新密码并确认：</div>
<form class="contact_form3" action="<?php echo $this->router->url('reset_three');?>" method="post" name="password">
 
     <ul>

        <li>
                <input type="password" name="passwd1" class="userPassw" placeholder="请输入密码" value="" required style=" width:170px; height:25px;" />
                <span class="form_hint">密码中必须包含字母、数字、特称字符，长度为6-14个字符</span>
        </li>
                        <li>
                            <input type="password" name="passwd2" class="userPassw" placeholder="确认密码" value="" required style=" margin-top:10px; width:170px; height:25px;" />
                            <span class="form_hint" style=" margin-top:13px;">请再次输入密码</span>
                        </li>
                        <li>
                            <button class="submit3" type="submit" value="下一步" >下一步</button>
                        </li>
                    </ul>
                </form>
        </div></div>
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
//检查密码函数
function CheckPwd(pwd) {
    var filter  = /^[0-9a-zA-Z_.$#@^&]{6,14}$/;
    if (filter.test(pwd)) return true;
    else {
        $('.form_hint').eq(0).show().css("background","#1781ae").text('密码中必须包含字母、数字、特称字符，长度为6-14个字符');
        return false;
    }
};

//验证密码
$("input[name=passwd1]").change(function(){
var pwd = $("input[name=passwd1]").val();
    if( CheckPwd(pwd) ){
        $('.form_hint').eq(0).show().css("background","#43d854").text('密码可以使用');
    };   
});

//验证2次密码是否一样
$("input[name=passwd2]").change(function(){
var pwd2 = $("input[name=passwd2]").val();
var pwd = $("input[name=passwd1]").val();
    if( pwd != pwd2 ){
        $('.form_hint').eq(1).show().css("background","#1781ae").text('两次输入的密码不一致');
    }else{
        $('.form_hint').eq(1).show().css("background","#43d854").text('两次输入的密码一致');
    }
});
</script>