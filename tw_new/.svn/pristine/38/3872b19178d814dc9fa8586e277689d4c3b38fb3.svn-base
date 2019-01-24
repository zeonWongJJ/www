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
    <link rel="stylesheet" href="static/style_default/style/2nd3rdClass.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>选择分类</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 二、三级分类 -->
    <div class="cateClass">
        <p class="pjoTitle">
            <a href="classification" class="back"><img src="static/style_default/images/lefB.png" alt=""/></a>
            <span>选择分类</span>
        </p>
        <!-- 分类列表 -->
        <div class="cateContainer">
            <?php foreach ($a_view_data as $pro) {if ($pro['pro_pid'] == $this->router->get(1)) {?>
            <dl>
                <dt class="cateA"><?php echo $pro['pro_name']?></dt>
                <?php foreach ($a_view_data as $goods) {
                    if ($goods['pro_pid'] == $pro['pro_id']) {?>
                <dd class="cateB">
                    <a href="share_goods-<?php echo $this->router->get(1)?>-<?php echo $pro['pro_id']?>-<?php echo $goods['pro_id']?>" class="productBox">
                        <img src="static/style_default/images/ship.png" alt=""/>
                        <em>
                            <h1><?php echo $goods['pro_name']?></h1>
                            <span>水果糖、薄荷糖、 巧克力糖水果糖、薄荷糖、 巧克力糖</span>
                        </em>
                        <i><img src="static/style_default/images/shezhi_03.png" alt=""/></i>
                    </a>
                </dd>
                <?php }}?>
            </dl>
            <?php }}?>
        </div>
        <!-- 分类列表 -->

    </div>
    <!-- 二、三级分类 -->

</body>
</html>