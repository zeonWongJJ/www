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
    <link rel="stylesheet" href="./static/style_default/style/storeSettlement.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <title>门店结算</title>
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

        <!-- 门店结算 -->
        <div class="storeSettlement">
            <p><a style="color:#000;" href="account_store">门店结算</a> >
                <?php
                    if ($a_view_data['state'] == 9 && $a_view_data['time'] == 9) {
                        echo '全部';
                    }
                    if ($a_view_data['state'] == 9 && $a_view_data['time'] != 9) {
                        echo date('Y年m月', $a_view_data['time']);
                    }
                    if ($a_view_data['state'] != 9 && $a_view_data['time'] == 9) {
                        if ($a_view_data['state'] == 0) {
                            echo '待核算';
                        } else if ($a_view_data['state'] == 1) {
                            echo '待结算';
                        } else if ($a_view_data['state'] == 2) {
                            echo '已结算';
                        }
                    }
                    if ($a_view_data['state'] != 9 && $a_view_data['time'] != 9) {
                        echo date('Y年m月', $a_view_data['time']).' > ';
                        if ($a_view_data['state'] == 0) {
                            echo '待核算';
                        } else if ($a_view_data['state'] == 1) {
                            echo '待结算';
                        } else if ($a_view_data['state'] == 2) {
                            echo '已结算';
                        }
                    }
                    echo ' > 第<b>'.$a_view_data['page'].'</b>页';
                ?>
            </p>
            <!-- 结算列表 -->
            <div class="setList">
                <a class="setA" href="<?php echo $this->router->url('account_store',['state'=>0,'time'=>9]); ?>">
                    <em>
                        <p><?php echo $a_view_data['state_one']; ?></p>
                        <span>待核算</span>
                    </em>
                    <img src="./static/style_default/image/ss_03.png" alt=""/>
                </a>
                <a class="setB" href="<?php echo $this->router->url('account_store',['state'=>1,'time'=>9]); ?>">
                    <em>
                        <p><?php echo $a_view_data['state_two']; ?></p>
                        <span>待结算</span>
                    </em>
                    <img src="./static/style_default/image/ss_03.png" alt=""/>
                </a>
                <a class="setC" href="<?php echo $this->router->url('account_store',['state'=>2,'time'=>9]); ?>">
                    <em>
                        <p><?php echo $a_view_data['state_three']; ?></p>
                        <span>已结算</span>
                    </em>
                    <img src="./static/style_default/image/ss_03.png" alt=""/>
                </a>
            </div>
            <!-- 结算列表 -->
            <!-- 账单列表 -->
            <div class="details">
                <div class="pointState">
                    <em class="pointTime">
                        <span>时间：</span>
                        <select name="account_time" onchange="account_store()">
                            <option value="9" <?php if ($a_view_data['time']==9) { echo 'selected'; } ?>>全部</option>
                            <?php foreach ($a_view_data['month'] as $key => $value): ?>
                            <option value="<?php echo $value; ?>" <?php if ($a_view_data['time']==$value) { echo 'selected'; } ?>><?php echo date('Y年m月', $value); ?></option>
                            <?php endforeach ?>
                        </select>
                    </em>
                    <em class="pointChoice">
                        <span>高级选项：</span>
                        <select name="account_state" onchange="account_store()">
                            <option value="9" <?php if ($a_view_data['state']==9) { echo 'selected'; } ?>>全部</option>
                            <option value="0" <?php if ($a_view_data['state']==0) { echo 'selected'; } ?>>待核算</option>
                            <option value="1" <?php if ($a_view_data['state']==1) { echo 'selected'; } ?>>待结算</option>
                            <option value="2" <?php if ($a_view_data['state']==2) { echo 'selected'; } ?>>已结算</option>
                        </select>
                    </em>
                </div>
                <!-- 积分数据 -->
                <ul class="cateList">
                    <li class="cateHead">
                        <em class="v1">店铺名称</em>
                        <em class="v2">店长名字</em>
                        <em class="v3">联系电话</em>
                        <em class="v4">月订单总数</em>
                        <em class="v5">月销售餐饮总数量</em>
                        <em class="v10">月预约办公订单总数量</em>
                        <em class="v6">月销售金额</em>
                        <em class="v7">月箱单返积分</em>
                        <em class="v8">结算状态</em>
                        <em class="v9">操作</em>
                    </li>
                    <?php foreach ($a_view_data['account'] as $key => $value): ?>
                    <li class="cateBody">
                        <div class="varieties">
                            <em class="v1"><?php echo $value['store_name']; ?></em>
                            <em class="v2"><?php echo $value['store_linkman']; ?></em>
                            <em class="v3"><?php echo $value['store_contact']; ?></em>
                            <em class="v4"><?php echo $value['order_count']; ?></em>
                            <em class="v5"><?php echo $value['coffee_ordercount']; ?></em>
                            <em class="v10"><?php echo $value['office_ordercount']; ?></em>
                            <em class="v6"><?php echo $value['money_count']; ?></em>
                            <em class="v7"><?php echo $value['month_score']; ?></em>
                            <em class="v8">
                            <?php if ($value['account_state'] == 0) {
                                echo '待核算';
                            } else if ($value['account_state'] == 1) {
                                echo '待结算';
                            } else if ($value['account_state'] == 2) {
                                echo '已结算';
                            } ?>
                            </em>
                            <em class="v9">
                                <span>
                                    <a href="<?php echo $this->router->url('account_detail',['id'=>$value['account_id'],'stye'=>1]); ?>">查看明细</a>
                                </span>
                            </em>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
                <!-- 积分数据 -->
            </div>
            <!-- 账单列表 -->
        </div>
        <!-- 门店结算 -->

        <!--&lt;!&ndash; 核算总额 &ndash;&gt;-->
        <!--<div class="totalAccount">-->
            <!--<div class="priceBox">-->
                <!--<p>-->
                    <!--<span>核算金额</span>-->
                    <!--<img class="priceHelp" src="./static/style_default/image/ww_03.png" alt=""/>-->
                <!--</p>-->
                <!--<span>123456.00</span>-->
            <!--</div>-->
            <!--<span>核算</span>-->
        <!--</div>-->
        <!--&lt;!&ndash; 核算总额 &ndash;&gt;-->

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('account_store-'.$a_view_data['state'].'-'.$a_view_data['time'].'-', [], false, false)); ?>
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
    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });
})

function account_store() {
    // 获取筛选条件
    var account_state = $("select[name='account_state']").val();
    var account_time = $("select[name='account_time']").val();
    window.location.href = 'account_store-'+account_state+'-'+account_time;
}

</script>