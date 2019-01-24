<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/member.css">
    <script src="js/layer.js"></script>
    <script src="script/jquery-1.js"></script>
</head>
<style>
	.order-list>ul>li{ border:1px solid #D9434E; margin-bottom:20px;}
	.main-op-warp .quarter.current .i-mino{background:url(image/cap.png)}
	.activity{width:100%;}
	.activity img{width:100%; vertical-align:bottom;}
</style>
<body>
	<div class="activity">
    	<a href="http://wap.7dugo.com/hunt-6YeR6Iq3-0-0-0-0-0-0-0-0-0-1.html"><img src="image/fatherwap.png" alt="" /></a>
	</div>
    <header id="header">
        <div class="header-wrap">
            <a class="header-back" href="member.html"><span>返回</span> </a>
            <h2>我的订单</h2>
        </div>
    </header>
    <div class="order-list-wp" id="order-list"></div>
        <div class="order-list">
            <?php if ( ! empty($a_view_data['order'])) {?>
                <ul>
                    <?php foreach ($a_view_data['order'] as $order) {?>
                        <li class="<%if(order_group_list[i].pay_amount){%>green-order-skin<%}else{%>gray-order-skin<%}%> <%if(i>0){%>mt10<%}%>">
                            <div class="order-ltlt">
                                <p>
                                    下单时间：<?php echo date('Y-m-d  H:i:s', $order['time_create']);?>
                                   
                                </p>
                            </div>
                           
                                <div class="order-lcnt">
                                    <div class="order-lcnt-shop">
                                        <p>店铺名称：<?php echo $order['store_name'];?></p>
                                        <input type="hidden" name="repurchase" id="repurchase" target="_blank" value="<?php echo $order['order_id']?>" >
                                        <p class="WIDout" value="<?php echo $order['order_sn']?>">订单编号：<?php echo $order['order_sn'];?></p>

                                    </div>
                                    <div class="order-shop-pd">
                                        <?php foreach ($a_view_data['ord'] as $ord) { 
                                            if ($order['order_id'] == $ord['order_id']) {      
                                        ?>
                                        <a class="order-ldetail clearfix bd-t-de" href="item-<?php echo $ord['goods_id']?>.html">
                                            <span class="order-pdpic">
                                                <img src="<?php echo get_config_item('goods_img')?><?php echo $ord['store_id']?>/<?php echo $ord['goods_image']?>"/>
                                            </span>
                                            <div class="order-pdinfor">
                                                <p><?php echo $ord['goods_name'];?></p>
                                                <p>
                                                    单价：<span class="clr-d94">￥
                                                   <?php echo $ord['goods_pay_price'];?>
                                                    
                                                    </span>
                                                </p>
                                                 <p>
                                                    商品数目：<?php echo $ord['goods_num'];?>
                                                </p>
                                            </div>
                                        </a>
                                        <?php }}?> 
                                    </div>
                                    <div class="order-shop-total">
                                        <p>运费：<span class="clr-d94">￥<?php echo $order['shipping_fee'];?></span></p>
                                        <p class="clr-c07">合计：￥<?php echo $order['order_amount'];?> </p>
                                       
                                        <p class="mt5">
                                            <?php if ($order['order_state'] == 10) {?>
                                                <a href="#" class="cancel-order">取消订单</a>
                                            <?php } else if ($order['order_state'] == 20) {?>
                                                <a href="#" style="background: #68c007;padding: 5px 20px; color: #fff;">待发货</a>
                                            <?php } else if ($order['order_state'] == 30) {?>
                                                <a href="#" class="sure-order">确认订单</a>
                                                <a href="order_delivery-<?php echo $order['order_id'];?>" class="viewdelivery-order">查看物流</a>
                                            <?php } else if ($order['order_state'] == 0) {?>
                                                 <a href="#" style="background: #9f9f9f;padding: 5px 20px; color: #fff;">已关闭</a>
                                            <?php } else if ($order['order_state'] == 40) {?>    
                                                <a href="#" style="background: #ec4f12;padding: 5px 20px; color: #fff;">已确认</a>
                                            <?php }?>   
                                        </p>
                                    </div>
                                </div>
                            
                            <?php if ($order['order_state'] == 10) {?>
                                <a href="#" class="l-btn-login check-payment">订单支付（￥<?php echo $order['order_amount'];?>）</a>
                            <?php }?>
                        </li>
                    <?php }?>
                </ul>
                <div class="pagination mt10">
                    <?php echo $a_view_data['page']?>
                </div>
            <?php } else {?>
                <div class="no-record">
                    暂无记录
                </div>
            <?php }?>
        </div>
    </script>
    <?php echo $this->display('footer1');?>
<script>
    //确定订单 
    $(".sure-order").click(function(){
        var affirm = $(this).parents("div").find(".order-lcnt-shop input").attr("value");
        con=confirm("是否确认?");
        if(con==true) {
            $.ajax({
                type : "POST",
                url : "<?php echo $this->router->url('order_confirm');?>",
                data: "affirm="+affirm,
                dataType : "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                success : function(data)
                {
                    if (data == 123) {
                        alert('提交成功！');
                        parent.location.reload();
                    } else {
                        alert('网络出错，请稍后再试');
                        
                    }
                }
            })
        }
    });

    //未付款的取消
    $(".cancel-order").click(function() {
       var abolish = $(this).parents("div").find(".order-lcnt-shop input").attr("value");
        con=confirm("是否确认?");
        if(con==true) {
            $.ajax({
                type : "POST",
                url : "<?php echo $this->router->url('order_confirm');?>",
                data: "abolish="+abolish,
                dataType : "json",
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                success : function(data)
                {
                    if (data == 88) {
                        alert('提交成功！');
                        parent.location.reload();
                    } else {
                        alert('网络出错，请稍后再试');
                        
                    }
                }
            })
        }  
    });
    
    // //立即支付
    $(".check-payment").click(function() {
        var WIDout = $(this).siblings(".order-lcnt").find(".WIDout").attr("value");
        console.log(WIDout);

        window.open("pay-"+WIDout);
    }); 
</script>
</body>
</html>