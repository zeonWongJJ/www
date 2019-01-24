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
    <link rel="stylesheet" href="static/style_default/style/brands.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/brands.js"></script>
    <title>时间段管理</title>
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

        <!-- 品牌管理 -->
        <div class="cupSize">
            <p>品牌管理>时间段管理</p>
            <div class="cup_content">
                <form action="">
                    <a href="time_add"><img src="static/style_default/image/pro_03.png" alt=""/>添加时间段</a>
                </form>
            </div>
            <!-- 选择 -->
            <div class="choice_stage">
                <table>
                    <thead>
                        <tr>
                            <td class="all_select">
                                <img src="static/style_default/image/pro_07.png" alt=""/>
                                <span>全选</span>
                            </td>
                            <td class="stage_name">
                                <span>阶段名称</span>
                            </td>
                            <td class="stage_time">
                                <span>阶段时间</span>
                            </td>
                            <td class="stage_operate">
                                <span>操作</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($a_view_data as $time) {?>
                        <tr class="id_<?php echo $time['time_id']?>">
                            <td class="choice_list">
                                <img src="static/style_default/image/pro_07.png" alt="" value="<?php echo $time['time_id']?>"/>
                            </td>
                            <td class="stage_name">
                                <span><?php echo $time['time_nema']?></span>
                            </td>
                            <td class="stage_time">
                                <span><?php echo $time['start_time'] .'-'. $time['end_tiem']?></span>
                            </td>
                            <td class="chocie_select">
                                <img src="static/style_default/image/pro_26.png" alt="" onclick="dele(<?php echo $time['time_id']?>)"/>
                                <a href="time_up-<?php echo $time['time_id']?>"><img class="revise" src="static/style_default/image/pro_28.png" alt=""/></a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <!-- 选择 -->
            <!-- 底部工具栏 -->
            <div class="tool_bottom">
                <a class="bottomAllSelect">
                    <img src="static/style_default/image/pro_07.png" alt=""/>
                    <span>全选</span>
                </a>
                <a class="bottomDelect">
                    <img src="static/style_default/image/pro_26.png" alt=""/>
                    <span>删除</span>
                </a>
            </div>
            <!-- 底部工具栏 -->
        </div>
        <!-- 品牌管理 -->

        <!-- 重要提示 -->
        <div class="tips_lay hide">
            <h4>重要提示</h4>
            <p>*确认要删除吗？</p>
            <span>*删除后不可恢复，平台将停止销售此时间段的产品</span>
            <img class="tipsClose" src="static/style_default/image/pro_19.png" alt=""/>
            <div class="tips_btn">
                <em>确认</em>
                <span>在看看</span>
            </div>
        </div>
        <!-- 重要提示 -->

        <!-- 遮罩层 -->
        <div class="lay"></div>
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>
<script>
    function dele(time_id) {
        $('.tips_btn>em').click(function() {
            $.ajax({
                url: '<?php echo $this->router->url('time_dele'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {id: time_id, vart: 1},
                success: function(data) {
                    if (data.code == 1) {
                        $('.id_'+time_id).remove();
                        $(".tips_lay").addClass("hide");
                        $(".lay").hide();
                    } else {
                        alert('删除失败！');                   
                    };
                }
            })
        })
        
    }

    $('.tips_btn>em').click(function() {
        var id = new Array();
        var i = 0;
        $('.checkbox_list').each(function() {
            id[i] = $(this).attr('value');
            i++;
        });
        $.ajax({
            url: '<?php echo $this->router->url('time_dele'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {id: id, vart: 2},
            success: function(ret) {
                if (ret.code == 1) {
                    window.location.reload();
                } else {
                    alert('删除杯型失败！');                   
                };
            }
        })
    })
</script>