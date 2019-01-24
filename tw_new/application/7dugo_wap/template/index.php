<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>7度健康商城</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta content="telephone=no" name="format-detection">
	<meta content="yes" name="apple-touch-fullscreen">
    <meta name="keywords" content="7度健康商城手机版,国内第一的健康商城手机客户端">
	<meta name="description" content="7度健康商城手机版全新上线">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <script type="text/javascript" src="www/js/cordova.js"></script>
        <script type="text/javascript" charset="utf-8" src="www/js/qiduguolink.js"></script>
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="style/swiper.min.css">
    <link href="style/instyle.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="script/jquery-1.js"></script>
    <!-- Demo styles -->
    <style>
    html, body {
        position: relative;
        height: 100%;
    }
    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color:#000;
        margin: 0;
        padding: 0;
    }
    .swiper-container {
        width: 100%;
        /*height: 100%;*/
        margin-left: auto;
        margin-right: auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .swiper-slide>a{width:100%;}
	.swiper-slide>a>img{ width:100%; /*height:100%;*/}
	.d-search, .bton-keyword{}
	.activity{width:100%;}
	.activity img{width:100%;}
    </style>

</head>
<body>
    <!--搜索-->
    <div class="activity">
    	<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/mobileAdvert.png" alt="" /></a>
    </div>
    
	<!--搜索-->
    <!-- banner -->
    <div class="swiper-container">
    	<div class="du-search-box" style="height:auto; position:absolute; top:10px; z-index:9">
    	<div class="du-search-tb">
        	<div class="du-logo fl"><img src="image/7du_logo.png" width="110" height="42"/></div>
            <form class="du-search-form fl" action="hunt" method="post">
            	<div id="tab" class="d-search relative diss fl">
                	<input type="text" value="袋鼠精" name="name" autocomplete="off" id="wd0" class="bton-keyword" onfocus="this.value=''" onblur="if(this.value==''){this.value='请输入文字';}">
			        <span class="xg_ser absolute" id="submit"></span> 
                </div>
            </form>
            <?php if (empty($_SESSION['user_name'])) {?>
              <div class="du-login fr"><a <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
                       onclick="loginid()"
                <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
                    onclick="login()"
                <?php } else {?>
                 href="login"
                <?php }?>><span>
               
              登陆</span></a></div>
            <?php } else {?>
              <div class="du-login fr"><a href="logout"><span>注销</span></a></div>  
            <?php }?>
        </div>
    </div>
        <div class="swiper-wrapper">
        	<div class="swiper-slide"><a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/jinbanner.png"/></a></div>
            <div class="swiper-slide"><a href="http://wap.7dugo.com/item-126.html"><img src="image/banner.jpg"/></a></div>
            <!-- <div class="swiper-slide"><img src="image/2015floor1Con_6.jpg"/></div> -->
            <!-- <div class="swiper-slide"><img src="image/banner.jpg"/></div>
            <div class="swiper-slide"><img src="image/2015floor1Con_6.jpg"/></div>
            <div class="swiper-slide"><img src="image/banner.jpg"/></div>
            <div class="swiper-slide"><img src="image/2015floor1Con_6.jpg"/></div> -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
    </div>
    <!-- Swiper JS -->
    <script src="js/swiper.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: true
    });
    </script>
    <div class="wrap">
    <div class="contact-box hide-landin">
        <!--热图分类-->
        <div style="margin-bottom:10px;">
            <img  src="image/menu_dingbu.png" usemap="#Map" border="0" width="100%"/>
            <map name="Map" id="Map">
              <area shape="rect" coords="17,17,339,123" href="search-1212.html" target="_blank" />
              <area shape="rect" coords="16,130,185,235" href="search-1214.html" target="_blank"/>
              <area shape="rect" coords="192,128,517,234" href="search-1211.html" target="_blank"/>
              <area shape="rect" coords="346,17,516,121" href="search-1213.html" target="_blank"/>
              <area shape="rect" coords="523,15,624,234" href="search-1215.html" target="_blank"/>
            </map>
      </div>
      <!--热图分类-->
      <!--联系方式-->
      <div class="contact-bottom">
      	 <a class="contact-left fl" href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310"><img src="image/contact-left.png"/>在线客服</a>
        <a class="contact-right fr" href="tel:4000681707"><img src="image/contact--right.png"/>客服电话</a>
      </div>
      <!--联系方式-->
      </div>
      <!--共用尾部 开始-->
      <?php echo $this->display('footer');?>
      <!--共用尾部 开始-->  
</body>
     <script>
      function login() {
        var json={"url":"http://wap.7dugo.com/login_android"}
          openNewWindow(json);
      }
        function loginid() {
          location.href = 'protocolhead://skipMy_?124';
        }
      $('#submit').click(function() {
        $('form').submit();
      });
    </script>
</html>