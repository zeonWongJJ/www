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
    <link rel="stylesheet" href="static/style_default/style/seatOrder.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <title>座位订单</title>
    <script>
        $(function(){
            // 改变当前分页的样式
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

        <!-- 分享订单 -->
        <div class="shareOrder">
            <div class="shareTitle">
                <img src="static/style_default/image/ord_03.png" alt=""/>
                <span>订单管理/座位订单<?php if ($a_view_data['type'] == 88) { echo '/查询订单'; } ?></span>
            </div>
            <!-- 咖啡订单导航 -->
            <div class="shareNav">
                <ul>
                    <li class="allOrder <?php if ($a_view_data['state'] == 'all') { echo 'current'; } ?>">
                        <a class="shareCur" href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state'=>'all']); ?>">所有订单</a>
                    </li>
                    <li class="waitingList <?php if ($a_view_data['state'] == 1) { echo 'current'; } ?>">
                        <i></i>
                        <a href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state' => 1]); ?>">待接单</a>
                        <em><?php echo $a_view_data['state_one']; ?></em>
                    </li>
                    <li class="inDistribution <?php if ($a_view_data['state'] == 2) { echo 'current'; } ?>">
                        <i></i>
                        <a href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state' => 2]); ?>">待入座</a>
                        <em><?php echo $a_view_data['state_two']; ?></em>
                    </li>
                    <li class="distribution <?php if ($a_view_data['state'] == 3) { echo 'current'; } ?>">
                        <i></i>
                        <a href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state' => 3]); ?>">入座中</a>
                        <em><?php echo $a_view_data['state_three']; ?></em>
                    </li>
                    <li class="cafeComplete <?php if ($a_view_data['state'] == 5) { echo 'current'; } ?>">
                        <i></i>
                        <a href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state' => 5]); ?>">已完成</a>
                        <em><?php echo $a_view_data['state_five']; ?></em>
                    </li>
                    <li class="cafeCancel <?php if ($a_view_data['state'] == 6) { echo 'current'; } ?>">
                        <a href="<?php echo $this->router->url('book_showlist',['store_id'=>$a_view_data['store_id'],'state' => 6]); ?>">已取消</a>
                    </li>
                </ul>
            </div>
            <!-- 咖啡订单导航 -->
        </div>

        <!-- 查找单号 -->
        <div class="searchOrder">
            <form action="book_search" method="post">
                <input type="hidden" name="store_id" value="<?php echo $a_view_data['store_id']; ?>">
                <ul>
                    <li class="orderNum">
                        <input type="text" name="keywords" placeholder="订单编号/用户名/手机号" id="orderNum" value="<?php if ($a_view_data['type'] == 88 && $a_view_data['keywords'] != 'all') { echo $a_view_data['keywords']; } ?>" />
                    </li>
                    <li class="seatNum">
                        <span>座位号</span>
                        <input type="text" name="seatkey" placeholder="请输入座位号" id="seatNum" value="<?php if ($a_view_data['type'] == 88 && $a_view_data['seatkey'] != 'all') { echo $a_view_data['seatkey']; } ?>"/>
                    </li>
                    <li class="orderSub">
                        <input type="submit" id="orderSub" value="查询"/>
                    </li>
                </ul>
            </form>
        </div>
        <!-- 查找单号 -->

        <!-- 订单列表 -->
        <div class="shareList">
            <div class="shareListTitle">
                <span style="width:352px;">用户名</span>
                <span style="width:178px;">入座时间</span>
                <span style="width:146px;">金额</span>
                <span style="width:242px;">联系方式</span>
                <span class="dealState" style="width:100px; position:relative;">
                    <a>交易状态</a>
                    <img src="static/style_default/image/pro_13.png" alt=""/>
                    <div class="dealStateBox hide">
                        <a href="">交易状态</a>
                        <a href="">交易状态</a>
                        <a href="">交易状态</a>
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
                <?php foreach ($a_view_data['appointment'] as $key => $value): ?>
                <li>
                    <dl>
                        <dt>
                            <span><?php echo date('Y-m-d H:i:s', $value['appointment_time']); ?></span>
                            <em>订单编号:  <?php echo $value['appointment_number']; ?></em>
                        </dt>
                        <dd class="cafeUser" style="text-align:left;">
                            <div>
                                <?php if (empty($value['user_pic'])) {
                                    echo '<img src="./static/style_default/image/tt_03.png" />';
                                } else if(strpos($value['user_pic'], 'http') === false) {
                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                                } else {
                                    echo '<img src="'.$value['user_pic'].'" />';
                                } ?>
                                <em>
                                    <p><?php echo $value['user_name']; ?></p>
                                    <span>座位：<?php echo $value['office_seatname']; ?></span>
                                </em>
                            </div>
                        </dd>
                        <dd class="seatTime">
                            <p><?php echo date('Y-m-d H:i', $value['begin_time']); ?></p>
                            <p><?php echo date('Y-m-d H:i', $value['end_time']); ?></p>
                        </dd>
                        <dd class="distributionCost">
                            <div>
                                <span>¥<?php echo $value['appointment_price']; ?></span>
                            </div>
                        </dd>
                        <dd class="seatContact">
                            <p><?php echo $value['linkman']; ?></p>
                            <p><?php echo $value['link_phone']; ?></p>
                        </dd>
                        <dd class="transactionState">
                            <div>
                                <div class="<?php if ($value['appointment_state'] == 1) { echo 'waitingList'; } else if ($value['appointment_state'] == 2) { echo 'distribution'; } else if ($value['appointment_state'] == 3) { echo 'inDistribution'; } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5 || $value['appointment_state'] == 6) { echo 'cafeComplete'; }  ?>">
                                    <i></i>
                                    <a>
                                    <?php if ($value['appointment_state'] == 1) {
                                        echo '待接单';
                                    } else if ($value['appointment_state'] == 2) {
                                        echo '待入座';
                                    } else if ($value['appointment_state'] == 3) {
                                        echo '入座中';
                                    } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) {
                                        echo '已完成';
                                    } else if ($value['appointment_state'] == 6) {
                                        echo '已取消';
                                    } ?>
                                    </a>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- 订单列表 -->
        <!-- 分享列表 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 88) {
                echo $this->pages->link_style_one($this->router->url('book_search-'.$a_view_data['store_id'].'-'.$a_view_data['seatkey'].'-'.$a_view_data['state'].'-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('book_showlist-'.$a_view_data['store_id'].'-'.$a_view_data['state'].'-', [], false, false));
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