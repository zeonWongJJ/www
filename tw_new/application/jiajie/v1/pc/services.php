<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/page/services.css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r23/html5.js"></script>
    <script src="https://cdn.bootcss.com/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
    <title>服务分类</title>
</head>
<body>
<!--头部-->
<div class="jiajie-common_header jiajie-common_full">
    <div class="jiajie-common_inner">
        <!--左边logo-->
        <div class="jiajie-header-logo">
            <a href="./index.html">帮家洁</a>
        </div>
        <!--右边导航栏-->
        <ul>
            <li><a href="./index.php">首页</a></li>
            <li><a class="active" href="./services.php">服务分类</a></li>
            <li><a href="./about.php">关于我们</a></li>
            <li><a href="./contact.php">联系我们</a></li>
        </ul>
    </div>
</div>
<!--banner 开始-->
<div class="jiajie-common_banner jiajie-common_full">
    <div class="jiajie-common_inner">
        <img src="assets/img/img_03.png" alt="">
        <h1>轻松一点，开启品质生活</h1>
        <p>因为热爱</p>
        <p>我们注重每一个服务细节</p>
        <p>配备专业工具</p>
        <p>专注服务品质体验</p>
    </div>
</div>
<!--banner 结束-->
<div class="jiajie-section-1 jiajie-common_full">
    <div class="jiajie-common_inner">
        <div class="jiajie-section_title">我们有哪些服务</div>
        <div id="service_category_box" style="overflow: hidden"></div>
    </div>
</div>
<?php include __DIR__ . '/template/footer.php' ?>
<script src="assets/js/getCatetgory.js"></script>
</body>
</html>