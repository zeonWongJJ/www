<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>耗材管理-耗材库存-每日消耗</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/consumptiveManage_stock_everyday.css"/>       
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/consumptiveManage_stock_everyday.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/layui/layui.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">每日消耗</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<div class="title">
    					<span class="titleL">日消耗列表:</span>
    					<div class="titleR">    						
							<input type="text" id="test1" placeholder="<?php if (empty($this->router->get(1))) {
								 echo date('Y-m-d', $_SERVER['REQUEST_TIME']);
							} else {
								echo date('Y-m-d', $this->router->get(1));
							}?>">
							<script type="text/javascript">
								layui.use('laydate', function(){
								  var laydate = layui.laydate;
								  laydate.render({
								    elem: '#test1', 
								    value: "",
								    done: function(value, date, endDate){
									     //得到日期生成的值，如：2017-08-18
										btime = Date.parse(new Date(value));
										btime = btime / 1000 -28800;
									    window.location.href = "consumable_daily-" + btime;
								  	}
								  })
								});
								
							</script>
    					</div>
	        		</div>
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead" style="background: #f5f7fd;">	        						        					
	        					<span>耗材名称</span>
	        					<span>消耗量</span>	
	        					<span>单位</span>        					
	        				</li>
	        				<?php foreach ($a_view_data['expend'] as $expend) {?>
		        				<li class="thead">					
		        					<span><?php foreach ($a_view_data['cons'] as $cons) {if ($expend['consumption_id'] == $cons['consumption_id']) {
		        						echo $cons['consu_name'];
		        					}}?></span>
		        					<span><?php echo $expend['expend']?></span>	
		        					<span><?php foreach ($a_view_data['cons'] as $cons) {if ($expend['consumption_id'] == $cons['consumption_id']) {
		        						echo $cons['units'];
		        					}}?></span> 
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
		            <span style="background:none">共计<em> <?php echo $a_view_data['total']; ?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->	        	
	        </div>
	</body>
</html>
