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
   
    <link rel="stylesheet" href="static/style_default/style/order_details.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <title>订单详情</title>
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

        <!-- 订单详情 -->
        <div class="order_details">
            <p>订单详情</p>
            <!-- 内容 -->
            <div class="content">
                <!--订单详情弹框开始-->
                <div class="detailBomb">
                    <div class="messageBox">
                        <div class="numberBox">
                            <p class="dingdan"><i></i>订单编号</p>
                            <div class="cont">
                                <p><?php echo $a_view_data['order'][0]['order_number']?></p>
                            </div>
                            <span class="shang"></span>
                            <span class="xia"></span>
                        </div>
                        <div class="numberBox timeBox">
                            <p class="dingdan"><i></i>下单时间</p>
                            <div class="cont">
                                <p><?php echo date('Y-m-d H:i', $a_view_data['order'][0]['time_create'])?></p>
                            </div>
                            <span class="shang"></span>
                            <span class="xia"></span>
                        </div>
                        <div class="numberBox takeBox">
                            <p class="dingdan"><i></i>收货信息</p>
                            <div class="cont">
                                <p>联系人：<?php echo $a_view_data['order'][0]['reciver_name']?></p>
                                <p>联系电话：<?php echo $a_view_data['order'][0]['mob_phone']?></p>
                                <p>联系地址：<?php echo $a_view_data['order'][0]['addres']?></p>
                            </div>
                            <span class="shang"></span>
                            <span class="xia"></span>
                        </div>
                        <div class="numberBox proBox">
                            <p class="dingdan"><i></i>下单产品</p>
                            <div class="cont">
                                <ul>
                                    <?php foreach ($a_view_data['order'] as $order) {?>
                                    <li>
                                        <i class="wen1"><?php echo $order['product_name']?><?php if ( ! empty($order['spec'])) {
                                            echo "(".$order['spec'].")";
                                        }?></i>
                                        <i class="wen2">x<?php echo $order['goods_num']?></i>
                                        <i class="wen3">¥<?php echo $order['order_price']?></i>
                                    </li>
                                    <?php }?>
                                </ul>
                                <p class="redPaper">
                                    <i class="red">积分抵扣</i>
                                    <i class="money">-¥<?php echo $a_view_data['order'][0]['use_jife']?></i>
                                </p>
                                <p class="redPaper">
                                    <i class="red">余额抵扣</i>
                                    <i class="money">-¥<?php echo $a_view_data['order'][0]['balance_deduction']?></i>
                                </p>
                                <p class="redPaper carryM">
                                    <i class="red">配送费</i>
                                    <i class="money">¥<?php echo $a_view_data['order'][0]['shipping_fee']?></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="payBox">
                        <span class="payType"><?php if ($a_view_data['order'][0]['payment_code'] == 'offline') {
                            echo "微信付款";
                        } else if ($a_view_data['order'][0]['payment_code'] == 'online') {
                            echo "在线支付";
                        } else if ($a_view_data['order'][0]['payment_code'] == 'alipay') {
                            echo "支付宝";
                        } else if ($a_view_data['order'][0]['payment_code'] == 'unionpay') {
                            echo "银联网关支付";
                        }?></span>
                        <span class="allMon">¥<?php echo $a_view_data['order'][0]['actual_pay']?></span>
                    </div>
                </div>
                <!--订单详情弹框结束-->
                <!-- 配送物流 -->
                <div class="log">
                    <ul>
                        <?php foreach ($a_view_data['express']['Traces'] as $key => $value): ?>
                        <li class="expressList">
                            <a class="exTime">
                                <p><?php echo $value['AcceptTime']; ?></p>
                            </a>
                            <a class="line">
                                <i></i>
                                <hr/>
                            </a>
                            <a class="exInfo">
                                <span><?php echo $value['AcceptStation']; ?></span>
                            </a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <!-- 配送物流 -->
            </div>
            <!-- 内容 -->
        </div>
        <!-- 订单详情 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->

</body>
</html>