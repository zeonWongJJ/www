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
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/shareOrderAdmin.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/shareOrderAdmin.js"></script>
    <title>分享订单管理</title>
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

        <!-- 分享订单 -->
        <div class="shareOrder">
            <div class="shareTitle">
                <img src="static/style_default/image/ord_03.png" alt=""/>
                <span>分享订单管理</span>
            </div>
            <!-- 咖啡订单导航 -->
            <div class="shareNav">
                <ul>
                    <li class="allOrder">
                        <a  href="<?php echo $this->router->url('share_order', ['i_order' => 0,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 0) {
                           echo "class='cafeCur'";}?>>所有订单</a>
                    </li>
                    <li class="pendingPayment">
                        <i></i>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 40,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 40) {
                           echo "class='cafeCur'";}?>>待付款</a>
                        <em><?php echo $a_view_data['payment']?></em>
                    </li>
                    <li class="waitingList">
                        <i></i>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 20,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 20) {
                           echo "class='cafeCur'";}?>>待接单</a>
                        <em><?php echo $a_view_data['waiting']?></em>
                    </li>
                    <li class="distribution">
                        <i></i>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 25,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 25) {
                           echo "class='cafeCur'";}?>>待配送</a>
                        <em><?php echo $a_view_data['shipping']?></em>
                    </li>
                    <li class="inDistribution">
                        <i></i>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 30,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 30) {
                           echo "class='cafeCur'";}?>>配送中</a>
                        <em><?php echo $a_view_data['distribu']?></em>   
                    </li>
                    <li class="cafeComplete">
                        <i></i>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 10,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 10) {
                           echo "class='cafeCur'";}?>>已完成</a>
                    </li>
                    <li class="cafeCancel">
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 55,'i_canshu' => 1]); ?>" <?php if ($a_view_data['i_order'] == 55) {
                           echo "class='cafeCur'";}?>>已关闭</a>
                    </li>
                </ul>
            </div>
            <!-- 咖啡订单导航 -->

        </div>
        <!-- 订单列表 -->
        <div class="shareList">
            <div class="shareListTitle">
                <span style="width:445px;">订单</span>
                <span style="width:140px;">实付款</span>
                <span style="width:230px;">订单进度</span>
                <span class="dealState" style="width:100px; position:relative;">
                    <a><?php if ($a_view_data['i_order'] == 0) {
                            echo "所有订单";
                        } else if ($a_view_data['i_order'] == 40) {
                            echo "待付款";
                        } else if ($a_view_data['i_order'] == 20) {
                            echo "待接单";
                        } else if ($a_view_data['i_order'] == 25) {
                            echo "待配送";
                        } else if ($a_view_data['i_order'] == 30) {
                            echo "配送中";
                        } else if ($a_view_data['i_order'] == 10) {
                            echo "已完成";
                        } else if ($a_view_data['i_order'] == 55) {
                            echo "已关闭";
                        }?></a>
                    <img src="static/style_default/image/pro_13.png" alt=""/>
                    <div class="dealStateBox hide">
                        <a  href="<?php echo $this->router->url('share_order', ['i_order' => 0,'i_canshu' => 1]); ?>">所有订单</a>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 40,'i_canshu' => 1]); ?>">待付款</a>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 20,'i_canshu' => 1]); ?>">待接单</a>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 25,'i_canshu' => 1]); ?>">待配送</a>
                         <a href="<?php echo $this->router->url('share_order', ['i_order' => 30,'i_canshu' => 1]); ?>">配送中</a>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 10,'i_canshu' => 1]); ?>">已完成</a>
                        <a href="<?php echo $this->router->url('share_order', ['i_order' => 55,'i_canshu' => 1]); ?>">已关闭</a>
                    </div>
                    <script>
                        $(function(){
                            $(".dealState").mouseover(function(){
                                $(".dealStateBox").removeClass("hide");
                            });
                            $(".dealState").mouseout(function(){
                                $(".dealStateBox").addClass("hide");
                            });
                        })
                    </script>
                </span>
            </div>
            <ul class="shareListContent">
               <?php foreach ($a_view_data['order'] as $order) { ?>
                <li>
                    <dl>
                        <dt>
                            <span><?php echo date('Y-m-d H:i', $order['time_create'])?></span>
                            <em>订单编号:  <?php echo $order['order_number']?></em>
                        </dt>
                        <dd class="cafeUser" style="text-align:left;">
                            <div>
                                <?php if (empty($order['user_pic'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else if(strpos($order['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$order['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$order['user_pic'].'" />';
                                } ?>
                                <em>
                                    <p><?php echo $order['user_name']?></p>
                                    <span><?php foreach ($a_view_data['goods'] as $gooder) {if ($order['order_id'] == $gooder['order_id']) {?>
                                                <?php echo $gooder['product_name']?>
                                                <?php if (! empty($gooder['spec'])) {
                                                    echo '('.$gooder['spec'].')';
                                                }?>
                                                <?php echo $gooder['goods_num']?> 份
                                            <?php }}?> 共<?php echo $order['order_count']?>件产品</span>
                                </em>
                            </div>

                        </dd>
                        <dd class="distributionCost">
                            <div>
                                <span>¥<?php echo $order['order_price']?></span>
                                <p>(含配送费：￥<?php echo $order['shipping_fee']?>)</p>
                            </div>
                        </dd>
                        <dd class="orderProgress">
                            <div>
                                <a><?php if ($order['order_state'] == 0) {
                                            echo "已关闭";
                                        } else if ($order['order_state'] == 40) {
                                            echo "待付款";
                                        } else if ($order['order_state'] == 20) {
                                            echo "待接单";
                                        } else if ($order['order_state'] == 25) {
                                            echo "待配送";
                                        } else if ($order['order_state'] == 30) {
                                            echo "配送中";
                                        } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                            echo "已完成";
                                        }?></a>
                                <div class="progressContentBg" >
                                    <div class="progressContent" style="<?php if ($order['order_state'] == 0) {
                                            echo "width: 0%";
                                        } else if ($order['order_state'] == 40) {
                                            echo "width: 15%";
                                        } else if ($order['order_state'] == 20) {
                                            echo "width: 40%";
                                        } else if ($order['order_state'] == 25) {
                                            echo "width: 60%";
                                        } else if ($order['order_state'] == 30) {
                                            echo "width: 80%";
                                        } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                            echo "width: 102%";
                                        }?>"></div>
                                </div>
                                <div class="progressText" style="margin-top:0;">
                                    <span>拍下</span>
                                    <em>完成</em>
                                </div>
                            </div>
                        </dd>
                        <dd class="transactionState">
                            <div>
                                <?php if ($order['order_state'] == 0) {?>
                                        <div>
                                            <i></i>
                                            <a>已关闭</a>
                                        </div>
                                    <?php } else if ($order['order_state'] == 40) {?>
                                        <div class="pendingPayment">
                                            <i></i>
                                            <a>待付款</a>
                                        </div>
                                    <?php } else if ($order['order_state'] == 20) {?>
                                        <div class="waitingList">
                                            <i></i>
                                            <a>待接单</a>
                                        </div>
                                    <?php } else if ($order['order_state'] == 25) {?>
                                        <div class="distribution">
                                            <i></i>
                                            <a>待配送</a>
                                        </div>
                                    <?php } else if ($order['order_state'] == 30) {?>
                                        <div class="inDistribution">
                                            <i></i>
                                            <a>配送中</a>
                                        </div>
                                    <?php } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {?>
                                        <div class="cafeComplete">
                                            <i></i>
                                            <a>已完成</a>
                                        </div>
                                    <?php }?>
                                <a href="share_order_details-<?php echo $order['order_id']?>" style="color:black;">订单详情</a>
                                <i class="remark" style="display:block; margin-top:5px;">
                                    <?php if (empty($order['order_message'])) {?>
                                          
                                    <?php } else{?>
                                    <img style="cursor:pointer;" src="static/style_default/image/ord_07.png" alt=""/>
                                    <div class="remarkInfo hide">
                                        <em></em>
                                        备注 ：<?php echo $order['order_message'];?>
                                    </div>
                                    <?php }?>
                                </i>
                            </div>
                        </dd>
                    </dl>
                </li>
                <?php }?>
            </ul>
        </div>
        <!-- 订单列表 -->
        <!-- 分享列表 -->
        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('share_order-'.$a_view_data['i_order'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['i_total']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->
        <!-- 订单层 -->
        <div class="shareOrders">
           
        </div>
        <!-- 订单层 -->
    </article>
    <!--  右侧内容 -->
</div>

<!--  后台管理 -->
</body>
</html>