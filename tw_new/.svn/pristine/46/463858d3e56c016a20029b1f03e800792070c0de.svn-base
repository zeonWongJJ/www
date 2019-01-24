<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>产品管理-咖啡管理</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/productManage_coffee.css"/>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/productManage_coffee.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>

		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">产品管理</a><span>></span><a href="javascript:;">餐饮管理</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--筛选导航开始-->
	        	<div class="dressNav">
	        		<ul class="oneLevel clearfix">
	        			<?php foreach ($a_view_data['pro'] as $pro) {
	        				if ($pro['proid'] == 1) {?>
	        			<li <?php if ($a_view_data['i_one'] == $pro['pro_id']) {
	        				echo 'class="oneCuttom"';
	        			}?>><a href="<?php echo $this->router->url('store_product', ['i_one' => $pro['pro_id'],'i_two' => 0,'i_three' => 0,'i_four' => '', 'i_pag' => 1]); ?>"><?php echo $pro['pro_name']?></a></li>
	        			<?php } }?>
	        		</ul>
	        		<div class="twoLevel">
	        			<div class="clearfix">
	        				<span>二级分类：</span>
	        				<ul>
	        					<li <?php if ($a_view_data['i_two'] == 0) { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],'i_two' => 0,'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>">全部</a></li>
	        					<?php if (empty($a_view_data['i_one'])) {
	        					foreach ($a_view_data['search']['second'] as $pron) {	?>
	        						<li <?php if ($a_view_data['i_two'] == $pron['pro_id']) { echo 'class="twoCuttom"';}?>>
	        						<a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],'i_two' => $pron['pro_id'],'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>"><?php echo $pron['pro_name']?></a></li>
	        					<?php }} else { foreach ($a_view_data['pro'] as $pron) {if ($pron['proid'] == 2) {if ($pron['pro_pid'] == $a_view_data['i_one']) {?>
	        					<li <?php if ($a_view_data['i_two'] == $pron['pro_id']) { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],'i_two' => $pron['pro_id'],'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>"><?php echo $pron['pro_name']?></a></li>
		        				<?php } } } }?>
	        				</ul>
	        			</div>
	        			<div class="clearfix">
	        				<span>三级分类：</span>
	        				<ul>
	        					<li <?php if ($a_view_data['i_three'] == 0) { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => 0,$a_view_data['i_four'],'i_pag' => 1]); ?>">全部</a></li>
	        					<?php foreach ($a_view_data['search']['third'] as $pro) {	?>
	        						<li <?php if ($a_view_data['i_three'] == $pro['pro_id']) { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],$a_view_data['i_two'],'i_three' => $pro['pro_id'],$a_view_data['i_four'],'i_pag' => 1]); ?>"><?php echo $pro['pro_name']?></a></li>
	        					<?php } ?>
	        				</ul>
	        			</div>
	        			<div class="clearfix">
	        				<span>关键字：</span>
	        				<ul>
	        					<li  <?php if ($a_view_data['i_four'] == '') { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],$a_view_data['i_two'],$a_view_data['i_three'],'i_four' => '','i_pag' => 1]); ?>">全部</a></li>
	        					<?php if (empty($a_view_data['name'][0])) {?>

	        					<?php } else{foreach ($a_view_data['name'] as $k => $name) {?>
	        					<li <?php if ($a_view_data['i_four'] == $name) { echo 'class="twoCuttom"';}?>><a href="<?php echo $this->router->url('store_product', [$a_view_data['i_one'],$a_view_data['i_two'],$a_view_data['i_three'],'i_four' => $this->general->base64_convert($name),'i_pag' => 1]); ?>"><?php echo $name?></a></li>
	        					<?php }}?>
	        				</ul>
	        			</div>
	        		</div>
	        	</div>
	        	<!--筛选导航结束-->
	        	<!--咖啡列单表开始-->
	        	<div class="coffeeModule clearfix">
	        	    <?php foreach ($a_view_data['product'] as $product) {?>
	        		<!--上架产品开始-->
	        		<div <?php if ( ! empty($a_view_data['mendian']) && in_array($product['product_id'], $a_view_data['mendian'])) { echo 'class="sigleModule"'; } else {echo 'class="sigleModule upModule"';}?>>
	        			<div class="imgBox">
	        				<img src="<?php echo get_config_item('goods_img')?>/<?php echo $product['pro_img']?>"/>
	        			</div>
	        			<div class="characterBox">
	        				<div class="title">
	        					<p class="h2"><a href="javascript:;"><?php echo $product['product_name']?></a></p>
	        					<p class="updown"><img src="static/style_default/images/tips_05.png"/></p>
								<?php if ( ! empty($a_view_data['mendian']) && in_array($product['product_id'], $a_view_data['mendian'])) { ?>
		        					<div class="stop" onclick="product(<?php echo $product['product_id']?>)">
		        						<input type="hidden" class="product" value="">
		        						<a href="javascript:;"><i class="stopImg"></i><span>下架产品</span></a>
		        					</div>
	        					<?php } else {?>
									<div class="stop up" onclick="product(<?php echo $product['product_id']?>)">
										<input type="hidden" class="product" value="">
		        						<a href="javascript:;"><i class="stopImg"></i><span>上架产品</span></a>
		        					</div>
	        					<?php }?>
	        				</div>
							<!-- 库存量 -->
							<?php if ( ! empty($a_view_data['mendian']) && in_array($product['product_id'], $a_view_data['mendian'])) { ?>
							<div class="stock" value="<?php echo $product['product_id']; ?>">
								<em>库存量</em>
								<img class="stockPrev" src="static/style_default/images/np_03.png" />
								<span id="stock_<?php echo $product['product_id']; ?>"><?php echo $product['today_stock']; ?></span>
								<img class="stockNext" src="static/style_default/images/np_05.png" />
							</div>
							<?php }?>
							<!-- 库存量 -->
	        				<p class="describe"><a href="javascript:;"><?php echo strip_tags($product['pro_details'])?></a></p>
	        				<?php foreach ($a_view_data['sto'] as $sto) {if ($product['product_id'] == $sto['product_id']) {if ($sto['prod_show'] == 1) {?>
		        				<div class="open" value="<?php echo $sto['id']?>">
		        				<span>启用</span>
	        					<img src="static/style_default/images/pro_10.png">
	        					</div>
		        				<?php } else { ?>
		        				<div class="stopOpen" value="<?php echo $sto['id']?>">
		        				<span>暂用</span>
	        					<img src="static/style_default/images/pro_33.png"/>
	        					</div>
		        				<?php }}}?>
	        				<div class="label">
	        					<div class="word">
	        						<?php $antistop = explode(",", $product['antistop']);
	        						foreach ($antistop as $key) {?>
	        						<span><?php echo $key?></span>
	        						<?php }?>
	        					</div>
	        					<p class="price" title="<?php foreach ($a_view_data['price'] as $price) {
	        						if ($product['product_id'] == $price['product_id']) { ?>
	        						(<?php echo $price['cup_name']?>)<?php echo $price['price']?>元
	        					<?php }}?>">
	        						<?php foreach ($a_view_data['price'] as $price) {
	        						if ($product['product_id'] == $price['product_id']) { ?>
	        						(<?php echo $price['cup_name']?>)<?php echo $price['price']?>元
	        					<?php }}?>
	        					</p>
	        				</div>
	        			</div>
	        		</div>
	        		<!--上架产品结束-->
	        		<?php }?>
	        	</div>

	        	<!--咖啡列单表结束-->
	        	<!--分页开始-->
	        	<div class="page">
	        		<?php echo $a_view_data['pages']?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['page']?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->
        </div>
	    <!--删除单个提示框开始-->
        <div class="delePart deleSingle">
        	<p>重要提示</p>
        	<p class="p2">*<span>确定要下架产品吗？</span></p>
        	<p class="p3">*<span>下架后，可重新上架此产品</span></p>
        	<p class="p4">
        		<span>预设每日库存:</span>
        		<input type="text" name="pro_stock" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')"  />
        	</p>
        	<div class="btnBox">
        		<a href="javascript:;" class="sure">确认</a>
        		<a href="javascript:;" class="think">取消</a>
        	</div>
        </div>
        <!--删除单个提示框结束-->
	</body>
</html>
<script>
function product(product_id) {
	$('.product').val(product_id);
}
</script>
