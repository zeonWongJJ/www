<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>耗材管理-耗材库存</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/consumptiveManage_stock.css"/>       
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/consumptiveManage_stock.js" type="text/javascript" charset="utf-8"></script>
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
        		</div>
	        	<!--面包屑导航结束-->	        	
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="addSearch">
	        			<div class="addBox">
	        				<a href="<?php echo $this->router->url('consumable_add'); ?>"><i>+</i>申请耗材</a>
	        			</div>
	        			<div class="searchBox">
	        				<form action="consumable" method='post' id="formId">
		        				<input type="text" class="int" placeholder="材料名称" onfocus="javascript:if(this.value=='材料名称')this.value='';" name="name"/>
		        				<button class="btn" onclick="document.getElementById('formId').submit();"></button>
	        				</form>
	        			</div>
	        			<div class="lookOver">
	        				<a href="consumable_daily">查看每日消耗</a>
	        			</div>
	        		</div>
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">	        						        					
	        					<span>耗材名称</span>
	        					<span>库存量</span>
	        					<span>昨日消耗量</span>
	        					<span>预警值</span>	        						        					
	        					<span>修改预警值</span>
	        				</li>
							<?php foreach ($a_view_data['cons'] as $cons) {?>
	        				<li class="row">	        					
	        					<span><?php foreach ($a_view_data['consu'] as $consu) {if ($cons['consumption_id'] == $consu['consumption_id']) {
	        						echo $consu['consu_name'];
	        					 }}?></span>
	        					<span class="stock"><?php echo $cons['inventory']?></span>
	        					<span><?php foreach ($a_view_data['expend'] as $expend) {if ($cons['consumption_id'] == $expend['consumption_id']) {
	        						echo $expend['expend'];
	        					}}?></span>
	        					<span class="warning"><?php echo $cons['prewarning_value']?></span>	 		
	        					<span>	        						
	        						<a href="javascript:;" class="edit" value="<?php echo $cons['id']?>"></a>
	        					</span>
	        				</li>
							<?php }?>
	        			</ul>
	        			
	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->	 
	        	<!--分页开始-->
	        	<div class="page">
	        		<?php echo $a_view_data['pages']?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['total']?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->	
	        <!--修改预警值弹框开始-->
	        <div class="seatName">
	         	<div class="title">
	         		<p class="h3">修改预警值</p>
	         		<a href="javascript:;" class="close"></a>
	         	</div>
	         	<div class="inputBox">
	         		<span class="biao">原预警值</span>
	         		<span class="oldNum">600</span>
	         	</div>
	         	<div class="inputBox">
	         		<span class="biao">修改后预警值</span>
	         		<input type="text" class="int newNum" placeholder="请输入修改后预警值" />
	         		<span class="red"><i></i>还没有输入预警值</span>
	         	</div>
	         	<div class="sureBox">
	         		<a href="javascript:;">确定</a>
	         	</div>
	         </div>
	        <!--修改预警值弹框结束-->
	</body>
</html>
