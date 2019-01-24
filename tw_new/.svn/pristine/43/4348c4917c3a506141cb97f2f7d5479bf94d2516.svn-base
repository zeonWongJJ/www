<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>会员中心</title>
    <link rel="stylesheet" type="text/css" href="./static/style_default/style/common.css" />
    <script src="./static/style_default/plugin/rem.js" type="text/javascript" charset="utf-8"></script>
     <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
     <script src="static/style_default/plugin/layer/layer.js?v=4.0"></script>
</head>

<body>
    <style type="text/css">
        .box {
            background: #fff;
            height: 100%;
            font-size: 0.14rem;
        }

        .head {
            background: #fff;
            height: 0.44rem;
            display: flex;
            justify-content: space-between;
        }

        .head div {
            line-height: .44rem;
            border-bottom: 0.01rem solid #eee;
            /*color: #FF6633;*/
        }

        .head div:nth-child(1) {
            flex: 0 0 0.7rem;
            padding: 0 0 0 .15rem;
            /*text-align: center;*/
        }

        .head div:nth-child(2) {
            flex: 1;
            text-align: center;
            font-size: .18rem;
        }

        .head div:nth-child(3) {
            flex: 0 0 0.7rem;
            font-size: .12rem;
            text-align: center;
            padding: 0.1rem 0 0 0;
        }

        .head div:nth-child(3) img {
            width: 0.24rem;
            text-align: center;
        }

        .border_bot {
            border-bottom: 0.05rem solid #eee;
        }

        .img_box {
            width: 100%;
            height: 1.93rem;
            background: #fff;
        }

        .img_box_top_loginx_box {
            display: none;
        }

        .img_box_top_login {

            display: flex;
            border-bottom: 0.01rem solid #eee;
            height: 1.15rem;
            align-items: center;
        }

        .img_box_top_login div:nth-child(1) {
            flex: 0 0 1rem;
            text-align: right;
            margin: 0 .15rem 0 0;
        }

        .img_box_top_login div:nth-child(1) img {
            width: .68rem;
            height: .68rem;
            border-radius: 50%;
        }

        .img_box_top_login div:nth-child(2) {
            flex: 0 0 1.3rem;
            font-weight: 800;
            font-size: .16rem;
        }

        .img_box_top_login div:nth-child(3) {
            flex: 0 0 1.15rem;
           text-align: center;

        }

        .img_box_top_login div:nth-child(3) img {
            width: .39rem;
            height: .39rem;
        }

        .img_box_top_login div:nth-child(3) p {
            font-size: .12rem;
        }

        .img_box_top {

            display: flex;
            border-bottom: 0.01rem solid #eee;
            height: 1.15rem;
            align-items: center;
        }

        .img_box_top div:nth-child(1) {
            flex: 0 0 1rem;
            text-align: right;
            margin: 0 .15rem 0 0;
        }

        .img_box_top div:nth-child(1) img {
            width: .68rem;
            height: .68rem;
            border-radius: 50%;
        }

        .img_box_top div:nth-child(2) {
            flex: 0 0 1.3rem;
            font-weight: 800;
            font-size: .16rem;
        }

        .img_box_top div:nth-child(3) {
            flex: 0 0 1.15rem;
            text-align: right;
        }

        .img_box_top div:nth-child(3) img {
            width: .39rem;
            height: .39rem;
        }

        .img_box_top div:nth-child(3) p {
            font-size: .12rem;
        }

        .img_box_num {
            height: .78rem;
        }

        .img_box_num_ul {
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            align-items: center;
        }

        .img_box_num_ul li {
            width: 33.33%;
            text-align: center;
            margin-top: .2rem;
        }

        .img_box_num_ul li div {
            color: #888888;
            margin-top: .03rem;
        }

        .order {
            width: 100%;
            height: 1.63rem;
            background: #fff;
        }

        .order_tit {
            height: .45rem;
            line-height: .45rem;
            border-bottom: 0.01rem solid #eee;
            padding: 0 .15rem;
            font-size: .14rem;
            font-weight: 800;
        }

        .order_com {}

        .order_com_ul {
            display: flex;
            justify-content: space-between;
            padding: 0 .15rem;
            align-items: center;
            text-align: center;
        }

        .order_com_ul li {
            width: 33.33%;
            margin-top: .15rem;
        }

        .order_com_ul li img {
            width: .55rem;
            height: .55rem;
            border-radius: 50%;
        }

        .order_com_ul li p {
            color: #888888;
            margin-top: .03rem;
        }

        .com_box {
            width: 100%;
            padding-bottom: 0.8rem;
            border-top: 0.01rem solid #EEEEEE;
        }

        .com_box_one {
            width: 100%;
            height: 1.1rem;
            background: #fff;
        }

        .com_box_one-t {
            height: .55rem;
            line-height: .55rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .com_box_one-t div {
            font-size: .14rem;
            font-weight: 800;
            padding: 0 .15rem;
        }

        .border-but_1 {
            border-bottom: 0.01rem solid #EEEEEE;
        }

        .com_box_one-t div img {
            width: 0.08rem;
        }

        .com_box_join {
            width: 100%;
            height: .55rem;
            background: #fff;
        }

        .com_box_foo {
            width: 100%;
            height: 1.1rem;
            background: #fff;
        }

        .com_box_service {
            width: 100%;
            height: .55rem;
            background: #fff;
        }
        /*!--注册登陆-->*/

        #loginReg {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            display: none;
            z-index: 9999;
        }

        .box_logn {
            background: #fff;
            min-height: 100%;
            font-size: .16rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            z-index: 999;
        }

        .box_logn .register {
            text-align: end;
            color: #ff6633;
            width: 100%;
            padding: .15rem;
        }

        .box_logn .logo {
            width: 1.165rem;
            height: 1.165rem;
        }

        .box_logn .logo img {
            width: 100%;
            height: auto;
        }

        .box_logn input {
            font-size: .16rem;
        }

        .box_logn .tel,
        .box_logn .password {
            border: 1px solid #cbcbcb;
            width: 3.1rem;
            height: .45rem;
            padding: 0 .1rem;
            border-radius: .03rem;
            margin: .2rem auto;
            cursor: pointer;
        }

        .box_logn .submit {
            background: #ff6633;
            width: 3.1rem;
            height: .45rem;
            padding: 0 .1rem;
            border-radius: .225rem;
            margin: .2rem;
            color: #fff;
        }

        .box_logn .other {
            padding: .3rem 0 .1rem;
            width: 3.1rem;
        }

        .box_logn .other>img {
            margin: .2rem;
            display: inline-block;
        }

        .box_logn .other .logo_tencent {
            width: .245rem;
            height: .295rem;
        }

        .box_logn .other .logo_wechat {
            width: .35rem;
            height: .28rem;
        }

        .box_logn .order {
            height: .6rem;
            line-height: .6rem;
            text-align: center;
            display: flex;
            align-items: flex-end;
        }

        .box_logn .order .line {
            display: inline-block;
            border-top: 1px solid #cbcbcb;
            flex: 1;
            height: .3rem;
        }

        .box_logn .order .txt {
            color: #888888;
            vertical-align: middle;
        }

        .box_logn .forgot {
            text-align: end;
            color: #ff6633;
            width: 3.1rem;
            margin: 0 auto;
            font-size: .12rem;
        }
        /*注册*/

        .box_reg {
            background: #fff;
            height: 100%;
            font-size: .16rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 900;
        }

        .box_reg .register {
            position: absolute;
            top: 0;
            /*right: .5rem;*/
            text-align: end;
            color: #ff6633;
            width: 100%;
            padding: .15rem;
        }

        .box_reg .logo {
            width: 1.165rem;
            height: 1.165rem;
        }

        .box_reg .logo img {
            width: 100%;
            height: auto;
        }

        .box_reg input {
            font-size: .16rem;
        }

        .box_reg .tel,
        .box_reg .password {
            border: 1px solid #cbcbcb;
            width: 3.1rem;
            height: .45rem;
            padding: 0 .1rem;
            border-radius: .03rem;
            margin: .2rem auto;
        }

        .box_reg .verifyCode {
            border: 1px solid #cbcbcb;
            width: 3.1rem;
            height: .45rem;
            margin: .2rem auto;
            border-radius: .03rem;
            position: relative;
        }

        .box_reg .verifyCode>input {
            height: 100%;
            width: 100%;
            border-radius: .225rem;
            padding: 0 .1rem;
        }

        .box_reg .verifyCode>.getCode {
            position: absolute;
            height: 100%;
            width: 1rem;
            color: #ff6633;
            font-size: .12rem;
            right: 0;
            top: 0;
            border-radius: 0 .225rem .225rem 0;
            text-align: center;
            line-height: .45rem;
        }

        .box_reg .verifyCode>.getCode.click {
            color: #888888;
        }

        .box_reg .submit {
            background: #ff6633;
            width: 3.1rem;
            height: .45rem;
            padding: 0 .1rem;
            border-radius: .225rem;
            margin: .2rem;
            color: #fff;
        }
		.span_img{
			position: absolute;
			left: .15rem;
		}
		.span_img img{
			width: .09rem;
			height: .18rem;
		}
        /*二维码*/
       .com_box_ewm {
                width: 100%;
                height: 100%;
                background: #4c4c4c;
                border-top: 0.01rem solid #EEEEEE;
                position: fixed;
                top: 0;
                left: 0;
                display: none;
                z-index: 130;
        }
        .head .back >img{
            height: 20px;

        }
        #loginform{
        	position: relative;
        }
        .count_boxxx{
        	width:100%;
        	position: absolute;
        	text-align: center;
        	top: 0.6rem;
        	display: none;
        }
		.load_count{
			background: white;
			width:3.1rem;
			text-align: left;
			margin:0 auto;
			border:0.01rem solid #cbcbcb;
			border-top:none;
			border-radius: 0.03rem;
		}
		.load_count>li{
			padding:0.04rem 0.1rem; 
			cursor: pointer;
			border-bottom: 0.01rem solid #cbcbcb;
		}
         .com_box_ewm_div{position: absolute;top: 1rem;left: .15rem;right: .15rem; height: 4.5rem;background: #fff;}
          .com_box_ewm_div div:nth-child(1){display: flex;align-items: center;height:1.15rem ;}
          .com_box_ewm_div div:nth-child(1) div{ width: .65rem;height: .65rem;border-radius: 50%;overflow: hidden;margin: 0 0 0 .25rem;}
          .com_box_ewm_div div:nth-child(1) p{margin-left: .15rem;font-size: .16rem;font-weight: 800;}
          .com_box_ewm_div div:nth-child(2){width: 2rem;height: 2rem;margin: .3rem auto .6rem;}
        .com_box_ewm_div div:nth-child(3){font-size: .14rem;text-align: center; margin: .2rem auto;}
        .tips{ width:100%; position:absolute; top:50%; left:0rem; text-align:center; padding:0.15rem 0; font-size:0.14rem; background:#303030; color:white; border-radius:0rem; display:none; z-index:3; }
        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            font-size: 0;
            border-top: 0.01rem solid #ddd;
            z-index: 90;
            background: white;
        }

        .footer>a {
            position: relative;
            width: 20%;
            display: inline-block;
            padding: 0.05rem 0;
            background: white;
            text-align: center;
        }

        .footer>a>img {
            width: 0.24rem;
        }

        .footer>a>span {
            font-size: 0.12rem;
            display: block;
            margin-top: 0.05rem;
        }
        .cartImg {
				width: 0.34rem;
				height: 0.4rem;
				line-height: 0.38rem;
				position: absolute;
				display: inline-block;
				text-align: center;
				font-size: 0.18rem;
				font-style: normal;
				color: white;
				top: -0.32rem;
				left: 0.18rem;
				background-image: url(./static/style_default/images/tuoooo.png);
				background-repeat: no-repeat;
				background-size: 100% 100%;
				cursor: pointer;
				visibility: hidden;
			}
			.com_box_foo a,.com_box_service a{
				display: block;
				width:100%;
			}
			.com_box_one-t div>img{
				width:0.2rem;
			}
			.com_box_one-t div>img{
				margin-right:0.1rem;
			}
			.com_box_one-t div>img,.com_box_one-t div>span{
				vertical-align: middle;
			}
			.wrapper2{
 				position:absolute;
  				top:0;
  				bottom:0;
  				left:0;
  				right:0; 
  				overflow-y:auto;
  				-webkit-overflow-scrolling : touch; 
			}
    </style>
    <div class="wrapper">
<!--二维码-->
                <div class="com_box_ewm">
                    <div class="com_box_ewm_div">
                        <div>
                            <div>
                                <img class="utouxiangs" src="<?php echo $a_view_data['user_pic']?>" >
                            </div>
                            <p class="uname">
                                <?php echo $a_view_data['user_name']?>
                            </p>
                        </div>
                        <div>
                            <img class="uerweimas" src="<?php echo $a_view_data['user_erweima']?>" >
                        </div>
                        <div>
                            在门店下单出示会员码，可积累积分
                        </div>
                    </div>
    
                </div>    
    <!--注册登陆-->
    <div id="loginReg">
        <div class="box_logn">
            <div class="register" ><span class="span_img"><img src="./static/style_default/images/back.png" ></span><span id="register">注册</span></div>
            <div class="logo">
                <img src="./static/style_default/images/logo.png" alt="">
            </div>
            <form id="loginform" action="" method="post">
                <input class="tel" type="text"  name="name_or_tel" placeholder="请输入手机号">
                <!-- 记录账号 -->
               <?php if ($a_view_data['history']) {
                   echo '<div class="count_boxxx"><ul class="load_count">';
                        foreach ($a_view_data['history'] as $item) {
                            echo '<li class="history_item" data-pwd="'.$item['post_login_pwd'].'">'.$item['post_login_name'].'</li>';
                        }
                    echo '</ul></div>';
                } ?>
                
                <!-- 记录账号 -->
                <input class="password" type="password"  name="user_password" placeholder="请输入密码">
                <input type="hidden" value="<?php echo $_COOKIE['client_id'] ?>" name="client_id">
                <div class="forgot">忘记密码</div>
                <input class="submit" type="button" id="mitLogin" value="登陆" />
                <div class="tips"></div>
            </form>
            <div class="other">
                <div class="order"
                    <span style="white-space:pre;"> </span>
                    <span class="line"></span>
                    <span style="white-space:pre;"> </span>
                    <span class="txt">第三方登陆</span>
                    <span style="white-space:pre;"> </span>
                    <span class="line"></span>
                </div>
                <img class="logo_tencent" src="./static/style_default/images/tencent.png" alt=""  onclick="login_qq()">
                <img class="logo_wechat" src="./static/style_default/images/weChat.png"  onclick="login_weixin()" alt="">
            </div>
        </div>
        <!--注册-->
        <div class="box_reg">
            <div class="register" >
            <span class="span_img">
            <img src="./static/style_default/images/back.png" >
            </span>
            <span id="login">登陆</span>
            </div>

            <div class="logo">
                <img src="./static/style_default/images/logo.png" alt="">
            </div>
            <form id="regform" action="" method="post">
                <input class="tel" id="register_name" name="user_name" type="text" placeholder="请输入手机号">
                <div class="verifyCode">
                    <input type="text" name="user_code" id="reg_code"  placeholder="请输入验证码">
                    <div class="getCode" >获取验证码</div>
                </div>
                  <input type="hidden" value="2" name="reg_type">

                <input class="password" type="password" id ="user_psd" name="user_password" placeholder="密码是8-20位数字和字母组合">
                <input class="submit" type="button" id="register_sub" value="注册" />
            </form>
            <div class="tips"></div>
        </div>
    </div>
   
    <!--头-->
    <div class="box">
        <div class="head">
            <div><!--<a href="index" class="back"> <img src="./static/style_default/images/back.png"></a>--></div>
            <div></div>
            <div>
               <?php if($a_view_data['is_login'] ==1 ){?> 
                <a href="user_set"><img src="./static/style_default/images/set.png"></a>
               <?php }else {?>
                  <a class="userset" href="javascript:;" > <img src="./static/style_default/images/set.png"></a>
                <?php }?>
            </div>
        </div>
        <div class="img_box border_bot" data-islogin="<?php echo $a_view_data['is_login']?>">
        	
            <div class="img_box_top_loginx_box">
                <div class="img_box_top_login">
                    <div>
                        <a href="user_own"><img class="utouxiang" src="<?php echo $a_view_data['user_pic']?>"></a>
                    </div>
                    <div class="ureal_name"><?php echo $a_view_data['user_name']?></div>
                        <div class="ewm_div">
                            <img class="uerweima" src="<?php echo $a_view_data['user_erweima']?>">
                            <p>会员专属码</p>
                    </div>                    
                </div>
            </div>

           
            <div class="img_box_top">
                <div>
                    <img src="./static/style_default/images/port.png">
                </div>
                <div id="clicklogin"> 登陆 / 注册</div>
                <!--  <div>
                        <img src="./static/style_default/images/erweima.png">
                        <p>会员专属码</p>
                    </div>-->

            </div>
            
            <div class="img_box_num">
                <ul class="img_box_num_ul">
                    <li>
                        <a href="user_balance"><span class="user_balance"><?php echo $a_view_data['user_balance']?></span>
                        <div>余额</div></a>

                    </li>
                    <li>
                        <a href="user_score"><span class="user_jife"><?php echo $a_view_data['user_score']?></span>
                        <div>积分</div></a>
                    </li>
                    <li>
                        <a href="collection_showlist" ><span class="user_collect"><?php echo $a_view_data['collect']?></span>
                        <div>收藏</div></a>
                    </li>
                </ul>
            </div>
        </div>
        <!--订单-->
        <div class="order border_bot">
            <div class="order_tit">
                我的订单
            </div>
            <div class="order_com">
                <ul class="order_com_ul">
                    <li>
                        <a href="goods_order"><img src="./static/style_default/images/cy.png" alt="">
                        <p>餐饮订单</p>
                        </a>
                    </li>
                    <li>
                        <a href="order_office"><img src="./static/style_default/images/hy.png" alt="">
                        <p>会议订单</p>
                        </a>
                    </li>
                    <li>
                        <a href="book_order"><img src="./static/style_default/images/dy.png" alt="">
                        <p>座位订单</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!--主体-->
        <div class="com_box">
            <!--分享好友赚钱-->
            <div class="com_box_one border_bot">
                <div class="com_box_one-t border-but_1">
                    	<a style="width:100%;" href="user_invitation">
                    <div>
                    <img src="./static/style_default/images/ce1.png" alt="" />	 	
                       <span>邀请好友</span> 
                    </div>
                    <div>
                       <img src="./static/style_default/images/more_gray.png"></a>
                    </div>
                </div>
                <?php if($a_view_data['is_shopman'] ==1 ){?>
                <a  href="shopman_detail">
                     <div class="com_box_one-t">
                    <div>
                        <img src="./static/style_default/images/ce2.png" alt="" />
                        <span>我是店主</span>
                    </div>
                    <div>
                        <img style="width:0.08rem; margin-right:0;" src="./static/style_default/images/more_gray.png">
                    </div>
                </div>
                </a>  
                 <?php }else{?>
                     <a  href="javascript:;" onclick="apply_shopman();">
                     <div class="com_box_one-t">
                    <div>
                        <img src="./static/style_default/images/ce2.png" alt="" />
                        <span>申请店主</span>
                    </div>
                    <div>
                        <img style="width:0.08rem; margin-right:0;" src="./static/style_default/images/more_gray.png">
                    </div>
                </div>
                </a> 
             
                 <?php }?>

            </div>

            <!--加盟申请 -->
             <a href="join_showlist">

            <div class="com_box_join border_bot">
                <div class="com_box_one-t">
                    <div>
                    	<img src="./static/style_default/images/ce4.png" alt="" />
                        <span>加盟申请</span>
                    </div>
                    <div>
                        <img style="width:0.08rem; margin-right:0;" src="./static/style_default/images/more_gray.png">
                    </div>
                </div>
            </div>
            </a>
            <!--的足迹-->
            <div class="com_box_foo border_bot">
                <div class="com_box_one-t border-but_1">
                    	<a href="footprint_showlist">
                    <div>
                    	<img src="./static/style_default/images/ce3.png" alt="" />
                       <span>我的足迹</span> 
                    </div>
                    <div>
                        <img src="./static/style_default/images/more_gray.png"></a>
                    </div>
                </div>
                <div class="com_box_one-t">
                   	<a href="user_comment">
                   <div>
                   	<img src="./static/style_default/images/ce6.png" alt="" />
                        <span>我的评价</span>
                    </div>
                    <div>
                        <img src="./static/style_default/images/more_gray.png"></a>
                    </div>
                </div>
            </div>
            <!--客服中心-->
            <div class="com_box_service border_bot">
                <div class="com_box_one-t">
                    <a href="call_center">
                    <div>
                    	<img src="./static/style_default/images/ce5.png" alt="" />
                        <span>客服中心</span>
                    </div>
                    <div>
                       <img src="./static/style_default/images/more_gray.png"></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer">
        <a href="index">
            <img src="./static/style_default/images/nav1.png" alt="" />
            <span>首页</span>
        </a>
        <a href="n_goods_list">
            <img src="./static/style_default/images/nav2.png" alt="" />
            <span>产品</span>
        </a>
        <a href="mood_showlist">
            <img src="./static/style_default/images/nav3.png" alt="" />
            <span>动态</span>
        </a>
        <a  class="shopCart" href="shopping">
            <img src="./static/style_default/images/nav4.png" alt="" />
            <span>购物车</span>
            <i class="cartImg"><?php echo $a_view_data['cart_count'] ;?></i>
        </a>
        <a href="javascript:;">
            <img src="./static/style_default/images/bn5.png" alt="" />
            <span style="color:#ff6633">会员</span>
        </a>
    </div>
	</div>
    <script src="./static/style_default/plugin/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8">

    	var u = navigator.userAgent;
		var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
		var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    </script>
    <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
    <?php } ?>
    <script type="text/javascript">

        function login_qq(){
            window.location.href="login_qq";
        }

        $(document).ready(function () {
            // get_client_history();

            // 历史记录点击事件绑定
            $('.count_boxxx').on('click', '.history_item', function (e) {
                var ele = $(e.target);
                e.stopPropagation();
                // alert(ele.data('pwd'));
                // 设置密码框文本
                $('[name=user_password]').val(ele.data('pwd'));
                // 设置账号框文本
                $('[name=name_or_tel]').val(ele.text())
                // 收起历史记录
                $(".count_boxxx").hide();
            });
        	var islogin = $(".img_box").data("islogin");
        	if(islogin ==1) {
			    $("#loginReg").hide();
                $(".img_box_top").hide();
                $(".img_box_top_loginx_box").show();        		
        	}
			//弹出登陆注册窗
            $("#clicklogin").click(function () {
                $("#loginReg").show();
            });
			//关闭登陆注册弹出窗
			$(".span_img").click(function () {
				$("#loginReg").hide();
			});
			//切换注册窗
            $("#register").click(function () {
                $(".box_logn").hide();
                $(".box_reg").show();
            });
			//切换登陆窗
            $("#login").click(function () {
                $(".box_reg").hide();
                $(".box_logn").show();
            });
			//登陆成功后切换头像状态.同时关闭登陆注册窗
    // 二维码
         $(".ewm_div").click(function () {
             $(".com_box_ewm").show();
         });
         $(".com_box_ewm").click(function () {
             $(".com_box_ewm").hide();
         });            
			
        });

</script>
</body>
<script>
 /***************登陆账号密码登录**************************/ 
$('#mitLogin').click(function(){  	
        $.post(
            'login',
            $("#loginform").serialize(),
            function(res){
                if (res.status ==1) {
                	var data = res.data;
                	$(".utouxiang").attr('src',data.user_pic); 
                	$(".uerweima").attr('src',data.user_erweima);
                    $(".utouxiangs").attr('src',data.user_pic); 
                    $(".uerweimas").attr('src',data.user_erweima);
                    $(".uname").html(data.user_name);                    
                	$(".ureal_name").html(data.user_name);
                	$(".user_balance").text(data.user_balance) ;
                	$(".user_jife").text(data.user_score);
                	$(".user_collect").text(data.collect);
                    $(".userset").attr("href",'user_set');
                	$(".img_box").data("islogin",'1');
                    show_login();
                  
                } else {
                    $(".tips").html(res.msg);
                    $(".tips").stop().show(100).delay(2000).hide(250);
                   return false;
                }
              
        },'json');
    return false;
});
$(".tel").focus(function(){
	$(".count_boxxx").slideDown(100);
});
$(".tel").blur(function(){
	$(".count_boxxx").slideUp(100);
});

/***************登陆账号密码登录**************************/ 
function  show_login () {
                $("#loginReg").hide();
                $(".img_box_top").hide();
                $(".img_box_top_loginx_box").show();
            }
/******************微信登录***********************/ 
function login_weixin() {
    if (isAndroid || isiOS) {
        var callbackSuccess = function(response){
            if (response != '') {
                $.ajax({
                    url: 'login_weixin',
                    type: 'POST',
                    dataType: 'json',
                    data: {response: response},
                    success: function (res) {
                        var data = res.data;
                        // alert(data);return;
                        if (res.code == 200) {
                            $(".utouxiang").attr('src',data.user_pic);
                            $(".uerweima").attr('src',data.user_erweima);
                            $(".utouxiangs").attr('src',data.user_pic);
                            $(".uerweimas").attr('src',data.user_erweima);
                            $(".uname").html(data.user_name);
                            $(".ureal_name").html(data.user_name);
                            $(".user_balance").text(data.user_balance) ;
                            $(".user_jife").text(data.user_score);
                            $(".user_collect").text(data.collect);
                            $(".userset").attr("href",'user_set');
                            $(".img_box").data("islogin",'1');
                            show_login();
                        } else {
                            alert(res.msg);
                            return false;
                        }
                    },
                    error:function (res) {
                    }
                })
            }
        }
    }
    if (isAndroid) {
        wxAuthorizationLogin(callbackSuccess);
    } else if (isiOS) {
        window.webkit.messageHandlers.vdao.postMessage({
            body: '',
            callback: callbackSuccess+'',
            command:'wxAuthorizationLogin'
        });
    } else {
        window.location.href = "https://open.weixin.qq.com/connect/qrconnect?appid=wx192abf31ae355781&redirect_uri=http%3a%2f%2fwofei_wap.7dugo.com%2fwx_callback&response_type=code&scope=snsapi_login&state=wxLogin#wechat_redirect";
    }
}
/******************微信登录***********************/ 


/***********************注册****************************/
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

    $("#register_name").blur(function(){
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
        var phone=$("#register_name").val();
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
                 $(".tips").stop().show(100).delay(2000).hide(100);
            }
    }); 

    function userPwd(){
        var val=$("#user_psd").val();
        if( registerReg.pwd.test(val) ){
            registerInit.pwd=true
        }else{
            $(".tips").stop().show(100).delay(2000).hide(100);
            $(".tips").html("密码格式错误！");
            registerInit.pwd=false;
        }
        var  reg_code = $("#reg_code").val();
        // if(reg_code ==""){
        //     $(".tips").stop().show(100).delay(3000).hide(100);
        //     $(".tips").html("验证码不能为空！");            
        // }
    }    

    //注册倒计时
        payTime = true;
        var interval = null;
        function getCode(type) {
            if (payTime && type ) {
                $('.getCode').addClass('click')
                timer(parseInt(59));
            }
        }
        function timer(intDiff) {
            interval = window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0; //时间默认值        
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }

                if (second == 0) {
                    payTime = true;
                    $('.getCode').html('重新获取验证码').removeClass('click');
                    window.clearInterval(interval)
                } else {
                    if (minute <= 9) minute = '0' + minute;
                    if (second <= 9) second = '0' + second;
                    $('.getCode.click').html(second + '秒');
                }

                intDiff--;

            }, 1000);
            payTime = !payTime;
        } 

    //提交注册
    $("#register_sub").click(function() {
        userPwd();
      $.post('register',$("#regform").serialize(),function(res)
        {       
                if (res.status ==1) {
               
                $(".tips").stop().show(100).delay(3000).hide(100);
                $(".tips").html("注册成功！"); 
                 $("#loginReg").hide(6000);        

                }else{
                $(".tips").stop().show(100).delay(2000).hide(100);
                $(".tips").html(res.msg);                          
                }

        },'json');
    });

/***********************注册****************************/
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid) {
               var obj={"isArrowFinish":true}
                isArrowWindowFinish(obj);
            } else if (isiOS) {
               
            };
</script>
  
</html>
<script>
	var ScrollFix = function(elem) {
    // Variables to track inputs
    var startY, startTopScroll;
    
    elem = elem || document.querySelector(elem);
    
    // If there is no element, then do nothing    
    if(!elem)
        return;

    // Handle the start of interactions
    elem.addEventListener('touchstart', function(event){
        startY = event.touches[0].pageY;
        startTopScroll = elem.scrollTop;
        
        if(startTopScroll <= 0)
            elem.scrollTop = 1;

        if(startTopScroll + elem.offsetHeight >= elem.scrollHeight)
            elem.scrollTop = elem.scrollHeight - elem.offsetHeight - 1;
    }, false);
};

/*判断设备调用ScrollFix*/

var sUserAgent=navigator.userAgent.toLowerCase();
if(sUserAgent.match(/iphone os/i) == "iphone os"){
    $('.wrapper').addClass('wrapper2');
    ScrollFix($('.wrapper2')[0]); 
}

/*阻止用户双击使屏幕上滑*/
var agent = navigator.userAgent.toLowerCase();        //检测是否是ios
var iLastTouch = null;                                //缓存上一次tap的时间
if (agent.indexOf('iphone') >= 0 || agent.indexOf('ipad') >= 0)
{
    document.body.addEventListener('touchend', function(event)
    {
        var iNow = new Date()
            .getTime();
        iLastTouch = iLastTouch || iNow + 1 /** 第一次时将iLastTouch设为当前时间+1 */ ;
        var delta = iNow - iLastTouch;
        if (delta < 500 && delta > 0)
        {
            event.preventDefault();
            return false;
        }
        iLastTouch = iNow;
    }, false);
}


function apply_shopman(){

            // 发送ajax请求
            $.ajax({
                url: 'apply_shopman',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.code == 200) {
                     layer.msg(res.msg);
                    }else if(res.code ==300){
                       layer.msg(res.msg);
                    }
                }
            })
}
</script>