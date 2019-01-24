<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>分类列表 - 7度购保健品商城</title>
	<meta name="description" content="7度购保健品商城,分类列表，搜索"/>
	<meta name="keywords" content="保健品商城,保健品网,营养保健品,健康产品,保健食品,保健品"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/iconfont.css">
    <link rel="shortcut icon" href="image/bitbug_favicon.ico" />
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plus.js"></script>
    <script src="js/common.js"></script>
</head>
	<style>
		body,html{margin:0;padding: 0;}
	</style>
<body>
    <div id="classify">
        <?php $this->display('header', $a_view_data['cate']);?>
        <section>
            <div class="selector">
                <header class="section_nav_bar">
                <div>
                    <div>
                        <img src="image/icon_home.png" alt="">
                        <span><a href="<?php echo get_config_item('domain'); ?>">首页</a></span>
                        <span>></span>
                        <span class="header_second">全部</span>
                        <span>></span>
                        <span class="header_thrid">全部</span>
                    </div>
                </div>
                </header>
                <section>
                    <div class="selector_0">
                        <ul>
                            <?php $url = $a_view_data['url'];$url['third'] = 0;$url['brand'] = 0;$url['type'] = 0;
                                foreach ($a_view_data['search_cate']['second'] as $key => $value){
                                    $url['cate_id'] = $value['gc_id'];
                             ?>
                                <li <?php 
                                if ($a_view_data['url']['cate_id'] == ""){
                                    if($key == 0){
                                        $a_view_data['url']['cate_id'] = $value['gc_id'];
                                        echo 'class="active"';
                                    }
                                } else {
                                    if ($a_view_data['cate_id'] == $value['gc_id']){echo 'class="active"';}
                                }
                                 ?>>
                                    <a href="<?php echo $this->router->url('search', $url); ?>">
                                        <?php echo $value['gc_name']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                     <div class="selector_1 thrid">
                        <span>分类：</span>
                        <ul>
                            <li class="<?php $url_third = $a_view_data['url']; if($a_view_data['search']['third'] == 0){echo 'active';} ?>"><a href="<?php $url_third['third'] = 0;echo  $this->router->url('search', $url_third); ?>">全部</a></li>
                            <?php if(is_array($a_view_data['search_cate']['third'])){
                                    foreach ($a_view_data['search_cate']['third'] as $key => $value) {
                                        $url_third['third'] = $value['gc_id'];
                                        $value['gc_id'] == $a_view_data['url']['third'] ? $active = "active" : $active = "";
                                        echo '<li class="' . $active . '"><a href="' . $this->router->url('search', $url_third) . '">' . $value['gc_name'] . '</a></li>';
                                    } 
                                } ?>
                        </ul>
                    </div>
                    <!-- <div class="selector_1 type">
                        <span>类型：</span>
                        <ul>
                            <li class="<?php $url_type = $a_view_data['url']; if($a_view_data['search']['type'] == 0){echo 'active';} ?>"><a href="<?php $url_type['type'] = 0;echo  $this->router->url('search', $url_type); ?>">全部</a></li>
                            <?php if(is_array($a_view_data['search_cate']['type'])){
                                    foreach ($a_view_data['search_cate']['type'] as $key => $value) {
                                        $url_type['type'] = $value['type_id'];
                                        $value['type_id'] == $a_view_data['url']['type'] ? $active = "active" : $active = ""; 
                                        echo '<li class="' . $active . '"><a href="' . $this->router->url('search', $url_type) . '">' . $value['type_name'] . '</a></li>';
                                    } 
                                } ?>
                        </ul>
                    </div> -->
                    <div class="selector_1 brand">
                        <span>品牌：</span>
                        <ul>
                            <li class="<?php $url_brand = $a_view_data['url']; if($a_view_data['search']['brand'] == 0){echo 'active';} ?>"><a href="<?php $url_brand['brand'] = 0;echo  $this->router->url('search', $url_brand); ?>">全部</a></li>
                            <?php if(is_array($a_view_data['search_cate']['brand'])){
                                    foreach ($a_view_data['search_cate']['brand'] as $key => $value) {
                                        $url_brand['brand'] = $value['brand_id'];
                                        $value['brand_id'] == $a_view_data['url']['brand'] ? $active = "active" : $active = "";
                                        echo '<li class="' . $active . '"><a href="' . $this->router->url('search', $url_brand) . '">' . $value['brand_name'] . '</a></li>';
                                    } 
                                } ?>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="classify_list">
                <div class="classify_bar">
                    <div>
                        <ul>
                            <li <?php $url_order = $a_view_data['url'];
                                $url_order['order'] <= 1 ? $url_order['order'] = 2 : $url_order['order'] = 1;
                                echo 'class="'; 
                                if ($a_view_data['url']['order'] <= 1){echo 'activeup';
                                } else if ($a_view_data['url']['order'] == 2){
                                    echo 'activedown';
                                };
                                echo ' "><a href="' . $this->router->url('search', $url_order) . '"'; ?>
                                >综合</a>
                            </li>

                            <li <?php $url_order = $a_view_data['url'];
                                $url_order['order'] == 3 ? $url_order['order'] = 4 : $url_order['order'] = 3;
                                echo 'class="'; 
                                if ($a_view_data['url']['order'] == 3){echo 'activeup';
                                } else if (
                                    $a_view_data['url']['order'] == 4){echo 'activedown';
                                };
                                echo ' "><a href="' . $this->router->url('search', $url_order) . '"'; ?>
                                >新品</a>
                            </li>

                            <li <?php $url_order = $a_view_data['url'];
                                $url_order['order'] == 5 ? $url_order['order'] = 6 : $url_order['order'] = 5;
                                echo 'class="'; 
                                if ($a_view_data['url']['order'] == 5){echo 'activeup';
                                } else if (
                                    $a_view_data['url']['order'] == 6){echo 'activedown';
                                };
                                echo ' "><a href="' . $this->router->url('search', $url_order) . '"'; ?>
                                >销量</a>
                            </li>

                            <li <?php $url_order = $a_view_data['url'];
                                $url_order['order'] == 7 ? $url_order['order'] = 8 : $url_order['order'] = 7;
                                echo 'class="'; 
                                if ($a_view_data['url']['order'] == 7){echo 'activeup';
                                } else if (
                                    $a_view_data['url']['order'] == 8){echo 'activedown';
                                };
                                echo ' "><a href="' . $this->router->url('search', $url_order) . '"'; ?>
                                >人气</a>
                            </li>
                            
                            <li <?php $url_order = $a_view_data['url'];
                                $url_order['order'] == 9 ? $url_order['order'] = 10 : $url_order['order'] = 9;
                                echo 'class="'; 
                                if ($a_view_data['url']['order'] == 9){echo 'activeup';
                                } else if (
                                    $a_view_data['url']['order'] == 10){echo 'activedown';
                                };
                                echo ' "><a href="' . $this->router->url('search', $url_order) . '"'; ?>
                                >价格</a>
                            </li>

                        </ul>
                        <div class="classify_bar_box">
                            <div class="input">
                                <div>
                                    <input class="price_min" value="<?php if ($a_view_data['url']['price_min'] > 0){
                                        echo $a_view_data['url']['price_min'];
                                        } else {
                                            echo "";
                                        };?>" type="text" placeholder="￥" maxlength="4">
                                </div>
                                <span>-</span>
                                <div>
                                    <input class="price_max" value="<?php if ($a_view_data['url']['price_max'] > 0){
                                        echo $a_view_data['url']['price_max'];
                                        } else {
                                            echo "";
                                        };?>" type="text" placeholder="￥" maxlength="4">
                                </div>
                            </div>
                            <div class="btn">
                                <span>去除</span>
                                <span class="active priceminmax">确定</span>
                            </div>
                        </div>
                    </div>
                    <form action="#" method="get">
                        <a href="<?php $autotrophy = $a_view_data['url'];$a_view_data['url']['autotrophy'] == 0 ? $autotrophy['autotrophy'] = 1 : $autotrophy['autotrophy'] = 0;
                                echo $this->router->url('search', $autotrophy);
                                ?>">          
                            <label for="self_support">
                                <span <?php if ($a_view_data['url']['autotrophy'] == 1){ echo 'style="opacity:1"';} ?>></span>
                            </label>
                                <span>7度自营</span>
                        </a>
                        <a href="<?php $gift = $a_view_data['url'];$a_view_data['url']['gift'] == 0 ? $gift['gift'] = 1 : $gift['gift'] = 0;
                                echo $this->router->url('search', $gift);
                                ?>">
                            <label for="gift">
                                <span <?php if ($a_view_data['url']['gift'] == 1){ echo 'style="opacity:1"';} ?>></span>
                            </label>
                            <span>赠品</span>
                        </a>
                        <a href="<?php $promotion = $a_view_data['url'];$a_view_data['url']['promotion'] == 0 ? $promotion['promotion'] = 1 : $promotion['promotion'] = 0;
                                echo $this->router->url('search', $promotion);
                                ?>">
                            <label for="promotion">
                                <span <?php if ($a_view_data['url']['promotion'] == 1){ echo 'style="opacity:1"';} ?>></span>
                            </label>
                                <span>促销</span>
                        </a>
                        <a href="<?php $integral = $a_view_data['url'];$a_view_data['url']['integral'] == 0 ? $integral['integral'] = 1 : $integral['integral'] = 0;
                                echo $this->router->url('search', $integral);
                                ?>">
                            <label for="integral">
                                <span <?php if ($a_view_data['url']['integral'] == 1){ echo 'style="opacity:1"';} ?>></span>
                            </label>
                                <span>积分</span>
                        </a>
                    </form>
                    <div class="classify_bar_right">
                        <div class="hide_btn">
                            <input name="" id="hidden_goods" type="checkbox" value="" />
                            <label for="hidden_goods"></label>
                        </div>
                        <span>隐藏已加购物车商品</span>
                        <p><span>1</span>/5</p>
                        <div class="paging_btn">
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="list">
                    <?php foreach ($a_view_data['search']['res'] as $key => $value) {?>
                        <div class="classify_item">
                        <a target="_blank" href="<?php echo get_config_item('domain') . '/item-' . $value->goods_id; ?>.html">
                            <header class="img" style="background-image: url(<?php echo "upload/shop/store/goods/" . $value->store_id . '/' . $value->goods_image;?>)">
                                <?php if ($a_view_data['time'] - $value->goods_addtime <= 7776000){
                                    echo '<label>新品</label>';
                                    } ?>
                                <div>
                                    <?php if ($value->is_own_shop == 1){echo '<span>7度自营</span>';} ?>
                                    <?php if ($value->have_gift == 1){echo '<span>赠</span>';} ?>
                                </div>
                            </header>
                            </a>
                            <section>
                                <h2><?php echo $value->goods_name;?></h2>
                                <h3><?php echo mb_substr($value->goods_jingle,0,30,'utf-8');if(mb_strlen($value->goods_jingle) > 30){echo '...';}?></h3>
                                <div class="price">
                                    <span>￥<?php echo $value->goods_price;?></span>
                                    <span>￥<?php echo $value->goods_marketprice;?></span>
                                </div>
                                <div class="comment">
                                    <!-- <p><span>13</span>人买过</p> -->
                                    <p><span><?php echo $value->evaluation_count; ?></span>人评价</p>
                                </div>
                            </section>
                            <footer class="dn">
                                <div>
                                    <span class="cellonclik">收藏</span>
                                    <span data="<?php echo $value->goods_id; ?>" class="shoponclik">加入购物车</span>
                                </div>
                                    <span>
                                        <span>7度自营</span>
                                        <a href="http://lyt.zoosnet.net/lr/chatpre.aspx?id=LYT42657310" target="_blank">
                                            <img src="image/icon_call.png" alt="">
                                        </a>
                                    <!--<i></i>-->
                                    </span>
                            </footer>
                        </div>
                    
                    <?php } ?>
                </div>
            </div>
            <div class="paging">
                <ul>
                    <li>
                        <?php echo $a_view_data['search']['page']; ?>
                    </li>
                </ul>
            </div>
        </section>
        <?php if(! empty($_SESSION['user_id'])){ ?>
            <?php $this->display('sidebar');?>
        <?php } ?>
        <?php $this->display('footer');?>
    </div>
</body>
</html>
<script>
    
    $('.priceminmax').click(function(){
        var price_min = $('.price_min').val();
        if (price_min == ""){
            price_min = 0;
        }
        var price_max = $('.price_max').val();
        if (price_max == ""){
            price_max = 0;
        }
        <?php   if($a_view_data['url']['keyword'] == ""){$a_view_data['url']['keyword'] = "";};
                if($a_view_data['url']['order'] == ""){$a_view_data['url']['order'] = 0;};
                if($a_view_data['url']['autotrophy'] == ""){$a_view_data['url']['autotrophy'] = 0;};
                if($a_view_data['url']['gift'] == ""){$a_view_data['url']['gift'] = 0;};
                if($a_view_data['url']['promotion'] == ""){$a_view_data['url']['promotion'] = 0;};
                if($a_view_data['url']['integral'] == ""){$a_view_data['url']['integral'] = 0;};
                if($a_view_data['url']['third'] == ""){$a_view_data['url']['third'] = 0;};
                if($a_view_data['url']['brand'] == ""){$a_view_data['url']['brand'] = 0;};
                if($a_view_data['url']['type'] == ""){$a_view_data['url']['type'] = 0;};
                if($a_view_data['url']['store'] == ""){$a_view_data['url']['type'] = 0;};
         ?>
        window.location.href='/search-<?php if($a_view_data["url"]["keyword"] != "" ){echo $a_view_data["url"]["keyword"]; }; ?>' +  '-' + 
                             <?php echo $a_view_data['url']['cate_id']; ?> + '-' 
                             + <?php echo $a_view_data['url']['order']; ?> + '-' 
                             + price_min + '-' + price_max + '-' 
                             + <?php echo $a_view_data['url']['autotrophy']; ?> + '-' 
                             + <?php echo $a_view_data['url']['gift']; ?> + '-'  
                             + <?php echo $a_view_data['url']['promotion']; ?> + '-' 
                             + <?php echo $a_view_data['url']['integral']; ?> + '-' 
                             + <?php echo $a_view_data['url']['third']; ?> + '-' 
                             + <?php echo $a_view_data['url']['brand']; ?> + '-' 
                             + <?php echo $a_view_data['url']['type']; ?> + '-'
                             + <?php echo $a_view_data['url']['store']; ?> + '.html';
    }); 
$('.shoponclik').click(function(){
    var url = '<?php echo $this->general->base64_convert(get_config_item('domain'));?>';
    var goodshop = $(this).attr('data');
        $.ajax({
            type : "POST",
            url : "<?php echo $this->router->url('goodshop');?>",
            data: "goodshop="+goodshop,
            dataType : "json",
            success : function(res)
            {
                if(res=='1'){
                    alert("加入购物车成功");
                }else if(res=='2'){
                    alert("加入购物车失败");
                }else {
                    alert("您没有登录");
                }
            },
            error:function(res){
                 self.location= '<?php echo get_config_item('user_domain').'/login-';?>'+url;
            }
        });
});
$('.cellonclik').click(function(){
    var cellgood = $(this).next('.shoponclik').attr('data');
    $.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('collect');?>",
        data: "cellgood="+cellgood,
        dataType : "json",
        success : function(res)
        {
            if(res=='1'){
                    alert("收藏成功");
            }else if(res=='0'){
                alert("收藏失败");
            } else{
                alert("您没有登录");
            }
        },
        error:function(res){
        alert(res.responseText);
        }
    });
});
</script>