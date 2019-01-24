<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>消息</title>
		<link rel="stylesheet" href="static/default/style/common.css"/>
		<link rel="stylesheet" href="static/default/style/message.css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/default/script/common.js" type="text/javascript"></script>
	</head>
	<script>
		$(function(){
			$(".lay").hide();
			$(".popMess").hide();
			$(".popNotice").hide();

			//显示
			function show(lay,ele){
				lay.show();
				ele.show(100);
			}
			//关闭
			function close(lay,ele){
				lay.hide();
				ele.hide(100);
			}
			$(".mess").click(function(){
				show($(".lay"),$(".popMess"));
			});
			$(".notice").click(function(){
				var mid = $(this).attr("id");//alert($("#title_" + mid).html());
				$(".popNotice dl dd").html($("#content_" + mid).html());
				show($(".lay"),$(".popNotice"));
				// 触发消息为已读
				$.ajax({
					url: "<?php echo $this->router->url('msg_read');?>",
					type: "post",
					data: "id_msg=" + mid,
					dataType: "json",
					success: function(result) {
						if (result.state == 'success') {
							$("#msg_img_read_" + mid).attr("src", "static/default/images/mes_10.png")
						}
					},
					error:function(msg){
						alert(msg);
					}
				});
			});
			$(".closeMess").click(function(){
				close($(".lay"),$(".popMess"));
			});
			$(".closeNotice").click(function(){
				close($(".lay"),$(".popNotice"));
			});
		})
	</script>
	<body>
		<div class="main">
			<!--左边导航开始-->
			<?php $this->view->display('menu_system');?>
			<!--左边导航结束-->
			<!-- 通知消息 -->
			<div class="messageBox">
				<p>通知消息</p>
				<!-- 消息列表 -->
				<div class="messContainer">
					<dl>
					<?php
					foreach ($a_view_data['msg'] as $a_msg) {
					?>
						<dd class="messList">
							<img id="msg_img_read_<?php echo $a_msg['mess_id'];?>" src="static/default/images/mes_<?php echo ($a_msg['examine'] == 1) ? '07' : '10';?>.png" alt=""/>
							<a class="notice" id="<?php echo $a_msg['mess_id'];?>">【系统消息】</a>
							<span id="title_<?php echo $a_msg['mess_id'];?>"><?php echo $a_msg['ues_name'];?></span>
							<em><?php echo date('Y-m-d H:i', $a_msg['mess_time']);?></em>
							<span id="content_<?php echo $a_msg['mess_id'];?>" style="display:none"><?php echo $a_msg['content'];?></span>
						</dd>
					<?php
					}
					?>
					<!-- <dd class="messList">
							<img id="msg_img_read_<?php echo $a_msg['mess_id'];?>" src="static/default/images/mes_<?php echo ($a_msg['examine'] == 1) ? '07' : '10';?>.png" alt=""/>
							<a class="notice" id="<?php echo $a_msg['mess_id'];?>">
								<span>【系统消息】</span>
								<em>个人</em>
							</a>
					
							<em><?php echo date('Y-m-d H:i', $a_msg['mess_time']);?></em>
							<span id="content_<?php echo $a_msg['mess_id'];?>" style="display:none"><?php echo $a_msg['content'];?></span>
						</dd>
					</dl> -->
					<!--分页开始-->
					<div class="page">
						<?php echo $this->pages->link_style_one($this->router->url('msg_show-', [], false, false));?>
					</div>
					<!--分页结束-->
				</div>
				<!-- 消息列表 -->

				<!-- 遮罩层 -->
				<div class="lay"></div>
				<!-- 遮罩层 -->
				<!-- 弹出框 -->
				<div class="popMess">
					<p class="closeMess">关闭</p>
					<dl>
						<dt>标题</dt>
						<dd>内容</dd>
					</dl>
				</div>
				<div class="popNotice">
					<p class="closeNotice">关闭</p>
					<dl>
						<dd>
							
						</dd>
					</dl>
				</div>
				<!-- 弹出框 -->
			</div>
			<!-- 通知消息 -->
		</div>	

	</body>
</html>
