<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/logistics.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>查看物流</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="logistics">
        <p class="pjoTitle">
            <a href="share_order"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>物流信息</span>
        </p>
        <div class="product">
            <a>
                <?php if (empty($a_view_data['goods']['pro_img'])) {
                    echo '<img src="static/style_default/images/bffg.png" />';
                } else {
                    echo '<img src="'.$a_view_data['goods']['pro_img'].'">';
                } ?>
                <em class="productInfo">
                    <span>
                        <?php echo $a_view_data['goods']['product_name'] ?>
                        <?php if ($a_view_data['order']['order_count'] > 1) { ?>
                            等<em><?php echo $a_view_data['order']['order_count']; ?></em>件商品
                        <?php } ?>
                    </span>
                    <p><?php echo date('Y-m-d H:i', $a_view_data['order']['time_create']); ?></p>
                    <em>¥<dfn><?php echo $a_view_data['order']['goods_amount']; ?></dfn></em>
                </em>
            </a>
        </div>
        <!-- 物流订单 -->
        <div class="logInfo">
            <p>
                <i><img src="static/style_default/images/addr.png" /></i>
                <span>[收货地址]<?php echo $a_view_data['order']['addres']; ?></span>
            </p>
            <div class="expressContainer">
                <ul>
                    <?php foreach ($a_view_data['express']['Traces'] as $key => $value): ?>
                    <li class="expressList">
                        <a class="exTime">
                            <p><?php echo $value['AcceptTime']; ?></p>
                        </a>
                        <a class="line">
                            <i></i>
                            <hr/>
                        </a>
                        <a class="exInfo">
                            <span><?php echo $value['AcceptStation']; ?></span>
                        </a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <!-- 物流订单 -->
    </div>


</body>
</html>

<script>

$(function(){
    $('.expressContainer').find("ul li").first().addClass('exCur');
})

</script>