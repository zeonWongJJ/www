<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>附近店铺-办公室列表</title>
		<link href="./static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="./static/style_default/style/officeList.css" rel="stylesheet" type="text/css">
		<script src="./static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="./static/style_default/script/officeList.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<a class="backUp"><img onclick="javascript:history.back(-1);" src="./static/style_default/images/yongping_03.png" alt="" /></a>
			<div class="title">
				<p>全部<?php if ($_SESSION['appointment_type'] == 1) { echo '房间'; } else { echo '座位'; } ?></p>
		    </div>
		    <div class="nav">
		    	<ul>
		    		<li class="current"><a href="javascript:;" value='all'>全部</a></li>
		    		<?php foreach ($a_view_data['type'] as $key => $value): ?>
		    		<li><a href="javascript:;" value="<?php echo $value['type_id']; ?>">
		    		<?php echo $value['type_name']; ?>
		    		</a></li>
		    		<?php endforeach ?>
		    	</ul>
		    </div>
		    <!--房间列表开始-->
		    <div class="content">
		    	<ul class="clearfix">
		    		<?php foreach ($a_view_data['office'] as $key => $value): ?>
		    		<li value="<?php echo $value['type_id']; ?>" onclick="office_detail(<?php echo $value['office_id']; ?>)">
		    			<div class="pic">
		    				<div class="img">
		    					<?php if (empty($value['room_mainpic'])) {
		    						echo '<img src="./static/style_default/images/officpic_03.png"/>';
		    					} else {
		    						echo '<img src="'.get_config_item('wofei_admin').$value['room_mainpic'].'"/>';
		    					} ?>
		    				</div>
		    				<div class="ding">
		    					<P class="name"><?php echo $value['room_name']; ?></P>
		    					<p class="start">
		    						<?php for ($i=0; $i<round($value['star']); $i++) {
		    							echo '<i></i>';
		    						} ?>
		    						<?php for ($i=0; $i<5-round($value['star']); $i++) {
		    							echo '<i class="harfStart"></i>';
		    						} ?>
		    						<span><?php echo round($value['star'], 1); ?></span>
		    					</p>
		    				</div>
		    				<div class="ding2">
		    					<img src="./static/style_default/images/officxiang_06.png"/>
		    				</div>
		    			</div>
		    			<p class="describe"><?php echo $value['room_description']; ?></p>
		    			<p>价格：￥<?php echo $value['office_price']; ?>/<?php if ($_SESSION['appointment_type'] == 1) { echo '小时'; } else { echo '个'; } ?></p>
		    		</li>
		    		<?php endforeach ?>
		    	</ul>
		    </div>
		    <!--房间列表结束-->
		</div>
		<?php echo $this->display('bottom'); ?>
	</body>

</html>


<script>

function office_detail(office_id) {
	window.location.href = 'office_detail-'+office_id;
}

</script>