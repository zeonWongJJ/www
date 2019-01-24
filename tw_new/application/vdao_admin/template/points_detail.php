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
    <link rel="stylesheet" href="static/style_default/style/pointDetailed.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
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

        <!-- 积分明细 -->
        <div class="pointDetailed">
            <p>积分管理</p>
            <!-- 用户信息 -->
            <div class="userInfo">
                <p>用户信息</p>
                <div class="infoContent">
                    <img src="static/style_default/image/tt_03.png" alt=""/>
                    <ul class="conA">
                        <li>
                            <span>用户名：</span>
                            <em><?php echo $a_view_data['user']['user_name']?></em>
                        </li>
                        <li>
                            <span>性别：</span>
                            <em><?php if ($a_view_data['user']['user_sex'] == 1) {
                                echo '男';
                            } else if ($a_view_data['user']['user_sex'] == 2) {
                                echo '女';
                            } ?></em>
                        </li>
                        <li>
                            <span>邮箱：</span>
                            <em><?php echo $a_view_data['user']['user_email']?></em>
                        </li>
                    </ul>
                    <ul class="conB">
                        <li>
                            <span>注册时间：</span>
                            <em><?php echo date('Y-m-d', $a_view_data['user']['user_regtime'])?></em>
                        </li>
                        <li>
                            <span>联系电话：</span>
                            <em><?php echo $a_view_data['user']['user_phone']?></em>
                        </li>
                        <li>
                            <span>积分盈余：</span>
                            <em><?php echo $a_view_data['user']['user_score']?></em>
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
                        <select name="" id="">
                            <option value="">2017-01</option>
                            <option value="">2017-01</option>
                        </select>
                    </em>
                    <em class="pointChoice">
                        <span>高级选项：</span>
                        <select name="status" id="">
                            <option value="0">积分状态</option>
                            <option value="1">积分增加</option>
                            <option value="2">积分减少</option>
                        </select>
                    </em>
                </div>
                <!-- 积分数据 -->
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">序号</em>
                        <em class="v2">下单时间</em>
                        <em class="v3">积分变动详情</em>
                        <em class="v4">积分状态</em>
                        <em class="v5">积分数</em>
                        <!-- <em class="v6">积分盈余</em> -->
                    </li>
                    <?php foreach ($a_view_data['points'] as $points) { ?>
                    <li class="cateBody">
                        <div class="varieties">
                            <em class="v1"><?php echo '1'+$i++?></em>
                            <em class="v2"><?php echo date('Y-m-d H:i:s', $points['pl_time_create'])?></em>
                            <em class="v3"><?php echo $points['pl_desc']?></em>
                            <em class="v4"><?php echo $points['pl_stage']?></em>
                            <em class="v5"><?php echo $points['pl_points']?></em>
                            <!-- <em class="v6">926</em> -->
                        </div>
                    </li>
                    <?php }?>
                </ul>
                <!-- 积分数据 -->
            </div>
            <!-- 积分列表 -->
        </div>
        <!-- 积分明细 -->
        <!-- 分页 -->
        <div class="page">
            <!-- <ul>
                <li><a href="" class="prevPage"><img src="static/style_default/image/np_03.png" alt=""/></a></li>
                <li><a href="" class="pageCur">1</a></li>
                <li><a href="" class="">2</a></li>
                <li><a href="" class="">3</a></li>
                <li><a href="" class="">4</a></li>
                <li><a href="" class="">5</a></li>
                <li><a style="background:none;">...</a></li>
                <li><a href="" class="">10</a></li>
                <li><a href="" class="nextPage"><img src="static/style_default/image/np_05.png" alt=""/></a></li>
                <li><a style="background:none;">共计<em> 56 </em>条数据</a></li>
            </ul> -->
            <?php echo $a_view_data['page']?>
        </div>
        <!-- 分页 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>