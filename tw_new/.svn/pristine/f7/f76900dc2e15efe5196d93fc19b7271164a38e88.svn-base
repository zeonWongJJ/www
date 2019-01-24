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
    <div style="font-size:18px; margin-top:18px; font-weight:bold; margin-left:20px; font-family:Microsoft YaHei; color:#5e5e5e">忘记密码</div> <div class="content_m"><img src="image/images/progress2.png"  style="margin:0px; width:908px; height:45px;">
    <div class="progress">
    <ul>
    <li style=" color:#1781ae; margin-left:35px;"">输入用户名 </li>
    <li style=" color:#1781ae; margin-left:162px;">验证身份 </li>
    <li style=" margin-left:165px;">重置密码 </li>
    <li style=" margin-left:175px; width:30px;">完成 </li>
    
    </ul>
    </div>
    
<form action="<?php echo $this->router->url('verify_res');?>" method="post" name="verify">
<div class="contact_form2">
    <div class="list1" style=" margin-left:22px" >您正在为账号<strong><?php  echo $a_view_data['member_name']; ?></strong>重置密码：</div>
    <div class="list1">
    <span style=" margin-left:107px; float:left; padding-top:5px;">请选择验证身份方式：</span>
    <ul id="box">
    <li>
    <a href="javascript:void(0);" hidefocus=true onfocus=this.blur() id="show"><img src="image/images/phone.png" alt="">已验证手机<span></span></a>
        <ul id="list">      
            <li class="mobile"><img src="image/images/phone.png" alt="" >已验证手机<span></span></li>
            <li class="email"><img src="image/images/email.png" alt="" >已验证邮箱<span></span></li>
        </ul>
    </li>
    </ul></div>
    <div class="list1">
    <span class="bound" style="margin-left:150px;  float:left;  height:20px; line-height:20px;">已绑定手机号：</span>
    <span style=" float:left; margin-left:10px;"><strong class="boundstrong">
    <?php 
    if( $a_view_data['member_mobile'] ){
        $mobile = substr( $a_view_data['member_mobile'] , 0 , 3 );
        $mobile1 = substr( $a_view_data['member_mobile'] , 7 , 4 );
        echo $mobile.'****'.$mobile1;
    }else{
        echo '你没有绑定手机号码';
    }
    ?></strong></span>
    
    </div>
	<div class="list1">
	<span style="margin-left:151px;  float:left; height:20px; line-height:20px;padding-top:8px;">请填写验证码：</span>
	<input type="text" name="verifyName" class="yanzhengma" placeholder="验证码" autocomplete="off" required style=" width:95px; height:20px; margin-left:10px;" />
	<span style="margin-left:110px;" class="form_hint">请输入途中的4位字符，不区分大小写</span>
	<span  class="btn">获取验证码</span>
	</div>
	   <button class="submit" type="submit" value="下一步" >下一步</button>
     </div>   
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
<script>
var oList=document.getElementById('box').getElementsByTagName('ul');
var oA=document.getElementById('show')
var oLi=document.getElementById('list').getElementsByTagName('li');
oA.onclick=function(e){
	if(getStyle(oList[0],'display')=='none'){

		oList[0].style.display='block';
	}else{
		oList[0].style.display='none';
	}
e=e||event;
e.cancelBubble=true;	
}

document.onclick=function(){
oList[0].style.display='none';
}
for(var i=0;i<oLi.length;i++){
	oLi[i].onclick=function(){
		oA.innerHTML=this.innerHTML;
		oList[0].style.display='none';
	}
}
function getStyle(obj,attr){
	return obj.currentStyle?obj.currentStyle[attr]:getComputedStyle(obj)[attr];
}
</script>

<script>
res = 'mobile';
//点击手机选项的时候
$('.mobile').click(function(){
    $('.bound').text('已绑定手机号：');
    res = 'mobile';
    $('.boundstrong').text("<?php 
        if( $a_view_data['member_mobile'] ){
            $mobile = substr( $a_view_data['member_mobile'] , 0 , 3 );
            $mobile1 = substr( $a_view_data['member_mobile'] , 7 , 4 );
            echo $mobile.'****'.$mobile1;
        }else{
            echo '你没有绑定手机号码';
        }
        ?>");
});

//点击邮箱选项的时候
$('.email').click(function(){
    $('.bound').text('已绑定邮箱号：');
    res = 'email';
    $('.boundstrong').text("<?php 
        if( $a_view_data['member_email'] ){
            $mobile = substr( $a_view_data['member_email'] , 0 , 3 );
            $mobile1 = substr( $a_view_data['member_email'] , 7 , 4 );
            echo $mobile.'****'.$mobile1;
        }else{
            echo '你没有绑定电子邮箱';
        }
        ?>");
});

// $('.btn').click(function(){
//     if( res == 'email' ){
//         email ="email="+ "<?php  echo $a_view_data['member_email']; ?>";
//         $.ajax({
//         type:'POST',
//         url:"<?php echo $this->router->url('verify');?>",
//         data:email

//     });
//     }else{
//         mobile ="mobile="+ "<?php  echo $a_view_data['member_mobile']; ?>";
//         $.ajax({
//         type:'POST',
//         url:"<?php echo $this->router->url('verify');?>",
//         data:mobile

//     });
//     }
    
// });

$(document).on('click',".btn",function(){
        $('.btn').addClass('phone_captcha');
        $('.btn').removeClass('btn');
        timer();
        if( res == 'email' ){
        email ="email="+ "<?php  echo $a_view_data['member_email']; ?>";
        $.ajax({
        type:'POST',
        url:"<?php echo $this->router->url('verify');?>",
        data:email
        });
        }else{
            mobile ="mobile="+ "<?php  echo $a_view_data['member_mobile']; ?>";
            $.ajax({
            type:'POST',
            url:"<?php echo $this->router->url('verify');?>",
            data:mobile

        });
        }

    }); 
    function timer(){
        var second = 60;
        var j = setInterval(function(){
            second--;
            $('.phone_captcha').text(second);
            if(second <= 0){
                $('.phone_captcha').addClass('btn');
                $('.phone_captcha').removeClass('phone_captcha');
                $('.btn').text('获取验证码');
                clearInterval(j);
            }
            console.log(second);
        }, 1000);

    }

</script>
       
</body>

</html>