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
    <link rel="stylesheet" href="static/style_default/style/suppliesList.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/suppliesList.js"></script>
    <title>耗材列表</title>
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

        <!-- 耗材列表 -->
        <div class="suppliesList">
            <p>耗材管理>耗材列表</p>
            <!-- 耗材内容 -->
            <div class="supplies_content">
                <!-- 耗材种类 -->
                <ul>
                    <li class="coffee_cate">
						<?php foreach ($a_view_data['search']['cons'] as $cons) {?>
                         <span <?php if ($a_view_data['i_one'] == $cons['id']) {echo 'class="cateCur"';}?>><a href="<?php echo $this->router->url('annex', ['i_one' => $cons['id'],'i_two' => 0,'i_three' => 0, 'i_pag' => 1]); ?>"><?php echo $cons['cons_name']?></a></span>
						<?php }?>
                        <em class="add_product">
                            <img src="static/style_default/image/pro_03.png" alt=""/>
                            <span><a href="<?php echo $this->router->url('annex_add')?>">添加耗材</a></span>
                        </em>
                    </li>
                    <li class="coffee_type">
                        <em>二级分类：</em>
	                    <span <?php if ($a_view_data['i_two'] == 0) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('annex', [$a_view_data['i_one'],'i_two' => 0,'i_three' => 0,'i_pag' => 1]); ?>">全部</a></span>
	                    <?php foreach ($a_view_data['search']['second'] as $pron) {	?>
    						<span <?php if ($a_view_data['i_two'] == $pron['id']) { echo 'class="typeCur"';}?>>
    						<a href="<?php echo $this->router->url('annex', [$a_view_data['i_one'],'i_two' => $pron['id'],'i_three' => 0,'i_pag' => 1]); ?>"><?php echo $pron['cons_name']?></a></span>
    					<?php }?>	
                    </li>
                    <li class="coffee_grade">
                        <em>三级分类：</em>
                        <span <?php if ($a_view_data['i_three'] == 0) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('annex', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => 0,'i_pag' => 1]); ?>">全部</a></span>
	        					<?php foreach ($a_view_data['search']['third'] as $pro) {?>
							<span <?php if ($a_view_data['i_three'] == $pro['id']) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('annex', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => $pro['id'],'i_pag' => 1]); ?>"><?php echo $pro['cons_name']?></a></span>
							<?php } ?>
                    </li>
                </ul>
                <!-- 耗材种类 -->

            </div>
            <!-- 耗材内容 -->
            <!-- 耗材分类 -->
            <ul class="storageList">
                <li class="cateHead">
                    <em class="v1">耗材名称</em>
                    <em class="v2">单价</em>
                    <em class="v3">单位</em>
                    <em class="v4">库存量</em>
                    <em class="v5">昨日消耗量</em>
                    <em class="v6">预警值</em>
                    <em class="v7">操作</em>
                </li>
                <?php foreach ($a_view_data['annex'] as $annex) {?>
                <li class="cateBody">
                    <em class="v1"><?php echo $annex['consu_name']?></em>
                    <em class="v2"><?php echo $annex['price']?></em>
                    <em class="v3"><?php echo $annex['units']?></em>
                    <em class="v4"><?php echo $annex['amount']?></em>
                    <em class="v5"><?php foreach ($a_view_data['expend'] as $expend)
                    { 
                        if ($annex['consumption_id'] == $expend['consumption_id']) {
                    	echo $expend['expend'];
                    }
                    }?></em>
                    <em class="v6"><?php echo $annex['prewaning']?></em>
                    <em class="v7">
                        <img src="static/style_default/image/pro_26.png" alt="" class="delete" value="<?php echo $annex['consumption_id']?>"/>
                        <a href="annex_update-<?php echo $annex['consumption_id']?>"><img src="static/style_default/image/pro_28.png" alt=""/></a>
                    </em>
                </li>
                <?php }?>
            </ul>
            <!-- 耗材分类 -->
        </div>
        <!-- 耗材列表 -->


        <!--  重要提示 -->
        <div class="tips hide">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="quxiao" />
            <p>
                <span>▪ 确认删除这一部分分类吗？</span>
                <span>▪ 删除后不可恢复，所删除分类下的所有产品也将被删除</span>
            </p>
            <div class="tipsBtn">
                <em class="duetw">确定</em>
                <a class="quxiao" >再看看</a>
            </div>
        </div>
        <!--  重要提示 -->

        <!-- 分页 -->
        <div class="page">
           <?php echo $a_view_data['pages']?>
            <span style="background:none">共计<em> <?php echo $a_view_data['zonsh']?> </em>条数据</span>
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


    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>