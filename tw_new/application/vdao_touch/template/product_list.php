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
    <link rel="stylesheet" href="static/style_default/style/allProduct.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/allProduct.js"></script>
    <script src="static/style_default/script/iscroll.js" type="text/javascript"></script>
    <script src="static/style_default/script/navbarscroll.js" type="text/javascript"></script>
    <title></title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <!-- 全部产品 -->
    <div class="allProduct">
        <div class="head">
            <?php if ($this->router->get(1) == 1) {?>
            <div class="searchBox">
                <a href="index" class="back"><img src="static/style_default/images/dri_03.png" alt=""/></a>
                <input type="text" id="search" placeholder="产品名称"/>
                <img src="static/style_default/images/search.png" alt=""/>
                <span class="goSearch">搜索</span>
            </div>
            <!-- 产品关键字搜索 -->
            <div class="productKeyContainer">
                <ul></ul>
            </div>
            <!-- 产品关键字搜索 -->
            </div>
            </div>
            <?php } else {?>
            <div class="searchBox">
                <a href="index" class="back"><img src="static/style_default/images/dri_03.png" alt=""/></a>
                <input type="text" id="search" placeholder="产品名称"/>
                <img src="static/style_default/images/search.png" alt=""/>
                <span class="goSearch">搜索</span>
            </div>
            <?php if ($this->router->get(5) == "") {?>
            <div class="wrapper wrapper01" id="retr">
                <div class="scroller">
                    <ul class="clearfix">
                        <?php if (empty($this->router->get(3))) {?>
                            <li class="current cur">
                            <?php if ($this->router->get(2) == 0) {?>
                            <a href="product_list-0">全部</a>                               
                            <?php } else {?>
                            <a href=""><?php foreach ($a_view_data['pron'] as $pron) {if($pron['pro_id'] == $this->router->get(2)) {echo $pron['pro_name'];}}?></a> 
                            <?php }?>
                            </li>
                            <?php foreach ($a_view_data['pron'] as $pron) {if ($pron['pro_id'] != $this->router->get(2)) {?>
                            <li><a href="product_list-0-<?php echo $pron['pro_id']?>"><?php echo $pron['pro_name']?></a></li>
                            <?php }}?>
                        <?php } else {if (empty($this->router->get(4))) {?>
                            <?php foreach ($a_view_data['pron'] as $pron) {?>
                                <li <?php if($this->router->get(3) == $pron['pro_id']) {echo 'class="cur"';}?>><a href="product_list-0-<?php echo $this->router->get(2)?>-<?php echo $pron['pro_id']?>"><?php echo $pron['pro_name']?></a></li>
                            <?php }?>
                        <?php } else {?>
                            <?php foreach ($a_view_data['pron'] as $pron) {?>
                                <li <?php if($this->router->get(4) == $pron['pro_id']) {echo 'class="cur"';}?>><a href="product_list-0-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $pron['pro_id']?>"><?php echo $pron['pro_name']?></a></li>
                            <?php }?>
                        <?php }}?>
                    </ul>
                </div>
            </div>
            <?php }?>
            <i class="cateDown"><img src="static/style_default/images/more.png" alt=""/></i>
            <!-- 产品关键字搜索 -->
            <div class="productKeyContainer">
                <ul></ul>
            </div>
            <!-- 产品关键字搜索 -->
        </div>

        <!-- 展开的分类 -->
        <div class="openCate">
            <p>
                <span>请选择分类</span>
                <img class="backDown" src="static/style_default/images/up.png" alt=""/>
            </p>
            <div class="cateContainer">
                <div class="cateL">
                    <ul>
                        <?php $i=0;foreach ($a_view_data['pront']['prot'] as $pront) {?>
                        <li <?php if (empty($this->router->get(2))) {
                        if($i == 0) {echo ' class="Lcur"';}$i++;} else { if ($this->router->get(2) == $pront['pro_id']) {echo ' class="Lcur"';}}?> value="<?php echo $pront['pro_id']?>"><a><?php echo $pront['pro_name']?></a></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="cateR">
                    <?php if (empty($a_view_data['pront']['second'])) {?>
                        <dl>
                            <dd class="Rcur">
                                <a href="product_list-0-<?php echo $a_view_data['pront']['prot'][0]['pro_id']?>">
                                <img src="static/style_default/images/pp_03.png" alt=""/>
                                <span>全部</span>
                                <!-- <em></em> -->
                                </a>
                            </dd>
                        </dl>
                    <?php } else { foreach ($a_view_data['pront']['second'] as $v => $second) {?>
                    <dl>
                        <dt><?php echo $second['pro_name']?></dt>
                        <dd class="Rcur">
                            <a href="product_list-0-<?php if (empty($this->router->get(2))) {echo $a_view_data['pront']['prot'][0]['pro_id'];} else {echo $this->router->get(2);}?>-<?php echo $second['pro_id']?>">
                            <img src="static/style_default/images/pp_03.png" alt=""/>
                            <span>全部</span>
                            <em><?php echo $a_view_data['pront']['yon'][$v]?></em>
                            </a>
                        </dd>
                        <?php foreach ($a_view_data['pront']['third'] as $k => $third) {
                            if ($second['pro_id'] == $third['pro_pid']) {?>
                        <dd class="">
                            <a href="product_list-0-<?php if (empty($this->router->get(2))) {echo $a_view_data['pront']['prot'][0]['pro_id'];} else {echo $this->router->get(2);}?>-<?php echo $second['pro_id']?>-<?php echo $third['pro_id']?>">
                            <img src="static/style_default/images/pp_03.png" alt=""/>
                            <span><?php echo $third['pro_name']?></span>
                            <em><?php echo $a_view_data['pront']['san'][$k]?></em>
                            </a>
                        </dd>
                        <?php }}?>
                    </dl>
                    <?php }}?>
                </div>
            </div>
        </div>
        <!-- 展开的分类 -->

        <div class="searchContainer">
            <form action="">
                <!-- 产品 -->
                <div class="productContainer">
                    <div class="productNav">
                        <ul>
                            <li class="productSort <?php if ($this->router->get(6) == 0 || $this->router->get(6) == 3) { echo "navCur"; }?>"><a><?php if ($this->router->get(6) == 3) {
                                echo "新产品"; } else {
                                    echo "综合排序";
                                }?>▾</a></li>
                            <li class="comment <?php if ($this->router->get(6) == 1) {
                                echo "navCur"; }?>"><a href="product_list-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $this->router->get(4)?>-<?php echo $this->router->get(5)?>-1-<?php echo $this->router->get(7)?>-<?php echo $this->router->get(8)?>-<?php echo $this->router->get(9)?>">好评优先</a></li>
                            <li class="distance <?php if ($this->router->get(6) == 2) {
                                echo "navCur"; }?>"><a href="product_list-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $this->router->get(4)?>-<?php echo $this->router->get(5)?>-2-<?php echo $this->router->get(7)?>-<?php echo $this->router->get(8)?>-<?php echo $this->router->get(9)?>">销量最高</a></li>
                            <li class="screen"><a>筛选</a></li>
                        </ul>
                        <!-- 排序 -->
                        <div class="sortContainer">
                            <ul>
                                <li <?php if ($this->router->get(6) == 0) {
                                echo "class='navCur'"; }?>><a href="product_list-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $this->router->get(4)?>-<?php echo $this->router->get(5)?>-0-<?php echo $this->router->get(7)?>-<?php echo $this->router->get(8)?>-<?php echo $this->router->get(9)?>">综合排序</a></li>
                                <li <?php if ($this->router->get(6) == 3) {
                                echo "class='navCur'"; }?>><a href="product_list-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $this->router->get(4)?>-<?php echo $this->router->get(5)?>-3-<?php echo $this->router->get(7)?>-<?php echo $this->router->get(8)?>-<?php echo $this->router->get(9)?>">新产品</a></li>
                            </ul>
                        </div>
                        <!-- 排序 -->
                        <!-- 筛选 -->
                        <div class="screenContainer">
                            <ul>
                                <li class="screenCate">
                                    <p>产品特色</p>
                                    <div class="tese">
                                        <a <?php if ( ! empty($this->router->get(9))) {echo "class='scCur'";}?>>达达配送</a>
                                        <input type="hidden" class="dada" value="<?php if ( ! empty($this->router->get(9))) {echo "1";} else {echo "0";}?>">
                                    </div>
                                </li>
                                <li class="screenPrice">
                                    <p>产品价格</p>
                                    <div class="priceBox">
                                        <input type="text" <?php if ( ! empty($this->router->get(7))) {echo 'value="'.$this->router->get(7).'"';} else {echo "placeholder='最低价'";}?> class="di" />
                                        <hr/>
                                        <input type="text" <?php if ( ! empty($this->router->get(8))) {echo 'value="'.$this->router->get(8).'"';} else {echo "placeholder='最高价'";}?> class="gao"/>
                                    </div>
                                </li>
                                <li class="screenBtn">
                                    <a class="reset">重置</a>
                                    <a class="complete">完成</a>
                                    <input type="hidden" value="product_list-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>-<?php echo $this->router->get(4)?>-<?php echo $this->router->get(5)?>-<?php echo $this->router->get(6)?>-" class="url">
                                </li>
                            </ul>
                        </div>
                        <!-- 筛选 -->
                    </div>
                    <!-- 产品列表 -->
                    <div class="productBox">
                        <ul>
                            <?php if (empty($a_view_data['goods'])) {
                                echo '<div class="noMore" style="font-size: 0.373333rem;color: #666666;text-align: center;line-height: 0.866666rem;">无此关键词产品</div>';
                            } else { foreach ($a_view_data['goods'] as $goods) {?>
                            <li class="productList">
                                <a href="item-<?php echo $goods['proid_id_1']?>-<?php echo $goods[0]?>-i">
                                    <img src="<?php echo get_config_item("goods_img") ."/". $goods['pro_img']?>" alt=""/>
                                    <em class="productContent">
                                        <h1><?php echo $goods['product_name']?></h1>
                                        <span><?php echo strip_tags($goods['pro_details'])?></span>
                                        <s>月售<span><?php if(empty($goods['number'])){echo "0";} else {echo $goods['number'];}?></span></s>
                                        <dfn>好评率<span><?php if (empty($goods['pingl'])) {
                                            echo "0";
                                        } else {echo $goods['pingl'];}?>%</span></dfn>
                                    </em>
                                    <?php if ($goods['goods_stye'] == 1) {?>
                                    <div class="productInfo">
                                        <span>自营</span>
                                        <em>达达配送</em>
                                    </div>
                                    <?php }?>
                                    <span class="productPrice">¥<em><?php echo $goods['money']?></em></span>
                                </a>
                            </li>
                            <?php }}?>
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
    <?php }?>
    <!-- 全部产品 -->

</body>
</html>
<script type="text/javascript">
    $(function(){
    	$(".cateContainer").height($(document).height());

        //demo示例一到四 通过lass调取，一句可以搞定，用于页面中可能有多个导航的情况
        $('.wrapper').navbarscroll();

        //demo示例五 通过id调取
        $('#demo05').navbarscroll({
            defaultSelect:6,
            endClickScroll:function(obj){
                console.log(obj.text())
            }
        });

        //demo示例六 通过id调取
        $('#demo06').navbarscroll({
            defaultSelect:3,
            scrollerWidth:6,
            fingerClick:1,
            endClickScroll:function(obj){
                console.log(obj.text())
            }
        });

         //定义一个总高度变量
        var totalHeight = 0;
        $(window).scroll(function(){
            //浏览器的高度加上滚动条的高度
            totalHeight =  parseFloat( $(window).height() ) +  parseFloat( $(window).scrollTop() );
            //当文档的高度小于或者等于总的高度时，开始动态加载数据
            if ( $(document).height() <= totalHeight ) {
                console.log(555);
                collection_goods();
            }
        })
    });
// 获取更多收藏的产品
var goods = 1;
function collection_goods() {
    var img = '<?php echo get_config_item("goods_img")?>';
    var i_one1 = '<?php echo $this->router->get(2);?>';
    var i_one2 = '<?php echo $this->router->get(3);?>';
    var i_one3 = '<?php echo $this->router->get(4);?>';
    var a_name = '<?php echo $this->router->get(5);?>';
    var i_order  = '<?php echo $this->router->get(6);?>';
    var i_pros_d = '<?php echo $this->router->get(7);?>';
    var i_pros_g = '<?php echo $this->router->get(8);?>';
    var i_dada   = '<?php echo $this->router->get(9);?>';
    goods++;
    $.ajax({
        url: 'product_list_page',
        type: 'POST',
        dataType: 'json',
        data: {page:goods,i_one1:i_one1,i_one2:i_one2,i_one3:i_one3,a_name:a_name,i_order:i_order,i_pros_d:i_pros_d,i_pros_g:i_pros_g,i_dada:i_dada},
        success: function(res) {
            if (res.code == 200) {
                // console.log(res.data);
                var html = '';
                $.each(res.data, function(index, el) {
                    html += '<li class="productList">';
                            html += '<a href="item-'+el.proid_id_1+'-'+el[0]+'-0">';
                            html += '<img src="'+img+'/'+el.pro_img+'" alt=""/>';
                            html += '<em class="productContent">';
                                html += '<h1>'+el.product_name+'</h1>';
                                html += '<span>'+el.pro_details+'</span>';
                                html += '<s>月售<span>';
                                if(el.number == null){
                                   html += 0;
                                } else {
                                   html += el.number;
                                }
                            html +=   '</span></s>';
                            html += '<dfn>好评率<span>';
                            if (el.pingl == null) {
                                       html += 0;
                                    } else {
                                        html += el.pingl;
                                    }
                            html += '%</span></dfn>';
                            html += '</em>';
                            if (el.goods_stye == 1) {
                            html += '<div class="productInfo">';
                                html += '<span>自营</span>';
                                html += '<em>达达配送</em>';
                            html += '</div>';
                            }
                            html += '<span class="productPrice">¥<em>'+el.money+'</em></span>';
                            html += '</a>';
                    html += '</li>';
                });
                $('.productBox ul').append(html);
            }
        }
    })
}
</script>