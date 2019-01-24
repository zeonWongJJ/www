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
    <link rel="stylesheet" href="./static/style_default/style/userReferrals.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
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

        <!-- 用户消费统计 -->
        <div class="userConsumption">
            <p>用户消费统计 > <?php echo $a_view_data['user']['user_name']; if($a_view_data['type'] == 2 || $a_view_data['type']==7) { echo ' > 推荐的人'; } ?> > <?php echo date('Y年m月',$a_view_data['statistic']['sta_time']); ?>订单 <?php if ($a_view_data['type']==6 || $a_view_data['type']==7) { echo ' > 搜索['.$a_view_data['keywords'].']'; } ?></p>
            <!-- 推荐人列表 -->
            <div class="referralsList_content">
                <form id="searchform" action="<?php if ($a_view_data['type'] == 1 || $a_view_data['type'] == 6) { echo $this->router->url('selforder_search'); } else if ($a_view_data['type'] == 2 || $a_view_data['type'] == 9) { echo $this->router->url('otherorder_search'); }  ?>" method="post">
                    <div class="search_referrals">
                        <input type="hidden" name="sta_id" value="<?php echo $a_view_data['sta_id']; ?>">
                        <?php if ($a_view_data['type'] == 6) {
                            echo '<input type="text" name="keywords" value="'.$a_view_data['keywords'].'"/>';
                        } else {
                            echo '<input type="text" name="keywords" placeholder="订单号/店铺"/>';
                        } ?>
                        <i><img src="./static/style_default/image/s_03.png" onclick="selforder_search()" /></i>
                    </div>
                </form>
            </div>
            <ul class="referralsList">
                <li class="cateHead">
                    <em class="v1" style="text-align:left;">

                    </em>
                    <em class="v2">订单号</em>
                    <em class="v3">下单店铺名称</em>
                    <em class="v4">数量</em>
                    <em class="v5">总价</em>
                    <em class="v6">给上级获得提成</em>
                    <em class="v7">下单时间</em>
                </li>
                <?php foreach ($a_view_data['order'] as $key => $value): ?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <div class="referralsInfo">
                            <?php if (empty($value['user_pic'])) {
                                echo '<img src="./static/style_default/image/tt_03.png" />';
                            } else if(strpos($value['user_pic'], 'http') === false) {
                                echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
                            } else {
                                echo '<img src="'.$value['user_pic'].'" />';
                            } ?>
                            <p>
                                <em><?php echo $value['user_name']; ?></em>
                                <span><?php echo date('Y-m-d', $value['user_regtime']); ?></span>
                            </p>
                        </div>
                    </em>
                    <em class="v2"><?php echo $value['order_number']; ?></em>
                    <em class="v3"><?php echo $value['store_name']; ?></em>
                    <em class="v4"><?php echo $value['order_count']; ?></em>
                    <em class="v5"><?php echo $value['goods_amount']; ?></em>
                    <em class="v6"><?php echo $value['order_commission']; ?></em>
                    <em class="v7"><?php echo date('Y-m-d H:i:s', $value['time_create']); ?></em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 推荐人列表 -->

        </div>
        <!-- 用户消费统计 -->

        <!-- 分页 -->
        <div class="page" style="margin-bottom:30px;">
            <?php if ($a_view_data['type'] == 6) {
                echo $this->pages->link_style_one($this->router->url('selforder_search-'.$a_view_data['sta_id'].'-'.$a_view_data['keywords'].'-', [], false, false));
            } else if ($a_view_data['type'] == 1) {
                echo $this->pages->link_style_one($this->router->url('statistic_selforder-'.$a_view_data['sta_id'].'-', [], false, false));
            } else if ($a_view_data['type'] == 2) {
                echo $this->pages->link_style_one($this->router->url('statistic_otherorder-'.$a_view_data['sta_id'].'-', [], false, false));
            } else if ($a_view_data['type'] == 7) {
                echo $this->pages->link_style_one($this->router->url('otherorder_search-'.$a_view_data['sta_id'].'-'.$a_view_data['keywords'].'-', [], false, false));
            } ?>
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

<script>
$(function(){
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
})

function selforder_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    }
}

</script>