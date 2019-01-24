<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="static/default/style/common.css"/>
		<link rel="stylesheet" href="static/default/style/userShowDemo.css"/>
		<script src="static/default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/default/script/common.js" type="text/javascript"></script>
	</head>
	<body >
		<div class="main" style="background:#f6f9ff;">
			<!-- 菜单 -->
			<div class="menu">
				<ul>
				<?php
				if (is_array($a_view_data['cart'])) {
					foreach ($a_view_data['cart'] as $a_data) {
						$s_attr = '';
						if (isset($a_data['attr']) && is_array($a_data['attr'])) {
							foreach ($a_data['attr'] as $a_attr) {
								$s_attr .= $a_attr['attr_name'] . '/';
							}
						}
						$s_attr = rtrim($s_attr, '/');
				?>
					<li class="menuList">
						<a>
							<i><img src="<?php echo $a_data['pro_img'];?>" alt=""/></i>
							<span><?php echo $a_data['num'];?></span>
						</a>
						<div class="dishesName">
							<h1><?php echo $a_data['product_name'];?></h1>
							<em>(<?php echo $a_data['cup_name'];?>)</em><dfn>¥</dfn><s><?php echo $a_data['price'];?>元</s>
						</div>
					</li>
				<?php
					}
				}
				?>
				</ul>
			</div>
			<!-- 菜单 -->
			<!-- 底部 -->
			<div class="bottom">
				<i class="logo"><img src="static/default/images/logo.png" alt=""/></i>
				<div class="payContainer">
					<span>共<em class="num"><?php echo $a_view_data['product_num'] ? $a_view_data['product_num'] : 0;?></em>件产品&nbsp;<dfn class="totoal"><?php echo $a_view_data['product_money'] ? $a_view_data['product_money'] : 0;?></dfn>元</span>
					<!-- 二维码 -->
					<div class="codeBox">
						<ul>
							<?php
							if (isset($a_view_data['qr_code_ali'])) {
							?>
							<li class="zhifubao">
								 <p>
									 <img src="static/default/images/submit_11.png" alt=""/>
									 <span>支付宝</span>
								 </p>
								<a>
									<i>
										<img src="<?php echo $this->router->url('qrcode', ['url' => $a_view_data['qr_code_ali']]);?>" alt=""/>
									</i>
								</a>
							</li>
							<?php
							}
							?>
							<?php
							if (isset($a_view_data['qr_code_wx'])) {
							?>
							<li class="weChat">
								<p>
									<img src="static/default/images/submit_15.png" alt=""/>
									<span>微信支付</span>
								</p>
								<a>
									<i>
										<img src="<?php echo $this->router->url('qrcode', ['url' => $a_view_data['qr_code_wx']]);?>" alt=""/>
									</i>
								</a>
							</li>
							<?php
							}
							?>
						</ul>
					</div>
					<!-- 二维码 -->
				</div>
			</div>
			<!-- 底部 -->
		</div>

	</body>
</html>
