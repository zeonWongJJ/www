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
    <link rel="stylesheet" href="static/style_default/style/firstClass.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <title>一级分类</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 一级分类 -->
    <div class="upLoad">
        <p class="pjoTitle">
            <span>选择分类</span>
            <a>我的产品</a>
        </p>
        <!-- 分类列表 -->
        <div class="cateContainer">
            <ul>
                <?php foreach ($a_view_data as $pro) {
                    if ($pro['proid'] == 1) {?>
                <li class="cateList">
                    <a href="classification_share-<?php echo $pro['pro_id']?>">
                        <i><img src="static/style_default/images/cateP.png" alt=""/></i>
                        <div class="productCate">
                            <h1><?php echo $pro['pro_name']?></h1>
                            <p>
                                <span>水果</span>/<span>肉类</span>/<span>特产等</span>
                            </p>
                        </div>
                    </a>
                </li>
                <?php }}?>
            </ul>
            <a href="myshare" class="close"><img src="static/style_default/images/y_03.png" alt=""/></a>
        </div>
        <!-- 分类列表 -->
    </div>
    <!-- 订单列表 -->

</body>
</html>