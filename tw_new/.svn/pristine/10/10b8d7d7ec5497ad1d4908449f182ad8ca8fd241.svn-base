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
    <link rel="stylesheet" href="static/style_default/style/packageList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <title>套餐列表</title>
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


        <div class="productList">
            <p>套餐管理>套餐列表</p>
            <a class="add_package" href="package_add" style="color:#000;">
                <img src="static/style_default/image/pro_03.png" />
                <span>添加套餐</span>
            </a>
            <div class="product_content">
                <div class="product_contentBox">
                    <ul>
                        <li>
                            <?php foreach ($a_view_data['product'] as $key => $value): ?>
                            <div class="boxTobox" id="tr_<?php echo $value['product_id']; ?>">
                                <i>
                                <?php if (!empty($value['pro_img'])) {
                                    echo '<img src=" ' . $value['pro_img'] . ' ">';
                                } else {
                                    echo '<img src="static/style_default/image/l_03.png" />';
                                } ?>
                                </i>
                                <div class="product_info">
                                    <h2><?php echo mb_substr($value['product_name'], 0, 20); ?>..</h2>
                                    <p>
                                    <?php
                                        $subject = strip_tags($value['pro_details']);//去除html标签
                                        $pattern = '/\s/';//去除空白
                                        $content = preg_replace($pattern, '', $subject);
                                        $seodata = mb_substr($content, 0, 50);//截取100个汉字
                                        echo $seodata;
                                    ?>
                                    </p>
                                    <span class="proDisable" value="<?php echo $value['pro_show']; ?>" proid="<?php echo $value['product_id']; ?>">
                                        <em>启用/暂用</em>
                                        <?php if ($value['pro_show'] == 1) {
                                            echo '<img src="static/style_default/image/pro_10.png" />';
                                        } else {
                                            echo '<img src="static/style_default/image/pro_33.png" />';
                                        } ?>
                                    </span>
                                    <div class="productType">
                                   <span>
                                        <?php if (!empty($value['antistop'])) {
                                            $keywords = explode(',', $value['antistop']);
                                            for ($i=0; $i < count($keywords); $i++) {
                                                echo '<a>' . $keywords[$i] . '</a> ';
                                            }
                                        } ?>
                                   </span>
                                        <em><?php echo $value['price']; ?>元</em>
                                    </div>
                                </div>
                                <img class="productTips" src="static/style_default/image/tips_05.png" />
                                <div class="popLay hide">
                                    <p class="pop_dele" onclick="product_delete(<?php echo $value['product_id']; ?>)">
                                        <img src="static/style_default/image/pro_26.png" />
                                        <span>删除产品</span>
                                    </p>
                                    <p class="pop_edit" onclick="product_update(<?php echo $value['product_id']; ?>)">
                                        <img src="static/style_default/image/pro_28.png" />
                                        <span>编辑产品</span>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 分页 -->
        <div class="page">
            <?php echo $this->pages->link_style_one($this->router->url('package_showlist-', [], false, false)); ?>
            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        </div>
        <!-- 分页 -->

        <!--  重要提示 -->
        <div class="tips">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" />
            <p>
                <span>▪ 确认删除此产品吗？</span>
                <span>▪ 删除后不可恢复！</span>
            </p>
            <div class="tipsBtn">
                <em>确定</em>
                <a>再看看</a>
            </div>
        </div>
        <!--  重要提示 -->

        <!--遮罩层 -->
        <div class="lay"></div>
        <!--遮罩层 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
<script>
    $(".tips").hide();
    $(".lay").hide();

    //禁用启用
    $(".proDisable>img").click(function(){
        var nowstate = $(this).parent('.proDisable').attr('value');
        var product_id = $(this).parent('.proDisable').attr('proid');
        var thisdom = $(this);
        // 发送ajax请求
        $.ajax({
            url: 'package_switch',
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id},
            success: function(res) {
                console.log(res);
                if (res.code == 200) {
                    if (nowstate == 1) {
                        thisdom.attr('src','static/style_default/image/pro_33.png');
                        thisdom.parent('.proDisable').attr('value', 2);
                    } else {
                        thisdom.attr('src','static/style_default/image/pro_10.png');
                        thisdom.parent('.proDisable').attr('value', 1);
                    }
                }
            }
        })
    });

    //弹出层
    $(".productTips").click(function(e){
        $(this).next(".popLay").removeClass("hide");
        e.stopPropagation();
    });
    $(".popLay").click(function(e){
        e.stopPropagation();
    });
    $(document.body).click(function(){
        $(".popLay").addClass("hide");
    });

    // 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });


    $(".productTips").click(function(e){
        $(this).next(".popLay").removeClass("hide");
        e.stopPropagation();
    });
    $(".popLay").click(function(e){
        e.stopPropagation();
    });
    $(document.body).click(function(){
        $(".popLay").addClass("hide");
    });

    $(".tipsBtn>a").click(function(){
        $(".tips").hide();
    });
    $(".tips>img").click(function(){
        $(".tips").hide();
    });


    function product_delete(product_id) {
        $(".tips").show();
        $('.tipsBtn em').click(function(event) {
            // 发送ajax请求
            $.ajax({
                url: 'package_delete',
                type: 'POST',
                dataType: 'json',
                data: {product_id: product_id},
                success: function(res){
                    console.log(res);
                    if (res.code == 200) {
                        $("#tr_"+product_id).remove();
                    }
                }
            })
            // 隐藏弹框
            $(".tips").hide();
            $(".lay").hide();
        });
    }

    function product_update(product_id) {
        window.location.href = "package_update-"+product_id;
    }

</script>
</body>
</html>