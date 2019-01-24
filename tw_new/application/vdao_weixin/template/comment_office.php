<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>用户评价-办公室</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/userAppraise_office.css" rel="stylesheet" type="text/css" />
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/userAppraise_office.js" type="text/javascript"></script>
	</head>
	<body>
        <!-- 拉框开始 -->
        <?php echo $this->display('head'); ?>
        <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="javascript:window.history.back();"><img src="./static/style_default/images/yongping_03.png"/></a>
				<i>店铺评价</i>
				<a class="submit" href="javascript:;">提交</a>
			</header>
			<div class="shopName">
				<div class="pic">
				<?php if (!empty($a_view_data['detail']['store_touxaing'])) {
					echo '<img src="'.$a_view_data['detail']['store_touxaing'].'" />';
				} else {
					echo '<img src="./static/style_default/images/yongping_07.png"/>';
				} ?>
				</div>
				<p class="name"><?php echo $a_view_data['detail']['store_name']; ?></p>
			</div>
			<!--办公室评价开始-->
			<form  id="commentform" action="appointment_comment" enctype="multipart/form-data" method="post">
			<input type="hidden" name="appointment_id" value="<?php echo $a_view_data['detail']['appointment_id']; ?>">
			<input type="hidden" name="appointment_number" value="<?php echo $a_view_data['detail']['appointment_number']; ?>">
			<div class="offAppraise">
				<p class="title">办公室评价<i>(文字评价和标签，必填一项)</i> </p>
				<div class="appBox">
					<ul>
						<li>
							<div class="roomType clearfix">
								<p class="rName">
								<?php if ($a_view_data['detail']['appointment_type'] == 1) {
									echo $a_view_data['detail']['room_name'];
								} else {
									echo $a_view_data['detail']['room_name'].'-'.$a_view_data['detail']['office_seatname'];
								} ?>
								</p>
								<div class="rFace">
									<a href="javascript:;" class="good"></a>
									<a href="javascript:;" class="soso"></a>
									<a href="javascript:;" class="bad"></a>
								</div>
								<input type="hidden" name="comment_cate" value="1">
							</div>
							<div class="tag">
								<?php foreach ($a_view_data['comtag'] as $key => $value): ?>
								<a href="javascript:;" value="<?php echo $a_view_data['comtag_cate']; ?>"><?php echo $value['comtag_name']; ?></a>
								<?php endforeach ?>
							</div>
							<input type="hidden" name="comment_tags">
							<div class="txtDiv">
								<textarea class="txt" name="comment_content" placeholder="点评一下吧，您的意见很重要哦"></textarea>
								<p class="num"><span>0</span>/<span>200</span></p>
							</div>
							<div class="upload">
								<!--<a href="javascript:;"><img src="./static/style_default/images/xiangji_03.png"/></a>-->
								<!--上传图片开始-->
								<div class="container">
				                    <!--    照片添加    -->
				                    <div class="z_photo">
				                        <div class="z_file">
				                            <input type="file" style="color:transparent; opacity:0;" name="file[]"  multiple="multiple" id="file" accept="images/*" onchange="imgChange('z_photo','z_file');" />
				                        </div>
				                    </div>

				                    <!--遮罩层-->
				                    <div class="z_mask">
				                        <!--弹出框-->
				                        <div class="z_alert">
				                            <p>确定要删除这张图片吗？</p>
				                            <p>
				                                <span class="z_cancel">取消</span>
				                                <span class="z_sure">确定</span>
				                            </p>
				                        </div>
				                    </div>
				                </div>
								<!--上传图片结束-->
							</div>
						</li>
					</ul>
				</div>
			</div>
			<!--办公室评价结束-->
			<!--店铺评价开始-->
			<div class="shopAppraise">
				<p class="sTitle">店铺评价<i>(必填)</i> </p>
				<div class="service">
					<p class="manner">
						<span class="fuwu">服务态度</span>
						<span class="star service_star">
							<i></i>
							<i></i>
							<i></i>
							<i></i>
							<i></i>
						</span>
						<span class="very">非常好</span>
					</p>
					<p class="manner">
						<span class="fuwu">服务质量</span>
						<span class="star goods_star">
							<i></i>
							<i></i>
							<i></i>
							<i></i>
							<i></i>
						</span>
						<span class="very">一般</span>
					</p>
				</div>
				<input type="hidden" name="goods_score">
				<input type="hidden" name="service_score">
			</div>
			<!--店铺评价结束-->
			<!--匿名评价开始-->
			<div class="hideName">
				<span class="gou"></span>
				<span class="ni">匿名评价</span>
			</div>
			<input type="hidden" name="is_anonymous" value="0">
			<!--匿名评价结束-->
		</div>
		</form>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--推出评价弹框开始-->
		<div class="qqBomb outBomb">
			<p class="p1">确定关闭评价？</p>
			<p class="p2">关闭后当前评价信息不会保留。</p>
			<p class="btnBox">
				<a href="javascript:;" class="cancel">取消</a>
				<a href="javascript:;" class="remove">确定</a>
			</p>
		</div>
		<!--推出评价弹框结束-->
		<!--提交成功提示开始-->
		<div class="blackTips">提交成功，感谢您的评价</div>
		<!--提交成功提示结束-->
	</body>
</html>
