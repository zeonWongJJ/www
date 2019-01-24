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
    <link rel="stylesheet" href="static/style_default/style/packageChoice.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/packageChoice.js"></script>
    <title>套餐</title>
</head>
<body>
    <!-- 头部 -->
    <?php if ($this->router->get(1) == 0) {?>
    <p class="pjoTitle" value="0">
        <a href="list-i"><img src="static/style_default/images/yongping_03.png" alt=""></a>
        <span>套餐热卖</span>
    </p>
    <?php } else {?>
    <div class="head">
        <p class="pjoTitle" value="<?php echo $this->router->get(1)?>">
            <a href="list_store-<?php echo $this->router->get(1)?>"><img src="static/style_default/images/gouxiang_18.png" alt=""/></a>
            <em>
                <a class="release share" ><img src="static/style_default/images/sIn_06.png" /></a>
                <a class="collection <?php if ($a_view_data['collection'] == 1) { echo 'coll'; } ?>">
                <?php if ($a_view_data['collection'] == 2) {
                    echo '<img src="./static/style_default/images/sd3.png" />';
                } else {
                    echo '<img src="./static/style_default/images/coll_03.png" />';
                } ?>
                </a>
            </em>
        </p>
         <div class="storeBox">
            <i><?php if (empty($a_view_data['store']['store_touxiang'])) {
                echo '<img src="./static/style_default/images/tou_03.png" />';
            } else {
                echo '<img src="'.$a_view_data['store']['store_touxiang'].'" />';
            } ?></i>
            <dl>
                <dt id="store_name"><?php echo $a_view_data['store']['store_name']; ?></dt>
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
        <a href="" class="meet"><img src="static/style_default/images/huyu_03.png" alt=""/></a>
    </div>
    <div class="navbar">
        <a href="list_store-<?php echo $this->router->get(1)?>" class="navCur">点餐</a>
        <a href="store_newcomment-<?php echo $this->router->get(1)?>">评价</a>
        <a href="store_newdetail-<?php echo $this->router->get(1)?>">商家</a>
        <span><a href="" class="seat">就餐订座</a></span>
    </div>
    
    <?php }?>
    <!-- 头部 -->
    <!-- 内容主体 -->
    <div class="storeContainer">

        <!-- 选项导航 -->
        <div class="choiceNav">
            <?php $i =0; foreach(explode(",", $a_view_data['meal']['group_product']) as  $v => $goods) {?>
                <a <?php if ($i == 0) {
                   echo 'class="chCur"';
                } $i++;?>>
                <?php echo $v+'1'?>
                </a>
            <?php }?>
        </div>
        <!-- 选项导航 -->

        <!-- 点餐-->
        <div class="order">
            <?php foreach(explode(",", $a_view_data['meal']['group_product']) as  $v => $goods) {?>
            <dl class="orderList <?php if ($v == 0) {
               echo "orderCur";
            }?>">
                <?php foreach (explode("-", $goods) as $product) {
                    foreach($a_view_data['prod'] as $prod){
                        if ($product == $prod['product_id']) {
                            foreach (explode(",", $prod['supply_time']) as $time) {
                                if (in_array($time, $a_view_data['time'])) {
                                ?>
                <dd>
                    <a>
                        <img src="<?php echo $prod['pro_img']?>" alt=""/>
                        <ul>
                            <li>
                                <span><?php echo $prod['product_name']?></span>
                                <em>

                                </em>
                            </li>
                            <li><?php echo strip_tags($prod['pro_details'])?></li>
                            <li>
                                <span>月售<em><?php echo $prod['number']?$prod['number']:0?></em></span>
                                <span>好评率<em><?php echo $prod['pingl']?$prod['pingl']:0?>%</em></span>
                            </li>
                            <li>
                                
                            </li>
                            <li class="specBox">选规格</li>
                        </ul>
                    </a>
                    <!-- 规格 -->
                    <div class="spec">
                        <p><?php echo $prod['product_name']?></p>
                        <img class="closeSpec" src="images/y_03.png" alt=""/>
                        <div class="choiceBox">
                            <ul>
                                <li class="choiceList">
                                    <p>杯型</p>
                                    <?php $i = 0;
                                        foreach ($a_view_data['pric'] as $pric) {
                                        if ($pric['product_id'] == $prod['product_id']) {?>
                                        <a <?php if ($i == 0) {echo 'class="choiceCur"';}?>><span><?php echo $pric['cup_name']?></span></a>
                                    <?php $i++ ;}}?>
                                </li>
                                <?php $s = 0;foreach ($a_view_data['att'] as $v => $att) {
                                    if ($att['product_id'] == $prod['product_id']) {?>
                                    <li class="choiceList">
                                        <p><?php foreach ($a_view_data['attr'] as $attr) {if ($att['stye'] == $attr['attri_id']) {echo $attr['attri_name'];}}?>：</p>
                                        <?php $i = 0;foreach ($a_view_data['attr'] as $attr) {
                                           if ( ! empty($att['attri_id']) && in_array($attr['attri_id'], explode(",", $att['attri_id']))){?>
                                            <a <?php if ($i == 0) {echo 'class="choiceCur"';} ?>>
                                                <span><?php echo $attr['attri_name']?></span>
                                            </a>
                                        <?php $i++;}}?>  
                                    </li>
                                <?php }}?>
                            </ul>
                        </div>
                        <div class="sureSpec">
                            <a>选好了</a>
                        </div>
                    </div>
                    <!-- 规格 -->
                </dd>
                <?php }}}}};?>
            </dl>
            <?php }?>
        </div>
        <!-- 点餐-->

    </div>
    <!-- 内容主体 --> 
    <input type="hidden" id="goods" value="<?php echo $this->router->get(2)?>"> 
    <input type="hidden" id="price" value="<?php echo $a_view_data['meal']['price']?>"> 
    <input type="hidden" id="name" value="<?php echo $a_view_data['store']['store_name'];?>"> 
    <!-- 底部 -->
    <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
        <input type="hidden" name="come_type" value="4">
        <input type="hidden" id="orst" name="store" value="<?php echo $this->router->get(1); ?>">
    <div class="bottom">
        <a class="packageSpan"></a>
        <a class="joinCart">加入购物车</a>
        <a class="totoal">结算 </a>
    </div>
        <script>
            $(".jiesuan").live("click", function() {
                $(".iyyy").submit();
            })
        </script>
    </form>
    <!-- 底部 -->

    <div class="lay"></div>

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

    <!--遮罩层开始-->
    <div class="shade"></div>
    <!--遮罩层结束-->

</body>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) { ?>
    <script type="text/javascript" src="https://cordova.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://qiduvdaolink.js"></script>
<?php } ?>
<script>
    $(".order>dl").not( $(".orderCur")).hide();
    $(".order>dl").each(function(i){
        $(this).addClass("c"+i);
    });
    $(".choiceNav>a").click(function(){
        var $this=$(this);
        $(this).addClass("chCur");
        $(".choiceNav>a").not($(this)).removeClass("chCur");
        if( $this.index()==$this.index() ){
            $(".c"+$this.index()).show();
            $(".c"+$this.index()).addClass("orderCur");
            $(".order>dl").not( $(".c"+$this.index())).hide();
            $(".order>dl").not( $(".c"+$this.index())).removeClass("orderCur");
        }
    });

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
        var latitude = "<?php echo $a_view_data['store']['store_latitude']; ?>";
        var longitude = "<?php echo $a_view_data['store']['store_longitude']; ?>";
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
</html>