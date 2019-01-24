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
    <link rel="stylesheet" href="static/style_default/style/productList2.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/productList2.js"></script>
    <title>产品列表</title>
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

        <!-- 产品列表 -->
        <div class="productList">
            <p>产品管理>产品列表</p>
            <!-- 产品内容 -->
            <div class="product_content">
                <!-- 产品种类 -->
                <ul>
                	<em class="add_product">
                        <img src="static/style_default/image/pro_03.png" alt=""/>
                        <span><a href="product_add">添加产品</a></span>
                    </em>
                    <li class="coffee_cate">
                    	<?php foreach ($a_view_data['search']['prot'] as $pro) {?>
                        <span <?php if ($a_view_data['i_one'] == $pro['pro_id']) {echo 'class="cateCur"';}?>><a href="<?php echo $this->router->url('product', ['i_one' => $pro['pro_id'],'i_two' => 0,'i_three' => 0,'i_four' => '', 'i_pag' => 1]); ?>"><?php echo $pro['pro_name']?></a></span>
                        <?php }?>
                        
                    </li>
                    <li class="coffee_type">
                        <em>二级分类：</em>
                        <span <?php if ($a_view_data['i_two'] == 0) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],'i_two' => 0,'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>">全部</a></span>
						<?php foreach ($a_view_data['search']['second'] as $pron) {	?>
    						<span <?php if ($a_view_data['i_two'] == $pron['pro_id']) { echo 'class="typeCur"';}?>>
    						<a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],'i_two' => $pron['pro_id'],'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>"><?php echo $pron['pro_name']?></a></span>
    					<?php }?>	
                    </li>
                    <li class="coffee_grade">
                        <em>三级分类：</em>
						<span <?php if ($a_view_data['i_three'] == 0) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>">全部</a></span>

	        				<?php if(empty($a_view_data['search']['third'])) {?>

                                <?php } else {foreach ($a_view_data['search']['third'] as $pro) {?>
							<span <?php if ($a_view_data['i_three'] == $pro['pro_id']) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => $pro['pro_id'],$a_view_data['i_four'],'i_pag' => 1]); ?>"><?php echo $pro['pro_name']?></a></span>
						    <?php }}?>	
                    </li>
                    <li class="coffee_key">
                        <em>关键字：</em>
                        <span <?php if ($a_view_data['i_four'] == '') { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],$a_view_data['i_two'],$a_view_data['i_three'],'i_four' => '','i_pag' => 1]); ?>">全部</a></span>
        					<?php if (empty($a_view_data['name'][0])) {?>
                                
                            <?php } else { foreach ($a_view_data['name'] as $k => $name) {?>
        					<span <?php if ($a_view_data['i_four'] == $name) { echo 'class="typeCur"';}?>><a href="<?php echo $this->router->url('product', [$a_view_data['i_one'],$a_view_data['i_two'],$a_view_data['i_three'],'i_four' => $this->general->base64_convert($name),'i_pag' => 1]); ?>"><?php echo $name?></a></span>
	        			<?php }}?>
                    </li>
                </ul>
                <!-- 产品种类 -->

                <!-- 产品内容 -->
                <div class="product_contentBox">
                    <ul>
                        <li>
                        	<?php foreach ($a_view_data['product'] as $product) {?>
                            <div class="boxTobox">
                                <i><img src="<?php echo $product['pro_img']?>" alt=""/></i>
                                <div class="product_info">
                                    <h2><?php echo $product['product_name']?></h2>
                                    <p><?php echo strip_tags($product['pro_details'])?></p>
                                <span class="proDisable">
                                	<?php if ($product['pro_show'] == 1) {?>
                                    启用
                                    <img src="static/style_default/image/pro_10.png" alt="" value="<?php echo $product['product_id']?>"/>
                                    <?php } else {?>
                                    暂用
                                    <img src="static/style_default/image/pro_33.png" alt="" value="<?php echo $product['product_id']?>" class="disabled"/>
                                    <?php }?>
                                </span>
                                    <div class="productType">
                                   <span>
                                   <?php $antistop = explode(",", $product['antistop']);
	        						foreach ($antistop as $key) {?>
	        						<a><?php echo $key?></a>
	        						<?php }?>
                                   </span>
                                   <p><?php foreach ($a_view_data['price'] as $price) {
	        						if ($product['product_id'] == $price['product_id']) { ?>
	        						(<?php echo $price['cup_name']?>)<?php echo $price['price']?>
	        					<?php }}?>元</p>
                                    </div>
                                </div>
                                <img class="productTips" src="static/style_default/image/tips_05.png" alt=""/>
                                <div class="popLay hide">
                                    <p class="pop_dele" value="<?php echo $product['product_id']?>">
                                        <img src="static/style_default/image/pro_26.png" alt=""/>
                                        <span>删除产品</span>
                                    </p>
                                    <p class="pop_edit"><a href="product_update-<?php echo $product['product_id']?>">
                                        <img src="static/style_default/image/pro_28.png" alt=""/>
                                        <span>编辑产品</span></a>
                                    </p>
                                </div>
                            </div>
							<?php }?>
                        </li>
                    </ul>
                    <div class="page">
                    	<?php echo $a_view_data['pages']?>
                    </div>
                    
                </div>
                <!-- 产品内容 -->
            </div>
            <!-- 产品内容 -->
            <!-- 选择产品 -->
        </div>
        <!-- 产品列表 -->


		 <!--  重要提示 -->
        <div class="tips">
            <em>重要提示</em>
            <img src="images/pro_19.png" alt=""/>
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
</body>
</html>