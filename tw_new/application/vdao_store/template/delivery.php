<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>订单管理-咖啡订单</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/orderManage_coffee.css"/>       
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/orderManage_coffee.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<!-- 头部 -->
        <?php echo $this->display('top'); ?>
        <!-- 头部 -->		
        <div class="bottom clearfix">
        	<!-- 导航 -->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航 -->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--小导航开始-->
	        	<div class="smallNav">
	        		<i></i>
	        		<a href="javascript:;">订单管理/</a><a class="cur" href="javascript:;">餐饮订单</a>
	        	</div>       		
	        	<!--小导航结束-->
	        	<!--所有订单开始-->
	        	<div class="allOrder">
	        		<ul>
	        			<li class="allList <?php if ($a_view_data['i_order'] == 0) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 0,'i_canshu' => 1]); ?>">所有订单</a></li>
	        			<li class="waitPay <?php if ($a_view_data['i_order'] == 40) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 40,'i_canshu' => 1]); ?>"><i class="dot"></i>待付款<i class="number"><?php echo $a_view_data['payment']?></i></a></li>
	        			<li class="waitList <?php if ($a_view_data['i_order'] == 20) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 20,'i_canshu' => 1]); ?>"><i class="dot"></i>待接单<i class="number"><?php echo $a_view_data['waiting']?></i></a></li>
	        			<li class="waitCarry <?php if ($a_view_data['i_order'] == 25) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 25,'i_canshu' => 1]); ?>"><i class="dot"></i>待配送<i class="number"><?php echo $a_view_data['shipping']?></i></a></li>
	        			<li class="inCarry <?php if ($a_view_data['i_order'] == 30) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 30,'i_canshu' => 1]); ?>"><i class="dot"></i>配送中<i class="number"><?php echo $a_view_data['distribu']?></i></a></li>
	        			<li class="hasFinish <?php if ($a_view_data['i_order'] == 10) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 10,'i_canshu' => 1]); ?>"><i class="dot"></i>已完成<i class="number"><?php echo $a_view_data['wanchenn']?></i></a></li>
	        			<li class="hasCancel <?php if ($a_view_data['i_order'] == 55) {echo "current";}?>"><a href="<?php echo $this->router->url('delivery', ['i_order' => 55,'i_canshu' => 1]); ?>">已取消</a></li>
	        		</ul> 	
	        	</div>
	        	<!--所有订单结束-->
	        	<!--标题开始-->
	        	<div class="tabThead">
	        		<ul>
	        			<li>订单</li>
	        			<li>实付款</li>
	        			<li>订单进度</li>
	        			<li class="dealState">
	        				<a class="biaoti"><span class="jiao"><?php if ($a_view_data['i_order'] == 0) {
	                            echo "所有订单";
	                        } else if ($a_view_data['i_order'] == 40) {
	                            echo "待付款";
	                        } else if ($a_view_data['i_order'] == 20) {
	                            echo "待接单";
	                        } else if ($a_view_data['i_order'] == 25) {
	                            echo "待配送";
	                        } else if ($a_view_data['i_order'] == 30) {
	                            echo "配送中";
	                        } else if ($a_view_data['i_order'] == 10) {
	                            echo "已完成";
	                        } else if ($a_view_data['i_order'] == 55) {
	                            echo "已关闭";
	                        }?></span>
	                        <i class="downPic"></i></a>
	        				<div class="selectBox">
	        					<a href="<?php echo $this->router->url('delivery', ['i_order' => 0,'i_canshu' => 1]); ?>">所有订单</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 40,'i_canshu' => 1]); ?>">待付款</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 20,'i_canshu' => 1]); ?>">待接单</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 25,'i_canshu' => 1]); ?>">待配送</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 30,'i_canshu' => 1]); ?>">配送中</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 10,'i_canshu' => 1]); ?>">已完成</a>
								<a href="<?php echo $this->router->url('delivery', ['i_order' => 55,'i_canshu' => 1]); ?>">已关闭</a>
	        					<i class="bai"></i>
	        				</div>
	        			</li>
	        			<li>操作</li>
	        		</ul>
	        	</div>
	        	<!--标题结束-->
	        	<!--表格模块开始-->
	        	<div class="tableBox">
	        		<ul>
	        			<?php foreach ($a_view_data['order'] as $order) {?>
	        			<li>
	        				<div class="title">	        					
	        					<p class="time"><?php echo date('Y-m-d H:i', $order['time_create'])?></p>
	        					<p class="orderNumber">订单编号:<?php echo $order['order_number']?></p>
	        				</div>
	        				<div class="row">
	        					<span>	        						
	        						<div class="userBox clearfix">
	        							<div class="imgL">
	        								<?php if (empty($order['user_pic'])) {
			                                    echo '<img src="static/style_default/images/yong_03.png" />';
			                                } else if(strpos($order['user_pic'], 'http') === false) {
			                                    echo '<img src="'.$order['user_pic'].'" />';
			                                } else {
			                                    echo '<img src="'.$order['user_pic'].'" />';
			                                } ?>
	        							</div>
	        							<div class="messageR">
	        								<p class="name"><?php echo $order['user_name']?></p>
	        								<p class="orderNum"><?php foreach ($a_view_data['goods'] as $gooder) {if ($order['order_id'] == $gooder['order_id']) {?>
	        									<?php echo $gooder['product_name']?>(<?php echo $gooder['spec']?>)<?php echo $gooder['goods_num']?>	份
	        								<?php }}?> 共<?php echo $order['order_count']?>件产品</p>
	        							</div>
	        						</div>
	        					</span>
	        					<span>
	        						<p class="price">￥<?php echo $order['order_price']?></p>
	        						<p class="carryMoney">(含配送费：￥<?php echo $order['shipping_fee']?>)</p>
	        					</span>
	        					<span>
	        						<div class="bigBar1">
	        							<div class="smallBar" style="<?php if ($order['order_state'] < 2) {
                                            echo "width: 0px";
                                        } else if ($order['order_state'] == 40) {
                                            echo "width: 15%";
                                        } else if ($order['order_state'] == 20) {
                                            echo "width: 40%";
                                        } else if ($order['order_state'] == 25) {
                                            echo "width: 60%";
                                        } else if ($order['order_state'] == 30) {
                                            echo "width: 80%";
                                        } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                            echo "width: 102%";
                                        }?>"></div>
	        							<div class="state"><s><?php if ($order['order_state'] < 2) {
                                            echo "已关闭";
                                        } else if ($order['order_state'] == 40) {
                                            echo "待付款";
                                        } else if ($order['order_state'] == 20) {
                                            echo "待接单";
                                        } else if ($order['order_state'] == 25) {
                                            echo "待配送";
                                        } else if ($order['order_state'] == 30) {
                                            echo "配送中";
                                        } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                            echo "已完成";
                                        }?></s><i class="sijiao"></i></div>
	        						</div>	        						
	        						<div class="character">
	        							<i class="pai">拍下</i>
	        							<i class="wan">完成</i>
	        						</div>
	        						
	        					</span>
	        					<span>	        						
	        						<p class="waitPay2"><i style="<?php if ($order['order_state'] < 2) {
                                           echo "background: #b5b5b5;";
                                    } else if ($order['order_state'] == 40) {
                                       echo "background: #000000";
                                    } else if ($order['order_state'] == 20) {
                                       echo "background: #ff5f4f;";
                                    } else if ($order['order_state'] == 25) {
                                       echo "background: #ffa800;";
                                    } else if ($order['order_state'] == 30) {
                                       echo "background: #1dc499;";
                                    } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                       echo "background: #b5b5b5;";
                                    }?>"></i><b><?php if ($order['order_state'] < 2) {
                                           echo "已关闭";
                                    } else if ($order['order_state'] == 40) {
                                       echo "待付款";
                                    } else if ($order['order_state'] == 20) {
                                       echo "待接单";
                                    } else if ($order['order_state'] == 25) {
                                       echo "待配送";
                                    } else if ($order['order_state'] == 30) {
                                       echo "配送中";
                                    } else if ($order['order_state'] == 10 || $order['order_state'] == 80) {
                                       echo "已完成";
                                    }?></b></p>
	        						<p class="detail"><a href="order_details-<?php echo $order['order_id']?>" class="order_id" value="<?php echo $order['order_id']?>">订单详情</a></p>
	        						<div class="messageTip">
	        							<a href="javascript:;" class="imgT"></a>
	        							<div class="messCha">备注：<?php if (empty($order['order_message'])) {
                                           echo "无";
                                        } else{echo $order['order_message'];}?><i class="sanjiao"></i></div>
	        						</div>
	        					</span>
	        					<span>	        	
	        						<?php if ($order['order_state'] < 2) {?>
	                                   <a href="javascript:;">关闭</a>
	                               <?php } else if ($order['order_state'] == 40) {?>
	                                    <a href="javascript:;" class="cancel" onclick="weifu(<?php echo $order['order_id']?>);">取消</a>
	                               <?php } else if ($order['order_state'] == 20) {?>
										<?php if ($order['order_time'] < strtotime("-5 minute")) {?>	
	                                    <a href="javascript:;" class="getOrder" value="<?php echo $order['order_id']?>">接单</a>
										<?php }?>
	                                    <a href="javascript:;" class="cancel" onclick="daijie(<?php echo $order['order_id']?>);">取消</a>
	                               <?php } else if ($order['order_state'] == 25) {?>
	                                  <!--  <a href="javascript:;" class="carry"  value="<?php echo $order['order_id']?>">配送</a>
	                                   <a href="javascript:;" class="cancel" onclick="daijie(<?php echo $order['order_id']?>);">取消</a> -->
	                               <?php } else if ($order['order_state'] == 30) {?>
	                                   <!--  <a href="javascript:;" class="hadFinish" value="<?php echo $order['order_id']?>">已完成</a> -->
	                               <?php } else {?>
	                                    
	                                <?php }?>
	        					</span>
	        				</div>
	        			</li>
						<?php }?>
	        		</ul>
	        	</div>
	        	<!--表格模块结束-->	        	
	        </div>
	        <!--分页开始-->
        	<div class="page">
        		<?php echo $a_view_data['page']?>
        		
	            <span style="background:none">共计<em> <?php echo $a_view_data['out']?> </em>条数据</span>
        	</div>
        	<!--分页结束-->
	        <!--右边内容结束-->	
	        <!--订单详情弹框开始-->
	        <div class="detailBomb">
	        </div>
	        <!--订单详情弹框结束-->
	        <!--取消订单提示弹框开始-->  
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
	        	<p class="remark"><span>*备注：</span><input type="text" class="txt" name="text" /></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">再看看</a>
	        	</div>
	        </div>
	        <!--取消订单提示弹框结束-->
	       
	</body>
</html>
<script>
	// 待付款取消
	function weifu(order_id) {
		$('.sure').click(function(){			
			var cho = $('.cho').text();
			var txt = $('.txt').val();
			if (cho == '其他') {
				var cho = txt;
			};
			$.ajax({
				type : 'post',
				url  : '<?php echo $this->router->url('delivery_quxiao');?>',
				data : {id:order_id,cho:cho,txt:txt,ster:1},
				dataType : 'json',
				success  : function(data) {
					if (data.stuo == 33) {
						alert('取消订单成功！');
						window.location.reload();
					};
				}
			})
		})
	}

	// 付款取消订单
	function daijie(order_id) {
		$('.sure').click(function(){			
			var cho = $('.cho').text();
			var txt = $('.txt').val();
			if (cho == '其他') {
				var cho = txt;
			};
			$.ajax({
				type : 'post',
				url  : '<?php echo $this->router->url('delivery_quxiao');?>',
				data : {id:order_id,cho:cho,ster:2},
				dataType : 'json',
				success  : function(data) {
					if (data.stuo == 33) {
						alert('退款成功！');
						window.location.reload();
					} else if (data.stuo == 44) {
						alert('用户已取消了订单！');
						window.location.reload();
					} else {
						alert('订单有误！请重试！');
						window.location.reload();
					};
				}
			})
		})
	}
	//点击已完成按钮 
	$('body').on('click','.tableBox .row .hadFinish',function(){
		var order_id = $(this).attr('value');
		$.ajax({
			type : 'post',
			url  : 'delivery_wanchen',
			data : {id:order_id},
			dataType : 'json',
			success  : function(data) {
				if (data.stuo == 33) {	
					alert('订单完成！');
					window.location.reload();
				}
			}
		})
	})
	//点击配送按钮
	$('body').on('click','.tableBox .row .carry',function(){
		var order_id = $(this).attr('value');
		$.ajax({
			type : 'post',
			url  : 'delivery_order',
			data : {id:order_id},
			dataType : 'json',
			success  : function(data) {
				if (data == 55) {	
					alert('配送成功！');
					window.location.reload();
				}
			}
		})
	})
	//点击接单按钮
	$('body').on('click','.tableBox .row .getOrder',function(){
		var order_id = $(this).attr('value');
		$.ajax({
			type : 'post',
			url  : '<?php echo $this->router->url('delivery_jiedan');?>',
			data : {id:order_id},
			dataType : 'json',
			success  : function(data) {
				if (data.stuo == 33) {	
					alert('接单成功！');
					window.location.reload();
				}
			}
		})
	})
</script>