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
    <link rel="stylesheet" href="static/style_default/style/shipped.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/shipped.js"></script>
    <title>发货信息</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="shipped">
        <p class="pjoTitle">
            <a href="share_order"><img src="static/style_default/images/kefu_03.png" /></a>
            <span>填写发货信息</span>
        </p>

        <form action="share_delivery" method="post">
            <input type="hidden" name="order_id" value="<?php echo $a_view_data['order']['order_id']; ?>">
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
            <!-- 填写信息 -->
            <div class="fillContainer">
                <ul>
                    <li class="logOrder">
                        <span>物流单号：</span>
                        <a>
                            <input type="text" id="order_num" name="express_number" placeholder="请输入物流单号"/>
                        </a>
                    </li>
                    <input type="hidden" name="express_company">
                    <li class="logCompany">
                        <span>物流公司</span>
                        <a class="choiceLog">
                            <span>请选择物流公司</span>
                            <img src="static/style_default/images/shezhi_03.png" />
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 快递 -->
            <div class="expressContainer">
                <ul>
                    <?php foreach ($a_view_data['express'] as $key => $value): ?>
                    <li class="expressList" myname="<?php echo $key; ?>">
                        <img src="static/style_default/images/redbag_10.png" />
                        <span><?php echo $value; ?></span>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 快递 -->
            <!-- 填写信息 -->

            <input type="submit" value="提交" id="logSub"/>
        </form>
    </div>

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->
</body>
</html>