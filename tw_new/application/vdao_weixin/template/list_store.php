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
    <link rel="stylesheet" href="static/style_default/style/cafeList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <!-- // <script src="static/style_default/script/cafeList.js"></script> -->
    <script src="static/style_default/script/iscroll.js" type="text/javascript"></script>
    <script src="static/style_default/script/navbarscroll.js" type="text/javascript"></script>
    <title>门店产品列表</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 咖啡列表  -->
    <div class="cafeList">
        <p class="pjoTitle" value="<?php echo $this->router->get(1)?>">
            <input type="hidden" id="store_name" value="<?php echo $a_view_data['store']['store_name']?>">
            <a href="store_detail-<?php echo $this->router->get(1)?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span><?php echo $a_view_data['store']['store_name']?></span>
        </p>
        <!-- 导航 -->
        <div class="wrapper wrapper01" id="retr">
            <div class="scroller">
                <ul class="clearfix">
                    <?php foreach ($a_view_data['pro'] as $pro) {?>
                       <li><a href="<?php echo $this->router->url('list_store', [ $this->router->get(1), $pro['pro_id']]);?>"><?php echo $pro['pro_name']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- 导航 -->

        <!-- 咖啡种类 -->
        <div class="cafeType">
            <ul>
                <?php foreach ($a_view_data['prod'] as $prod) {?>
                <li>
                    <a href="<?php echo $this->router->url('item', [$this->router->get(2) ? $this->router->get(2) : $a_view_data['pro'][0]['pro_id'], $prod['product_id'], $this->router->get(1)]);?>">
                        <img src="<?php echo get_config_item('goods_img')?>/<?php echo $prod['pro_img']?>" alt=""/>
                        <ol>
                            <li class="typeName">
                                <h1><?php echo $prod['product_name']?></h1>
                                <font><em>￥<?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></em><span>起</span></font>
                            </li>
                            <li class="typeText">
                                <p>
                                    <?php echo strip_tags($prod['pro_details'])?>
                                </p>
                            </li>
                            <li class="typeDetail">
                                <em></em>
                               <!--  <em>月售<span>3</span></em>
                                <span>好评 率<em>100%</em></span>-->
                                <dfn class="choiceSpec" value="<?php echo $prod['product_id']?>">
                                    <span>选规格</span>
                                    <!-- <i>2</i> -->
                                </dfn>
                            </li>
                        </ol>
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
        <!-- 咖啡种类 -->
        <!-- 地址区域 -->
        <div class="addressInfo">
            <div class="storeInfo">
                <a class="address">
                    <img src="static/style_default/images/ca_03.png" alt=""/>
                    <span><?php echo $a_view_data['store']['store_address']?></span>
                    <i><img src="static/style_default/images/shezhi_03.png" alt=""/></i>
                </a>
                <a class="businessTime">
                    <img src="static/style_default/images/ca_10.png" alt=""/>
                    <span>营业时间:<em><?php echo $a_view_data['imte']['set_parameter']?></em></span>
                </a>
            </div>
            <div class="storePhone">
                <a href="tel:<?php echo $a_view_data['store']['store_tel']?>"><img src="static/style_default/images/ca_06.png" alt=""/></a>
            </div>
        </div>
        <!-- 地址区域 -->
    </div>
    <!-- 咖啡列表  -->

    <!-- 底部 -->
    <div class="bottom">
        <div class="productPrice">
            <em class="yuan">
                <img src="static/style_default/images/bei_03.png" alt=""/>
                <!-- <i id="oute"></i> -->
            </em>
            <em class="priceBox">
                <span>￥<em>0</em></span>
                <em>
                    <span>另需配送费</span><dfn>￥<?php echo $a_view_data['set']['set_parameter']?></dfn>
                </em>
            </em>
        </div>
        <a href="login?oldurl=<?php echo $this->router->get_url(); ?>" class="totalBox">去结算</a>
        </script>
    </div>
    <!-- 底部 -->

    <div class="lay"></div>
    <!-- 提示 -->
  <!--   <div class="tips">
        <p>注意</p>
        <span>确定要清空购物车吗</span>
        <div class="tipsChoice">
            <a class="cancelClear">取消</a>
            <a class="sureClear">确定</a>
        </div>
    </div> -->
    <div class="tipsBox">

    </div>
    <!-- 提示 -->
    <script type="text/javascript">
        $(function(){
            $('.wrapper').navbarscroll();
            $('#demo05').navbarscroll({
                defaultSelect:6,
                endClickScroll:function(obj){
                    console.log(obj.text())
                }
            });

            $('#demo06').navbarscroll({
                defaultSelect:3,
                scrollerWidth:6,
                fingerClick:1,
                endClickScroll:function(obj){
                    console.log(obj.text())
                }
            });
        });
        $(".choiceSpec").live("click",function(e){
            e.preventDefault();
            window.location.href="login?oldurl=<?php echo $this->router->get_url(); ?>";
        })
    </script>
</body>
</html>