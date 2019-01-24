<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/swiper.css"/>
    <link rel="stylesheet" href="static/style_default/style/index.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/plugin/swiper.js"></script>
    <script src="static/style_default/script/index.js"></script>
    <title>V稻</title>
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- 导航 -->
        <div class="nav">
            <img src="static/style_default/images/LOGO.png" alt=""/>
            <ul>
                <li class="navCur"><a href="index"><span>首页</span></a></li>
                <li><a href="download"><span>下载APP</span></a></li>
                <li><a href="message"><span>新闻公告</span></a></li>
                <li><a href="seriveCenter"><span>客服中心</span></a></li>
            </ul>
        </div>
        <!-- 导航 -->
    </div>
    <!-- 头部 -->

    <!-- 广告 -->
    <div class="balance">
        <div class="balanceContent">
            <div class="balanceText">
                <h1>V稻</h1>
                <p>连锁平台的管理神器</p>
                <p>超过3亿人使用的手机应用平台</p>
                <a href="download">免费下载 &nbsp;→</a>
            </div>
            <!--  轮播 -->
            <div class="carousel">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href=""><img src="static/style_default/images/hou.png" alt=""/></a></div>
                        <div class="swiper-slide"><a href=""><img src="static/style_default/images/sto.png" alt=""/></a></div>
                        <div class="swiper-slide"><a href=""><img src="static/style_default/images/mob.png" alt=""/></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!--  轮播 -->
        </div>
    </div>
    <!-- 广告 -->

    <!-- 内容 -->
    <div class="article">
        <div class="productContainer">
            <!-- 二维码 -->
            <div class="codeContainer">
                <div class="code">
                    <img src="static/style_default/images/code.png" alt=""/>
                    <p>扫我下载</p>
                    <p>App更多专享资讯</p>
                </div>
            </div>
            <!-- 二维码 -->
            <p>
            	<span>产品描述</span>
                <a href="download">
                    <span>更多</span>
                    <img src="static/style_default/images/moe.png" alt=""/>
                </a>
            </p>
            <div class="productList">
                <div class="productLeft">
                    <a>
                        <div>
                            <span>移动APP端</span>
                            <img src="static/style_default/images/g1.png" alt=""/>
                        </div>
                    </a>
                    <a>
                        <div>
                            <span>微信公众号</span>
                            <img src="static/style_default/images/g2.png" alt=""/>
                        </div>
                    </a>
                </div>
                <div class="productMiddle">
                    <a>
                        <div>
                            <span>系统后台</span>
                            <img src="static/style_default/images/hss.png" alt=""/>
                        </div>
                    </a>
                    <a>
                        <div>
                            <span>门店后台</span>
                            <img src="static/style_default/images/saas.png" alt=""/>
                        </div>
                    </a>
                </div>
                <div class="productRight">
                    <a>
                        <div>
                            <span>收银系统</span>
                            <img src="static/style_default/images/shoyin.png" alt=""/>
                        </div>
                    </a>
                    <a>
                        <div>
                            <span>下载APP<br/><br/>更多精彩</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- 消息 -->
        <div class="message">
            <span>最新消息</span>
            <i></i>
            <div class="messageList">
                <?php foreach ($a_view_data as $new) {?>
                <dl>
                    <dt>
                        <a value="<?php echo $new['notice_id']?>">
                            <i></i>
                            <span><?php echo $new['notice_title']?></span>
                        </a>
                        <span><?php echo date('Y年m月d日',$new['notice_time']); ?></span>
                    </dt>
                    <dd><?php echo strip_tags($new['notice_content'])?></dd>
                </dl>
                <?php }?>
            </div>
            <a href="message">
                <span>查看更多</span>
                <img src="static/style_default/images/moe.png" alt=""/>
            </a>
        </div>
        <!-- 消息 -->
    </div>
    <!-- 内容 -->

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

    <!-- 弹出框 -->
    <div class="popMess">
        <p class="closeMess">关闭</p>
        <dl id="popMess">
            
        </dl>
    </div>
    <!-- 弹出框 -->

    <!-- 底部 -->
    <div class="bottom">
        <p>客服电话：020-31560183&nbsp;&nbsp;&nbsp;4000681707&nbsp;&nbsp;&nbsp;邮箱：7du@7dugou.com</p>
        <p>广州柒度信息科技有限公司</p>
        <p>地址：广州市天河区广棠北路20号B栋F515房</p>
        <p>备案号：粤ICP备10094607号-7 粤ICP备10094607号-11</p>
    </div>
    <!-- 底部 -->
</body>
</html>