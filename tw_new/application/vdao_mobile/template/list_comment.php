<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>咖啡评价</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/noPointCoffee_coffeeAppraise.css" rel="stylesheet" type="text/css">
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/noPointCoffee_coffeeAppraise.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a  style="top:0.15rem" class="back" href="<?php echo $this->router->url('item', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id']]); ?>"><img src="static/style_default/images/yongping_03.png"/></a>
				<i>产品评价</i>
			</header>
			<div class="tagBox">
				<ul>
					<li class="allClick"><a href="<?php echo $this->router->url('list_comment', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id'],'i_canshu' => 0]); ?>">全部</a></li>
					<li><a href="<?php echo $this->router->url('list_comment', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id'],'i_canshu' => 1]); ?>">很满意(<i><?php echo $a_view_data['hao']?></i>)</a></li>
					<li><a href="<?php echo $this->router->url('list_comment', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id'],'i_canshu' => 2]); ?>">满意(<i><?php echo $a_view_data['zho']?></i>)</a></li>
					<li><a href="<?php echo $this->router->url('list_comment', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id'],'i_canshu' => 3]); ?>">待提高(<i><?php echo $a_view_data['cha']?></i>)</a></li>
					<li><a href="<?php echo $this->router->url('list_comment', [$a_view_data['i_lexin'], $a_view_data['goods_id'],$a_view_data['store_id'],'i_canshu' => 4]); ?>">有图(<i><?php echo $a_view_data['img']?></i>)</a></li>
				</ul>
			</div>
			<div class="appList">
				<ul class="clearfix">
					<?php foreach ($a_view_data['comment'] as $comment) {?>
						<li>
							<div class="picL">
								<img src="<?php foreach ($a_view_data['user'] as $user) {
									if($user['user_id'] == $comment['user_id']){ echo $user['user_pic'];}}?>"/>
							</div>
							<div class="describeR">
								<p class="name">
									<span class="ming"><?php foreach ($a_view_data['user'] as $user) {
									if($user['user_id'] == $comment['user_id']){ echo $user['user_name'];}}?></span>
									<span class="shijian"><?php echo date('m-d', $comment['comment_time'])?></span>
								</p>
								<p class="product">产品：<?php echo $comment['product_name']?></p>
								<p class="discuss"><i class="red">[<?php if ($comment['comment_cate'] == 1) { echo "很满意";} else if ($comment['comment_cate'] == 2) { echo "满意";} else if ($comment['comment_cate'] == 3) { echo "待提高";}?>]</i><?php echo $comment['comment_content']?></p>
								<div class="imgBox">
								<?php if (empty($comment['comment_pic'])) {?>

								<?php } else { foreach (explode(",", $comment['comment_pic']) as $img) {?>
									<img src="<?php echo $img?>"/>
								<?php }}?>
								</div>
							</div>
						</li>
					<?php }?>
				</ul>
			</div>
		</div>
	</body>
</html>
