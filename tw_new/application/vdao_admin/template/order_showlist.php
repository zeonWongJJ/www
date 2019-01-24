<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="./static/style_default/style/common.css"/>
    <link rel="stylesheet" href="./static/style_default/style/public.css"/>
    <link rel="stylesheet" href="./static/style_default/style/orderManagement.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>店铺订单管理</title>
    <script>
        $(function(){
            $('.page a').each(function(index, el) {
                if ($(this).attr('href') == '#') {
                    $(this).css('background-color','#6e5c58');
                    $(this).css('color','#ffffff');
                }
            });
        })
    </script>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 订单管理 -->
        <div class="orderManagement">
            <p>订单管理</p>
            <!-- 订单列表 -->
            <ul class="ordersContent">
                <?php $i=1; foreach ($a_view_data['store'] as $key => $value): ?>
                <li class="ordersList">
                    <dl>
                        <dt>
                            <i <?php if (($a_view_data['page']-1) * 8 + $i < 4) { echo "style='background-color:#f4dcb1;'"; } ?>>
                                <s></s>
                                <span><?php if (($a_view_data['page']-1) * 8 + $i < 4) { echo "top"; } ?><?php echo ($a_view_data['page']-1) * 8 + $i; ?></span>
                            </i>
                            <div class="storeInfo">
                                <?php if (empty($value['store_touxiang'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else {
                                    echo '<img src="'.get_config_item('vdao_store').$value['store_touxiang'].'" />';
                                } ?>
                                <h1><?php echo $value['store_name']; ?></h1>
                                <span>开店时间：<?php echo date('Y-m-d', $value['store_regtime']); ?></span>
                            </div>
                        </dt>
                        <a href="<?php echo $this->router->url('order_coffee',['id'=>$value['store_id']]); ?>">
                            <dd class="cafeOrder">
                                <p>餐饮订单</p>
                                <span><?php echo $value['store_order']; ?></span>
                            </dd>
                        </a>
                        <a href="<?php echo $this->router->url('order_office',['id'=>$value['store_id']]); ?>" target="new">
                            <dd class="roomOrder">
                                <p>会议订单</p>
                                <span><?php echo $value['store_officeorder']; ?></span>
                            </dd>
                        </a>
                        <a href="<?php echo $this->router->url('book_showlist',['id'=>$value['store_id']]); ?>" target="new">
                            <dd class="seatOrder">
                                <p>座位订单</p>
                                <span><?php echo $value['book_count']; ?></span>
                            </dd>
                        </a>
                    </dl>
                </li>
                <?php $i++; endforeach ?>
            </ul>
            <!-- 订单列表 -->
        </div>
        <!-- 订单管理 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('order_showlist-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>