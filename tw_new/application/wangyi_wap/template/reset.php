<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登陆中心</title>
<meta name="keywords" content="保健品商城,保健品网,营养保健品,健康产品,保健食品,保健品" />
<meta name="description" content="7度购营养保健品商城是中国领先的、最值得信赖的营养与健康保健品网上销售平台，专业提供男性、女性、儿童、中老年人的营养保健品及保健食品。七度购保健品健康商城支持货到付款、30天无理由退换货！订购热线:400-681-7707。" />
<link rel="stylesheet" type="text/css" href="style/longin.css" />
<link rel="stylesheet" type="text/css" href="style/footerstyl.css"/>
</head>

<body>
<?php $this->display('header');?>
<!--内容区-->
<div class="qd_loginbox center mb20 qd_loginbox22">
  <div class="center">
  <!--方式-->
  <div class="qd_login_layout">
  	<p class="qd_login_layoutp">您正在为账户<strong>找回密码</strong>，请选择身份验证方式：</p>
    <ul class="qd_select-strategy">
    	<li>
        	<i class="icon icon-phone fl"></i>
            <div class="desc  desc-hasnotice">
            	<h3>通过手机验证码</h3>
                <p>如果你的手机还在正常使用，请选择此方式</p>
            </div>
            <a href="#" class="ui-button-text fr">立即验证</a>
        </li>
        <li>
        	<i class="icon icon-mail fl"></i>
            <div class="desc  desc-hasnotice">
            	<h3>通过邮箱验证码</h3>
                <p>如果你的邮箱还在正常使用，请选择此方式</p>
            </div>
            <a href="#" class="ui-button-text fr">立即验证</a>
        </li>
         
    </ul>
  </div>
  <!--方式 结束-->
 
     <!--输入验证码的页面-->
         <div class="loginwrap qd_loginmima">
            <div id="loginmima_text">您正在使用	<span>手机验证码</span> 验证身份，请完成以下操作</div>
            <div class="login_yanzhengm"><span>用户名：</span><input name="" class="phone" type="text" placeholder="用户名"></div>
            <div class="login_yanzhengm"><span>手机号：</span><input name="" class="phone" type="text" placeholder="输入手机号码"></div>
            <div class="login_yanzhengm"><span>校证码：</span><input name="" class="xiaoyanma" type="text" placeholder="校验码"><input name="" type="button" value="重新获取" class="xiaoyanma_but"></div>
            
                <div class="loginbtn">
                  <div class="loginsubmit fl">
                    <input type="submit" value="下一步">
                  </div>
                  <div class="clear"></div>
                </div>
          </div>
          
          <!-- 输入验证码的页面--> 

 </div>
</div>


<!--内容区 结束-->
<?php $this->display('footer');?>
</body>
</html>
