<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的收藏</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/member.css">
    <script type="text/javascript" src="script/jquery-1.js"></script>
</head>
	<style>
		.footer li{position:relative;}
		.cartBox{position:absolute; bottom:0.8em; right:0;}
	</style>
<body>
    <header id="header">
        <div class="header-wrap">
            <a class="header-back" href="member.html"><span>返回</span> </a>
            <h2>我的收藏</h2>
        </div>
    </header>
    <div class="favorites-list" id="favorites_list">
    <div class="footer" id="footer">
        <?php if ( ! empty($a_view_data)) {?>
		 <ul>
			<?php foreach ($a_view_data as $val) {
                ?>
            <li>
                <a href="item-<?php echo $val['fav_id'] ?>.html" class="mf-item clearfix">
                    <span class="mf-pic">
                        <img src="<?php echo get_config_item('goods_img')?><?php echo $val['store_id']?>/<?php echo $val['goods_image']?>"/>
                    </span>
                    <div class="mf-infor">
                        <p class="mf-pd-name"><?php echo $val['goods_name'] ?></p>
                        <p class="mf-pd-price">
                        	￥<?php echo $val['goods_price'] ?>
                        	
                        </p>           
                    </div>
                </a>               
                <div class="cartBox">
                    <?php if ($val['goods_state'] == 1) {?>
                       <span class="i-cart" value="<?php echo $val['fav_id'] ?>" style="background:url(../image/cart.png) no-repeat 0 5px;width:39px;height:23px; display:inline-block;"></span>
                    <?php }?>
                    

                	<span class="i-del" value="<?php echo $val['fav_id'] ?>"></span>
                </div>
            </li>
            <br>
            <?php }?>
        </ul>
        <?php } else {?>
        <div class="no-record">
            暂无记录
        </div>
       <?php }?>
    </div>
</div>
 <?php echo $this->display('footer1');?>
 <script>
 $(".i-del").unbind("click").click(function(){
    var id = $(this).attr('value');
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('collection');?>",
        data: "id="+id,
        dataType : "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success : function(data)
        { 
            if(data == 1){
                alert("删除成功！");
                self.location='<?php echo $this->router->url('collection');?>';
            }
        }
    })
 })
 $(".i-cart").unbind("click").click(function(){
    var id = $(this).attr('value');
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('cart_list');?>",
        data: "goodshop="+id,
        dataType : "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success : function(data)
        { 
            if (data == 1) {                       
                alert ("加入购物车成功！");
            }else if (data == 0) {                       
                alert ("加入购物车失败！");
            }
        }
    })
    
 })

 </script>
</body>
</html>