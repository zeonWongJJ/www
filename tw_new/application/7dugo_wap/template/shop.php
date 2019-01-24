<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>购物车列表</title>
   <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/child.css">
    <script src="js/jquery-1.8.2.min.js"></script>
    <style>
    .red_border{border:4px solid red;}
    .cart-list-ttue{margin-bottom:10px; padding: 8px; background:white; position: relative;}
    .cart-list-ttue>.cart-shop-name{padding: 8px 0px; border-bottom: 1px solid #e8e5e5; margin-bottom: 8px;}
    .cart-list-item>.cart-shop-name>i{float:right;}
    .cart-list-item>.cart-shop-name>i>img{width:15px;}
    .main-op-warp .quarter .i-cart{background-position:-51px -97px;}
    .goto-settlement{ -webkit-appearance: none;}
    .activity{width:100%;}
	.activity img{width:100%; vertical-align:bottom;}
	.footer-top{padding:0;}
	.footer-top>p{height:44px; line-height:44px; padding:0 20px; float:left; color:white;}
	.sub{float:right; }
	.sub>input{height:44px; padding:0 20px; color:white; background:#D9434E; border:none;}
    </style>
</head>
<body>
<script>
    window.onload=function(){
        /* 切换选中状态 */
       var cartLi=$(".cart-list-item");
       cartLi.toggle(function(){
           $(this).addClass('red_border');
           var item_id=$(this).attr('data-id');
           $(this).find(".buynum").attr("name",'num['+item_id+']');
           jisuan();
           $(this).children(".cart-shop-name").children("i").find("img").attr("src","image/ck2.png");
       },function(){
           $(this).removeClass('red_border');
           $(this).find(".buynum").removeAttr("name");
           jisuan();
			$(this).children(".cart-shop-name").children("i").find("img").attr("src","image/ck1.png");
       })

       
        /* 购物车加减 */
        var minusWp=$(".minus-wp");
        var buyNum=$(".buy-num").val();
        var addWp=$(".add-wp");
        minusWp.click(function(){
           var minus=$(this).next().val(parseInt($(this).next().val())-1);
           if( parseInt(minus.val())<1 ){
               minus.val(1);
           }
           event.stopPropagation();
           jisuan();
            var numt= $(this).siblings(".buynum").attr("value");
            var moneyt = $(this).parents("li").find(".goods-total").text();
            zhon = numt * moneyt;
            $(this).parents("li").find('.goods-total-price').text(zhon);
        });
        addWp.click(function(){
            $(this).prev().val(parseInt($(this).prev().val())+1);
            
            event.stopPropagation();
            jisuan();
            var numt= $(this).siblings(".buynum").attr("value");
            var moneyt = $(this).parents("li").find(".goods-total").text();
            zhon = numt * moneyt;
            $(this).parents("li").find('.goods-total-price').text(zhon);
         })
         
        // 图片链接
        
        $(".cart-litemw-imgwp").click(function(){
        	var cartHref=$(this).attr("href");
        	window.location=cartHref;
        	event.stopPropagation();
        })
        function jisuan(){
        var zon = 0;
        $(".red_border").each(function(){
           var num= $(this).find(".buynum").val();
           var money = $(this).find(".goods-total").text();
           zon += num * money;
           $('.total_price').text(zon);
        })
           $('.total_price').text(zon);
       }
       
       $(".cart-list-ttue>.cart-shop-name").append($("<span style='float:right; color:red;'>已下架</span>"));
    }
</script>
<div class="wrap center">
	<div class="activity">
    	<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/mobileAdvert.png" alt="" /></a>
    </div>
    <header id="header"></header>
        <div class="cart-list-wp">
            <?php if( ! empty($a_view_data['cart'])) { ?>
                <form action="<?php echo $this->router->url('bill'); ?>" method="post" >
                <ul class="cart-list">
                    <?php foreach ($a_view_data['cart'] as $val) { 
                            foreach ($val as $goods) {
                                if ($goods['goods_state'] != 1) {
                        ?>

                        <li class="cart-list-ttue" data-id='<?php echo $goods['goods_id']?>'>
                            <div class="cart-shop-name">
                                店铺名称：<?php echo $goods['store_name']?>
                            </div>
                            <div class="cart-litem-wp clearfix">
                          
                                <a class="cart-litemw-imgwp" href="item-<?php echo $goods['goods_id']?>.html">
                                    <img src="<?php echo get_config_item('goods_img')?><?php echo $goods['store_id']?>/<?php echo $goods['goods_image']?>"/>
                                </a>
                                <div class="cart-litemw-cnt" cart_id="<%=cart_list[i].cart_id%>">
                                    <a class="cart-litemwc-pdname" href="item-<?php echo $goods['goods_id']?>.html">
                                        <?php echo $goods['goods_name']?>
                                    </a>
                                    <p class="mt5">
                                        商品单价：￥<span class="goods-total"><?php echo $goods['goods_price']?></span>
                                    </p>
                                     <p class="mt5">
                                        商品总价：￥<span class="goods-total-price"> <?php if($goods['goods_promotion_type'] == 0){echo $goods['goods_price'] * $goods['goods_num'];} else {echo $goods['goods_promotion_price'] * $goods['goods_num'];} ?></span>
                                    </p>
                                    <p class="cart-litemwc-pdcount clearfix mt5">
                                        <span class="minus-wp fleft">
                                            <span class="i-minus"></span>
                                        </span>
                                        <input type="text" class="buy-num buynum fleft" value="<?php echo $goods['goods_num']?>"/>
                                        <span class="add-wp fleft">
                                            <span class="i-add"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <span class="cart-list-del" cart_id="<%=cart_list[i].cart_id%>">
                                <span class="i-del" value="<?php echo $goods['goods_id'] ?>"></span>
                            </span>
                        </li>
                        <?php } else {?>
                        <li class="cart-list-item" data-id='<?php echo $goods['goods_id']?>'>
                            <div class="cart-shop-name">
                                店铺名称：<?php echo $goods['store_name']?>
                                <i>
                                	<img src="image/ck1.png" alt="" />
                                </i>	
                            </div>
                            <div class="cart-litem-wp clearfix">
                          
                                <a class="cart-litemw-imgwp" href="item-<?php echo $goods['goods_id']?>.html">
                                    <img src="<?php echo get_config_item('goods_img')?><?php echo $goods['store_id']?>/<?php echo $goods['goods_image']?>"/>
                                </a>
                                <div class="cart-litemw-cnt" cart_id="<%=cart_list[i].cart_id%>">
                                    <a class="cart-litemwc-pdname" href="item-<?php echo $goods['goods_id']?>.html">
                                        <?php echo $goods['goods_name']?>
                                    </a>
                                    <p class="mt5">
                                        商品单价：￥<span class="goods-total">
                                        <!-- <?php echo $goods['goods_price']?> -->
                                        <?php if($goods['goods_promotion_type'] == 0){echo $goods['goods_price'];
                                        } else {
                                            echo $goods['goods_promotion_price'];} ?></span>
                                    </p>
                                     <p class="mt5">
                                        商品总价：￥<span class="goods-total-price"> <?php if($goods['goods_promotion_type'] == 0){echo $goods['goods_price'] * $goods['goods_num'];} else {echo $goods['goods_promotion_price'] * $goods['goods_num'];} ?></span>
                                    </p>
                                    <p class="cart-litemwc-pdcount clearfix mt5">
                                        <span class="minus-wp fleft">
                                            <span class="i-minus"></span>
                                        </span>
                                        <input type="text" class="buy-num buynum fleft" value="<?php echo $goods['goods_num']?>"/>
                                        <span class="add-wp fleft">
                                            <span class="i-add"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <span class="cart-list-del" cart_id="<%=cart_list[i].cart_id%>">
                                <span class="i-del" value="<?php echo $goods['goods_id'] ?>"></span>
                            </span>
                        </li>

                    <?php } } }?>
                    <!--<li class="cart-list-oitem mt10">
                        商品总金额：￥<span class="clr-d94 total_price">0</span>
                    </li>-->
                    <li>
                        <!-- <a href="javascript:void(0)" class="goto-settlement mt10">去结算</a> -->
                       <!-- <input type="submit" class="goto-settlement mt10" value="去结算">-->
                    </li>
                    <li>
                       <a href="goods_list-1211" class="goto-shopping mt10">去逛逛</a>
                    </li>
                </ul>
               
                <?php } else {?>
                <div class="no-record m10">
                    暂无记录
                </div>
                <?php }?>
        </div>
    </div>
    <!--<?php echo $this->display('footer1');?>
    <div id="footer"></div>-->
    </div>
    <div class="xuanfu">
    <div class="footer">
        <div class="footer-top">
            <!--<div class="footer-tleft">
                <a class="btn mr5" href="logout.html">注销账号</a>
            </div>
            <a href="" class="gotop">
                <span class="gotop-icon"></span>
                <p>回顶部</p>
            </a>-->
                       
           <p>商品总金额：￥<span class=" total_price">0</span></p>
           <div class="sub">
           		<input type="submit" class="" value="去结算">    
           </div>
        </div>
        <div class="main-opera-pannel" id="main-opera-pannel" style=" display:block;">
        <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {?>
                <style>.activity{padding-top:64px;background:#bebdc2;}
            .footer-top{ margin-bottom:49px;}</style>
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

                       <p style="color:#D9434E;">购物车</p>
                    </a>
                    <a href="member.html" class="quarter li_member li_order_form li_collection li_address">
                        <span class="i-mino"></span>

                        <p>我的商城</p>
                    </a>
                </div>
        <?php }?>
        
    </div>
    </form>
</div>
</div>
<script>

$(".i-del").unbind("click").click(function(){
    var id = $(this).attr('value');
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('shop');?>",
        data: "id="+id,
        dataType : "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success : function(data)
        { 
            if(data == 1){
                alert("删除成功！");
                self.location='<?php echo $this->router->url('shop');?>';
            } else {
                alert("删除失败！");
            }
        }
    })
})
</script>
</body>
</html>