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
    <link rel="stylesheet" href="static/style_default/style/storePage.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/storePage.js"></script>
    <title></title>
</head>
<body>
    <!-- 头部 -->
    <div class="head">
        <p class="pjoTitle" value="<?php echo $this->router->get(1)?>">
            <a href="javascript:;" onclick="goback_app()"><img src="static/style_default/images/gouxiang_18.png" alt=""/></a>
            <em>
            	<a href="index"><img src="./static/style_default/images/homeHref.png" alt="" /></a>
                <a class="collection" href="login?oldurl=<?php echo $this->router->get_url(); ?>;"><img src="static/style_default/images/sIn_06.png" alt=""/></a>
                <a class="release share" href="login?oldurl=<?php echo $this->router->get_url(); ?>;"><img src="static/style_default/images/sd3.png" alt=""/></a>
            </em>
        </p>
         <div class="storeBox">
            <i><?php if (empty($a_view_data['store']['store_touxiang'])) {
                echo '<img src="./static/style_default/images/tou_03.png" />';
            } else {
                echo '<img src="'.$a_view_data['store']['store_touxiang'].'" />';
            } ?></i>
            <dl>
                <dt><?php echo $a_view_data['store']['store_name']; ?></dt>
                <dd>
                    <span>总评:</span><em><?php echo $a_view_data['all_score']; ?></em>&nbsp;
                    <span>服务:</span><em><?php echo $a_view_data['service_score']; ?></em>&nbsp;
                    <span>质量:</span><em><?php echo $a_view_data['goods_score']; ?></em>&nbsp;
                </dd>
                <dd>
                    <span>营业时间:</span>
                    <em><?php echo $a_view_data['store_open_time']; ?></em>
                </dd>
            </dl>
        </div>
        <a href="office_showlist-1-<?php echo $a_view_data['store']['store_id'];?>" class="meet"><img src="static/style_default/images/huyu_03.png" alt=""/></a>
    </div>
    <!-- 头部 -->
    <!-- 内容主体 -->
    <div class="storeContainer">
        <div class="navbar">
            <a href="list_store-<?php echo $this->router->get(1)?>" class="navCur">点餐</a>
            <a href="store_newcomment-<?php echo $this->router->get(1)?>">评价</a>
            <a href="store_newdetail-<?php echo $this->router->get(1)?>">商家</a>
            <span><a href="office_showlist-2-<?php echo $this->router->get(1);?>" class="seat">就餐订座</a></span>
        </div>
        <!-- 点餐-->
        <div class="order">
            <ul class="orderNav">
                <?php foreach ($a_view_data['pro'] as $pro) {?>
                    <li <?php if ($pro['pro_id'] == $this->router->get(2)) {
                      echo 'class="orderCur"';}?>><a href="<?php echo $this->router->url('list_store', [ $this->router->get(1), $pro['pro_id']]);?>"><?php echo $pro['pro_name']?></a>
                    </li>
                <?php }?>
                <li <?php if ($this->router->get(2) == 'i') {
                    echo 'class="orderCur"';}?>><a href="<?php echo $this->router->url('list_store', [ $this->router->get(1), 'i']);?>">套餐</a>
                </li>
            </ul>
            <dl class="orderList">
                <!-- <dt>挝的啡</dt> -->
                <?php foreach ($a_view_data['prod'] as $prod) {?>
                <dd>
                    <a href="<?php echo $this->router->url('item', [$this->router->get(2), $prod['product_id'], $this->router->get(1)]);?>">
                        <img src="<?php echo $prod['pro_img']?>" alt=""/>
                        <ul>
                        	<li>
                        		<em>
                                    <?php $i=0; if (!empty($prod['supply_time'])) {
                                        foreach (explode(",", $prod['supply_time']) as $time) {
                                           if (!empty($time) && in_array($time, $a_view_data['time'])) {?>    <?php $i=1;?>      
                                    <?php } } } ?>
                                    <?php if ($i != 1) {?>
                                        <?php foreach (explode(",", $prod['supply_time']) as $time) {foreach($a_view_data['time_name'] as $name) {if ($name['time_id'] == $time) {echo '<span>'.$name['time_nema'].'供应</span>';}}}?>
                                    <?php }?>
                                </em>
                        	</li>
                            <li>
                                <span><?php echo $prod['product_name']?></span>
                                
                            </li>
                            <li><?php echo strip_tags($prod['pro_details'])?></li>
                            <li>
                                <span>月售<em><?php echo $prod['number'] ? $prod['number']:0?></em></span>
                                <span>好评率<em><?php echo $prod['pingl'] ? $prod['pingl']:0?>%</em></span>
                            </li>
                            <li>
                                <span>￥<em><?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></em></span>起
                            </li>
                            <?php if (!empty($prod['supply_time'])) {
                                foreach (explode(",", $prod['supply_time']) as $time) {
                                   if (in_array($time, $a_view_data['time'])) {
                                    if ($prod['today_stock'] != 0) {?>
                            <li class="specBox" value="<?php echo $prod['product_id']?>"><?php if ($this->router->get(2) == 'i') {?>去选择<?php } else { ?>选规格<?php }?></li>                            
                            <?php } } } } else {if ($prod['today_stock'] != 0) {?>
                            <li class="specBox" value="<?php echo $prod['product_id']?>"><?php if ($this->router->get(2) == 'i') {?>去选择<?php } else { ?>选规格<?php }?></li>  
                            <?php } }?>
                        </ul>
                    </a>
                </dd>
                <?php }?>
            </dl>
        </div>
        <!-- 点餐-->
    </div>
    <!-- 内容主体 -->

    <!-- 底部 -->
    <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
        <input type="hidden" name="come_type" value="4">
        <div class="bottom">
            <div class="productPrice">
                <em class="yuan">
                    <img src="static/style_default/images/bei_03.png" alt=""/>
                    <i id="oute">0</i>
                </em>
                <em class="priceBox">
                    <span>￥<em id="poutt">0</em></span>
                    <em>
                        <span>另需配送费</span><dfn>￥0</dfn>
                    </em>
                </em>
            </div>
            <input type="hidden" name="store" value="0">
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
    <div class="shopCart"></div>
    <!-- 购物车 -->
    <!-- 提示 -->
    <div class="tips">
        <p>注意</p>
        <span>确定要清空购物车吗</span>
        <div class="tipsChoice">
            <a class="cancelClear">取消</a>
            <a class="sureClear" value="0">确定</a>
        </div>
    </div>
    <div class="tipsBox">

    </div>

    <!-- 提示 -->
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script type="text/javascript">
    //购物车
    function usorep() {
        var usore = '<?php echo $this->router->get(1)?>'
        $.ajax({
            type : 'post',
            url  : 'shop_inex',
            data : {usore:usore},
            dataType : 'json',
            success  : function(data) {
                if(data.code == 200) {
                    var out = 0;
                    for(var it in data.data.goods){
                        out += parseInt(data.data.goods[it].prot_count);
                    }
                    $('#oute').html(out);   
                    $('#poutt').text(data.data.pout);
                    if (data.data.pout > 0) {                            
                        $(".yuan>i").show();
                    };
                }
            }
        })
    }
    $(".specBox").live("click",function(e){
        e.preventDefault();
        window.location.href="login?oldurl=<?php echo $this->router->get_url(); ?>";
    })

    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

    // 回退到APP店铺列表
    function goback_app() {
        if (isAndroid) {
            webGoBackPagePress();
        } else if (isiOS) {
            window.webkit.messageHandlers.vdao.postMessage({
                body:'',
                callback:'',
                command:'webGoBackPagePress'
            });
        } else {
            window.location.href = "index";
        }
    }


    // 打开店铺位置
    function store_position() {
        var latitude = "<?php echo $a_view_data['detail']['store_latitude']; ?>";
        var longitude = "<?php echo $a_view_data['detail']['store_longitude']; ?>";
        var json = {"latitude":latitude,"longitude":longitude};
        if (isAndroid) {
            openStoreLocation(json);
        } else if (isiOS) {
            json = JSON.stringify(json);
            window.webkit.messageHandlers.vdao.postMessage({
                body    : json,
                callback: '',
                command : 'openStoreLocation'
            });
        }
    }
</script>
</body>

</html>