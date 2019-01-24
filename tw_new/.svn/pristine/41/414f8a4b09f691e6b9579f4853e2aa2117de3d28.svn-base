 <!--共用尾部 开始-->
<footer>
	<div></div>
    <div class="footer-lian">
      <ul> 
      	<li><a <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
                       href="login_ios"
                <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
                    onclick="login()"
                <?php } else {?>
                 href="login"
                <?php }?>> <img src="image/footer-pic_01.png"/>登陆</a></li>
        <li><a href="register.html"> <img src="image/footer-pic2.png"/>注册</a></li>
        <li><a href="order_form.html"> <img src="image/footer-pic3.png"/>订单</a></li>
        <li><a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310"> <img src="image/footer-pic4.png"/>客服</a></li>
      </ul>
    
    </div>
    <div class="footer-lian">
    	
    
    </div>
    <div class="footer-di">
    	<p><a href="tel:4000681707" style="color: #FFF;">7度购：400-068-1707</a></p>
        <p>国家备案：粤ICP备10094607号-7</p>
    </div>

</footer>
<!--共用尾部 开始-->
</div>
<!--底部弹出功能-->
<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>

    <?php if ($this->router->get_url() == 'http://wap.7dugo.com/') { ?>
       
    <?php } else {?>
        <style>.activity{padding-top:64px;background:#bebdc2;}
            .footer-top{ margin-bottom:49px; }</style>
    <?php }?>
<?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
        
<?php } else {?>
    <div class="xuanfu">
        <div class="main-opera-pannel" id="main-opera-pannel" style=" display:block;">
            <div class="main-op-table main-op-warp">
                <a href="index" class="quarter li_index">
                    <span class="i-home"></span>

                    <p>首页</p>
                </a>
                <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" class="quarter">
                    <span class="i-categroy"></span>

                    <p>客服</p>
                </a>
                <a href="classify.html" class="quarter li_goods_list li_search li_item">
                    <span class="i-mine"></span>

                    <p>分类</p>
                </a>
                <a href="shop.html" class="quarter">
                    <span class="i-cart"></span>

                    <p>购物车</p>
                </a>
                <a href="member.html" class="quarter">
                    <span class="i-mino"></span>

                    <p>我的商城</p>
                </a>
            </div>
        </div>
    </div>
<?php }?>
<script>
var strUrl=window.location.href; 
var arrUrl=strUrl.split("/"); 
var arr={};
var strPage=arrUrl[arrUrl.length-1]; //123.html
var filename=strPage.split("."); // 123      html
var pre=filename[filename.length-2];
if(pre == undefined){
    arr[0]='index';
    var image_name='index';
}else{
    var arr=pre.split("-"); 
    if(arr[0] == 'goods_list'  || arr[0]=='search' || arr[0]=='item') {
        var image_name='goods_list';
    }
}
$(".li_"+arr[0]).addClass('current');
</script>
<script language="javascript" src="http://lyt.zoosnet.net/JS/LsJS.aspx?siteid=LYT42657310&lng=cn"></script>