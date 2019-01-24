<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>产品页面</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta content="telephone=no" name="format-detection">
	<meta content="yes" name="apple-touch-fullscreen">
    <meta name="keywords" content="7度健康商城手机版,国内第一的健康商城手机客户端">
	<meta name="description" content="7度健康商城手机版全新上线">
	<link href="style/instyle.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="script/jquery-1.js"></script>
  <script type="text/javascript" src="www/js/cordova.js"></script>
  <script type="text/javascript" charset="utf-8" src="www/js/qiduguolink.js"></script>
</head>
	<style>
		.du-search-box{height:0;}
		#list-breadcrumb li a{padding:0; margin-right:22px;}
		.noneShop>p{text-align:center; font-size:25px; color:white;}
		.activity{width:100%;}
		.activity img{width:100%; vertical-align:bottom;}
	</style>
<body>
<div class="wrap hide-landin relative">
	<!--搜索-->
	<div class="activity">
    	<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/mobileAdvert.png" alt="" /></a>
    </div>
    <div class="du-search-box absolute">
    	<div class="du-search-tb">
        	<div class="du-logo fl"><a href="index.html"><img src="image/7du_logo.png" width="110" height="42"/></a></div>
            <form class="du-search-form fl" action="hunt" method="post">
            	<div id="tab" class="d-search relative diss fl">
                	<input type="text" name="name" value="澳洲原装进口红袋鼠精" autocomplete="off" id="wd0" class="bton-keyword" onfocus="this.value=''" onblur="if(this.value==''){this.value='澳洲原装进口红袋鼠精';}">
			        <span class="xg_ser absolute" id="submit"></span> 
                </div>
            </form>
            <?php if (empty($_SESSION['user_name'])) {?>
              <div class="du-login fr"><a <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
                       href="login_ios"
                <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
                    onclick="login()"
                <?php } else {?>
                 href="login"
                <?php }?>><span>登陆</span></a></div>
            <?php } else {?>
              <div class="du-login fr"><a href="logout"><span>注销</span></a></div>  
            <?php }?>
        </div>
    </div>
	<!--搜索 end-->
    <!--list-banner-->
     <div class="list-banner"><img src="image/banner2.png"/></div>
    <!--list-banner end-->
    <!--list-内容列表-->
    <div id="list-list">
      <ul id="list-breadcrumb">
        <li><a href="#"><span class="icon icon-home"> </span><img src="image/homeipc.png" width="22" height="21"/></a></li>
         <li><a href="index"><span class="icon icon-beaker"> </span> 首页</a></li>
          <li><a href="goods_list-<?php echo $this->router->get(1)?>.html"><span class="icon icon-double-angle-right"></span> 
          <?php 
          if ($this->router->get(1) == 1214) {
             echo '老年';           
          } else if ($this->router->get(1) == 1215) {
            echo '调节';
          } else if ($this->router->get(1) == 1212) {
            echo '男性';
          } else if ($this->router->get(1) == 1213) {
            echo '儿童';
          } else if ($this->router->get(1) == 1211) {
            echo '女性';
          }?></a></li>
          <?php if ( ! empty($this->router->get(2))) {?>
            <li><a href="#"><span class="icon icon-rocket"> </span> <?php echo $a_view_data['name'][0]['gc_name']?></a></li>
          <? } else {?> 
           
          <?php }?>
          
          <li><a href="#"><span class="icon icon-arrow-down"> </span> 全部</a></li>
      </ul>
      <div class="list-box">
      	<ul class="good-list">
            
            <?php if (!empty($a_view_data['order'])) {
            foreach ($a_view_data['order'] as $goods) { ?>
              <li>                
                <a href="item-<?php echo $goods['goods_id']?>.html">
                    <img
                        src="<?php echo get_config_item('goods_img')?><?php echo $goods['store_id']?>/<?php echo $goods['goods_image']?>"
                        title="<?php echo $goods['goods_name'] ?>" width="300" height="300">
                    <p class="g-title"><?php echo $goods['goods_name'].'<br>'.$goods['goods_jingle'] ?></p>
      

                    <p class="g-price-odd">市场价：
                        <del><?php echo $goods['goods_marketprice'] ?></del>
                    </p>
                    <p class="g-price"><?php if ($goods['goods_promotion_type'] != 0) {
                            echo '促销价:' . $goods['goods_promotion_price'] . '<span style="color:green">(原价' . $goods['goods_price'] . ')</span>';
                        } else {
                            echo '7度价:' . $goods['goods_price'];
                        } ?></p>

                    <?php if ($goods['goods_promotion_type'] != 0) { ?>
                    <span class="count">促销</span>
                    <?php } ?>
                </a>
              </li>
            <?php }
             } else {
            ?>
    		
    		<li class="noneShop" style="border:none; padding:100px 0;">
    			<p>暂无商品！</p>
    		</li>
            <?php }?>
            <div id="pages" style="position:relative; z-index:2;">
              <?php echo $a_view_data['page']?>
            </div>

        </ul>
      </div>
    </div>
    <!--list-内容列表 end-->
    <!--共用尾部 开始-->
   <?php echo $this->display('footer');?>
    <!--共用尾部 开始-->
</body>
  <script>
      function login() {
        var json={"url":"http://wap.7dugo.com/login_android"}
          openNewWindow(json);
      }
    $('#submit').click(function() {
      $('form').submit();
    });
  </script>
</html>
