<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>门店资金-结算管理 -月销售明细</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/storeFund_countManage_monthSale(noCheck).css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/storeFund_countManage_monthSale(noCheck).js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="javascript:;">门店资金</a>
        			<span>></span>
        			<a href="account_showlist-9">结算管理</a>
        			<span>></span>
        			<a href="javascript:;"><?php echo $a_view_data['detail']['account_date']; ?>销售明细</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	
	        	<div class="detailNav">
                	<a href="account_detail-<?php echo $this->router->get(1)?>-1">餐饮订单</a>
                	<a href="account_detail-<?php echo $this->router->get(1)?>-2">预约办公订单</a>
                </div>
	        	
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span>序号</span>
	        					<span>订单号</span>
	        					<span>下单时间</span>
	        					<span>成交时间</span>
	        					<?php if ($this->router->get(2) == 1) {?>
	        					<span>餐饮数量</span>
	        					<?php } else {?>
	        					<span>预约办公数量</span>
	        					<?php }?>
	        					<span>总金额</span>
 	        			    </li>
 	        			    <?php $i=1; foreach ($a_view_data['order'] as $key => $value): ?>
	        				<li class="row">
	        					<span><?php echo ($a_view_data['page']-1) * $a_view_data['prow'] + $i; ?></span>
	        				   <?php if ($this->router->get(2) == 1) {?>
	        					<span><?php echo $value['order_number']; ?></span>
	        					<span><?php echo date('Y-m-d H:i:s', $value['time_create']); ?></span>
	        					<span><?php echo date('Y-m-d H:i:s', $value['order_time']); ?></span>
	        					<span><?php echo $value['order_count']; ?></span>
	        					<span><?php echo $value['goods_amount']; ?></span>
	        					<?php } else {?>
	        					<span><?php echo $value['appointment_number']; ?></span>
	        					<span><?php echo date('Y-m-d H:i:s', $value['pay_time']); ?></span>
	        					<span><?php echo date('Y-m-d H:i:s', $value['pay_time']); ?></span>
	        					<span>1</span>
	        					<span><?php echo $value['appointment_price']; ?></span>
	        					<?php }?>
	        				</li>
 	        			    <?php $i++; endforeach ?>
	        			</ul>

	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->
	        	<div class="bottomBox">
	        		<div class="bottomL">
	        			<div class="PLeft">
	        				<p class="p1">
							<?php if ($a_view_data['detail']['account_state'] == 0) {
								echo '核算金额';
							} else if ($a_view_data['detail']['account_state'] == 1) {
								echo '核算金额';
							} else if ($a_view_data['detail']['account_state'] == 2) {
								echo '结算金额';
							} ?>
	        				</p>
	        				<p class="p2">
							<?php if ($a_view_data['detail']['account_state'] == 0) {
						 	if ($this->router->get(2) == 1) {	
						 		echo $a_view_data['detail']['money_count'];
						  	}else {
						  		echo $a_view_data['detail']['appointment_money_count'];
						  	}

							} else if ($a_view_data['detail']['account_state'] == 1) {
								echo $a_view_data['detail']['money_update'];
							} else if ($a_view_data['detail']['account_state'] == 2) {
								echo $a_view_data['detail']['money_update'];
							} ?>
	        				</p>
	        			</div>
	        			<div class="pRight">
	        				<a href="javascript:;" class="noCheck">
							<?php if ($a_view_data['detail']['account_state'] == 0) {
								echo '待核算';
							} else if ($a_view_data['detail']['account_state'] == 1) {
								echo '待结算';
							} else if ($a_view_data['detail']['account_state'] == 2) {
								echo '已结算';
							} ?>
	        				</a>
	        			</div>
	        		</div>
	        		<div class="bottomR">
	        			<!--分页开始-->
			        	<div class="page">
							<?php echo $this->pages->link_style_one($this->router->url('account_detail-'.$a_view_data['detail']['account_date'].'-'.$a_view_data['stye'].'-', [],false, false)); ?>
				            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
			        	</div>
			        	<!--分页结束-->
	        		</div>
	        	</div>

	        </div>
	        <!--右边内容结束-->

	</body>
</html>
