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
    <title>产品列表</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 咖啡列表  -->
    <div class="cafeList">
         <p class="pjoTitle" value="0">
            <a href="<?php echo $this->router->url('product_category')?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>新品热卖</span>
        </p>

        <!-- 咖啡种类 -->
        <div class="cafeType">
            <ul>
                <?php foreach ($a_view_data['prod'] as $prod) {?>
                <li>
                    <a href="<?php echo $this->router->url('item', [$this->router->get(1), $prod['product_id'], 0]);?>">
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
    </div>
    <!-- 咖啡列表  -->

    <!-- 底部 -->
    <form action="bill" class="iyyy" method="post">
    <div class="bottom">
        <div class="productPrice">
            <em class="yuan">
                <img src="static/style_default/images/bei_03.png" alt=""/>
                <!-- <i id="oute"></i> -->
            </em>
            <em class="priceBox">
                <span>￥<em id="poutt">0</em></span>
                <em>
                    <span>另需配送费</span><dfn>￥<?php echo $a_view_data['set']['set_parameter']?></dfn>
                </em>
            </em>
        </div>
        <input type="hidden" name="store" value="-1">
        <a href="login?oldurl=<?php echo $this->router->get_url(); ?>" class="totalBox">去结算</a>
         <script>
        $(".totalBox").click(function(){
            $(".iyyy").submit();
        })
        </script>
    </div>
    
    </form>
    <!-- 底部 -->
    

    <div class="lay"></div>
    
    <div class="tipsBox">

    </div>
</body>
</html>
<script>
   $(".choiceSpec").live("click",function(e){
        e.preventDefault();
        window.location.href="login?oldurl=<?php echo $this->router->get_url(); ?>";
    })
</script>