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
    <link rel="stylesheet" href="static/style_default/style/orderShareList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/orderShareList.js"></script>
    <title>订单列表</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 订单列表 -->
    <div class="orderShareList">
        <p class="pjoTitle">
            <a href=""><img src="static/style_default/images/lefB.png" alt=""/></a>
            <span>我的订单</span>
        </p>
        <!-- 导航 -->
        <div class="nav">
            <a class="navCur"><span>全部</span></a>
            <a><span>待付款</span></a>
            <a><span>待接单</span></a>
            <a><span>待发货</span></a>
            <a><span>已发货</span></a>
        </div>
        <!-- 导航 -->

        <!-- 订单 -->
        <div class="orderContainer">
            <ul>
                <li class="orederList">
                    <div class="myState">
                        <img src="static/style_default/images/tou_03.png" alt=""/>
                        <span>还我大鸡腿</span>
                        <em>待付款</em>
                    </div>
                    <div class="myProduct">
                        <a>
                            <img src="static/style_default/images/bffg.png" alt=""/>
                            <em class="productInfo">
                                <span>招牌爽爽挝啡 等<em>6</em>件商品</span>
                                <p>2017-10-23 10:30</p>
                                <em>¥<dfn>50.3</dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <a class="cancelOrder">取消订单</a>

                    </div>
                </li>
                <li class="orederList">
                    <div class="myState">
                        <img src="static/style_default/images/tou_03.png" alt=""/>
                        <span>还我大鸡腿</span>
                        <em>待接单</em>
                    </div>
                    <div class="myProduct">
                        <a>
                            <img src="static/style_default/images/bffg.png" alt=""/>
                            <em class="productInfo">
                                <span>招牌爽爽挝啡 等<em>6</em>件商品</span>
                                <p>2017-10-23 10:30</p>
                                <em>¥<dfn>50.3</dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <a class="cancelOrder">取消订单</a>
                        <a class="meet">接单</a>
                    </div>
                </li>
                <li class="orederList">
                    <div class="myState">
                        <img src="static/style_default/images/tou_03.png" alt=""/>
                        <span>还我大鸡腿</span>
                        <em>待发货</em>
                    </div>
                    <div class="myProduct">
                        <a>
                            <img src="static/style_default/images/bffg.png" alt=""/>
                            <em class="productInfo">
                                <span>招牌爽爽挝啡 等<em>6</em>件商品</span>
                                <p>2017-10-23 10:30</p>
                                <em>¥<dfn>50.3</dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <a class="cancelOrder">取消订单</a>
                        <a class="mail">我已寄出</a>
                    </div>
                </li>
                <li class="orederList">
                    <div class="myState">
                        <img src="static/style_default/images/tou_03.png" alt=""/>
                        <span>还我大鸡腿</span>
                        <em>已取消</em>
                    </div>
                    <div class="myProduct">
                        <a>
                            <img src="static/style_default/images/bffg.png" alt=""/>
                            <em class="productInfo">
                                <span>招牌爽爽挝啡 等<em>6</em>件商品</span>
                                <p>2017-10-23 10:30</p>
                                <em>¥<dfn>50.3</dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <a class="logistics">查看物流</a>
                    </div>
                </li>
                <li class="orederList">
                    <div class="myState">
                        <img src="static/style_default/images/tou_03.png" alt=""/>
                        <span>还我大鸡腿</span>
                        <em>已完成</em>
                    </div>
                    <div class="myProduct">
                        <a>
                            <img src="static/style_default/images/bffg.png" alt=""/>
                            <em class="productInfo">
                                <span>招牌爽爽挝啡 等<em>6</em>件商品</span>
                                <p>2017-10-23 10:30</p>
                                <em>¥<dfn>50.3</dfn></em>
                            </em>
                        </a>
                    </div>
                    <div class="orderChoice">
                        <a class="cancelOrder">取消订单</a>
                        <a class="logistics">查看物流</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- 订单 -->

        <p class="nothing" style="height:0.77rem; line-height:0.77rem; text-align:center; font-size:0.37rem; color:#666666; ">没有更多了</p>
    </div>
    <!-- 订单列表 -->

    <!-- 遮罩层 -->
    <div class="lay"></div>
    <!-- 遮罩层 -->

</body>
</html>