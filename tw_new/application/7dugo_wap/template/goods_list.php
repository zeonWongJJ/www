<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>分类列表</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
  <meta content="yes" name="apple-mobile-web-app-capable">
  <meta content="black" name="apple-mobile-web-app-status-bar-style">
  <meta content="telephone=no" name="format-detection">
  <meta content="yes" name="apple-touch-fullscreen">
  <meta name="keywords" content="7度健康商城手机版,国内第一的健康商城手机客户端">
  <meta name="description" content="7度健康商城手机版全新上线">
  <link href="style/instyle.css" rel="stylesheet" type="text/css">
    <!--<script src="js/show/jquery-1.js"></script>-->
  <script type="text/javascript" src="script/jquery-1.js"></script>
  <script type="text/javascript" src="www/js/cordova.js"></script>
  <script type="text/javascript" charset="utf-8" src="www/js/qiduguolink.js"></script>
    <!--左侧导航JS-->
    <!--<script type="text/javascript" src="js/left_nav.js"></script>-->
  <!--左边浮动导航js-->
</head>
	<style>
		footer{display:none;}
		#nav{top:auto;}
		.activity{width:100%;}
		.activity img{width:100%;}
	</style>

<body>
<div class="wrap relative hide-landin">
	 
  <!--搜索-->
    <div class="du-search-box relative" style="top:0;">
    	<div class="activity">
    		<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/mobileAdvert.png" alt="" /></a>
    	</div>
      <div class="du-search-tb">
          <div class="du-logo fl"><a href="index.html"><img src="image/7du_logo.png" width="110" height="42"/></a></div>
            <form class="du-search-form fl" action="hunt" method="post">
              <div id="tab" class="d-search relative diss fl">
                  <input type="text" name="name" value="袋鼠精" autocomplete="off" id="wd0" class="bton-keyword" onfocus="this.value=''" onblur="if(this.value==''){this.value='袋鼠精';}">
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
  <!--搜索-->
    <!--导航开始-->
  
        <div class="modSubnav modHelp">
          <div id="nav">
            <?php foreach ($a_view_data as $val) {?>
            <?php if ($val['gc_id'] == $this->router->get(1)) {?>
              <div class="borderBotm cur">
            <?php } else {?>
              <div class="borderBotm">
            <?php }?>
              <a href="goods_list-<?php echo $val['gc_id']?>.html" class="current "><p><?php echo $val['gc_name']?></p></a>
              
              <div class="subCon" style="min-width:0; ">
                <div class="third-promotion"><a href="item-933.html"><img src="image/list-banner.jpg"></a></div> 
                <ul id="mod_pingpai">
                      <li>
                        <dl>
                            <dt>
                               <a href="search-<?php echo $this->router->get(1)?>.html"><img src="../image/bbuu/0.jpg" alt="澳洲富康"/></a>
                            </dt>
                            <dd><a href="search-<?php echo $this->router->get(1)?>-" title="全部商品">全部商品</a></dd>
                        </dl>
                      </li>  
                  </ul> 
                  <?php foreach ($a_view_data['goods'] as $va) {?>
                  <ul id="mod_pingpai">
                      <li>
                        <dl>
                            <dt>
                               <a href="search-<?php echo $va['gc_parent_id']?>-<?php echo $va['gc_id']?>.html"><img src="../image/bbuu/<?php echo $va['gc_id']?>.jpg" alt="澳洲富康"/></a>
                            </dt>
                            <dd><a href="search-<?php echo $va['gc_parent_id']?>-<?php echo $va['gc_id']?>.html" title="<?php echo $va['gc_name']?>"><?php echo $va['gc_name']?></a></dd>
                        </dl>
                      </li>  
                  </ul>
                  <?php }?>
                </div>
            </div>  
            <?php }?>   
          </div>
        </div>
        <!--<script type="text/javascript" src="http://192.168.1.103/qd/wap/js/zeptomin.js"></script>-->
        <!--<script type="text/javascript" src="http://192.168.1.103/qd/wap/js/v2-mobile.js"></script>-->
     	<!--<script type="text/javascript">
            helpOpen("modSubnav");
        </script>-->
    
 
        <!--导航栏 结束-->

    </div>
     <!--底部弹出功能-->
 <?php echo $this->display('footer');?>
    <!--底部弹出功能-->
</body>
</html>
<script>
      function login() {
        var json={"url":"http://wap.7dugo.com/login_android"}
          openNewWindow(json);
      }
      $('#submit').click(function() {
        $('form').submit();
      });
</script>