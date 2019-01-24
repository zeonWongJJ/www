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
    <link rel="stylesheet" href="./static/style_default/style/userStatistics.css"/>
    <link rel="stylesheet" href="./static/style_default/layui/css/layui.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/layui/layui.js"></script>
    <title>消费统计</title>
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
        <div class="userStatistics">
            <p>用户消费统计 >
            <?php if ($a_view_data['time'] == 9 && $a_view_data['type'] == 1) {
                echo '全部';
            } else if ($a_view_data['time'] != 9 && $a_view_data['type'] == 1) {
                echo date('Y年m月', $a_view_data['time']);
            } else if ($a_view_data['type'] == 6) {
                echo '搜索['.$a_view_data['keywords'].']';
            }
            echo ' > 第'.$a_view_data['page'].'页';
            ?>
            </p>
            <!-- 月订单列表 -->
            <div class="oreders_content">
                <form id="searchform" action="<?php echo $this->router->url('statistic_search'); ?>" method="post">
                    <div class="ordersDate">
                        <span>月订单交易成功账单</span>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <select name="sta_time" onchange="change_time()">
                                  <option value="9" <?php if ($a_view_data['time'] == 9) { echo 'selected'; } ?>>全部月份</option>
                                  <?php foreach ($a_view_data['month'] as $key => $value): ?>
                                  <option value="<?php echo $value; ?>" <?php if ($a_view_data['time'] == $value) { echo 'selected'; } ?> ><?php echo date('Y年m月',$value); ?></option>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="search_num">
                        <?php if ($a_view_data['type'] == 6) {
                            echo '<input type="text" name="keywords" value="'.$a_view_data['keywords'].'"/>';
                        } else {
                            echo '<input type="text" name="keywords" placeholder="用户名/手机号"/>';
                        } ?>
                        <i><img src="./static/style_default/image/s_03.png" onclick="static_search()" /></i>
                    </div>
                </form>
            </div>
            <ul class="ordersList">
                <li class="cateHead">
                    <em class="v1" style="text-align:left;">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户
                    </em>
                    <em class="v2">月订单数</em>
                    <em class="v3">月消费咖啡杯数</em>
                    <em class="v4">月消费总额</em>
                    <em class="v5">推荐的人月订单数</em>
                    <em class="v6">推荐的人月消费咖啡杯数</em>
                    <em class="v7">推荐的人月消费总额</em>
                    <em class="v8">操作</em>
                </li>
                <?php foreach ($a_view_data['user'] as $key => $value): ?>
                <li class="cateBody">
                    <em class="v1" style="text-align:left;">
                        <div class="ordersInfo">
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
                    <em class="v2"><?php echo $value['user_selfsum']; ?></em>
                    <em class="v3"><?php echo $value['user_selfcount']; ?></em>
                    <em class="v4"><?php echo $value['user_self']; ?></em>
                    <em class="v5"><?php echo $value['user_othersum']; ?></em>
                    <em class="v6"><?php echo $value['user_othercount']; ?></em>
                    <em class="v7"><?php echo $value['user_other']; ?></em>
                    <em class="v8">
                        <a href="<?php echo $this->router->url('statistic_selforder',['id'=>$value['sta_id']]); ?>">订单列表</a>
                        <a href="<?php echo $this->router->url('statistic_otherorder',['id'=>$value['sta_id']]); ?>">推荐的人订单列表</a>
                    </em>
                </li>
                <?php endforeach ?>
            </ul>
            <!-- 月订单列表 -->

        </div>
        <!-- 用户消费统计 -->

        <!-- 分页 -->
        <div class="page">
            <?php if ($a_view_data['type'] == 6) {
                echo $this->pages->link_style_one($this->router->url('statistic_search-'.$a_view_data['keywords'].'-', [], false, false));
            } else {
                echo $this->pages->link_style_one($this->router->url('statistic_showlist-'.$a_view_data['time'].'-', [], false, false));
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

function change_time() {
    var sta_time = $("select[name='sta_time']").val();
    window.location.href = "statistic_showlist-"+sta_time;
}

function static_search() {
    var keywords = $("input[name='keywords']").val();
    if (keywords != '') {
        $("#searchform").submit();
    }
}

</script>