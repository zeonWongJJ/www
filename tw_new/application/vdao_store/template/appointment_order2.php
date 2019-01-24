<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>订单管理-房间订单</title>
		<link rel="stylesheet" href="./static/style_default/style/common.css"/>
        <link rel="stylesheet" href="./static/style_default/style/header.css"/>
        <link rel="stylesheet" href="./static/style_default/style/orderManage_room.css"/>
        <script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="./static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="./static/style_default/script/orderManage_room.js" type="text/javascript" charset="utf-8"></script>
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
	        	<!--小导航开始-->
	        	<div class="smallNav">
	        		<i></i>
	        		<a href="javascript:;">订单管理 / </a><a class="cur" href="appointment_order-1">会议订单</a>
	        		<?php if ($a_view_data['type'] == 6) { echo ' / <a class="cur" href="javascript:;">订单搜索 ['.$a_view_data['keywords'].']</a>'; } ?>
	        	</div>
	        	<!--小导航结束-->
	        	<!--所有订单开始-->
	        	<div class="allOrder">
	        		<ul>
	        			<li class="allList <?php if ($a_view_data['state'] == 9) { echo 'current'; } ?>"><a href="appointment_order-1-9">所有订单</a></li>
	        			<li class="waitList <?php if ($a_view_data['state'] == 1) { echo 'current'; } ?>"><a href="appointment_order-1-1"><i class="dot"></i>待接单<i class="number"><?php echo $a_view_data['state_one']; ?></i></a></li>
	        		
	        			<li class="inService <?php if ($a_view_data['state'] == 3) { echo 'current'; } ?>"><a href="appointment_order-1-3"><i class="dot"></i>进行中<i class="number"><?php echo $a_view_data['state_three']; ?></i></a></li>
	        			<li class="hasFinish <?php if ($a_view_data['state'] == 5) { echo 'current'; } ?>"><a href="appointment_order-1-5"><i class="dot"></i>已完成<i class="number"><?php echo $a_view_data['state_five']; ?></i></a></li>
	        			<li class="hasCancel <?php if ($a_view_data['state'] == 6) { echo 'current'; } ?>"><a href="appointment_order-1-6">已取消</a></li>
	        		</ul>
	        	</div>
	        	<!--所有订单结束-->
	        	<!--搜索预约开始-->
	        	<div class="sbBox clearfix" <?php if ($a_view_data['state'] != 9) { echo 'style="display:none"'; } ?>>
	        		<form id="searchform" action="appointment_search" method="post">
	        		<input type="hidden" name="cate" value="<?php echo $a_view_data['cate']; ?>">
	        		<div class="searchL clearfix">
	        			<div class="user">
	        				<span class="yonghu">用户：</span>
	        				<input class="bianhao" name="keywords" type="text" placeholder="订单编号/联系人/手机号" <?php if ($a_view_data['type'] == 6 && $a_view_data['keywords'] != 9) { echo 'value="'.$a_view_data['keywords'].'"'; } ?> />
	        			</div>
	        			<div class="roomType">
	        				<span class="roomName">房型/座位号：</span>
	        				<div class="twoSelect">
	        					<select class="roomSel" name="search_office" onchange="appointment_getseat()">
	        						<option value="all">全部房型</option>
	        						<?php foreach ($a_view_data['office'] as $key => $value): ?>
	        						<option value="<?php echo $value['office_id']; ?>" <?php if ($a_view_data['search_office'] == $value['office_id']) { echo 'selected'; } ?>><?php echo $value['room_name']; ?></option>
	        						<?php endforeach ?>
	        					</select>
	        					<span class="su">|</span>
	        					<select class="seatSel" name="search_seat">
	        						<option value="all">全部座位</option>
									<?php if ($a_view_data['type'] == 6) { ?>
										<?php foreach ($a_view_data['seat'] as $key => $value): ?>
											<?php if ($value != '0') { ?>
												<option value='<?php echo $value ?>' <?php if ($a_view_data['search_seat'] == $value) { echo 'selected'; } ?>><?php echo $value ?></option>
											<?php } ?>
										<?php endforeach ?>
									<?php } ?>
	        					</select>
	        				</div>
	        			</div>
	        			<div class="search">
	        				<a href="javascript:;" onclick="appointment_search()">查询</a>
	        			</div>
	        		</div>
	        		</form>
	        		<div class="bookR">
	        			<p class="p1">今天预约</p>
	        			<p class="p2"><?php echo $a_view_data['today']; ?></p>
	        		</div>
	        	</div>
	        	<!--搜索预约结束-->
	        	<!--表格模块开始-->
	        	<div class="tableBox">
	        		<ul>
	        			<?php foreach ($a_view_data['order'] as $key => $value): ?>
	        			<li>
	        				<div class="title">
	        					<p class="h3"><?php echo $value['room_type'] . $value['room_name']; ?>&nbsp;&nbsp;<?php echo $value['office_seatname']; ?></p>
	        					<p class="time">下单时间：<?php echo date('Y-m-d', $value['appointment_time']); ?>&nbsp;&nbsp;<?php echo date('H:i:s', $value['appointment_time']); ?></p>
	        				</div>
	        				<div class="row">
	        					<span>
	        						<p class="tit">用户名</p>
	        						<div class="userBox clearfix">
	        							<div class="imgL">
		                                <?php if (empty($value['user_pic'])) {
		                                    echo '<img src="static/style_default/images/yong_03.png" />';
		                                } else if(strpos($value['user_pic'], 'http') === false) {
		                                    echo '<img src="'.get_config_item('vdao_mobile').$value['user_pic'].'" />';
		                                } else {
		                                    echo '<img src="'.$value['user_pic'].'" />';
		                                } ?>
	        							</div>
	        							<div class="messageR">
	        								<p class="name"><?php echo $value['user_name']; ?></p>
	        								<p class="orderNum">订单编号:<?php echo $value['appointment_number']; ?></p>
	        							</div>
	        						</div>
	        					</span>
	        					<span>
	        						<p class="tit">预约时间</p>
	        						<p class="bookTime">
	        							<?php echo date('Y-m-d', $value['appointment_time']); ?><br>
	        							<?php echo $value['arrival_time']; ?>
	        						</p>
	        					</span>
	        					<span>
	        						<p class="tit">联系方式</p>
	        						<p class="contact">
	        							<?php echo $value['linkman']; ?><br>
	        							<?php echo $value['link_phone']; ?>
	        						</p>
	        					</span>
	        					<span>
	        						<p class="tit">金额</p>
	        						<p class="contact">
	        							<?php echo $value['appointment_price']; ?>
	        						</p>
	        					</span>
	        					<span>
	        						<p class="tit">订单状态</p>
	        						<p id="<?php echo 'state_boxp'.$value['appointment_id']; ?>" class="<?php if ($value['appointment_state'] == 1) { echo 'waitLis'; } else if ($value['appointment_state'] == 2) { echo 'waitSer'; } else if ($value['appointment_state'] == 3) { echo 'inSer'; } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) { echo 'hasFin'; } else if ($value['appointment_state'] == 6) { echo 'hasFin'; } ?>"><i></i><b <?php if($value['appointment_state'] == 6) { echo 'style="text-decoration:line-through;"'; } ?>><?php if ($value['appointment_state'] == 1) { echo '待接单'; }  else if ($value['appointment_state'] == 3) { echo '进行中'; } else if ($value['appointment_state'] == 4 || $value['appointment_state'] == 5) { echo '已完成'; } else if ($value['appointment_state'] == 6) { echo '已取消'; } ?></b></p>
	        					</span>
	        					<span value="<?php echo $value['appointment_id']; ?>">
	        						<?php if ($value['appointment_state'] == 1) {
	        							echo '<a href="javascript:;" class="getOrder">接单</a>';
	        							echo '<a href="javascript:;" class="cancel">取消</a>';
	        						} else if ($value['appointment_state'] == 3) {
	        							echo '<a href="javascript:;" class="overSer">已完成</a>';
	        							echo '<a href="javascript:;" class="cancel">取消</a>';
	        						} ?>
	        					</span>
	        				</div>
	        			</li>
	        			<?php endforeach ?>
	        		</ul>
	        	</div>
	        	<!--表格模块结束-->
	        </div>
	        <!--分页开始-->
        	<div class="page">
        		<?php if ($a_view_data['type'] == 6) {
        			echo $this->pages->link_style_one($this->router->url('appointment_search-'.$a_view_data['cate'].'-'.$a_view_data['search_office'].'-'.$a_view_data['search_seat'].'-'.$a_view_data['keywords'].'-', [], false, false));
        		} else {
        			echo $this->pages->link_style_one($this->router->url('appointment_order-'.$a_view_data['cate'].'-'.$a_view_data['state'].'-', [], false, false));
        		} ?>
	            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
        	</div>
        	<!--分页结束-->
	        <!--右边内容结束-->
	        <!--删除订单提示弹框开始-->
	        <div class="delePart cancelBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p>重要提示</p>
	        	<p>*确定要取消订单吗？</p>
	        	<div class="reasonBox">
	        		<p class="ding">*订单取消原因：</p>
	        		<div class="reasonSel">
	        			<a href="javascript:;" class="choose"><span class="cho"></span><i class="down"></i></a>
	        			<div class="select">
	        				<ul>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">跟用户协商</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">房间故障</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">用户拍错了</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">信息填写错误</span></label></li>
	        					<li><label><input type="radio" name="check" class="rad"/><span class="rea">其他</span></label></li>
	        				</ul>
	        			</div>
	        		</div>
	        	</div>
	        	<p><span>*备注：</span><input type="text" name="cancel_description" class="txt"/></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--删除订单提示弹框结束-->

	</body>
</html>

<script>

// 当选择办公室时获取办公室的座位号
function appointment_getseat() {
	var office_id = $("select[name='search_office']").val();
	$('.seatSel option').not(':eq(0)').remove();
	if (office_id != 'all') {
		$.ajax({
			url: 'appointment_getseat',
			type: 'POST',
			dataType: 'json',
			data: {office_id: office_id},
			success: function(res) {
				console.log(res);
				if (res.code == 200) {
					var append_content = '';
					for (var i=0; i<res.data.length; i++) {
						if (res.data[i] != 0) {
							append_content += '<option value="'+res.data[i]+'">'+res.data[i]+'</option>';
						}
					}
					$(".seatSel").append(append_content);
				}
			}
		})
	}
}

// 订单搜索
function appointment_search() {
	$("#searchform").submit();
}

</script>
