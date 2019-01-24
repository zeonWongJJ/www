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
    <link rel="stylesheet" href="./static/style_default/style/setCenter.css"/>
    <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="./static/style_default/script/public.js"></script>
    <script src="./static/style_default/script/setCenter.js"></script>
    <title>设置中心</title>
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

        <!-- 设置中心 -->
        <div class="setCenter">
            <p>设置中心</p>
            <!-- 设置列表 -->
            <ul class="setList">
                <li>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_03.png" /></p>
                        <p class="listText">用户注册开关</p>
                        <p class="listSwitch" id="user_register_switch">
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='user_register_switch' && $value['set_parameter']==1) {
                                echo '<img class="choice" src="./static/style_default/image/pro_10.png" value="2" />';
                            } else if ($value['set_name']=='user_register_switch' && $value['set_parameter']==2) {
                                echo '<img class="choice" src="./static/style_default/image/pro_33.png" value="1" />';
                            } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit" style="visibility:hidden">
                            <span>修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_05.png" /></p>
                        <p class="listText">普通用户消费获得积分比例</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='user_score_ratio') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="user_score_ratio">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_07.png" /></p>
                        <p class="listText">普通用户推荐消费提成比例</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='user_consume_ratio') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="user_consume_ratio">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_05.png" /></p>
                        <p class="listText">移动店主消费获得积分比例</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='shopman_score_retio') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="shopman_score_retio">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_07.png" /></p>
                        <p class="listText">移动店主推荐消费提成比例</p>
                        <p class="listCon" >
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='shopman_referee_ratio') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="shopman_referee_ratio">修改</span>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_19.png" /></p>
                        <p class="listText">动态审核开关</p>
                        <p class="listSwitch" id="mood_state_review">
                        <?php foreach ($a_view_data as $key => $value): ?>
                        <?php if ($value['set_name']=='mood_state_review' && $value['set_parameter']==1) {
                            echo '<img class="choice" src="./static/style_default/image/pro_10.png" value="0" />';
                        } else if ($value['set_name']=='mood_state_review' && $value['set_parameter']==0) {
                            echo '<img class="choice" src="./static/style_default/image/pro_33.png" value="1" />';
                        } ?>
                        <?php endforeach ?>
                        </p>
                        <p class="edit" style="visibility:hidden">
                            <span>修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/se_11.png" /></p>
                        <p class="listText">营业时间</p>
                        <p class="listCon">
                            <input type="text" style="font-size:18px;" />
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='store_open_time') { echo '<span style="font-size:18px;">'.$value['set_parameter'].'</span>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="store_open_time">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/se_06.png" /></p>
                        <p class="listText">门店抢单返积分比例</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='score_tostore_ratio') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="score_tostore_ratio">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_09.png" /></p>
                        <p class="listText">预约办公室需消费金额</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='appointment_user_consume') { echo '<span>'.$value['set_parameter'].'</span>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="appointment_user_consume">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/setC_11.png" /></p>
                        <p class="listText">积分提现比例</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='user_score_cash') { echo '<span>'.$value['set_parameter'].'</span><em>%</em>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="user_score_cash">修改</span>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/se_18.png" /></p>
                        <p class="listText">咖啡配送费</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='user_order_freight') { echo '<span>'.$value['set_parameter'].'</span>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="user_order_freight">修改</span>
                        </p>
                    </div>
                    <div class="listBox">
                        <p class="listPic"><img src="./static/style_default/image/se_18.png" /></p>
                        <p class="listText">积分余额提现需到金额</p>
                        <p class="listCon">
                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>
                            <?php foreach ($a_view_data as $key => $value): ?>
                            <?php if ($value['set_name']=='withdraw_limit') { echo '<span>'.$value['set_parameter'].'</span>'; } ?>
                            <?php endforeach ?>
                        </p>
                        <p class="edit">
                            <span value="withdraw_limit">修改</span>
                        </p>
                    </div>
                </li>
            </ul>
            <!-- 设置列表 -->
        </div>
        <!-- 设置中心 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>


<script>

// 注册开关
$('#user_register_switch img').click(function(event) {
    var set_parameter = $(this).attr('value');
    $.ajax({
        url: 'set_update',
        type: 'POST',
        dataType: 'json',
        data: {set_name: 'user_register_switch', set_parameter: set_parameter},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (set_parameter == 2) {
                    $("#user_register_switch img").attr({
                        src: './static/style_default/image/pro_33.png',
                        value: 1,
                    });
                } else {
                    $("#user_register_switch img").attr({
                        src: './static/style_default/image/pro_10.png',
                        value: 2,
                    });
                }
            }
        }
    })
});

// 动态审核开关
$('#mood_state_review img').click(function(event) {
    var set_parameter = $(this).attr('value');
    $.ajax({
        url: 'set_update',
        type: 'POST',
        dataType: 'json',
        data: {set_name: 'mood_state_review', set_parameter: set_parameter, type: 1},
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                if (set_parameter == 0) {
                    $("#mood_state_review img").attr({
                        src: './static/style_default/image/pro_33.png',
                        value: 1,
                    });
                } else {
                    $("#mood_state_review img").attr({
                        src: './static/style_default/image/pro_10.png',
                        value: 0,
                    });
                }
            }
        }
    })
});

</script>