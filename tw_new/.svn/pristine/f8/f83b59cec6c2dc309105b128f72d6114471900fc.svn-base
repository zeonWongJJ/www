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
    <link rel="stylesheet" href="static/style_default/style/slideAdmin.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/slideAdmin.js"></script>
    <title>广告管理</title>
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


        <div class="slideAdmin">
            <p>广告轮播管理</p>
            <div class="slide_content">
                <form action="">
                    <a href="ad_add"><img src="static/style_default/image/pro_03.png" />添加图片</a>
                </form>
            </div>

            <div class="choice_slide">
                <table>
                    <thead>
                    <tr>
                        <td>
                            <span>图片</span>
                        </td>
                        <td>
                            <span>标题</span>
                        </td>
                        <td>
                            <span>链接</span>
                        </td>
                        <td>
                            <span>排序</span>
                        </td>
                        <td>
                            <span>操作</span>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($a_view_data['ad'] as $key => $value): ?>
                    <tr id="tr_<?php echo $value['ad_id']; ?>">
                        <td>
                            <?php if (!empty($value['ad_pic'])) {
                                echo '<img src="' . $value['ad_pic'] . '">';
                            } ?>
                        </td>
                        <td>
                            <span><?php echo $value['ad_title']; ?></span>
                        </td>
                        <td><?php echo $value['ad_link']; ?></td>
                        <td><?php echo $value['ad_order']; ?></td>
                        <td>
                            <img class="revise" value="<?php echo $value['ad_id']; ?>" src="static/style_default/image/pro_26.png" />
                            <img onclick="ad_update(<?php echo $value['ad_id']; ?>)" src="static/style_default/image/pro_28.png" />
                        </td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('ad_showlist-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!-- 遮罩层 -->
        <div class="lay"></div>
        <!-- 遮罩层 -->

        <!-- 重要提示 -->
        <div class="tips_lay">
            <h4>重要提示</h4>
            <p>*确认要删除此轮播吗？</p>
            <span>*删除后不可恢复！</span>
            <img class="tipsClose" src="static/style_default/image/pro_19.png" />
            <div class="tips_btn">
                <em>确认</em>
                <span>再看看</span>
            </div>
        </div>
        <!-- 重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>

<script>

$(function(){
    $(".revise").click(function(){
        $(".tips_lay").show();
        var ad_id = $(this).attr('value');
        $(".tips_btn > em").click(function(){
            // 发送ajax请求
            $.ajax({
                url: 'ad_delete',
                type: 'POST',
                dataType: 'json',
                data: {ad_id: ad_id},
                success: function (res) {
                    console.log(res);
                    if (res.code == 200) {
                        $('#tr_'+ad_id).remove();
                    }
                }
            })
            $(".tips_lay").hide();
        });
    });
})

function ad_update(ad_id) {
    window.location.href = "ad_update-" + ad_id;
}

</script>