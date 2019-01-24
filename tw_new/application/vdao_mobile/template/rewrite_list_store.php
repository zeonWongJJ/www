<?php //var_dump($a_view_data['store']);exit; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <title>门店点餐</title>
    <link rel="stylesheet" type="text/css" href="./static/rewrite/style/common.css"/>
    <link rel="stylesheet" href="./static/rewrite/style/storeMain.css"/>
    <link rel="stylesheet" href="./static/rewrite/style/productInfo.css"/>
    <link rel="stylesheet" href="./static/rewrite/style/officeInfo.css"/>
    <link rel="stylesheet" href="./static/rewrite/style/valuation.css"/>
    <link rel="stylesheet" href="./static/rewrite/style/shop_body.css"/>
    <script src="./static/rewrite/script/rem.js" type="text/javascript" charset="utf-8"></script>
    <script src="./static/rewrite/script/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/plugin/layer/layer.js?v=4.0"></script>
</head>
<style>
    a, img, div, i {
        cursor: pointer;
    }

    .seat_box {
        top: 1.71rem;
        background: white;
        width: 100%;
        position: absolute;
        z-index: 90;
        display: none;
    }

    .seat_box .seat_info {
        padding: 0.1rem 0;
        text-align: center;
        border-top: 0.01rem solid #ddd;
        border-bottom: 0.01rem solid #ddd;
    }

    .seat_box .seat_info > a {
        text-align: center;
        display: inline-block;
        font-size: 0.14rem;
        vertical-align: middle;
        margin-right: 0.1rem;
    }

    .seat_box .seat_info > a > img,
    .seat_info > a > span {
        vertical-align: middle;
    }

    .seat_box .seat_info > a > img {
        width: 0.2rem;
    }

    .seat_box .window,
    .seat_box .door {
        display: inline-block;
        margin-left: 0.1rem;
        margin-top: 0.1rem;
    }

    .seat_box .window > img,
    .seat_box .door > img {
        width: 0.28rem;
    }

    .seat_suface {
        margin-left: 0.6rem;
    }

    .seatList {
        display: block;
        margin: 0.2rem 0;
    }

    .seatList > td {
        display: inline-block;
        text-align: center;
        margin-right: 0.5rem;
    }

    .seatList > td > i {
        display: block;
    }

    .seatList > td > img {
        width: 0.37rem;
        margin: 0.05rem;
        cursor: pointer;
    }

    .seatList > td > i > img {
        width: 0.38rem;

        cursor: pointer;
    }

    .seatList > td > img:nth-child(1) {
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
    }

    .seatList > td > img:nth-child(2) {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
    }

    .seatList > td > img:nth-child(4) {
        -webkit-transform: rotate(-135deg);
        -moz-transform: rotate(-135deg);
    }

    .seatList > td > img:nth-child(5) {
        -webkit-transform: rotate(135deg);
        -moz-transform: rotate(135deg);
    }

    .choice_seatBox {
        padding: 0.2rem 0.15rem;
    }

    .choice_seatBox > p {
        font-size: 0.12rem;
    }

    .choice_seatBox > ul {
        width: 2rem;
        display: inline-block;
        margin-top: 0.13rem;
    }

    .choice_seatBox > ul > li {
        position: relative;
        padding: 0.06rem;
        display: inline-block;
        border: 0.01rem solid #000;
        font-size: 0.12rem;
        margin-right: 0.14rem;
        margin-bottom: 0.1rem;
    }

    .choice_seatBox > ul > li > img {
        width: 0.15rem;
        position: absolute;
        top: -0.05rem;
        cursor: pointer;
    }

    .choice_seatBox > #sureSeat {
        float: right;
        width: 1.31rem;
        height: 0.45rem;
        line-height: 0.45rem;
        color: white;
        text-align: center;
        font-size: 0.18rem;
        border-radius: 0.06rem;
        background: #ff6633;
        margin-top: 0.1rem;
        cursor: pointer;
    }

    .head > .store_share > img {
        cursor: pointer;
    }
    
</style>

<body>
<div class="box" style="position: relative; height:100%;">
    <!-- 头部 -->
    <div class="head">
        <a class="back" href="javascript:history.go(-1);"><img style="width:0.35rem;"
                                                               src="./static/style_default/images/dri_03.png" alt=""/></a>
        <span class="store_share"><img src="./static/rewrite/img/share.png" alt=""/></span>
        <div class="storeBox">
            <i><img src="<?php echo $a_view_data['store']['store_touxiang']; ?>" alt=""/></i>
            <ul class="storeInfo">
                <li>v店</li>
                <li>
                    <span>总评：<?php echo number_format(($a_view_data['set']['service_score'] + $a_view_data['set']['goods_score']) / 2, 1); ?></span>
                    <span>服务：<?php echo $a_view_data['set']['service_score']; ?></span>
                    <span>质量：<?php echo $a_view_data['set']['goods_score']; ?></span>
                </li>
                <li>
                    营业时间：<?php echo $a_view_data['set']['store_open_time']; ?>
                </li>
            </ul>

        </div>
        <i class="coll <?php if($a_view_data['collection'] == 1) echo 'coll_type'?>"><img
                    src="./static/rewrite/img/<?php echo $a_view_data['collection'] == 2 ? 'like' : 'syyh' ?>.png"
                    alt=""/></i>
    </div>
    <!-- 导航 -->
    <div class="content_box">
        <ul class="funNav">
            <li class="navCur t_food">点餐</li>
            <li class="t_sit">订座</li>
            <li class="t_office">订办公室</li>
            <li class="t_mes">评价</li>
            <li class="t_shop">商家</li>
        </ul>
    </div>
    <ul class="type_list">
        <li class="typeCur">全部</li>
        <?php foreach ($a_view_data['categorys'] as $category) { ?>
            <li value="<?php echo $category['pro_id'] ?>"><?php echo $category['pro_name']; ?></li>
        <?php } ?>
    </ul>
    <div class="main_content_box">
        <div class="main_content">
            <ul class="shop_list">

                <?php foreach ($a_view_data['category_goods'] as $goods) {
                    p ?>

                    <li>
                        <a href="<?php echo $this->router->url('item', [$goods['proid_id_1'], $goods['product_id'], $this->router->get(1)]); ?>">
                            <i><img src="<?php echo $goods['pro_img']; ?>" alt=""/></i>
                            <ul>
                                <li><?php echo $goods['product_name']; ?></li>
                                <li><?php echo $goods['pro_details']; ?>
                                </li>
                                <li>
                                    <span>月售<?php echo $goods['sale_number']; ?></span>
                                    <span>好评率<?php echo $goods['praise_rate']; ?>%</span>
                                </li>
                                <li>
                                    <span>¥<?php echo $goods['min_price']; ?></span>起
                                    <i class="choiceType" value="<?php echo $goods['product_id']; ?>"><img
                                                src="./static/rewrite/img/notJoin.png" alt=""/></i>
                                </li>
                            </ul>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="office_info">
        <div class="officeBox">
            <?php if (!empty($a_view_data['offices'])) { ?>
                <?php foreach ($a_view_data['offices'] as $office) { ?>
                    <div class="office">
                        <a href="office_detail-<?php echo $office['office_id']?>">
                            <div class="img">
                                <img src="<?php echo $office['room_detail'][0]['room_mainpic']; ?>">
                                <!-- <div class="state c_orange"><?php echo $office['office_isfull'] == 1 ? '已预定' : '可预约'; ?></div> -->
                                <div class="type"><?php echo $office['room_detail'][0]['room_type_name']; ?></div>
                                <div class="star">⭐⭐⭐⭐⭐4.8</div>
                            </div>
                        </a>
                        <div class="info"> <?php echo $office['room_detail'][0]['room_description']; ?></div>
                        <div class="price">
                            <div class="left">
                                价格：<span class="money c_orange">￥<?php echo $office['office_price'] ?></span><span
                                        class="c_gray">/小时</span>
                            </div>
                                <div class="right"><a
                                            href="<?php echo $this->router->url('office_appoint_new', ['office_id' => $office['office_id']]); ?>">预定</a>
                                </div>
                          
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

    <div class="valuation_box">
        <div class="header">
            <div class="left">
                <div class="c_orange num"><?php echo number_format(($a_view_data['set']['service_score'] + $a_view_data['set']['goods_score']) / 2, 1); ?></div>
                <div>商家评分</div>
            </div>
            <div class="right">
                <div>服务态度<span>⭐⭐⭐⭐⭐<?php echo $a_view_data['set']['service_score']; ?></span></div>
                <div>服务质量<span>⭐⭐⭐⭐⭐<?php echo $a_view_data['set']['goods_score']; ?></span></div>
            </div>
        </div>
        <div class="kg"></div>
        <div class="nav">
            <div class="check" value="2">餐饮评价</div>
            <div value="1">办公室评价</div>
            <div value="3">座位评价</div>
        </div>
        <div class="view">
            <div class="food check">
                <div class="top">
                    <div class="type check" value="0">全部</div>
                    <div class="type" value="1">很满意</div>
                    <div class="type" value="2">满意</div>
                    <div class="type" value="3">一般</div>
                </div>
                <div class="info">
                    <!--<div class="valua" data-type="2">
                    <div class="img"></div>
                    <div class="other">
                        <div class="nameBox">
                            <div class="name">还我大鸡腿256</div>
                            <div class="time c_gray">11-6</div>
                        </div>
                        <div class="goods c_gray">产品：抹茶星冰乐 </div>
                        <div class="info">
                            <span class="type c_orange">[满意]</span>
                            干净卫生、食材新鲜，很满意，味道很好，服务态度很好，发货速度也快，赞一个！
                        </div>
                        <div class="imgs">
                            <img src="./static/rewrite/img/tea.png" alt="">
                            <img src="./static/rewrite/img/tea.png" alt=""><img src="./static/rewrite/img/tea.png" alt="">
                            <img src="./static/rewrite/img/tea.png" alt="">
                            <img src="./static/rewrite/img/tea.png" alt="">
                        </div>
                    </div>
                </div>-->
                </div>
            </div>
            <div class="office">
                <div class="top">
                    <div class="type check" value="0">全部</div>
                    <div class="type" value="1">很满意</div>
                    <div class="type" value="2">满意</div>
                    <div class="type" value="3">一般</div>
                </div>
                <div class="info">
                </div>
            </div>
        </div>
    </div>

    <div class="shop_body">
        <div class="shop_box__">
            <div class="title c_b">店铺信息</div>
            <div class="adressBox c_gray">
                <a class="adress " href="tel:<?php echo $a_view_data['store']['store_contact'] ?>"><?php echo $a_view_data['store']['store_address'] ?></a>
            </div>
            <div class="timeBox c_gray">营业时间:
                <span class="time c_b"><?php echo $a_view_data['set']['store_open_time']; ?></span>
            </div>
            <?php if ($a_view_data['store']['store_img']) { ?>
                <div>
                    <div class="c_b">店铺实景</div>
                    <div class="imgs">
                        <img src="<?php echo $a_view_data['store']['store_img'] ?>" alt="">
                    </div>
                </div>
            <?php } ?>
            <?php if ($a_view_data['store']['store_licence']) { ?>
                <div>
                    <div class="c_b">营业资质</div>
                    <div class="imgs">
                        <img src="<?php echo $a_view_data['store']['store_licence'] ?>" alt="">
                    </div>
                </div>
            <?php } ?>

            <?php if ($a_view_data['store']['store_introduction']) { ?>

                <div>
                    <div class="c_b">店铺介绍</div>
                    <div class="imgs">
                        <?php echo $a_view_data['store']['store_introduction'] ?>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>

    <!--   **************************** 订座模块    *****************************************   -->
    <!-- 订座 -->
    <div class="seat_box">
        <div class="seat_info">
            <a>
                <img src="./static/rewrite/img/sa1.png" alt=""/>
                <span>可选</span>
            </a>
            <a>
                <img src="./static/rewrite/img/sa2.png" alt=""/>
                <span>已售</span>
            </a>
            <a>
                <img src="./static/rewrite/img/sa3.png" alt=""/>
                <span>已选</span>
            </a>
            <a>
                <img src="./static/rewrite/img/door.png" alt=""/>
                <span>门</span>
            </a>
            <a>
                <img src="./static/rewrite/img/window.png" alt=""/>
                <span>窗</span>
            </a>
        </div>
        <div class="window">
            <img src="./static/rewrite/img/window.png" alt=""/>
        </div>
        <div class="door">
            <img src="./static/rewrite/img/door.png" alt=""/>
        </div>
        <table class="seat_suface">

            <tr class="seatList">
                <td>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                    <i><img src="./static/rewrite/img/table.png" alt=""/></i>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                </td>
                <td>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                    <i><img src="./static/rewrite/img/table.png" alt=""/></i>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                </td>
            </tr>
            <tr class="seatList">
                <td>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                    <i><img src="./static/rewrite/img/table.png" alt=""/></i>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                </td>
                <td>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                    <i><img src="./static/rewrite/img/table.png" alt=""/></i>
                    <img data-seat="1" alt=""/>
                    <img data-seat="1" alt=""/>
                </td>
            </tr>
        </table>
        <form action="reservation" id="seatform" method="get">
            <input type="hidden" name="office_id" value="28">
            <input type="hidden" name="office_seat" value="">
             <input type="hidden" name="appointment_type" value="2">
            <input type="hidden" name="office_seatname" value="">
        </form>
        <div class="choice_seatBox">
            <p>已选座位</p>
            <ul>
                <!--<li>
                    <span>01座</span>
                    <img src="img/empty.png" alt="" />
                </li>-->
            </ul>
            <a id="sureSeat" href="javascript:;">确认选座</a>
        </div>
    </div>
    <!-- 订座 -->

    <!--   **************************** 订座模块 *****************************************   -->


    <div class="bg_gray">

    </div>

    <!-- 底部 -->
    <div class="footer">
        <div class="shopCart_box">
            <div class="cartImg" id="cartImg">
                <img src="./static/rewrite/img/claccvv.png" alt=""/>
                <i>1</i>
            </div>
            <div class="cartType">
                <span data-type="1" class="cart_typecur store_gi">外卖配送</span>
                <span data-type="2" class="">门店自取</span>
            </div>
            <div class="cartPrice">
                <span>总计 :<em>¥88.00</em></span>
                <p>配送费<span><?php echo $a_view_data['set']['user_order_freight'] ?></span>元</p>
            </div>
        </div>

        <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" id="myform" method="post">
            <input type="hidden" name="come_type" value="4">
            <input type="hidden" name="oldurl" value="<?php echo $this->router->get_url(); ?>">
            <input type="hidden" name="distribution" value="1">
            <input type="hidden" name="store" value="<?php echo $this->router->get(1);?>">
            <a href="javascript:;" class="banc">结算</a>
            <script>
                $(".banc").click(function(){
                    $("#myform").submit();
                })
            </script>
        </form>

        <div class="cartList_box">
            <p>
                <span>已选商品</span>
                <em class="clear_list">清空</em>
            </p>
            <ul class="shop_list_box">
                <!--<li>
                    <div class="list_left">
                        <p>乌龙奶茶</p>
                        <span>小杯/冷/加糖</span>
                    </div>
                    <div class="list_right">
                        <span>¥32.00</span>
                        <img class="minNum" src="./static/rewrite/img/add_03.png" alt="" />
                        <em>1</em>
                        <img class="addNum" src="./static/rewrite/img/add_05.png" alt="" />
                    </div>
                </li>-->

            </ul>
            <p style="font-size:0.1rem; text-align: center;">商品如需分开打包，请在下单时备注</p>
        </div>
    </div>
    <!-- 底部 -->
</div>
<!-- 选规格 -->
<div class="type_box">
    <dl id="goods_spec">
    </dl>
    <div class="type_info">
        <span>¥32.00</span>
        <p></p>
    </div>
    <p class="joinCart">加入购物车</p>
</div>
<!-- 选规格 -->
<div class="lay"></div>

<div class="share_botBox">
    <p>分享到</p>
    <div class="box_box">
        <a style="cursor: pointer"><img onclick="weix_peyo()" src="./static/rewrite/img/fhao.png"
                                        alt=""/><span>微信好友</span></a>
        <a style="cursor: pointer"><img onclick="weix_quan()" src="./static/rewrite/img/hhas.png"
                                        alt=""/><span>微信朋友圈</span></a>
    </div>
</div>

<script src='./static/rewrite/script/swipe.js'></script>
<script>

    $('.price .right').click(function(){
        var store_id = <?= $a_view_data['store']['store_id']?>;
        window.location.href = 'office_appoint_new-29';
    })

    function blance() {
        var length = $('.swipe-wrap img').length;
        $('.index').text('1/' + length);
        // pure JS
        var elem = document.getElementById('mySwipe');
        window.mySwipe = Swipe(elem, {
            startSlide: 0,
            auto: 2000,
            continuous: true,
            disableScroll: true,
            stopPropagation: true,
            callback: function (index, element) {
                $('.index').text(index + 1 + '/' + length);
            },
            transitionEnd: function (index, element) {
            }
        });

        // with jQuery
        // window.mySwipe = $('#mySwipe').Swipe().data('Swipe');
    }
</script>

</body>
<script>


    //遮罩层
    $("body").on("click", ".lay", function () {
        $(".lay").hide();
        $(".type_box").hide();
        $(".cartList_box").hide();
        zIndex();
        $(".cartImg").removeClass("cartShow");
        $(".share_botBox").slideUp(100);
    });

    //分享
    function share() {
        $(".lay").show();
        $(".share_botBox").slideDown(100);
    }

    //店铺分享
    $("body").on("click", ".store_share", function () {
        share()
    });
    //产品分享
    $("body").on("click", ".body .share", function () {
        share()
    });

    //收藏
    function collet($this, eleClass) {
        if ($this.hasClass(eleClass)) {
            $this.removeClass(eleClass);
            $this.children("img").attr("src", "./static/rewrite/img/like.png");
        } else {
            $this.addClass(eleClass);
            $this.children("img").attr("src", "./static/rewrite/img/syyh.png");
        }
    }

    $("body").on("click", ".coll", function () {
        var $this = $(this);


        var store_id = "<?php echo $this->router->get(1);?>";
        $.ajax({
            url: 'store_collection',
            type: 'POST',
            dataType: 'json',
            data: {store_id: store_id},
            success: function (res) {
                if (res.code == 500) {
                    alert(res.msg);
                    return false;
                }
                if ($this.hasClass("coll_type")) {
                    $this.removeClass("coll_type");
                    $this.children("img").attr("src", "./static/rewrite/img/like.png");
                } else {
                    $this.addClass("coll_type");
                    $this.children("img").attr("src", "./static/rewrite/img/syyh.png");
                }
            }
        })
    });

    $("body").on("click", ".like", function () {
        var $this = $(this);
        if ($this.hasClass("coll_typeSo")) {
            $this.removeClass("coll_typeSo");
            $this.css("background-image", "url(./static/rewrite/img/like.png)");
        } else {
            $this.addClass("coll_typeSo");
            $this.css("background-image", "url(./static/rewrite/img/syyh.png)");
        }
    });


    function store_show() {
        $(".head").show();
        $(".content_box").show();
        $(".type_list").show();
        $(".main_content_box").show();
    }

    function store_hide() {
        $(".head").hide();
        $(".content_box").hide();
        $(".type_list").hide();
        $(".main_content_box").hide();
    }

    //导航
    $("body").on("click", ".funNav>li", function () {
        $(this).addClass("navCur");
        $(".funNav>li").not($(this)).removeClass("navCur");
        if ($(this).hasClass("t_food")) {
            store_show();
            $(".footer").show();
            $(".shop_body").hide();
            $(".seat_box").hide();
        } else if ($(this).hasClass("t_sit")) {
            $(".footer").hide();
            $(".type_list").hide();
            $(".main_content_box").hide();
            $(".office_info").hide();
            $(".valuation_box").hide();
            $(".shop_body").hide();
            $(".seat_box").show();
        } else if ($(this).hasClass("t_office")) {
            $(".type_list").hide();
            $(".main_content_box").hide();
            $(".footer").hide();
            $(".office_info").show();
            $(".valuation_box").hide();
            $(".shop_body").hide();
            $(".seat_box").hide();
        } else if ($(this).hasClass("t_mes")) {
            $(".footer").hide();
            $(".type_list").hide();
            $(".content_box").show();
            $(".main_content_box").hide();
            $(".valuation_box").show();
            $(".shop_body").hide();
            $(".seat_box").hide();
        } else if ($(this).hasClass("t_shop")) {
            $(".footer").hide();
            $(".type_list").hide();
            $(".content_box").show();
            $(".main_content_box").hide();
            $(".valuation_box").hide();
            $(".shop_body").show();
            $(".seat_box").hide();
        }
    });

    //获取产品信息到产品详情页面
    function shopDetail($this) {
        var shopName = $this.find("ul>li:nth-child(1)").html();
        var shopDes = $this.find("ul>li:nth-child(2)").html();
        var shopPrice = $this.find("ul>li:nth-child(4)>span").html();
        $(".body .price ").html(shopPrice + "起");
        $(".body .nameBox>.name ").html(shopName);
        $(".body .describe>p ").html(shopDes);
    }

    //进入产品详情
    $("body").on("click", ".shop_list>li>a", function () {
        shopDetail($(this));
        store_hide();
        $(".office_info").hide();
        $(".body").show();
        blance();
    });

    //关闭产品详情
    $("body").on("click", ".body .back", function () {
        $(".body").hide();
        store_show();
    });

    //产品详情的加入购物车
    $("body").on("click", ".body .nameBox>.shop", function () {
        $(".lay").show();
        $(".type_box").show();
        loopType($(this));
    });

    //购物车显示的数量
    function shopCart_num() {
        var sopListLen = $(".shop_list_box>li").length
        $(".cartImg>i").html(sopListLen);
    }

    $(".type_list>li").each(function (i) {
        $(this).addClass("type_" + i);
    })

    //门店茶品类型
    $("body").on("click", ".type_list>li", function () {
        //var Index = $(this).index();
        $(this).addClass("typeCur");
        $(".type_list>li").not($(this)).removeClass("typeCur");
        //$(".shopType_" + Index).show();
        //$(".shop_list>li").not($(".shopType_" + Index)).hide();
        //$(this).hasClass("type_0") ? $(".shop_list>li").show() : "";

        var store_id = '<?php echo $this->router->get(1)?>';
        var cat_id = $(this).attr("value");
        $.ajax({
            type: "post",
            url: "/category_goods",
            data: {store_id: store_id, cat_id: cat_id},
            dataType: "json",
            success: function (data) {
                var html = '';
                data.forEach(function (val) {
                    console.log(val)
                    var goods_href = 'item-' + val.proid_id_1 + '-' + val.product_id + '-' + <?php echo $this->router->get(1);?> +'.html';
                    html += '<li><a href="' + goods_href + '"><i><img src="' + val.pro_img + '" alt=""/></i>' +
                        '<ul><li>' + val.product_name + '</li>' +
                        '<li>' + val.pro_details + '</li>' +
                        '<li><span>月售' + val.sale_number + '</span><span>好评率' + val.praise_rate + '%</span></li>' +
                        '<li><span>¥' + val.min_price + '</span>起<i class="choiceType" value="' + val.product_id + '">' +
                        '<img src="./static/rewrite/img/notJoin.png" alt=""/></i>' +
                        '</li></ul></a></li>';
                });

                $('.shop_list').html(html);

            },
        });
    });

    //弹出选规格窗口
    function loopType($this) {
        var list = $(".type_box>dl>dd");
        var html = "";
        list.each(function (i) {
            html += list.eq(i).children("a.typeCur").html() + "/";
        });
        $(".type_box>dl>dt>span").html($this.parent().parent().find("li:nth-child(1)").html());
        $(".type_info>span").html($this.parent().parent().find("li:nth-child(4)>span").html());
        $(".type_info>p").html(html);
    }

    $("body").on("click", ".choiceType", function (e) {
        e.preventDefault();
        $(".lay").show();
        $(".type_box").show();
        var product_id = $(this).attr("value");
        $.ajax({
            type: "post",
            url: "/goods_spec",
            data: {product_id: product_id},
            dataType: "json",
            async: false,
            success: function (data) {
                var html = '<dt><span>产品名loopType函数会改变</span><img class="closeType" src="./static/rewrite/img/y_03.png" alt=""/></dt>';
                data.data.forEach(function (val, key) {
                    html += '<dd><p>' + val.attributive.attri_name + '</p>';
                    var html2 = '';
                    val.attributive1.forEach(function (v, k) {
                        if (key == 0) {
                            if (k == 0) {
                                html2 += '<a class="typeCur" data-cup_id = "' + v.cup_id + '" value="' + v.price + '">' + v.attri_name + '</a>';
                                 html2 += '<input type="hidden" class="product_id" value="' + product_id + '">';
                            } else {
                                html2 += '<a data-cup_id = "' + v.cup_id + '" value="' + v.price + '">' + v.attri_name + '</a>';
                                html2 += '<input type="hidden" class="product_id" value="' + product_id + '">';
                            }
                        } else {
                            if (k == 0) {
                                html2 += '<a class="typeCur">' + v.attri_name + '</a>';
                            } else {
                                html2 += '<a value="">' + v.attri_name + '</a>';
                                html2 += '<input type="hidden" class="product_id" value="' + product_id + '">';
                            }
                        }
                    });
                    html2 += '</dd>';
                    html += html2;
                });
                $('#goods_spec').html(html);
            },

        });

        loopType($(this));
        e.stopPropagation();

    });

    //选规格
    function choiceType($this) {
        var list = $(".type_box>dl>dd");
        var html = "";
        $this.addClass("typeCur");
        $this.parent().find("a").not($this).removeClass("typeCur");
        list.each(function (i) {
            html += list.eq(i).children("a.typeCur").html() + "/";
        });

        var price = $this.attr('value');
        if (price && price != 'undefined') {
            $(".type_info>span").html('¥' + $this.attr('value'));
        }

        $(".type_info>p").html(html);
    }


    $("body").on("click", ".type_box>dl>dd>a", function () {
        choiceType($(this));
    });

    //关闭选规格
    $("body").on("click", ".closeType", function () {
        $(".type_box").hide();
        $(".lay").hide();
    });

    function zIndex() {
        $(".cartList_box").css("z-index", "2");
        $(".shopCart_box").css("z-index", "2");
        $(".banc").css("z-index", "2");
    }

    //加入购物车
    /*
    function joinCart($this, shopName, shopType, shopMoney) {
        var html = "";
        html = "<li>" +
            "<div class='list_left'>" +
            "<p>" + shopName + "</p>" +
            "<span>" + shopType + "</span>" +
            "</div>" +
            "<div class='list_right'>" +
            "<span>" + shopMoney + "</span>" +
            "<img class='minNum' src='./static/rewrite/img/add_03.png' />" +
            "<em>1</em>" +
            "<img  class='addNum' src='./static/rewrite/img/add_05.png'  />"
        "</div>" +
        "</li>"
        $(".shop_list_box").append(html);
    }
    */

    $("body").on("click", ".joinCart", function () {
        //此购物车参考前同事代码，凌乱中
        var $this = $(this);

        var product_id = $('.product_id').val();//product_id
        //var manoe = $(this).parent().find("#manoe").text();
        // manoe = manoe.slice(1, manoe.length);
        var price = $(this).prev().find("span").html().substring(1);//price
        //var shuxi = $('#xuic').attr('value');
        var goods_spec = $('.type_info p').text();//属性: 大中小/冷热/咸淡 这种方式
        //var tost  = $('.pjoTitle').attr('value');
        var store_id = '<?php echo $this->router->get(1)?>';//store_id
        //var name  = $('#store_name').text();
        var store_name = '<?php echo $a_view_data['store']['store_name']; ?>';//store_name
        //var spec = $(this).parent().find('.choiceCur').attr('value');
        var cup_id = $(this).parent().find('.typeCur').attr('data-cup_id');

        $.ajax({
            type: 'post',
            url: 'shop_add',
            //data: {tost: tost, goods: goods, manoe: manoe, shuxi: shuxi, name: name, spec: spec, oute: 1},
            data: {
                tost: store_id,
                goods: product_id,
                manoe: price,
                shuxi: goods_spec,
                name: store_name,
                spec: cup_id,
                oute: 1
            },
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.code == 200) {
                    //var shopName = $this.parent().parent().find("dl>dt>span").html();
                    //var shopType = $this.prev().find("p").html();
                    //var shopMoney = $this.prev().find("span").html();
                    //joinCart($this, shopName, shopType, shopMoney);
                    //shopCart_num();
                    //list_len();
                    //totalPrice();
                    $(".type_box").hide();
                    $(".lay").hide();
                    usorep();
                } else {
                    alert(data.msg);
                    location.href = '/nuser_center';
                    return false;
                }
            },
        });
        //jinzhi = 1;
        //touchMove();
        //top = $(window).scrollTop();
        //$("body").css("top", top);
        //$("body").removeClass("ovfHiden");


    });

    usorep();

    function usorep() {
        var usore = '<?php echo $this->router->get(1)?>'
        $.ajax({
            type: 'post',
            url: 'shop_inex',
            data: {usore: usore},
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    var goods_number = 0;//购物车数量总数
                    var cart_lsit = "";//购物车列表
                    data.data.goods.forEach(function (val) {
                        cart_lsit += '<li value="' + val.cart_id + '">' +
                            "<div class='list_left'>" +
                            "<p>" + val.product_name + "</p>" +
                            "<span>" + val.shux_name + "</span>" +
                            "</div>" +
                            "<div class='list_right'>" +
                            "<span>" + '￥' + val.money + "</span>" +
                            "<img class='minNum' src='./static/rewrite/img/add_03.png' />" +
                            "<em>" + val.prot_count + "</em>" +
                            "<img  class='addNum' src='./static/rewrite/img/add_05.png'  />"
                        "</div>" +
                        "</li>"

                        goods_number += parseInt(val.prot_count);
                    });

                    $('#cartImg i').text(goods_number);
                    $('#cartImg i').show();
                    $('.cartPrice em').text(data.data.pout);//购物车总价格 pout = goods_total_price
                    $(".shop_list_box").html(cart_lsit);
                }
            }
        })
    }


    //购物车
    $("body").on("click", ".cartImg", function () {
        if ($(this).hasClass("cartShow")) {
            $(this).removeClass("cartShow");
            $(".lay").hide();
            $(".cartList_box").hide();
            zIndex();
        } else {
            $(this).addClass("cartShow");
            $(".lay").show();
            $(".cartList_box").show();
            $(".cartList_box").css("z-index", "98");
            $(".shopCart_box").css("z-index", "99");
            $(".banc").css("z-index", "99");
        }
    });
    //清空购物车
    $("body").on("click", ".clear_list", function () {
        var stoue = '<?php echo $this->router->get(1);?>';
        $.ajax({
            type: 'post',
            url: 'shop_delete',
            data: {stoue: stoue},
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    $(".cartPrice>span>em").html("0.00");
                    $(".shop_list_box>li").remove();
                    list_len();//清空购物车数量和价格
                }
            }
        })
    });

    function list_len() {
        var listLen = $(".shop_list_box>li").length;
        listLen < 1 ?
            $(".cartImg>i").hide() :
            $(".cartImg>i").show();
        $(".cartImg>i").html(listLen);
    }

    list_len();

    //购物车加
    function addNum($this) {
        var cart_id = $this.parent().parent().attr("value");
        var stou = '<?php echo $this->router->get(1)?>';//应该是store_id
        var goods_number = $this.prev().html();
        goods_number++;

        $.ajax({
            type: 'post',
            url: '<?php echo $this->router->url('shop_reudaa');?>',
            data: {id: cart_id, stou: stou, vart: 1},
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.code == 200) {
                    $this.prev().html(goods_number);
                }
            }
        })

    }

    //购物车减
    function minNum($this) {
        var cart_id = $this.parent().parent().attr("value");
        var stou = '<?php echo $this->router->get(1)?>';//应该是store_id
        var goods_number = $this.next().html();
        goods_number--;
        if (goods_number < 1) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->router->url('shop_dele');?>',
                data: {id: cart_id},
                dataType: 'json',
                async: false,
                success: function (data) {
                    if (data.code == 200) {
                        $this.parent().parent().remove();
                    }
                }
            })
        } else {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->router->url('shop_reudaa');?>',
                data: {id: cart_id, stou: stou, vart: 2},
                dataType: 'json',
                async: false,
                success: function (data) {
                    if (data.code == 200) {
                        $this.next().html(goods_number);//赋值数量
                    }
                    ;
                }
            })
        }
    }

    $("body").on("click", ".addNum", function () {
        addNum($(this));
        list_len();
        totalPrice($(this))
    });
    $("body").on("click", ".minNum", function () {
        minNum($(this));
        list_len();
        totalPrice();
    });

    //计算购物车总价
    function totalPrice() {
        var list = $(".shop_list_box>li>.list_right");
        var unival;
        var shopNum;
        var totolNum = 0; //商品数量
        var totolPrice = 0; //总价
        var disp = 0; //配送费
        for (var i = 0; i < list.length; i++) {
            unival = list[i].children[0].innerHTML.substring(1);
            shopNum = list[i].children[2].innerHTML;
            totolNum += Number(shopNum);
            totolPrice += Number(unival) * Number(shopNum);
        }
        $(".cartImg>i").html(totolNum);
        $(".cartPrice>span>em").html("¥" + totolPrice.toFixed(2));

    }

    totalPrice();

    //选择方式
    $("body").on("click", ".cartType>span", function () {
        $(this).addClass("cart_typecur");
        $(".cartType>span").not($(this)).removeClass("cart_typecur");
        var distribution = $(this).data("type");
        $("input[name='distribution']").val(distribution);
        if ($(this).hasClass("store_gi")) {

            $(".cartPrice>p").show();
        } else {
            $(".cartPrice>p").hide();
        }
    });
</script>
<script>
    var index = 0;
    var length = $('.officeBox').children('.office').length;
    // transform: translate(-90%, 0) translateZ(0px);
    $(function () {
        $(".officeBox").on("touchstart", function (e) {
            // 判断默认行为是否可以被禁用
//          if (e.target.className === "right") {
//              return
//          }
//          if (e.target.tagName === "a") {
//              return
//          }
//          if (e.cancelable) {
//          	console.log(e.target)
//              // 判断默认行为是否已经被禁用
//              if (!e.defaultPrevented) {
//                  e.preventDefault();
//              }
//          }
            startX = e.originalEvent.changedTouches[0].pageX,
                startY = e.originalEvent.changedTouches[0].pageY;
        });
        $(".officeBox").on("touchend", function (e) {
            // 判断默认行为是否可以被禁用
//          if (e.target.className === "right") {
//              return
//          }
//          if (e.target.tagName === "a") {
//              return 
//          }
//          if (e.cancelable) {
//              // 判断默认行为是否已经被禁用
//              console.log(e.target)
//              if (!e.defaultPrevented) {
//                  e.preventDefault();
//              }
//          }
            moveEndX = e.originalEvent.changedTouches[0].pageX,
                moveEndY = e.originalEvent.changedTouches[0].pageY,
                X = moveEndX - startX,
                Y = moveEndY - startY;
            //左滑
            if (X > 0) {
                // alert('左滑');
                if (index != 0) {
                    index--
                    $(".officeBox").css({

                        'webkitTransform': 'translate(' + -90 * index + '%, 0) translateZ(0px)',

                        'transform': 'translate(' + -90 * index + '%, 0) translateZ(0px)'
                    });
                }
            }
            //右滑
            else if (X < 0) {
                // alert('右滑');
                if (index != length - 1) {
                    index++
                    $(".officeBox").css({

                        'webkitTransform': 'translate(' + -90 * index + '%, 0) translateZ(0px)',

                        'transform': 'translate(' + -90 * index + '%, 0) translateZ(0px)'
                    });
                }
            }
            //下滑
            else if (Y > 0) {
                // alert('下滑');
            }
            //上滑
            else if (Y < 0) {
                // alert('上滑');
            }
            //单击
            else {
                // alert('单击');
            }
        });
    })
</script>

<script type="text/javascript">
    var data = {
        valua: {
            food: [{
                type: 1
            },
                {
                    type: 2
                },
                {
                    type: 3
                },
                {
                    type: 4
                },
                {
                    type: 1
                },
            ],
            office: [{
                type: 1
            },
                {
                    type: 2
                },
                {
                    type: 3
                },
                {
                    type: 4
                },
                {
                    type: 1
                },
            ]
        }
    }
    $(function () {
        $("body").on("click", ".t_mes", function () {
            shop_comment(2);
        });

        //获得评论列表
        function shop_comment(comment_type, comment_cate = 0, object_id = 0) {
            var store_id = '<?php echo $this->router->get(1)?>';
            $.ajax({
                type: "post",
                url: "/shop_comment",
                data: {store_id: store_id, comment_type: comment_type, comment_cate: comment_cate, object_id: object_id},
                dataType: "json",
                success: function (data) {
                    var html = '';
                    if (data.data) {
                        $.each(data.data, function (key, value) {
                            var collectivity_score_desc = comment_cate == 1 || comment_cate == 0 ? '很满意' : (comment_cate == 2 ? '满意' : '一般');
                            html += '<div class="valua">' +
                                '<div class="img" >';
                            if (value.user_pic) {
                                html += '<img src="' + value.user_pic + '">';
                            }
                            html += '</div>' +
                                '<div class="other">' +
                                '<div class="nameBox">' +
                                '<div class="name">' + value.comment_user_name + '</div>' +
                                '<div class="time c_gray">' + value.comment_date + '</div>' +
                                '</div>' +
                                '<div class="goods c_gray">产品：' + value.product_name + ' </div>' +
                                '<div class="info">' +
                                '<span class="type c_orange">[' + collectivity_score_desc + ']</span>' + value.comment_content + '</div>';
                            if (value.comment_pic) {
                                html += '<div class="imgs"><img src="' + value.comment_pic + '" alt=""></div>';
                            }
                            html += '</div></div>';
                        });
                    }

                    if (comment_type == 2) {
                        $('.view .food>.info').html(html);
                    } else {
                        $('.view .office>.info').html(html);
                    }
                },
            });
        }

        //评价
        $('body').on('click', '.nav div', function () {
            var comment_type = $(this).attr('value');
            shop_comment(comment_type);
        })

        $('.nav>div').click(function () {
            var index = $(this).index();
            $(this).addClass('check').siblings().removeClass('check');
            $('.view>div').removeClass('check').eq(index).addClass('check');
        })
        $('.top .type').click(function () {
            var comment_type = $('.nav .check').attr("value");
            var comment_cate = $(this).attr("value");
            shop_comment(comment_type, comment_cate)
            $(this).addClass('check').siblings().removeClass('check');
            //var index = $(this).index();
            //var $this = $('.view .check');
            //$(this).addClass('check').siblings().removeClass('check');
            //$('.view .check').find('.valua').hide();
            /*
            switch (index) {
                case 0:
                    $this.find('.valua').show();
                    break;
                case 1:
                    $this.find('.valua[data-type = "1"]').show();
                    break;
                case 2:
                    $this.find('.valua[data-type = "2"]').show();
                    break;
                case 3:
                    $this.find('.valua[data-type = "3"]').show();
                    break;
                case 4:
                    $this.find('.valua[data-type = "4"]').show();
                    break;
            }
            */
        })
    })
</script>

<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>

<script type="text/javascript">
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

    // 分享的链接
    var shareContent = "<?php echo $this->router->get_url(); ?>";
    // 分享的标题
    var title = "<?php echo $a_view_data['store']['store_name']; ?>";
    // 分享的描述
    var content = "<?php echo $a_view_data['store']['store_introduction']; ?>";
    // 门店头像
    var store_touxiang = "<?php echo $a_view_data['store']['store_touxiang']; ?>";

    // 微信好友
    function weix_peyo() {
        var json = {
            "whatTypeShare": "wx",
            "whoToShare": "talk",
            "shareType": "url",
            "shareContent": shareContent,
            "title": title,
            "content": content,
            "imgurl": store_touxiang,
        }
        if (isiOS) {
            json = JSON.stringify(json);
            window.webkit.messageHandlers.vdao.postMessage({
                body: json,
                callback: '',
                command: 'shareToThirdApp'
            });
        } else if (isAndroid) {
            shareToThirdApp(json);
        }
    }

    // 微信朋友圈
    function weix_quan() {
        var json = {
            "whatTypeShare": "wx",
            "whoToShare": "friends",
            "shareType": "url",
            "shareContent": shareContent,
            "title": title,
            "content": content
        }
        if (isiOS) {
            json = JSON.stringify(json);
            window.webkit.messageHandlers.vdao.postMessage({
                body: json,
                callback: '',
                command: 'shareToThirdApp'
            });
        } else if (isAndroid) {
            shareToThirdApp(json);
        }
        ;
    }
</script>

<script type="text/javascript">
    $(function () {
        $('.shop_body .imgs>img').click(function () {
            var src = $(this).attr('src');
            $('.bg_gray').append('<img src="' + src + '" >').css('display', 'flex');
        });
        $('.bg_gray').click(function () {
            $(this).empty().hide();
        })
    })

</script>


<!--  订座板块  -->
<script>
    var seat_info = [];
    $(function () {
        //初始化座位状态
        function seat() {
            $.ajax({
                url: 'check_seat_occupy-<?php echo $a_view_data['store']['store_id']; ?>',
                type: 'GET',
                success: function (rs) {
                    if (rs.code == 200) {
                        $.each(rs.data, function (i, e) {
                            $('img[data-id=' + e.office_seat + ']').attr("src", "./static/rewrite/img/sa2.png");
                            $('img[data-id=' + e.office_seat + ']').attr("data-seat","2");
                        });
                    }
                }
            });

            var dataSeat = $(".seatList>td>img").attr("data-seat");
            $("img[data-seat='1']").attr("src", "./static/rewrite/img/sa1.png");//可选
            $("img[data-seat='2']").attr("src", "./static/rewrite/img/sa2.png");//不可选
            $("img[data-seat='3']").attr("src", "./static/rewrite/img/sa3.png");//已选
        }

        seat();
        //选择座位
        $(".seat_box .seatList>td>img").click(function () {

            var html = "";
            var seatId = $(this).attr("data-id");
            var rowNum = ($(this).parent().parent().index() + 1);// 行号
            var tableNum = ($(this).parent().index() + 1);//桌号
            var seatNum = ($(this).parent().children().not("i").index(this) + 1);//座位号

            var _this = $(this);
            // ajax获取座位是否被占用
            $.ajax({
                url: 'check_seat_occupy',
                type: 'POST',
                data: {office_seat: seatId, store_id: <?php echo $a_view_data['store']['store_id']; ?>},
                dataType: 'JSON',
                beforeSend: function () {
                    layer.msg('读取座位状态', {
                        icon: 16
                        , time: 0
                        , shade: 0.01
                    });
                },
                success: function (rs) {
                    if (rs.code == 200) {
                        // 座位状态正常
                        if (_this.attr("data-seat") == 1) { // 可选时的点击变为不可选
                            _this.attr("data-seat", "3");
                            _this.attr("src", "./static/rewrite/img/sa3.png");//已选
                            html += "<li data-id='" + seatId + "' data-row='" + rowNum + "' data-table='" + tableNum + "' data-seatType='" + seatNum + "'><span>" + rowNum + "排" + tableNum + "台" + seatNum + "座</span><img src='./static/rewrite/img/empty.png'/></li>";
                            _this.attr('text',rowNum + "排" + tableNum + "台" + seatNum + "座");
                        } else if (_this.attr("data-seat") == 3) {
                            _this.attr("data-seat", "1");
                            _this.attr("src", "./static/rewrite/img/sa1.png");//已选
                            //					$(".choice_seatBox>ul>li[data-row='"+rowNum+"'][data-table='"+tableNum+"'][data-seatType='"+seatNum+"']").remove();
                            $(".choice_seatBox>ul>li[data-id='" + seatId + "']").remove();
                        }
                        $(".choice_seatBox>ul").append(html);
                    } else {
                        // 座位被占用
                        _this.attr("src", "./static/rewrite/img/sa2.png");//已选
                    }
                    layer.closeAll();
                }
            });

            /* 点击添加属性方便后续删除辨认 */
            $(this).attr("data-row", rowNum);
            $(this).attr("data-table", tableNum);
            $(this).attr("data-seatType", seatNum);

// 				if( $(this).attr("data-seat")==1 ) { // 可选时的点击变为不可选
// 					$(this).attr("data-seat","3");
// 					html+="<li data-id='"+seatId+"' data-row='"+rowNum+"' data-table='"+tableNum+"' data-seatType='" +seatNum+"'><span>"+rowNum+"排"+tableNum+"台"+seatNum+"座</span><img src='./static/rewrite/img/empty.png'/></li>";
//
// 				}else if( $(this).attr("data-seat")==3 ){// 不可选时的点击变为可选
// 					$(this).attr("data-seat","1");
// //					$(".choice_seatBox>ul>li[data-row='"+rowNum+"'][data-table='"+tableNum+"'][data-seatType='"+seatNum+"']").remove();
// 					$(".choice_seatBox>ul>li[data-id='"+seatId+"']").remove();
// 				}
            seat();
        });

        $("body").on("click", ".choice_seatBox>ul>li>img", function () {
            var row = $(this).parent().attr("data-row");//获取行号
            var table = $(this).parent().attr("data-table");//获取桌号
            var seat = $(this).parent().attr("data-seatType");//获取座位号
            var seatId = $(this).parent().attr("data-id");//获取座位号
            /* 将上面的属性作为寻找的条件 */
//				$("img[ data-row='"+row+"'][data-table='"+table+"'][ data-seatType='"+seat+"' ]").attr("data-seat","1");
//				$("img[ data-row='"+row+"'][data-table='"+table+"'][ data-seatType='"+seat+"' ]").attr("src","./static/rewrite/img/sa1.png");
            $("img[ data-id='" + seatId + "']").attr("data-seat", "1");
            $("img[ data-id='" + seatId + "']").attr("src", "./static/rewrite/img/sa1.png");
            $(this).parent().remove();
        });

        // 点击确认选座按钮
        $('#sureSeat').click(function() {
           // 获取选座记录
           var seatBoxlists = $('.seat_suface').find('.seatList>td>img[data-seat=3]');
           var office_seat = [];
           var office_seatname = [];
           $.each(seatBoxlists, function (i, e) {
               office_seat.push($(this).data('id'));
               office_seatname.push($(this).attr('text'));
           });
           $('input[name=office_seat]').val(office_seat.join(','));
           $('input[name=office_seatname]').val(office_seatname.join(','));

           if (office_seat == '') {
               alert('请选择至少一个座位');
           }else{
               $('#seatform').submit();
           }

        });

        $(".seatList>td>img").each(function (i) {
            $(this).attr("data-id", i + 1);
        })
    });

</script>
<!--  订座板块  -->
