<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/competitiveOrder.css"/>
    <title></title>
</head>
<body>
    <!-- 竞标中的订单 -->
    <div class="competitiveOrder">
        <div class="competitiveBox">
            <!-- 竞标中 -->
            <div class="competitiveTime">
                <p>竞标中 ></p>
                <em>
                    <span>已生成竞标订单，请留意投标详情...</span>
                </em>
                <div class="competitiveBtn">
                    <a href="">取消订单</a>
                    <a href="<?php echo $this->router->url('demand_bid_detail',['id'=>$a_view_data['demand_id']]); ?>">查看投标详情</a>
                </div>
            <!-- 竞标中 -->
            </div>

        </div>
        <!--  订单的信息 -->
        <div class="detailInfo">
            <!--  信息 -->
            <ul>
                <li>
                    <i><img src="../img/app.png" alt="span"/></i>
                    <span><?php echo $a_view_data['title']; ?></span>
                </li>
                <li>
                    <i><img src="../img/time.png" alt="span"/></i>
                    <span><?php echo date('m月d日 H:i',$a_view_data['start_time']); ?> - <?php echo date('m月d日 H:i',$a_view_data['end_time']); ?></span>
                </li>
                <li>
                    <i><img src="../img/posi.png" alt="span"/></i>
                    <span>联系人：<?php echo $a_view_data['contacts_name']; ?></span>
                    <em><?php echo $a_view_data['mobile_phone']; ?></em>

                </li>
                <li>
                    <p>服务地址: <?php echo $a_view_data['area_info']; ?></p>
                </li>
            </ul>
            <!--  信息 -->
            <!--  虚线 -->
            <div class="dashed">
                <i></i>
                <p></p>
                <i></i>
            </div>
            <!--  虚线 -->
            <!--  费用 -->
            <div class="cost">
                <i>
                    <img src="../img/cost.png" alt=""/>
                </i>
                <div class="costInfo">
                    <p>
                        <span>
                            <em>番禺钟村&nbsp;急需一名空调维修工厂上门维修工上门维修空调不制冷</em>
                            <br/>
                            <s>保修</s>
                        </span>
                        <em>
                            <span>¥<?php echo $a_view_data['price']; ?></span>
                            <em>x1</em>
                        </em>
                    </p>
                </div>
                <div class="toubiao">
                    <a href="">查看投标详情</a>
                </div>
                <!--  虚线 -->
                <div class="dashed" style="margin-top:48px;">
                    <i></i>
                    <p></p>
                    <i></i>
                </div>
                <!--  虚线 -->
                <!--  价格 -->
                <div class="pay">
                    <span>
                        <span>总计¥<?php echo $a_view_data['price']; ?></span>
                        |
                        <em>红包优惠 <b style="font-size:12px; ">¥<?php echo $a_view_data['discount_amount']; ?></b></em>
                    </span>
                    <em>
                        <span><b>¥</b><?php echo $a_view_data['the_amount']; ?></span>
                    </em>
                </div>
                <!--  价格 -->
            </div>
            <!--  费用 -->
        </div>
        <!--  订单的信息  -->
        <!--  订单时间信息 -->
        <div class="orderInfo">
            <p>
                <span>订单号码</span>
                <em><?php echo $a_view_data['order_sn']; ?></em>
            </p>
            <p>
                <span>下单时间</span>
                <em><?php echo date('Y-m-d H:i', $a_view_data['release_time']); ?></em>
            </p>
            <p>
                <span>支付方式</span>
                <em>在线支付</em>
            </p>
            <em>复制</em>
        </div>
        <!--  订单时间信息 -->
    </div>
    <!-- 竞标中的订单 -->
    <!--  弹出框 -->
    <div class="tips hide">

    </div>
    <div class="pop hide">
        <p>确认服务已完成？</p>
        <a><span>确认</span></a>
        <a><em>再等等</em></a>
    </div>
    <!--  弹出框 -->
</body>
</html>