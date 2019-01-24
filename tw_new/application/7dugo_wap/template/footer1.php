<script type="text/javascript" src="script/jquery-1.js"></script>

<div class="xuanfu">
    <div class="footer">
        <div class="footer-top">
            <div class="footer-tleft">
                <a class="btn mr5" href="logout.html">注销账号</a>
            </div>
            <a href="" class="gotop">
                <span class="gotop-icon"></span>
                <p>回顶部</p>
            </a>
        </div>
        <div class="main-opera-pannel" id="main-opera-pannel" style=" display:block;">
        <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
            <style>.activity{padding-top:64px;background:#bebdc2;}
                    .footer-top{ margin-bottom:49px;}
            </style> 
    <?php } else if(strpos($_SERVER['HTTP_USER_AGENT'],'APP_WEBVIEW') !== false){ ?>
            
    <?php } else {?>
        <div class="main-op-table main-op-warp">
                    <a href="index" class="quarter">
                        <span class="i-home"></span>

                        <p>首页</p>
                    </a>
                    <a href="classify" class="quarter">
                        <span class="i-categroy"></span>

                        <p>客服</p>
                    </a>
                    <a href="classify.html" class="quarter">
                        <span class="i-mine"></span>

                        <p>分类</p>
                    </a>
                    <a href="shop.html" class="quarter li_shop">
                        <span class="i-cart"></span>

                       <p>购物车</p>
                    </a>
                    <a href="member.html" class="quarter li_member li_order_form li_collection li_address">
                        <span class="i-mino"></span>

                        <p>我的商城</p>
                    </a>
        </div>
    <?php }?>
           
        </div>
    </div>
</div>

<script>
var strUrl=window.location.href; 
var arrUrl=strUrl.split("/"); 
var arr={};
var strPage=arrUrl[arrUrl.length-1]; //123.html
var filename=strPage.split("."); // 123      html
var pre=filename[filename.length-2];
if(pre == undefined){
    var a = filename[0]; 
    $(".li_"+a).addClass('current');
} else {
    var arr=pre.split("-");
    $(".li_"+arr).addClass('current');
}
	$(".gotop").click(function(){
		$("body,html").animate({scrollTop:0},300);
		return false;
	})
</script>