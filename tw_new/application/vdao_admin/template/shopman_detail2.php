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
    <link rel="stylesheet" href="./static/style_default/style/recommenderList.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/recommenderList.js"></script>
    <title></title>
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

        <!-- 移动店主 -->
        <div class="recommenderList">
            <p>移动店主><?php echo $a_view_data['user_name']; ?>的订单</p>
            <!-- 店主列表 -->
            <div class="recommenderList_content">
                <form action="">
                    <div class="search_recommenderList">
                        <input type="text" placeholder="用户名/手机号"/>
                        <i><img src="./static/style_default/image/s_03.png" /></i>
                    </div>
                </form>
            </div>
            <ul class="recomList">
                <li class="cateHead">
                    <em class="v1" style="text-align:left;">
                        <img src="./static/style_default/image/pro_07.png" />
                        <span style="vertical-align:middle;">全选</span>
                    </em>
                    <em class="v2">性别</em>
                    <em class="v3">手机号码</em>
                    <em class="v4">下单店铺名称</em>
                    <em class="v5">数量</em>
                    <em class="v6">总价</em>
                    <em class="v7">给上级的提成
<!--                         <span>全部状态</span>
                        <img src="./static/style_default/image/pro_13.png" />
                        <div class="state hide">
                            <a>待付款</a>
                            <a>待配送</a>
                            <a>配送中</a>
                            <a>待评价</a>
                        </div> -->
                    </em>
                    <em class="v8">下单时间</em>
                </li>
                <?php foreach ($a_view_data['order'] as $key => $value): ?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <img src="./static/style_default/image/pro_07.png" value="<?php echo $value['order_id']; ?>" />
                        <div class="recomInfo">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($value['user_pic'], 'http') === false) {
                                echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                            } else {
                                echo '<img src="'.$value['user_pic'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $value['user_name']; ?></em>
                                <span><?php echo date('Y-m-d',$value['user_regtime']); ?></span>
                            </p>
                        </div>
                    </em>
                    <em class="v2">
                    <?php
                        if ($value['user_sex'] == 0) {
                            echo '未知';
                        } else if ($value['user_sex'] == 1) {
                            echo '男';
                        } else if ($value['user_sex'] == 2) {
                            echo '女';
                        }
                    ?>
                    </em>
                    <em class="v3"><?php echo $value['user_phone']; ?></em>
                    <em class="v4"><?php echo $value['store_name']; ?></em>
                    <em class="v5"><?php echo $value['order_count']; ?></em>
                    <em class="v6"><?php echo $value['goods_amount']; ?></em>
                    <em class="v7"><?php echo $value['order_commission']; ?></em>
                    <em class="v8"><?php echo date('Y-m-d',$value['time_create']); ?></em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 店主列表 -->

        </div>
        <!-- 移动店主 -->

        <!--  底部选项 -->
        <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="./static/style_default/image/pro_07.png" />
                <span>全选</span>
            </a>
            <a class="bottomDelect">
                <img src="./static/style_default/image/pro_26.png" />
                <span>删除</span>
            </a>
        </div>
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('shopman_referee_detail-'.$a_view_data['user_id'].'-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="./static/style_default/image/pro_19.png" />
            <p>
                <span>▪ 确认删除此公告吗？</span>
                <span>▪ 删除后不可恢复！</span>
                </p>
                <div class="tipsBtn">
                    <em>确定</em>
                    <a>再看看</a>
            </div>
        </div>
        <!--  重要提示 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>