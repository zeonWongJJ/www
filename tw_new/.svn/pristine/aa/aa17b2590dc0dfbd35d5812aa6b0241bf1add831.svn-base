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
                        <img src="<?php echo $prod['pro_img']?>" alt=""/>
                        <ol>
                            <li class="typeName">
                                <h1><?php echo $prod['product_name']?></h1>
                                <em>
                                    <?php $i=0; if (!empty($prod['supply_time']) && !empty($a_view_data['time']) ) {
                                        foreach (explode(",", $prod['supply_time']) as $time) {
                                           if ( ! empty($time) && in_array($time, $a_view_data['time'])) {?>    <?php $i=1;?>      
                                    <?php } } } ?>
                                    <?php if ($i != 1) {?>
                                        <?php foreach (explode(",", $prod['supply_time']) as $time) {foreach($a_view_data['time_name'] as $name) {if ($name['time_id'] == $time) {echo '<span>'.$name['time_nema'].'供应</span>';}}}?>
                                    <?php }?>
                                </em>
                            </li>
                            <li class="typeText">
                                <p>
                                    <?php echo strip_tags($prod['pro_details'])?>
                                </p>
                            </li>
                            <li class="typeDetail">
                               <font><em>￥<?php $i = 0; foreach ($a_view_data['cup'] as $cup) {if ($prod['product_id'] == $cup['product_id']) {if ($i == 0) {echo $cup['price'];}$i++;}}?></em><span>起</span></font>
                                <em>月售<span><?php echo $prod['number']?$prod['number']: 0?></span></em>
                                <span>好评 率<em><?php echo $prod['pingl']?$prod['pingl']:0?>%</em></span> 
                                <dfn class="choiceSpec" value="<?php echo $prod['product_id']?>">
                                    <?php if (!empty($prod['supply_time']) && !empty($a_view_data['time'])) {$i=1;
                                       foreach (explode(",", $prod['supply_time']) as $time) { 
                                           if (in_array($time, $a_view_data['time'])) {if($i == 1){?>
                                        <span><?php if ($this->router->get(1) == 'i') {echo "去选择";} else {echo "选规格";}?></span>         
                                    <?php  $i++;} } } } else {?>
                                        <span><?php if ($this->router->get(1) == 'i') {echo "去选择";} else {echo "选规格";}?></span>  
                                    <?php } ?>
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
    <form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
    <input type="hidden" name="come_type" value="4">
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
    
    </form>
    <!-- 底部 -->
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
        $(".choiceSpec").live("click",function(e){
            e.preventDefault();
            window.location.href="login?oldurl=<?php echo $this->router->get_url(); ?>";
        })
    </script>
</body>
</html>