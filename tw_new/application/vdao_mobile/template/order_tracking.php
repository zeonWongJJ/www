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
    <link rel="stylesheet" href="static/style_default/style/orderTrack.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <?php if ($a_view_data['result']['status_code'] == 20000) {echo $a_view_data['result']['map_code_head']; }?>

    <title>订单跟踪</title>
</head>
<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
    <div class="logistics">
        <p class="pjoTitle">
            <a href="goods_list-<?php echo $this->router->get(1)?>"><img src="static/style_default/images/kefu_03.png" alt=""/></a>
            <span>订单跟踪</span>
        </p>

        <!-- 订单跟踪 -->
        <div class="logInfo">
            <div class="expressContainer">
                <ul>
                    <?php foreach ($a_view_data['order'] as $order) {?>
                    <li class="expressList exCur">
                        <a class="exTime">
                            <p><?php echo date('Y-m-d H:i', $order['time']);?></p>
                        </a>
                        <a class="line">
                            <i></i>
                            <hr/>
                        </a>
                        <a class="exInfo">
                            <span><?php echo $order['name']?></span>
                        </a>
                    </li>
                    <?php }?>
                    <?php if ($a_view_data['result']['status_code'] == 20000) {?>
                        <li class="expressList exCur">
                            <a class="exTime">
                                <p><?php echo $a_view_data['result']['acceptTime'];?></p>
                            </a>
                            <a class="line">
                                <i></i>
                                <hr/>
                            </a>
                            <a class="exInfo">
                                <span>
                                	<?php echo $a_view_data['result']['statusMsg']?>
                                	<?php echo $a_view_data['result']['transporterName']?>
                                	<?php echo $a_view_data['result']['transporterPhone']?>	
                                </span>
                              	<em class="mapBox">
                                	<?php echo $a_view_data['result']['map_code_body']?>
                              	</em>
                            </a>
                           
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- 订单跟踪 -->
    </div>


</body>
</html>