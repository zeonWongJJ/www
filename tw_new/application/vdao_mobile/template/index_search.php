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
    <link rel="stylesheet" href="static/style_default/style/indexSearch.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/indexSearch.js"></script>
    <title>搜索</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 首页搜索 -->
    <div class="indexSearch">
        <div class="searchContainer">
            <form action="">
                <div class="searchBox">
                    <a href="" class="back"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
                    <input type="text" id="search" placeholder="产品名称"/>
                    <img src="static/style_default/images/search.png" alt=""/>
                    <span class="goSearch">搜索</span>
                </div>
                <!-- 产品关键字搜索 -->
                <div class="productKeyContainer">
                    <ul></ul>
                </div>
                <!-- 产品关键字搜索 -->
                <!-- 产品 -->
                <div class="productContainer">
                    <div class="productNav">
                        <ul>
                            <li class="productSort"><a>综合排序▾</a></li>
                            <li class="comment"><a >好评优先</a></li>
                            <li class="distance"><a>距离最近</a></li>
                            <li class="screen"><a>筛选</a></li>
                        </ul>
                        <!-- 排序 -->
                        <div class="sortContainer">
                            <ul>
                                <li class="sortCur"><a>综合排序</a></li>
                                <li><a>销量最高</a></li>
                                <li><a>配送费最低</a></li>
                            </ul>
                        </div>
                        <!-- 排序 -->
                        <!-- 筛选 -->
                        <div class="screenContainer">
                            <ul>
                                <li class="screenCate">
                                    <p>产品特色</p>
                                    <div>
                                        <a class="scCur">达达配送</a>
                                        <a>新产品</a>
                                        <a>达达配送</a>
                                    </div>
                                </li>
                                <li class="screenPrice">
                                    <p>产品价格</p>
                                    <div class="priceBox">
                                        <input type="text" placeholder="最低价"/>
                                        <hr/>
                                        <input type="text" placeholder="最高价"/>
                                    </div>
                                </li>
                                <li class="screenBtn">
                                    <a class="reset">重置</a>
                                    <a class="complete">完成</a>
                                </li>
                            </ul>
                        </div>
                        <!-- 筛选 -->
                    </div>
                    <!-- 产品列表 -->
                    <div class="productBox">
                        <ul>
                            <li class="productList">
                                <a href="">
                                    <img src="static/style_default/images/bffg.png" alt=""/>
                                    <em class="productContent">
                                        <h1>摩卡星冰乐</h1>
                                        <span>香浓摩卡酱与咖啡原液，在牛奶加冰块中绽放快乐</span>
                                        <s>月售<span>3</span></s>
                                        <dfn>好评率<span>100%</span></dfn>
                                    </em>
                                    <div class="productInfo">
                                        <span>自营</span>
                                        <em>达达配送</em>
                                    </div>
                                    <span class="productPrice">¥<em>32</em></span>
                                </a>
                            </li>
                            <li class="productList">
                                <a href="">
                                    <img src="static/style_default/images/bffg.png" alt=""/>
                                    <em class="productContent">
                                        <h1>摩卡星冰乐</h1>
                                        <span>香浓摩卡酱与咖啡原液，在牛奶加冰块中绽放快乐</span>
                                        <s>月售<span>3</span></s>
                                        <dfn>好评率<span>100%</span></dfn>
                                    </em>
                                    <div class="productInfo">
                                        <span>自营</span>
                                        <em>达达配送</em>
                                    </div>
                                    <span class="productPrice">¥<em>32</em></span>
                                </a>
                            </li>
                            <li class="productList">
                                <a href="">
                                    <img src="static/style_default/images/bffg.png" alt=""/>
                                    <em class="productContent">
                                        <h1>摩卡星冰乐</h1>
                                        <span>香浓摩卡酱与咖啡原液，在牛奶加冰块中绽放快乐</span>
                                        <s>月售<span>3</span></s>
                                        <dfn>好评率<span>100%</span></dfn>
                                    </em>
                                    <div class="productInfo">
                                        <span>自营</span>
                                        <em>达达配送</em>
                                    </div>
                                    <span class="productPrice">¥<em>32</em></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- 产品列表 -->
                </div>
                <!-- 产品 -->
            </form>
        </div>

        <!-- 遮罩层 -->
        <div class="lay"></div>
        <!-- 遮罩层 -->
    </div>
    <!-- 首页搜索 -->

</body>
</html>