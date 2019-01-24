<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/page/contact.css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r23/html5.js"></script>
    <script src="https://cdn.bootcss.com/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
    <!--时间轴插件-->
    <link href="assets/css/timeline.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="assets/js/modernizr.js"></script>
    <script type="text/javascript" src="assets/js/jquery-1.8.3.min.js"></script>
    <title>关于我们 - 帮家洁</title>
</head>
<body>
<!--头部-->
<div class="jiajie-common_header jiajie-common_full">
    <div class="jiajie-common_inner">
        <!--左边logo-->
        <div class="jiajie-header-logo">
            <a href="./index.php">帮家洁</a>
        </div>
        <!--右边导航栏-->
        <ul>
            <li><a href="./index.php">首页</a></li>
            <li><a href="./services.php">服务分类</a></li>
            <li><a href="./about.php">关于我们</a></li>
            <li><a class="active" href="./contact.php">联系我们</a></li>
        </ul>
    </div>
</div>
<!--banner 开始-->
<div class="jiajie-common_banner jiajie-common_full">
    <div class="jiajie-common_inner" style="position: relative;">
        <div class="jiajie-contact_bubble">有疑问？可点下方咨询按钮哦~</div>
        <div class="jiajie-contact_icon"></div>

        <div class="jiajie-contact_box">
            <dl>
                <dt></dt>
                <dd>
                    <h5>在线客服</h5>
                    <p>工作时间：09:00-18:00</p>
                </dd>
            </dl>
            <dl>
                <dt></dt>
                <dd>
                    <h5>电话客服</h5>
                    <p>工作时间：09:00-18:00 客服电话：020-31560183</p>
                </dd>
            </dl>
        </div>

    </div>
</div>
<!--banner 结束-->

<div class="jiajie-section-1 jiajie-common_full">
    <div class="jiajie-common_inner">
        <div class="jiajie-section_title">最新消息</div>
        <section id="cd-timeline" class="cd-container"></section>
    </div>
</div>
<?php include __DIR__ . '/template/footer.php'; PHP_EOL ?>
<script src="assets/js/getTimeLine.js?v=<?php echo date('Ym');?>"></script>
<script>
    $(function () {
        var $timeline_block = $('.cd-timeline-block');
        //hide timeline blocks which are outside the viewport
        $timeline_block.each(function () {
            if ($(this).offset().top > $(window).scrollTop() + $(window).height() * 0.75) {
                $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
            }
        });
        //on scolling, show/animate timeline blocks when enter the viewport
        $(window).on('scroll', function () {
            $timeline_block.each(function () {
                if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden')) {
                    $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
                }
            });
        });
    });
</script>
</body>
</html>