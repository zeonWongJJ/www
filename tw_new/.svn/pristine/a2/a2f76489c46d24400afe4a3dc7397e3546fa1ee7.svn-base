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
    <link rel="stylesheet" href="./static/style_default/style/pointDetailed.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>积分明细</title>
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

        <!-- 积分明细 -->
        <div class="pointDetailed">
            <p>积分管理</p>
            <!-- 用户信息 -->
            <div class="userInfo">
                <p>用户信息</p>
                <div class="infoContent">
                    <?php if (empty($a_view_data['user']['user_pic'])) {
                        echo '<img src="./static/style_default/image/tt_03.png" />';
                    } else if(strpos($a_view_data['user']['user_pic'], 'http') === false) {
                        echo '<img src="'.get_config_item('vdao_mobile').$a_view_data['user']['user_pic'].'" />';
                    } else {
                        echo '<img src="'.$a_view_data['user']['user_pic'].'" />';
                    } ?>
                    <ul class="conA">
                        <li>
                            <span>用户名：</span>
                            <em><?php echo $a_view_data['user']['user_name']; ?></em>
                        </li>
                        <li>
                            <span>性别：</span>
                            <em><?php if ($a_view_data['user']['user_sex'] == 1) { echo '男'; } else if ($a_view_data['user']['user_sex'] == 2) { echo '女'; } else { echo '未知'; } ?></em>
                        </li>
                        <li>
                            <span>邮箱：</span>
                            <em><?php echo $a_view_data['user']['user_email']; ?></em>
                        </li>
                    </ul>
                    <ul class="conB">
                        <li>
                            <span>注册时间：</span>
                            <em><?php echo date('Y-m-d', $a_view_data['user']['user_regtime']); ?></em>
                        </li>
                        <li>
                            <span>联系电话：</span>
                            <em><?php echo $a_view_data['user']['user_phone']; ?></em>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 用户信息 -->
            <!-- 积分列表 -->
            <div class="details">
                <div class="pointState">
                    <em class="pointTime">
                        <span>积分明细：</span>
                        <select name="pl_time" onchange="change_time()">
                            <option value="9" <?php if ($a_view_data['time'] == 9) { echo "selected='selected'"; } ?>>全部时间</option>
                            <?php foreach ($a_view_data['month'] as $key => $value) { ?>
                                <option value="<?php echo $value; ?>" <?php if ($a_view_data['time'] == $value) { echo "selected='selected'"; } ?>>
                                <?php echo date('Y-m', $value); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </em>
                    <em class="pointChoice">
                        <span>高级选项：</span>
                        <select name="pl_type" onchange="change_type()">
                            <option value="9" <?php if ($a_view_data['type'] == 9) { echo "selected='selected'"; } ?>>全部状态</option>
                            <option value="1" <?php if ($a_view_data['type'] == 1) { echo "selected='selected'"; } ?>>积分增加</option>
                            <option value="2" <?php if ($a_view_data['type'] == 2) { echo "selected='selected'"; } ?>>积分减少</option>
                        </select>
                    </em>
                </div>
                <!-- 积分数据 -->
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">序号</em>
                        <em class="v2">变动时间</em>
                        <em class="v3">积分变动详情</em>
                        <em class="v4">积分状态</em>
                        <em class="v5">积分数</em>
                        <em class="v6">积分盈余</em>
                    </li>
                    <?php $i=1; foreach ($a_view_data['points'] as $key => $value): ?>
                    <li class="cateBody">
                        <div class="varieties">
                            <em class="v1"><?php echo ($a_view_data['page']-1) * 10 + $i; ?></em>
                            <em class="v2"><?php echo date('Y-m-d H:i:s', $value['pl_time']); ?></em>
                            <em class="v3"><?php echo $value['pl_description']; ?></em>
                            <em class="v4"><?php echo $value['pl_item']; ?></em>
                            <em class="v5"><?php if ($value['pl_type'] == 1) { echo '+'.$value['pl_variation']; } else { echo '-'.$value['pl_variation']; } ?></em>
                            <em class="v6"><?php echo $value['pl_score']; ?></em>
                        </div>
                    </li>
                    <?php $i++; endforeach ?>
                </ul>
                <!-- 积分数据 -->
            </div>
            <!-- 积分列表 -->
        </div>
        <!-- 积分明细 -->
        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('score_detail-'.$a_view_data['user']['user_id'].'-'.$a_view_data['type'].'-'.$a_view_data['time'].'-', [], false, false)); ?>
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

// 改变类型
function change_type() {
    var pl_type = $("select[name='pl_type']").val();
    var user_id = "<?php echo $a_view_data['user']['user_id']; ?>";
    var pl_time = "<?php echo $a_view_data['time']; ?>";
    window.location.href = 'score_detail-'+user_id+'-'+pl_type+'-'+pl_time;
}

// 改变时间
function change_time() {
    var pl_type = "<?php echo $a_view_data['type']; ?>";
    var pl_time = $("select[name='pl_time']").val();
    var user_id = "<?php echo $a_view_data['user']['user_id']; ?>";
    window.location.href = 'score_detail-'+user_id+'-'+pl_type+'-'+pl_time;
}

</script>