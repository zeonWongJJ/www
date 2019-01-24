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
    <link rel="stylesheet" href="static/style_default/style/swiper.css"/>
    <link rel="stylesheet" href="static/style_default/style/suppLiesRecord.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/suppliesRecord.js"></script>
    <script src="static/style_default/plugin/swiper.js"></script>
    <title>耗材管理记录</title>
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

        <!-- 耗材管理记录 -->
        <div class="suppliesRecord">
            <p>耗材管理>耗材管理记录</p>


            <!-- 入库列表 -->
            <div class="supplies_content">
                <form action="<?php echo $this->router->url('entry_record')?>" method='post' id="formId">
                    <a href="<?php echo $this->router->url('entry_add')?>"><img src="static/style_default/image/pro_03.png" alt=""/>添加入库</a>
                    <div class="search_supplies">
                        <input type="text" placeholder="材料名称" onfocus="javascript:if(this.value=='材料名称')this.value='';" name="name"/>
                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </div>
                </form>
            </div>
            <ul class="storageList">
                <li class="cateHead">
                    <em class="v1">发生时间</em>
                    <em class="v2">材料名称</em>
                    <em class="v3">数量</em>
                    <em class="v4">总价</em>
                    <em class="v5 stateBox" style="">
                        <?php if ($a_view_data['i_state'] == 0) {
                            echo '<span>'.'全部状态'.'</span>';
                        } else if ($a_view_data['i_state'] == 1) {
                            echo '<span>'.'入库'.'</span>';
                        } else if ($a_view_data['i_state'] == 2) {
                            echo '<span>'.'出库'.'</span>';
                        }?>
                        <img src="static/style_default/image/pro_13.png" alt=""/>
                        <div class="state hide">
                            <a href="<?php echo $this->router->url('entry_record', [$this->general->base64_convert($a_view_data['a_name']),'i_two' => 0,'i_pag' => 1]); ?>">全部状态</a>
                            <a href="<?php echo $this->router->url('entry_record', [$this->general->base64_convert($a_view_data['a_name']),'i_two' => 1,'i_pag' => 1]); ?>">入库</a>
                            <a href="<?php echo $this->router->url('entry_record', [$this->general->base64_convert($a_view_data['a_name']),'i_two' => 2,'i_pag' => 1]); ?>">出库</a>
                        </div>
                    </em>
                    <em class="v6">操作原因</em>
                    <em class="v7">凭证</em>
                    <em class="v8">操作人员</em>
                    <em class="v9">操作</em>
                </li>
                <?php foreach ($a_view_data['annex'] as $annex) {?>
                <li class="cateBody">
                    <em class="v1"><?php echo date('Y-m-d H:i', $annex['add_time']);?></em>
                    <em class="v2"><?php echo $annex['consu_name']?></em>
                    <em class="v3"><?php echo $annex['amount']?></em>
                    <em class="v4"><?php echo $annex['price']?></em>
                    <em class="v5"><?php if ($annex['state'] == 1) {
                     echo "入库";} else {echo "出库";} ?></em>
                    <em class="v6"><?php echo $annex['reason']?></em>
                    <em class="v7" value="<?php echo $annex['record_id']?>"><?php if ($annex['state'] == 1) {?>查看<?php }?></em>
                    <em class="v8"><?php echo $annex['operate']?></em>
                    <em class="v9"><?php if ($annex['state'] == 1) {?>
                        <a href="entry_uptate-<?php echo $annex['record_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                    <?php }?></em>
                </li>
                <?php }?>
            </ul>
            <!-- 入库列表 -->

            <!-- 查看照片 -->
            <div class="lookPicture hide">
                <p>查看凭证</p>
                <div class="picBox">
                    <div class="swiper-container" style="width:200px">
                        <div class="swiper-wrapper">
                           <!--  <div class="swiper-slide"><a href="#"><img src="static/style_default/image/bd.jpg" alt=""/></a></div>
                            <div class="swiper-slide"><a href="#"><img src="static/style_default/image/storeBg_03.png" alt=""/></a></div>
                            <div class="swiper-slide"><a href="#"><img src="static/style_default/image/bd.jpg" alt=""/></a></div> -->
                        </div>

                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <a>
                    <span class="closePic">关闭窗口</span>
                </a>
            </div>
            <!-- 查看照片 -->

            <!-- 分页 -->
            <div class="page">
               <?php echo $a_view_data['pages']?>
                <span style="background:none">共计<em><?php echo $a_view_data['ourt']?></em>条数据</span>
                <script>
                    $(function(){
                        $('.page a').each(function(index, el) {
                            if ($(this).attr('href') == '#') {
                                $(this).css('background-color','#6e5c58');
                                $(this).css('color','#ffffff');
                            }
                        });
                    })
                </script>
            </div>
            <!-- 分页 -->

        </div>
        <!-- 耗材管理记录 -->

    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>