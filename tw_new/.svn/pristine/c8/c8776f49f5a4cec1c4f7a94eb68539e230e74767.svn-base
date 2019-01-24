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
    <script src="static/style_default/script/cafeList.js"></script>
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
                     <!-- 规格 -->
                    <div class="spec li_<?php echo $prod['product_id']?>">
                        <p id="goodsid" value="<?php echo $prod['product_id']?>"><?php echo $prod['product_name']?></p>
                        <img class="closeSpec" src="static/style_default/images/y_03.png" alt=""/>
                        <div class="cupSize">
                            <p>杯型：</p>
                            <?php $i = 0;
                                foreach ($a_view_data['pric'] as $v => $pric) {
                                if ($pric['product_id'] == $prod['product_id']) {?>
                                <a value="<?php echo $pric['cup_id']?>" <?php if ($i == 0) {echo 'class="cupCur"';}?>><span value="<?php echo $pric['cup_name']?>"><?php echo $pric['cup_name']?></span></a>
                            <?php $i++ ;}}?>
                        </div>
                        <?php $s = 0;foreach ($a_view_data['att'] as $v => $att) {
                            if ($att['product_id'] == $prod['product_id']) {?>
                        <div class="temperature shux_<?php echo $s; $s++;?>">
                            <p><?php foreach ($a_view_data['attr'] as $attr) {if ($att['stye'] == $attr['attri_id']) {echo $attr['attri_name'];}}?>：</p>
                            <?php $i = 0;foreach ($a_view_data['attr'] as $attr) {
                               if ( ! empty($att['attri_id']) && in_array($attr['attri_id'], explode(",", $att['attri_id']))){?>
                                <a <?php if ($i == 0) {echo 'class="terCur"';} ?> id="goods_<?php echo $att['stye']?>" value="<?php echo $att['stye']?>">
                                    <span><?php echo $attr['attri_name']?></span>
                                </a>
                            <?php $i++;}}?>
                        </div>
                        <?php }}?>
                        <div class="shopPrice">
                            <span id="ouate">￥<?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></span>(<em></em><dfn></dfn><s style="text-decoration:none;"></s>)
                        </div>
                        <input type="hidden" id="xuic" value="" class="">
                        <a class="cart">加入购物车</a>
                    </div>
                    <!-- 规格 -->
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
    <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
    <input type="hidden" name="come_type" value="4">
    <div class="bottom">
        <div class="productPrice">
            <em class="yuan">
                <img src="static/style_default/images/bei_03.png" alt=""/>
                <i id="oute"></i>
            </em>
            <em class="priceBox">
                <span>￥<em id="poutt"></em></span>
                <em>
                    <span>另需配送费</span><dfn>￥<?php echo $a_view_data['set']['set_parameter']?></dfn>
                </em>
            </em>
        </div>
        <input type="hidden" name="store" value="<?php echo $this->router->get(1)?>">
        <a href="javascript:;" class="totalBox">去结算</a>
         <script>
        $(".totalBox").click(function(){
            $(".iyyy").submit();
        })
        </script>
    </div>
    </form>
    <!-- 底部 -->
    <!-- 购物车 -->
    <div class="shopCart">
    </div>
    <!-- 购物车 -->

    <div class="lay"></div>
    <!-- 提示 -->
    <div class="tips">
        <p>注意</p>
        <span>确定要清空购物车吗</span>
        <div class="tipsChoice">
            <a class="cancelClear">取消</a>
            <a class="sureClear" value="<?php echo $this->router->get(1)?>">确定</a>
        </div>
    </div>
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
        function qinh() {
            $(".tips").show(100);
        }
        //购物车增加
        function add(cart_id) {
            //门店id
            var stou = $('.pjoTitle').attr('value');
            var outt = $("#ou_"+cart_id).text();
            // console.log(outt);
            $.ajax({
                type : 'post',
                url  : '<?php echo $this->router->url('shop_reudaa');?>',
                data : {id:cart_id,stou:stou,vart:1},
                dataType : 'json',
                success  : function(data) {
                    if (data.code == 200) {
                        outt = parseInt(outt) + 1;
                        $('#ou_'+cart_id).html(outt);
                        usorep();
                    };
                }
            })
        }
        //购物车减少
        function reduce(cart_id) {
            //门店id
            var stou = $('.pjoTitle').attr('value');
            var outt = $("#ou_"+cart_id).text();
                oupp = parseInt(outt) - 1;
                if (oupp <= 0) {
                    $.ajax({
                        type : 'post',
                        url  : '<?php echo $this->router->url('shop_dele');?>',
                        data : {id:cart_id},
                        dataType : 'json',
                        success  : function(data) {
                            if (data.code == 200) {
                                $('.html_'+cart_id).remove();
                                 usorep();
                            };
                        }
                    }) 
                } else {
                    $.ajax({
                        type : 'post',
                        url  : '<?php echo $this->router->url('shop_reudaa');?>',
                        data : {id:cart_id,stou:stou,vart:2},
                        dataType : 'json',
                        success  : function(data) {
                            if (data.code == 200) {
                                $('#ou_'+cart_id).html(oupp);
                                usorep();
                            };
                        }
                    })                    
                };
        }
        //购物车
        function usorep() {
            var usore = $('.pjoTitle').attr('value');
            $.ajax({
                type : 'post',
                url  : 'shop_inex',
                data : {usore:usore},
                dataType : 'json',
                success  : function(data) {
                    if(data.code == 200) {
                        var out = 0;
                        var money = 0;
                        for(var it in data.data.goods){
                            out += parseInt(data.data.goods[it].prot_count);
                        }
                        // console.log(out);
                        $('#oute').html(out);   
                        $('#poutt').text(data.data.pout);
                    }
                }
            })
        }
    </script>
</body>
</html>