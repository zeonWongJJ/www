<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>评价管理-房间评价</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/appraiseManage_coffee.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/appraiseManage_coffee.js" type="text/javascript" charset="utf-8"></script>
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
	        	<div class="bread">
	        		<div class="breadNav">
	        			<a href="javascript:;">评价管理</a>
	        		</div>
	        		<div class="tagManage">
	        			<a href="javascript:;"><i>+</i>标签管理</a>
	        		</div>
	        	</div>
	        	<!--面包屑导航结束-->
	        	<!--评价类型模块开始-->
	        	<div class="appraiseBox clearfix">
	        		<div class="appL">
	        			<div class="aLeft">
	        				<div class="tou">
	        					<img src="./static/style_default/images/tt_03.png"/>
	        				</div>
	        				<p class="p1">hi,<?php echo $_SESSION['manager_name']; ?></p>
	        				<p class="p2">
				            <?php if ( date('H',$_SERVER['REQUEST_TIME']) < '6' ) {
				              echo '凌晨好';
				            } else if (date('H',$_SERVER['REQUEST_TIME']) < '8') {
				            	echo '早上好';
				            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '11' ) {
				                echo '上午好';
				            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '14' ) {
				                echo '中午好';
				            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '19' ) {
				                echo '下午好';
				            } else if ( date('H',$_SERVER['REQUEST_TIME']) < '24' ) {
				                echo '晚上好';
				            } ?>，为梦想加油</p>
	        				<span class="yuan1"></span>
	        				<span class="yuan2"></span>
	        			</div>
	        			<div class="aRight">
	        				<div class="rTop">
	        					<div class="dian">
	        						<p class="h3"><?php echo $a_view_data['store']['store_name']; ?></p>
	        						<p class="chang"><?php echo $a_view_data['store']['store_address']; ?></p>
	        					</div>
	        					<div class="lei">
	        						<p class="shou">累计售出</p>
	        						<p class="bei"><i><?php echo $a_view_data['store']['store_salescount']; ?></i>杯</p>
	        					</div>
	        				</div>
	        				<div class="rBottom">
	        					<ul>
	        						<li>
	        							<p class="bai"><?php echo $a_view_data['com_acc']['good_ratio']; ?>%</p>
	        							<p class="lv">好评率</p>
	        						</li>
	        						<li>
	        							<p class="bai"><?php echo $a_view_data['com_acc']['service_score']; ?></p>
	        							<p class="lv">服务态度</p>
	        						</li>
	        						<li>
	        							<p class="bai"><?php echo $a_view_data['com_acc']['goods_score']; ?></p>
	        							<p class="lv">服务质量</p>
	        						</li>
	        					</ul>
	        				</div>
	        			</div>
	        		</div>
	        		<div class="appR">
	        			<!--小表格开始-->
	        			<ul class="smallTab">
	        				<li class="sThead">
	        					<span>评价类型</span>
	        					<span>最近1周</span>
	        					<span>最近1个月</span>
	        					<span>最近3个月</span>
	        					<span>最近6个月</span>
	        					<span>6个月前</span>
	        					<span>总计</span>
	        				</li>
	        				<li class="sRow">
	        					<span><img src="./static/style_default/images/lian_03.png"/></span>
	        					<span><?php echo $a_view_data['com_acc']['good_week_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['good_month_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['good_month_three']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['good_month_six']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['good_month_sixago']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['good_all']; ?></span>
	        				</li>
	        				<li class="sRow">
	        					<span><img src="./static/style_default/images/lian_06.png"/></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_week_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_month_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_month_three']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_month_six']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_month_sixago']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['middle_all']; ?></span>
	        				</li>
	        				<li class="sRow">
	        					<span><img src="./static/style_default/images/lian_08.png"/></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_week_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_month_one']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_month_three']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_month_six']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_month_sixago']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['bad_all']; ?></span>
	        				</li>
	        				<li class="sRow">
	        					<span>总结</span>
	        					<span><?php echo $a_view_data['com_acc']['week_all']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['month_one_all']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['month_three_all']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['month_six_all']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['month_sixago_all']; ?></span>
	        					<span><?php echo $a_view_data['com_acc']['all_all']; ?></span>
	        				</li>
	        			</ul>
	        			<!--小表格结束-->
	        		</div>
	        	</div>
	        	<!--评价类型模块结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">
	        		<!--切换导航开始-->
	        		<div class="tabNav">
	        			<ul>
	        				<li class="current"><a href="<?php echo $this->router->url('coffee_room'); ?>">餐饮订单评价</a></li>
	        				<li><a href="comment_room">会议订单评价</a></li>
	        			</ul>
	        		</div>
	        		<!--切换导航结束-->
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<!--标题开始-->
	        				<li class="thead">
	        					<span>
	        						<span class="state">
		        						<a href="javascript:;" class="staTitle"><s>
										<?php if ($a_view_data['comment_cate'] == 9) {
											echo '全部状态';
										} else if ($a_view_data['comment_cate'] == 1) {
											echo '好评';
										} else if ($a_view_data['comment_cate'] == 2) {
											echo '中评';
										} else if ($a_view_data['comment_cate'] == 3) {
											echo '差评';
										} ?>
		        						</s><i></i></a>
		        						<ul class="stateSelect">
		        							<li><a href="coffee_room-9">全部</a></li>
		        							<li><a href="coffee_room-1">好评</a></li>
		        							<li><a href="coffee_room-2">中评</a></li>
		        							<li><a href="coffee_room-3">差评</a></li>
		        						</ul>
		        						<div class="zhe"></div>
		        					</span>
	        					</span>
	        					<span class="tag"></span>
	        					<span>
	        						<span class="state">
		        						<a href="javascript:;" class="staTitle"><s>
										<?php if ($a_view_data['comment_empty'] == 9) {
											echo '全部的状态';
										} else if ($a_view_data['comment_empty'] == 1) {
											echo '有评论内容';
										} else if ($a_view_data['comment_empty'] == 2) {
											echo '无评论内容';
										} ?>
		        						</s><i></i></a>
		        						<ul class="stateSelect">
		        							<li><a href="coffee_room-9-9">全部的状态</a></li>
		        							<li><a href="coffee_room-9-1">有评论内容</a></li>
		        							<li><a href="coffee_room-9-2">无评论内容</a></li>
		        						</ul>
		        						<div class="zhe"></div>
		        					</span>
	        					</span>
	        					<span>用户名</span>
	        					<span>产品名称</span>
	        					<span>审核状态</span>
	        					<span>操作</span>
	        				</li>
	        				<!--标题结束-->
	        				<?php foreach ($a_view_data['comment'] as $key => $value): ?>
	        				<li class="row" id="comment_<?php echo $value['comment_id']; ?>">
	        					<span>
									<?php if ($value['comment_cate'] == 1) {
										echo '<img src="./static/style_default/images/lian_03.png"/>';
									} else if ($value['comment_cate'] == 2) {
										echo '<img src="./static/style_default/images/lian_06.png"/>';
									} else {
										echo '<img src="./static/style_default/images/lian_08.png"/>';
									} ?>
	        					</span>
	        					<span class="tag">
		        					<?php if (!empty($value['comment_tags'])) {
		        						$tags = explode(',', $value['comment_tags']);
		        						for ($i=0; $i<count($tags); $i++) {
		        							echo '<a href="javascript:;">' . $tags[$i] . '</a>';
		        						}
		        					} ?>
	        					</span>
	        					<span class="comment">
	        						<p class="ping"><?php echo $value['comment_content']; ?></p>
	        						<!--图片开始-->
	        						<?php if (!empty($value['comment_pic'])) {  ?>
	        						<div class="picBox clearfix">
	        							<ul>
	        								<?php
	        									$imgs = explode(',', $value['comment_pic']);
	        									for ($i=0; $i<count($imgs); $i++) {
	        										echo '<li><img style="width:70px;" src="'.$imgs[$i].'"/></li>';
	        									}
	        								?>
	        							</ul>
	        						</div>
	        						<?php } ?>
	        						<!--图片结束-->
	        						<p class="time">[评价时间]：<?php echo date('Y-m-d H:i:s', $value['comment_time']); ?></p>
	        					</span>
	        					<span><?php echo $value['user_name']; ?></span>
	        					<span><?php echo $value['product_name']; ?></span>
	        					<span id="state_<?php echo $value['comment_id']; ?>"><?php if ($value['comment_state'] == 0) { echo '未审核'; } else { echo '已审核'; } ?></span>
	        					<span class="handle">
	        						<?php if ($value['comment_state'] == 0) { ?>
	        						<a href="javascript:;" class="shen" id="shen_<?php echo $value['comment_id']; ?>" onclick="comment_shenhe(<?php echo $value['comment_id']; ?>)">审核评价</a>
	        						<?php }; ?>
	        						<a href="javascript:;" class="shan" onclick="comment_delete(<?php echo $value['comment_id']; ?>)">删除评价</a>
	        					</span>
	        				</li>
	        				<?php endforeach ?>
	        			</ul>
	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->
	        </div>
	        <!--分页开始-->
        	<div class="page" style="margin-bottom:30px;">
        		<?php echo $this->pages->link_style_one($this->router->url('coffee_room-'.$a_view_data['comment_cate'].'-'.$a_view_data['comment_empty'].'-', [], false, false)); ?>
	            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        	</div>
        	<!--分页结束-->
	        <!--右边内容结束-->
	        <!-- 审核评价弹框开始-->
	        <div class="delePart examineBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*确定该条评论审核通过？</p>
	        	<p>*审核通过后2小时内将在用户界面显示</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--审核评价弹框结束-->
	        <!--删除评论弹框开始-->
	        <div class="delePart deleteBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*确定删除该条评价？</p>
	        	<p>*删除该条评价后，将不可恢复</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除评论弹框结束-->
	        <input type="hidden" name="comtag_type" value="2">
	        <!--标签管理弹框开始-->
	        <div class="tagBomb">
	        	<div class="h2">
	        		<span class="title">标签管理</span>
	        		<a href="javascript:;" class="close"></a>
	        	</div>
	        	<div class="navBox">
	        		<div class="navL">
	        			<a href="javascript:;" class="nCoffee aCur">咖啡</a>
	        			<a href="javascript:;" class="nRoom">房间</a>
	        		</div>
	        		<div class="addR">
	        			<a href="javascript:;" class="addA"><i>+</i>添加标签</a>
	        		</div>
	        	</div>
	        	<div class="commentBox">
	        		<!--咖啡标签开始-->
	        		<div class="coffeeCom coffeeCom1" style="display: block;">
	        			<div class="cofWrap">
		        			<div class="good good1">
		        				<P class="tit">好评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 2 && $value['comtag_cate'] == 1) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
		        			<div class="good soso">
		        				<P class="tit">中评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 2 && $value['comtag_cate'] == 2) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
		        			<div class="good bad">
		        				<P class="tit">差评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 2 && $value['comtag_cate'] == 3) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
	        			</div>
	        			<div class="sureBox">
	        				<a href="javascript:;">确定</a>
	        			</div>
	        		</div>
	        		<!--咖啡标签结束-->
	        		<!--房间标签开始-->
	        		<div class="coffeeCom roomCom" style="display: none;">
	        			<div class="cofWrap">
		        			<div class="good good1">
		        				<P class="tit">好评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 1 && $value['comtag_cate'] == 1) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
		        			<div class="good soso">
		        				<P class="tit">中评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 1 && $value['comtag_cate'] == 2) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
		        			<div class="good bad">
		        				<P class="tit">差评</P>
		        				<div class="comList">
		        					<ul class="clearfix">
		        						<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
		        							<?php if ($value['comtag_type'] == 1 && $value['comtag_cate'] == 3) { ?>
		        							<li id="<?php echo 'comtag_'.$value['comtag_id']; ?>"><?php echo $value['comtag_name']; ?><a href="javascript:;" class="shanchu" onclick="comtag_delete(<?php echo $value['comtag_id']; ?>)"></a></li>
		        							<?php }; ?>
		        						<?php endforeach ?>
		        					</ul>
		        				</div>
		        			</div>
	        			</div>
	        			<div class="sureBox">
	        				<a href="javascript:;">确定</a>
	        			</div>
	        		</div>
	        		<!--房间标签结束-->
	        	</div>
	        </div>
	        <!--标签管理弹框结束-->
	        <!--删除标签提示1开始-->
	        <div class="delePart deleSingle deleTag1">
	        	<p>重要提示</p>
	        	<p>*确定要删除此标签吗？</p>
	        	<p>*删除后不可以恢复</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除标签提示1结束-->
	        <!--删除标签提示1开始-->
	        <div class="delePart deleSingle deleTag2">
	        	<p>重要提示</p>
	        	<p>*标签有用户使用中，不能被删除</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--删除标签提示1结束-->
	</body>
</html>

<script>

// 删除评论
function comment_delete(comment_id) {
	$('.deleteBomb').show();
	$(".deleteBomb .sure").click(function(event) {
		$.ajax({
			url: 'comment_delete',
			type: 'POST',
			dataType: 'json',
			data: {comment_id: comment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$("#comment_"+comment_id).remove();
				}
			}
		})
		$('.deleteBomb').hide();
	});
	$(".deleteBomb .think").click(function(event) {
		$('.deleteBomb').hide();
	});
}

// 审核评论
function comment_shenhe(comment_id) {
	$('.examineBomb').show();
	$(".examineBomb .sure").click(function(event) {
		$.ajax({
			url: 'comment_shenhe',
			type: 'POST',
			dataType: 'json',
			data: {comment_id: comment_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					$("#shen_"+comment_id).remove();
					$("#state_"+comment_id).html('已审核');
				}
			}
		})
		$('.examineBomb').hide();
	});
	$(".examineBomb .think").click(function(event) {
		$('.examineBomb').hide();
	});
}

</script>