<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>门店资金-结算管理</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/storeFund_countManage.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/storeFund_countManage.js" type="text/javascript" charset="utf-8"></script>
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
        			<a href="<?php echo $this->router->url('account_showlist'); ?>">结算管理</a>
        			<?php if ($a_view_data['state'] == 0) {
        				echo '<span>></span><a href="javascript:;">待核算</a>';
        			} else if ($a_view_data['state'] == 1) {
        				echo '<span>></span><a href="javascript:;">待结算</a>';
        			} else if ($a_view_data['state'] == 2) {
        				echo '<span>></span><a href="javascript:;">已结算</a>';
        			} ?>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--彩色导航开始-->
	        	<div class="colorNav">
	        		<ul class="clearfix">
	        			<li class="noCheck">
	        				<a href="account_showlist-0">
	        					<span class="number">
	        						<i><?php echo $a_view_data['state_zero']; ?></i>
	        						<s>待核算</s>
	        					</span>
	        					<img  class="img" src="./static/style_default/images/jie_03.png"/>
	        				</a>
	        			</li>
	        			<li class="noCount">
	        				<a href="account_showlist-1">
	        					<span class="number">
	        						<i><?php echo $a_view_data['state_one']; ?></i>
	        						<s>待结算</s>
	        					</span>
	        					<img  class="img" src="./static/style_default/images/jie_09.png"/>
	        				</a>
	        			</li>
	        			<li class="hasCount">
	        				<a href="account_showlist-2">
	        					<span class="number">
	        						<i><?php echo $a_view_data['state_two']; ?></i>
	        						<s>已结算</s>
	        					</span>
	        					<img  class="img" src="./static/style_default/images/jie_06.png"/>
	        				</a>
	        			</li>
	        		</ul>
	        	</div>
	        	<!--彩色导航结束-->
	        	<!--高级选项开始-->
	        	<div class="optionBox">
	        		<span class="span1">高级选项：</span>
	        		<a href="javascript:;" class="opTit"><s>
	        		<?php if ($a_view_data['state'] == 9) {
	        			echo '全部';
	        		} else if ($a_view_data['state'] == 0) {
	        			echo '待核算';
	        		} else if ($a_view_data['state'] == 1) {
	        			echo '待结算';
	        		} else if ($a_view_data['state'] == 2) {
	        			echo '已结算';
	        		} ?>
	        		</s><i></i></a>
	        		<ul class="stateSelect">
						<li><a href="account_showlist-9">全部</a></li>
						<li><a href="account_showlist-0">待核算</a></li>
						<li><a href="account_showlist-1">待结算</a></li>
						<li><a href="account_showlist-2">已结算</a></li>
					</ul>
					<div class="zhe"></div>
	        	</div>
	        	<!--高级选项结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">

	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">
	        					<span> 账单时间</span>
	        					<span>月订单总数</span>
	        					<span>月销售餐饮总数量</span>
	        				    <span>月预约办公订单总数量</span> 
	        					<span>系统核算金额</span>
	        					<span>实际打款金额</span>
	        					<span>打款备注</span>
	        					<span>结算状态</span>
	        					<span>操作</span>
	        				</li>
							<?php foreach ($a_view_data['account'] as $key => $value): ?>
	        				<li class="row">
	        					<span><?php echo  $value['account_date']; ?></span>
	        					<span><?php echo $value['order_count']; ?></span>
	        					<span><?php echo $value['product_count']; ?></span>
	        					 <span><?php echo $value['appointment_count']; ?></span> 
	        					<span><?php echo $value['money_count']; ?></span>
	        					<span><?php echo $value['money_update']; ?></span>
	        					<span><?php echo $value['remark_update']; ?></span>
	        					<span><?php if($value['account_state']==0){ echo '待核算'; } else if ($value['account_state']==1) { echo '待结算'; } else if ($value['account_state']==2) { echo '已结算'; } ?></span>
	        					<span class="notCheck">
	        						<a href="<?php echo $this->router->url('account_detail',['account_date'=>$value['account_date'],'stye'=>1]); ?>">查看明细</a>
	        					</span>
	        				</li>
							<?php endforeach ?>
	        			</ul>
	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->
	        	<!--分页开始-->
	        	<div class="page">
					<?php echo $this->pages->link_style_one($this->router->url('account_showlist-'.$a_view_data['state'].'-', [], false, false)); ?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->

	</body>
</html>
