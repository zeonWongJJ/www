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
    <link rel="stylesheet" href="./static/style_default/style/roomOrder.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>订单管理-会议订单</title>
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

        <!-- 会议订单 -->
        <div class="roomOrder">
            <div class="roomTitle">
                <img src="./static/style_default/image/ord_03.png" />
                <span><a href="order_showlist">订单管理</a> / <?php echo '<a href="order_office-'.$a_view_data['store']['store_id'].'">'.$a_view_data['store']['store_name'].'</a>' ?> / </span>
                <em>会议订单<?php if ($a_view_data['type'] == 88) { echo ' / 搜索订单'; } ?></em>
            </div>
            <!-- 会议订单导航 -->
            <div class="roomNav">
                <ul>
                    <li class="allOrder">
                        <a <?php if ($a_view_data['state'] == 'all') { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id']]); ?>">所有订单</a>
                    </li>
                    <li class="receiveOrder">
                        <i></i>
                        <a <?php if ($a_view_data['state'] == 1) { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id'],'state'=>1]); ?>">待接单</a>
                        <em><?php echo $a_view_data['state_one']; ?></em>
                    </li>
                    <li class="servranOrder">
                        <i></i>
                        <a <?php if ($a_view_data['state'] == 2) { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id'],'state'=>2]); ?>">待服务</a>
                        <em><?php echo $a_view_data['state_two']; ?></em>
                    </li>
                    <li class="servranRun">
                        <i></i>
                        <a <?php if ($a_view_data['state'] == 3) { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id'],'state'=>3]); ?>">服务中</a>
                        <em><?php echo $a_view_data['state_three']; ?></em>
                    </li>
                    <li class="roomComplete">
                        <i></i>
                        <a <?php if ($a_view_data['state'] == 5) { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id'],'state'=>5]); ?>">已完成</a>
                        <em><?php echo $a_view_data['state_five']; ?></em>
                    </li>
                    <li class="roomCancel">
                        <a <?php if ($a_view_data['state'] == 6) { echo 'class="roomCur"'; } ?> href="<?php echo $this->router->url('order_office',['store_id'=>$a_view_data['store']['store_id'],'state'=>6]); ?>" style="text-decoration:line-through;">已取消</a>
                    </li>
                </ul>
            </div>
            <!-- 会议订单导航 -->
            <!-- 用户搜索与分类选择 -->
            <div class="roomCateBox">
                <form action="<?php echo $this->router->url('appointment_search'); ?>" method="post">
                <input type="hidden" name="store_id" value="<?php echo $a_view_data['store']['store_id']; ?>">
                    <ul>
                        <li class="userAndSeatNum">
                            <a class="searchOrder">
                                <span>关键词：</span>
                                <input type="text" name="keywords" id="search_order" placeholder="订单编号/用户名/手机号"  <?php if ($a_view_data['type'] == 88 && $a_view_data['keywords'] != 9) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
                            </a>
                            <a class="seatNum">
                                <span>会议：</span>
                                <select name="office_id">
                                    <option value="all" <?php if ($a_view_data['ofid'] == 'all') { echo 'selected'; } ?>>全部会议</option>
                                    <?php foreach ($a_view_data['office'] as $key => $value): ?>
                                    <option value="<?php echo $value['office_id']; ?>" <?php if ($a_view_data['ofid'] == $value['office_id']) { echo 'selected'; } ?>><?php echo $value['room_name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </a>
                        </li>
                        <input type="hidden" name="appointment_state" value="<?php echo $a_view_data['state']; ?>">
                        <li class="orderState">
                            <span>订单状态：</span>
                            <a href="javascript:;" value='all' <?php if ($a_view_data['state'] == 'all') { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>全部</a>
                            <a href="javascript:;" value='1' <?php if ($a_view_data['state'] == 1) { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>待接单</a>
                            <a href="javascript:;" value='2' <?php if ($a_view_data['state'] == 2) { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>待服务</a>
                            <a href="javascript:;" value='3' <?php if ($a_view_data['state'] == 3) { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>服务中</a>
                            <a href="javascript:;" value='5' <?php if ($a_view_data['state'] == 5) { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>已完成</a>
                            <a href="javascript:;" value='6' <?php if ($a_view_data['state'] == 6) { echo 'style="background-color:rgb(93,55,25); color:#fff;"'; } ?>>已取消</a>
                        </li>
                    </ul>
                    <input type="submit" id="roomSub" value="查询"/>
                </form>
            </div>
            <!-- 用户搜索与分类选择 -->
            <!--  预约数量 -->
            <div class="makeOnNum">
                <ul>
                    <li>
                        <p>今天预约</p>
                        <span><?php echo $a_view_data['today_order']; ?></span>
                    </li>
                    <li>
                        <p>所有预约</p>
                        <span><?php echo $a_view_data['all_order']; ?></span>
                    </li>
                    <li>
                        <p>日均预约</p>
                        <span><?php echo $a_view_data['average_order']; ?></span>
                    </li>
                </ul>
            </div>
            <!--  预约数量 -->
        </div>
        <!-- 会议列表 -->
        <div class="roomList">
            <ul>
                <?php foreach ($a_view_data['appointment'] as $key => $value): ?>
                <li class="roomType">
                    <p>
                        <em><?php echo $value['room_type'] . $value['room_name'].'&nbsp;&nbsp;'.$value['office_seatname']; ?></em>
                        <!-- <span>下单时间：<?php echo date('Y-m-d H:i:s', $value['appointment_time']); ?></span> -->
                    </p>
                    <dl>
                        <dt class="roomUser">
                            <p>用户名</p>
                            <div class="userBox">
                                <?php if (empty($value['user_pic'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else if(strpos($value['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'" />';
                                } ?>
                                <em>
                                    <p><?php echo $value['user_name']; ?></p>
                                    <span>订单编号:  <?php echo $value['appointment_number']; ?>&nbsp;&nbsp;</span>
                                </em>
                            </div>
                        </dt>
                        <dd class="roomTime">
                            <p> 下单时间</p>
                            <div class="TimeBox">
                                <p><?php echo date('Y-m-d', $value['appointment_time']); ?></p>
                                <span><?php echo date('H:i', $value['appointment_time']); ?></span>
                            </div>
                        </dd>
                        <dd class="roomTime">
                            <p>预计到达时间</p>
                            <div class="TimeBox">
                                <p><?php echo date('Y-m-d', $value['appointment_time']); ?></p>
                                <span><?php echo $value['arrival_time']; ?></span>
                            </div>
                        </dd>
                        <dd class="roomContact">
                            <p>联系方式</p>
                            <div class="contactBox">
                                <p><?php echo $value['linkman']; ?></p>
                                <span><?php echo $value['link_phone']; ?></span>
                            </div>
                        </dd>
                        <dd class="roomContact">
                            <p>金额</p>
                            <div class="contactBox">
                                <span><?php echo $value['appointment_price']; ?></span>
                            </div>
                        </dd>
                        <dd class="roomState">
                            <p>订单状态</p>
                            <div
                                <?php if ($value['appointment_state'] == 1) {
                                    echo 'class="receiveOrder"';
                                } else if ($value['appointment_state'] == 2) {
                                    echo 'class="servranOrder"';
                                } else if ($value['appointment_state'] == 3) {
                                    echo 'class="servranRun"';
                                } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) {
                                    echo 'class="roomComplete"';
                                } else if ($value['appointment_state'] == 6) {
                                    echo '';
                                } ?>
                            >
                               <i></i>
                               <span <?php if ($value['appointment_state'] == 6) { echo 'style="text-decoration:line-through"'; } ?>>
                                <?php if ($value['appointment_state'] == 1) {
                                    echo '待接单';
                                } else if ($value['appointment_state'] == 2) {
                                    echo '待服务';
                                } else if ($value['appointment_state'] == 3) {
                                    echo '服务中';
                                } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) {
                                    echo '已完成';
                                } else if ($value['appointment_state'] == 6) {
                                    echo '已取消';
                                } ?>
                               </span>
                            </div>
                        </dd>
                       <!--  <dd  class="typeState">
                            <?php if ($value['appointment_state'] == 1) {
                                echo '<a href="javascript:;">接单</a>';
                            } else if ($value['appointment_state'] == 2) {
                                echo '<a href="javascript:;">开始服务</a>';
                            } else if ($value['appointment_state'] == 3) {
                                echo '<a href="javascript:;">服务结束</a>';
                            }?>
                        </dd> -->
                    </dl>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- 会议列表 -->

        <!-- 分页 -->
        <div class="page" style="margin-bottom:30px;">
            <?php
            if ($a_view_data['type'] == 88) {
                // 搜索时的分页
                echo $this->pages->link_style_one($this->router->url('appointment_search-'.$a_view_data['store']['store_id'].'-'.$a_view_data['ofid'].'-'.$a_view_data['state'].'-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                // 列表时的分页
                echo $this->pages->link_style_one($this->router->url('order_office-'.$a_view_data['store']['store_id'].'-'.$a_view_data['state'].'-', [], false, false));
            } ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>
$(function(){
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
    $('.orderState a').click(function(event) {
        $('.orderState a').css('background-color', 'white');
        $('.orderState a').css('color', 'black');
        $(this).css('background-color','rgb(93,55,25)');
        $(this).css('color','white');
        $("input[name='appointment_state']").val($(this).attr('value'));
    });
})

</script>