<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>7度健康商城手机版-国内第一的健康商城手机客户端</title>
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
    <!-- <script type="text/javascript" src="js/view.js"></script> -->
</head>
	<style>
		.content_tpl>h1{line-height:30px;}
		.du-search-tb{height:50px;}
		.content_tpl img{width:100%; height:auto;}
		.du-goodsinfo>h3{width:180px;  height:auto;}
		.activity{width:100%;}
		.activity img{width:100%;}
    #breadcrumb{ top:100px; }
	</style>
<body>
<script>
	window.onload=function(){
		$("#toCart").toggle(function(){
			$(".main-opera-pannel").css("display","block");
			$("#cart1").css("padding","10px 0 0px");
		},function(){
			$(".main-opera-pannel").css("display","none");
			$("#cart1").css("padding","10px 0 15px");
		});
		
	
		$("html, body").scrollTop(0).animate({scrollTop: $(".tab-lst>li>a").offset().top});
		$(".tab-lst>li>a").click(function(){
			 var target_top = $(this).offset().top;
			$("html,body").animate({scrollTop: target_top}, 1000); 
			$("html,body").scrollTop(target_top);
		});
		
		
		$("#minus").click(function(){
				minus(this);
		});
		$("#plus").click(function(){
				plus(this);
		})
		// 购物车加减 
		function minus(ele){
			$(ele).next().val(parseInt($(ele).next().val())-1);
			if( parseInt($(ele).next().val())<1 ){
           		$(ele).next().val(1);
         	}
		}
		function plus(ele){
			$(ele).prev().val(parseInt($(ele).prev().val())+1);
		}
	}
  
</script>
<div class="wrap hide-landin relative">
	<div class="activity">
    	<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/mobileAdvert.png" alt="" /></a>
    </div>
	<!--搜索-->
    <div class="du-search-box relative">
    	<div class="du-search-tb" >
        	<div class="du-logo fl"><a href="index.html"><img src="image/7du_logo.png" width="110" height="42"/></a></div>
            <form class="du-search-form fl" action="hunt" method="post">
            	<div id="tab" class="d-search relative diss fl">
                	<input type="text" name="name" value="澳洲原装进口红袋鼠精" autocomplete="off" id="wd0" class="bton-keyword" onfocus="this.value=''" onblur="if(this.value==''){this.value='澳洲原装进口红袋鼠精';}">
			        <!-- <span class="xg_ser absolute"></span>  -->
              <input type="submit" style="background: url(../image/du-sprites.png) no-repeat; width: 25px;height: 25px;top: 5px;right: 0px;position: absolute;" value="">              
                </div>
            </form>
            <?php if (empty($_SESSION['user_name'])) {?>
              <div class="du-login fr" style="position:relative; z-index:2; right:3%;"><a <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
                       href="login_ios"
                <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
                    onclick="login()"
                <?php } else {?>
                 href="login"
                <?php }?>><span>登陆</span></a></div>
            <?php } else {?>
              <div class="du-login fr" style="position:relative; z-index:2; right:3%;"><a href="logout"><span>注销</span></a></div>  
            <?php }?>
        </div>
    </div>
	<!--搜索-->
    <!--产品详情-->
    <div id="du16-mainLayout" class="relative">
    <form action="<?php echo $this->router->url('bill'); ?>" method="post" >
    	<div class="du16-adaptive-circle">
        	<div class="layout middle">
            <img src="<?php echo get_config_item('goods_img')?><?php echo $a_view_data[0]['store_id']?>/<?php echo $a_view_data[0]['goods_image']?>">
            </div>
        </div>

        <div class="du-goodsinfo"  data-id='<?php echo $this->router->get(1)?>'>
            <!-- <input type="hidden" name="" value="<?php echo $this->router->get(1)?>"> -->
            <h1><a id="goods_id" value="<?php echo $this->router->get(1)?>"><?php echo $a_view_data[0]['goods_name'] ?></a></h1>
            <h3><?php echo $a_view_data[0]['goods_jingle'] ?></h3>
            <ul>
              <li class="shang_7duprice"><strong><?php if ($a_view_data[0]['goods_promotion_type'] != 0) {
                                        echo '<span>促销价</span><strong>￥' . $a_view_data[0]['goods_promotion_price'] . '</strong>(原价:￥' . $a_view_data[0]['goods_price'] . ')';
                                    } else { ?>7度价：<strong>￥<?php echo $a_view_data[0]['goods_price'] ?></strong><?php } ?></strong> 
                                      <span><?php 
                                      if(empty($a_view_data[0]['goods_feng'])){
                                        echo (@intval(1/20 * $a_view_data[0]['goods_price']));
                                     } else {
                                      echo $a_view_data[0]['goods_feng'];
                                      }
                                      ?>积分</span></li>
              <li class="du-goprice">
                <dl class="xbase_item xnumber">
                <!-- <dd>购买数量：</dd> -->
                <dd>
                   <p class="option">
                       <a id="minus" class="btn-del" <!--onClick="minus()";-->></a>
                       <input id="number" class="fm-txt" type="text" onBlur="modify();" name="num[]" value="1"></input>
                        <a id="plus" class="btn-add" <!--onClick="plus();"-->></a>
                    </p>
                </dd>
                </dl>
              </li>
              <li><p>支付宝  财富通 7度发货 免运费 退换保障</p></li>
            </ul>
        
        </div>
       </div> 
        <!--介绍；规格；评论-->
        <!--选项卡-->
         <div class="good-detail sift-mg" id="dump">
             <div id="fixed" class="sift-tab">
                <ul class="tab-lst">
                    <li><a href="item-<?php echo $this->router->get(1)?>-1.html"
                           value="wareInfo" <?php if ($this->router->get(2) == 1) echo 'class="on"'; ?>>商品介绍</a>
                         <a style="display:none;"></a> 
                    </li>
                    <li><a href="item-<?php echo $this->router->get(1)?>-2.html"
                           value="warePack" <?php if ($this->router->get(2) == 2) echo 'class="on"'; ?>><span
                                class="bar"></span>规格参数</a></li>
                    <li><a href="item-<?php echo $this->router->get(1)?>-3-1.html"
                           value="wareStandard" <?php if ($this->router->get(2) == 3) echo 'class="on"'; ?>><span
                                class="bar"></span>商品评价</a></li>
                </ul>
              </div>
              <?php if ($this->router->get(2) == 1) { ?>
                                    <div class="detail" id="wareInfo">
                                        <p>
                  <span>  
                    <div class="content_tpl">
                            <?php
              if (empty($a_view_data[0]['mobile_body'])) {
                echo $a_view_data[0]['goods_body'];
              } else {
                echo $a_view_data[0]['mobile_body'];             
              }
              ?>
                        </div>
                  </span>
                                        </p>
                                    </div>
                                <?php } ?>

                            <?php if ($this->router->get(2) == 2) { ?>
                                <div class="detail" id="wareService">
                                    <p>
                                      <span>
                                         <?php echo '所属分类：' . $a_view_data[0]['gc_name']; ?><br/>
                                            <?php echo '品牌：' . $a_view_data[0]['brand_name']; ?><br/>
                                </span>
                                    </p>
                                </div>                            
                            <?php } ?>

                            <?php if ($this->router->get(2) == 3) { ?>
                                <div class="detail" id="wareStandard">                    

                                    <div class="commentbox">
                                        <ul>
                                            <?php foreach($a_view_data['evaluate_goods'] as $comment) {?>
                                                    <li>
                                                        <div class="ment_leftpic">
                                                          <span><img alt="" src="image/ping_bg.jpg"/></span>
                                                          <strong>
                                                              <p style="width:66px; color: #ef4b15; ">
                                                                  <?php echo $comment['geval_frommembername']; ?>
                                                              </p>
                                                              <?php for ($i = 1; $i <= $comment['geval_scores']; $i++) {
                                                                  echo '<img src="image/star.png"; height: 20px;"/>';
                                                              } ?>
                                                          </strong>
                                                        </div>
                                                        <div class="ment_right">
                                                            <p style="max-width:none; padding-bottom:0;"><b>购物心得：</b><?php echo $comment['geval_content']; ?>
                                                            </p>
                                                            <span>评论时间：<?php echo date('Y-m-d', $comment['geval_time_create']); ?></span>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </li>
                                          <?php }?>
                                        </ul>
                                    </div>
                                    <?php echo $a_view_data['page']; ?>
                                </div>
                            <?php } ?>

         </div>                  
       <!--选项卡-->
       <!--介绍；规格；评论-->
       <!--浮动路径面包屑-->
		<ul id="breadcrumb"  class="absolute">
          <li><a href="index.html"><span class="icon icon-home"></span><img src="image/homeipc.png"/></a></li>
          <li><a href="index.html"><span class="icon icon-beaker"> </span> 首页</a></li>
          <li><a href="search-<?php echo $a_view_data[0]['gc_id_2']?>.html"><span class="icon icon-double-angle-right"></span> <?php foreach ($a_view_data['name'] as $id => $name) {
             if ($id == $a_view_data[0]['gc_id_2']) {
            echo $name;
           } }?></a></li>
          <li><a href="search-<?php echo $a_view_data[0]['gc_id_2']?>-<?php echo $a_view_data[0]['gc_id_3']?>.html"><span class="icon icon-rocket"> </span> <?php foreach ($a_view_data['name'] as $id => $name) {
             if ($id == $a_view_data[0]['gc_id_3']) {
            echo $name;
           } }?></a></li>
          <li><a href="#"><span class="icon icon-arrow-down"> </span> 详情</a></li>
        </ul>
    <!--浮动路径面包屑-->
    </div>
    <!--产品详情-->
    <br />
    <br />
    <br />
	<!--购物车-->    
       <div id="cart1" class="cart-btns-fixed" style="display: table;">
        <div class="cart-btns-fixed-box">
          <?php if ($a_view_data[0]['goods_state'] != 1) {?>
              <a class="btn btn-buy" href="#"> 产品已下架</a>
              <a id="toCart" class="btn cart-num" href="#">菜单</a>
          <?php } else { ?>
           <input type="submit" style=" -webkit-appearance:none; color:#fba744;border: 1px solid #fba744;border-radius: 50px;width: 100px;background: #901414;font-size: 16px;height: 31px;" value="立即购买">
              <a id="add_cart" class="btn btn-cart" href="#">加入购物车</a>
           
              <a id="toCart" class="btn cart-num" href="#">菜单</a>
          <?php }?>
        </div>
        </form>
           <!--底部弹出功能-->
           <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
           <style>#login-list img{ margin-top:64px; }
                    #cart1{ margin-bottom:49px; }</style>
          <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
                  
          <?php } else {?>
              <div class="main-opera-pannel" id="main-opera-pannel" style="max-width:100%; min-width:100%;">
                <div class="main-op-table main-op-warp">
                    <a href="index.html" class="quarter">
                        <span class="i-home"></span>

                          <p>首页</p>
                        </a>
                        <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" class="quarter">
                            <span class="i-categroy"></span>

                            <p>客服</p>
                        </a>                
                        <a href="classify.html" class="quarter current">
                            <span class="i-mine"></span>

                            <p>分类</p>
                        </a>                
                        <a href="shop.html" class="quarter">
                            <span class="i-cart"></span>

                            <p>购物车</p>
                        </a>
                        <a href="member.html" class="quarter">
                            <span class="i-mine"></span>

                            <p>我的商城</p>
                        </a>
                </div>
              </div>
          <?php }?>
    </div>
    <!--底部弹出功能-->
       </div>
    <!--购物车--> 
    
   
  <script>
    var item_id = $(".du-goodsinfo").attr('data-id');
    $("#number").attr("name",'num['+item_id+']');

    //加入购物车
    $(".btn-cart").click(function() {
        var goodsnum = $("#number").attr('value');
        var goodshop = $("#goods_id").attr('value');
          $.ajax({
              type : "POST",
              url : "<?php echo $this->router->url('cart_list');?>",
              data: {"goodshop" : goodshop,"goodsnum" : goodsnum},
              dataType : "json",
              contentType: "application/x-www-form-urlencoded;charset=UTF-8",
              success : function(data)
              {
                  if (data == 3) {                       
                    self.location='<?php echo $this->router->url('login');?>';
                  } else if (data == 1) {                       
                      alert ("加入购物车成功！");
                  }else if (data == 0) {                       
                      alert ("加入购物车失败！");
                  }
              }
          });
    });
    function login() {
        var json={"url":"http://wap.7dugo.com/login_android"}
          openNewWindow(json);
      }
  </script>
</body>
</html>
