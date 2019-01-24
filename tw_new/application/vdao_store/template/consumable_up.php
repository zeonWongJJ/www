<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>申请耗材</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/consumptiveManage_stock_apply.css"/>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/consumptiveManage_stock_apply.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">耗材管理</a>
        			<span>></span>
        			<a href="javascript:;">耗材库存</a>
        			<span>></span>
        			<a href="javascript:;">申请耗材</a>
        		</div>
	        	<!--面包屑导航结束-->	        	
	        	<!--右下半部分开始-->
	        	<div class="rightDown">
	        		<div class="rightNav">
	        			<ul>
	        				<li class="current"><a href="javascript:;">申请耗材</a></li>
	        				<!--<li><a href="javascript:;">提现账户</a></li>-->
	        			</ul>
	        		</div>
	        		<div class="wrapBox">
	        			 <!--申请耗材开始-->
	        			<form action="<?php echo $this->router->url('consumable_up'); ?>" method="post">
	        			 <div class="basicBox clearfix">
	        			 	<div class="bLeft">
	        			 		<ul>
	        			 			<input type="hidden" name="id" value="<?php echo $a_view_data['con']['cons_id']; ?>">
	        			 			<li>
	        			 				<p class="smallTitle">门店名称</p>
	        			 				<p class="fill" ><?php echo $a_view_data['con']['store_name']?></p>
	        			 			</li>
	        			 			<li>
	        			 				<p class="smallTitle">门店地址</p>
	        			 				<p class="fill"><?php echo $a_view_data['con']['store_address']?></p>
	        			 				<input type="hidden" name="store_address" value="<?php echo $a_view_data['con']['store_address']?>">
	        			 			</li>	        			 			
	        			 			<li class="makings chooseLi clearfix total">
	        			 				<p class="smallTitle"><i class="xing"></i>申请耗材</p>
	        			 				<div class="fillBox">	        			 					
	        			 					<div class="chooseBox">
	        			 						<a href="javascript:;" class="product">+&nbsp;按产品添加</a>
	        			 						<a href="javascript:;" class="material">+&nbsp;按耗材添加</a>
	        			 					</div>
	        			 					<div class="typeBox">
	        			 						<!--按产品添加框开始-->
	        			 						<div class="productBox productBox1">
	        			 							<!-- <p class="lack">库存紧缺的产品：咖啡外卖杯、塑料吸管、外卖包装袋外</p> -->
	        			 							<div class="listBox clearfix">
	        			 								<div class="nameDiv clearfix">
	        			 									<span class="biaoL">产品名称</span>
	        			 									<div class="inputL intRea">
	        			 										<input type="text" class="int product_name"/>
	        			 										<div class="content hide"></div>
	        			 										<div class="selPic"><i></i></div>
	        			 										<input type="hidden" id="product_id">
	        			 									</div>
	        			 									<div class="chooseL">
	        			 										<!--多级筛选开始-->
	        			 										<div class="moreBox clearfix">        			 											
	        			 											<div class="selectBox oneLev">
		        			 											<a href="javascript:;" class="tit"><span>请选择产品分类</span><i></i></a>
		        			 											<div class="select id_1">
																			<?php foreach ($a_view_data['pro'] as $pro) {  ?>
		        			 												<a href="javascript:;"  value="<?php echo $pro['pro_id']?>"><?php echo $pro['pro_name']?></a>
																			<?php } ?>
		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox twoLev">
		        			 											<a href="javascript:;" class="tit"><span class="yin">请选择产品分类</span><i></i></a>
		        			 											<div class="select id_2">
		        			 												
		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox threeLev">
		        			 											<a href="javascript:;" class="tit"><span class="yin1">请选择产品分类</span><i></i></a>
		        			 											<div class="select id_3">
		        			 												
		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox fourLev">
		        			 											<a href="javascript:;" class="tit"><span class="yin2">请选择产品</span><i></i></a>
		        			 											<div class="select proid">
		        			 												
		        			 											</div>		        			 											
		        			 										</div>
	        			 										</div>
	        			 										<!--多级筛选结束-->
	        			 										<!--杯型选择开始-->
	        			 										<div class="selectBox cupSelect" >
	        			 											<a href="javascript:;" class="tit"><span>请选择杯型</span><i></i></a>
	        			 											<div class="select cup">

	        			 											</div>
	        			 											<span class="beixing">请选择<i>杯型</i></span>
	        			 											<input type="hidden" value="" id="cup">
	        			 										</div>
	        			 										<!--杯型选择结束-->
	        			 									</div>
	        			 								</div>
	        			 								<!--数量填写框开始-->
	        			 								<div class="numDiv" id="consumption">

	        			 								</div>
	        			 								<!--数量填写框结束-->
	        			 								<div class="controlBox clearfix">
	        			 									<a href="javascript:;" class="save">保存</a>
	        			 									<a href="javascript:;" class="saveEdit">保存</a>
	        			 									<a href="javascript:;" class="cancel">取消</a>
	        			 								</div>
	        			 							</div>
	        			 						</div>
	        			 						<!--按产品添加框结束-->
	        			 						<!--按耗材添加框开始-->
	        			 						<div class="productBox materialBox">
	        			 							<p class="lack">库存紧缺的耗材：：<?php if (empty($a_view_data['consutt'])) {
	        			 								echo "无";
	        			 							} else{foreach ($a_view_data['consu'] as $consu) {
	        			 								echo $consu."、";
	        			 							}}?></p>
	        			 							<div class="listBox clearfix" >
	        			 								<div class="nameDiv">
	        			 									<span class="biaoL">耗材名称</span>	        			 									
	        			 									<div class="inputL intRea">
	        			 										<input type="text" class="int"/>
	        			 										<input type="hidden" class="conte"/>
	        			 										<div class="selPic"><i></i></div>
	        			 									</div>
	        			 									<div class="chooseL" >	        			 										       			 										
	        			 										<!--多级筛选开始-->
	        			 										<div class="moreBox clearfix" >        			 											
	        			 											<div class="selectBox oneLev">
		        			 											<a href="javascript:;" class="tit"><span>请选择耗材分类</span><i></i></a>
		        			 											<div class="select haoc1">
		        			 												<?php foreach ($a_view_data['cons'] as $cons) {?>
		        			 												<a href="javascript:;" value="<?php echo $cons['id']?>"><?php echo $cons['cons_name']?></a>
		        			 												<?php }?>	
		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox twoLev">
		        			 											<a href="javascript:;" class="tit"><span id="haoc2">请选择耗材分类</span><i></i></a>
		        			 											<div class="select haoc2">

		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox threeLev">
		        			 											<a href="javascript:;" class="tit"><span id="haoc3">请选择耗材分类</span><i></i></a>
		        			 											<div class="select haoc3">

		        			 											</div>		        			 											
		        			 										</div>
		        			 										<div class="selectBox fourLev">
		        			 											<a href="javascript:;" class="tit"><span id="haoc4">请选择耗材名称</span><i></i></a>
		        			 											<div class="select haoc4">

		        			 											</div>		        			 											
		        			 										</div>
	        			 										</div>
	        			 										<!--多级筛选结束-->
	        			 									</div>
	        			 								</div>
	        			 								<!--数量填写框开始-->
	        			 								<div class="numDiv">
	        			 									<!--单个添加开始-->
	        			 									<div class="sigleNum">
	        			 										<span class="sNum"><s>数量</s></span>
	        			 										<div class="intL">
	        			 											<input type="text" class="sInt" />&nbsp;&nbsp;份
	        			 										</div>
	        			 										<span class="sTips">标准份数为10份，减少了<i>5</i>份</span>
	        			 										<span class="sTips2">请填写份数，不需要时写<i>0</i></span>
	        			 									</div>	
	        			 									<!--单个添加结束-->
	        			 								</div>
	        			 								<!--数量填写框结束-->
	        			 								<div class="controlBox clearfix">
	        			 									<a href="javascript:;" class="save1">保存</a>
	        			 									<a href="javascript:;" class="saveEdit1">保存</a>
	        			 									<a href="javascript:;" class="cancel1">取消</a>
	        			 								</div>
	        			 							</div>
	        			 						</div>
	        			 						<!--按耗材添加框结束-->
	        			 					</div>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请至少申请一种耗材</span>
	        			 				</div>
	        			 			</li>	        			 			
	        			 			<li class="phone total">
	        			 				<p class="smallTitle"><i class="xing"></i>联系电话</p>
	        			 				<div class="fillBox">
	        			 					<input type="text" class="int mobile" placeholder="请输入手机号码" name="phone" value="<?php echo $a_view_data['con']['phone']?>"/>
	        			 				</div>
	        			 				<div class="tipsBox">
	        			 					<span class="red"><i></i>请至少输入一个联系电话</span>
	        			 				</div>
	        			 			</li>	        			 			
	        			 			<li class="traffic introduce">
	        			 				<p class="smallTitle">申请备注</p>
	        			 				<div class="fillBox">
	        			 					<textarea class="txt"name="shop_remark"><?php echo $a_view_data['con']['shop_remark']?></textarea>
	        			 					<!-- <p class="num"><span>0</span>/<span>200</span></p> -->
	        			 				</div>	        			 				
	        			 			</li>	        			 				        			 		
	        			 		</ul>
	        			 		<div class="saveBox">	        			 			
	        			 			<input type="submit" id="cateSub" value="确定"/>
	        			 		</div>
	        			 	</div>
	        			 	<!--右边列表开始-->
	        			 	<div class="bRight">
	        			 		<p class="rTitle">已添加申请耗材</p>
	        			 		<div class="addBox">
	        			 			<!--按产品添加开始-->
	        			 			<div class="productAdd productAdd1">
		        			 			<!--单个添加开始-->
	        			 				<?php foreach ($a_view_data['suppt'] as $suppt) {
	        			 					if ( ! empty($suppt['product_id'])) {?>
		        			 			<div class="singleAdd">
			        			 			<ul>
			        			 				<?php foreach ($a_view_data['supp'] as $supp) {
			        			 					if ($suppt['product_id'] == $supp['product_id']) {
			        			 						if ($supp['consumption_id'] == 'i') {?>
				        			 			<li class="first">
					        			 			<span class="addName"><s><?php foreach ($a_view_data['prod'] as $prod) {
				        			 						if ($supp['product_id'] == $prod['product_id']) {
				        			 						echo $prod['product_name'];}}?></s>（<i><?php foreach ($a_view_data['cup'] as $cup) {
					        			 				if ($cup['cup_id'] == $supp['cup_id']) {
					        			 					echo $cup['cup_name'];}}?></i>）</span>
					        			 			<span class="addNum"><s><?php echo $supp['amount']?></s>份</span>
					        			 			<span class="addCon">
					        			 			<a href="javascript:;" class="delete">		        			 				
					        			 			</a><a href="javascript:;" class="edit"></a>
					        			 			</span>
					        			 			<input name="cons[1][<?php echo $supp['product_id']?>][<?php echo $supp['cup_id']?>][i]" value="65" id="cons1" type="hidden">
				        			 			</li>
				        			 			<?php }}}?> 
				        			 			<?php foreach ($a_view_data['supp'] as $supp) {
			        			 					if ($suppt['product_id'] == $supp['product_id']) {
			        			 						if ($supp['consumption_id'] != 'i') {?>
				        			 			<li class="second">
					        			 			<span class="addName" value="<?php echo $supp['consumption_id']?>"><s><?php foreach ($a_view_data['consu'] as $cons) {
				        			 						if ($supp['consumption_id'] == $cons['consumption_id']) {
				        			 						echo $cons['consu_name'];}}?></s></span>
					        			 			<span class="addNum"><s><?php echo $supp['amount']?></s>份</span>
					        			 			<input name="cons[1][<?php echo $supp['product_id']?>][<?php echo $supp['cup_id']?>][<?php echo $supp['consumption_id']?>]" value="<?php echo $supp['product_id']?>" id="cons" type="hidden">
				        			 			</li>
				        			 			<?php }}}?> 
			        			 			</ul>
		        			 			</div>
		        			 			<?php }}?>
		        			 			<!--单个添加结束-->			        			 			
	        			 			</div>
	        			 			<!--按产品添加结束-->
	        			 			<!--按耗材添加开始-->
	        			 			<div class="productAdd materialAdd">		        			 			
		        			 			<p class="matTitle">单独添加耗材</p>
		        			 			 <div class="singleAdd">
		        			 				<ul>
		        			 					<?php foreach ($a_view_data['supp'] as $supp) {
		        			 						if (empty($supp['product_id'])) {?>
		        			 						<li>
				        			 					<span class="addName">
				        			 					<?php foreach ($a_view_data['consu'] as $cons) {
				        			 						if ($supp['consumption_id'] == $cons['consumption_id']) {
				        			 						echo $cons['consu_name'];}}?></span>
				        			 					<span class="addNum"><s><?php echo $supp['amount']?></s>份</span>
				        			 					<input name="cons[2][<?php echo $supp['consumption_id']?>]" value="<?php echo $supp['amount']?>" id="out" type="hidden">
				        			 					<span class="addCon">
				        			 						<a href="javascript:;" class="delete"></a>
				        			 						<a href="javascript:;" class="edit"></a>
				        			 					</span>
			        			 					</li>
		        			 					<?php }}?>
		        			 					
		        			 					<li>
		        			 					</li>
		        			 				</ul>
		        			 			</div> 		        			 				        			 			
	        			 			</div>
	        			 			<!--按耗材添加结束-->
	        			 		</div>
	        			 	</div>
	        			 	<!--右边列表结束-->
	        			 </div>
	        			</form>
	        			 <!--申请耗材结束-->	        			 
	        		</div>
	        	</div>
	        	<!--右下半部分结束-->
	        </div>
	        <!--右边内容结束-->
	        <!--编辑后刷新页面提示框开始-->
	        <div class="delePart deleSingle renovateBomb">
	        	<p>重要提示</p>
	        	<p>*确定要推出吗？</p>
	        	<p>*已编辑的内容将不做保存</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--编辑后刷新页面提示框结束-->
	        <!--删除某个耗材申请提示框开始-->
	        <div class="delePart deleSingle deleBomb">
	        	<p>重要提示</p>
	        	<p>*确定要删除此耗材吗？</p>
	        	<p>*删除后不可恢复</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除某个耗材申请提示框结束-->
	</body>
</html>
