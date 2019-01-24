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
    <title><?php echo $a_view_data['product']['product_name'] ?></title>
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
	.footer{
		/*position: fixed;*/
	}
    .body {
        display: block;
    }
</style>

<body>
<div class="box" style="position: relative; ">

    <div class="body">
        <div id='mySwipe' class='swipe'>
            <div class='swipe-wrap'>
                <div><img src="<?php echo $a_view_data['product']['pro_img']; ?>"></div>
            </div>
            <div class="row">
                <div class="back" onclick="history.go(-1);"></div>
                <div class="share"></div>
            </div>
            <div class="row2">
                <i class="coll <?php if ($a_view_data['collection'] == 1) echo 'coll_type' ?>"><img width="33"
                                                                                                    height="33"
                                                                                                    src="./static/rewrite/img/<?php echo $a_view_data['collection'] == 2 ? 'like' : 'syyh' ?>.png"
                                                                                                    alt=""/></i>
            </div>
            <div class="index">
            </div>
        </div>
        <div class="info">
            <div class="price c_orange">￥<?php echo $a_view_data['product']['min_price'] ?>起</div>
            <div class="nameBox">
                <div class="name"><?php echo $a_view_data['product']['product_name'] ?></div>
                <div class="shop choiceType" value="<?php echo $a_view_data['product']['product_id']; ?>"> 加入购物车</div>
            </div>
            <div class="star c_orange">⭐⭐⭐⭐⭐4.8</div>
        </div>
        <div class="describe">
            <div class="top">产品描述</div>
            <p> <?php echo $a_view_data['product']['pro_details']; ?></p>
        </div>
        <div class="valuation">

            <div class="top">
                <div class="left">评价</div>
            </div>
            <div class="valuaBox">

            </div>
        </div>
    </div>


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
               <?php if($this->router->get(3) !=0){?> <span data-type="2" class="">门店自取</span><?php }?>
            </div>
            <div class="cartPrice">
                <span>总计 :<em>¥88.00</em></span>
                <p>配送费<span><?php echo $a_view_data['set']['set_parameter'] ?></span>元</p>
            </div>
        </div>


        <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" id="myform" method="post">
            <input type="hidden" name="come_type" value="4">
            <input type="hidden" name="oldurl" value="<?php echo $this->router->get_url(); ?>">
             <input type="hidden" name="distribution" value="1">
            <input type="hidden" name="store" value="<?php echo $this->router->get(3); ?>">
            <a href="javascript:;" class="banc">结算</a>
            <script>
                $(".banc").click(function () {
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
        <span>¥<?php echo $a_view_data['product']['min_price'] ?></span>
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

    $('.price .right').click(function () {
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

        var product_id = "<?php echo $this->router->get(2);?>";
        $.ajax({
            url: 'item_colle',
            type: 'POST',
            dataType: 'json',
            data: {goods: product_id},
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

    blance();

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
    /*
    $("body").on("click", ".body .nameBox>.shop", function () {
        $(".lay").show();
        $(".type_box").show();
        loopType($(this));
    });
    */

    //购物车显示的数量
    function shopCart_num() {
        var sopListLen = $(".shop_list_box>li").length
        $(".cartImg>i").html(sopListLen);
    }

    $(".type_list>li").each(function (i) {
        $(this).addClass("type_" + i);
    })


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
                var html = '<dt><span><?php echo $a_view_data['product']['product_name']?></span><img class="closeType" src="./static/rewrite/img/y_03.png" alt=""/></dt>';
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

        var product_id = $('.product_id').attr('value');//product_id
        // alert(product_id);return;
        //var manoe = $(this).parent().find("#manoe").text();
        // manoe = manoe.slice(1, manoe.length);
        var price = $(this).prev().find("span").html().substring(1);//price
        //var shuxi = $('#xuic').attr('value');
        var goods_spec = $('.type_info p').text();//属性: 大中小/冷热/咸淡 这种方式
        //var tost  = $('.pjoTitle').attr('value');
        var store_id = '<?php echo $this->router->get(3)?>';//store_id
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
        var store_id = '<?php echo $this->router->get(3)?>'
        $.ajax({
            type: 'post',
            url: 'shop_inex',
            data: {usore: store_id},
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
        var stoue = '<?php echo $this->router->get(3);?>';
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
        var stou = '<?php echo $this->router->get(3)?>';//应该是store_id
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
        var stou = '<?php echo $this->router->get(3)?>';//应该是store_id
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
             var distribution = $(this).data("type");
        $("input[name='distribution']").val(distribution);
        $(".cartType>span").not($(this)).removeClass("cart_typecur");
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
            if (e.targer.className === "right") {
                return
            }
            if (e.cancelable) {
                // 判断默认行为是否已经被禁用
                if (!e.defaultPrevented) {
                    e.preventDefault();
                }
            }
            startX = e.originalEvent.changedTouches[0].pageX,
                startY = e.originalEvent.changedTouches[0].pageY;
        });
        $(".officeBox").on("touchend", function (e) {
            // 判断默认行为是否可以被禁用
            if (e.targer.className === "right") {
                return
            }
            if (e.cancelable) {
                // 判断默认行为是否已经被禁用
                if (!e.defaultPrevented) {
                    e.preventDefault();
                }
            }
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
        var product_id = '<?php echo $this->router->get(2)?>';
        shop_comment(2, 0, product_id);

        //获得评论列表
        function shop_comment(comment_type, comment_cate = 0, object_id = 0) {
            var store_id = '<?php echo $this->router->get(3)?>';
            $.ajax({
                type: "post",
                url: "/shop_comment",
                data: {
                    store_id: store_id,
                    comment_type: comment_type,
                    comment_cate: comment_cate,
                    object_id: object_id
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);
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


                    $('.valuaBox').html(html);

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

    //分享
    $("body").on("click", ".share", function () {
        share()
    });

    //分享
    function share() {
        $(".lay").show();
        $(".share_botBox").slideDown(100);
    }

</script>
