  <!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>产品详情</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/noPointCoffee_productDetail.css" rel="stylesheet" type="text/css">
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="static/style_default/plugin/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="static/style_default/script/noPointCoffee_productDetail.js" type="text/javascript"></script>
	</head>
	<body>
    <!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<div class="head clearfix" style="height:6rem; padding-top:0;">
				<div class="img">
					<img src="<?php echo $a_view_data['goods'][0]['pro_img']?>"/>
				</div>
				<div class="title">
					<a href="<?php  if ($this->router->get(3) == 'i') { echo 'product_list';} else if ($this->router->get(3) == 'n') { echo 'share_goods_list';} else if ($this->router->get(3) == 0) {
						echo $this->router->url('list', [$this->router->get(1)]);
					} else { echo $this->router->url('list_store', [$this->router->get(3), $this->router->get(1)]);};?>"  class="back" style="top:0;"><img src="static/style_default/images/vbf.png"/></a>
					<span><?php if (empty($a_view_data['goods'][0]['store_id'])) {
						echo "不指定店铺";
					} else {echo $a_view_data['goods'][0]['store_name'];}?></span>
					<input type="hidden" id="store_name" value="<?php echo $a_view_data['goods'][0]['store_name'];?>">
				</div>
				<p class="control">
					<a class="collect cCur" href="login?oldurl=<?php echo $this->router->get_url(); ?>;" value="<?php echo $this->router->get(2)?>"><img src="static/style_default/images/fa.png"></a>
					<a class="share" href="login?oldurl=<?php echo $this->router->get_url(); ?>;"><img src="static/style_default/images/saf.png"/></a>
				</p>
				
				<!--<div class="xiebai"><img src="static/style_default/images/xiebai3_02.png"/></div>-->
				
			</div>
			<?php if ($a_view_data['goods'][0]['goods_stye'] == 2) {?>
			<!-- 分享者 -->
			<div class="sharing">
				<dl>
					<dt>
						<span>分享者：</span>
						<em><?php echo $a_view_data['goods'][0]['user_name']?></em>
					</dt>
					<dd>
						<span>许可证号：</span>
						<em><?php echo $a_view_data['goods'][0]['goods_license']?></em>
					</dd>
					<dd>
						<span>发货地：</span>
						<em><?php echo $a_view_data['goods'][0]['join_province'] . $a_view_data['goods'][0]['join_city'] . $a_view_data['goods'][0]['join_district'] . $a_view_data['goods'][0]['addre']?></em>
					</dd>
					<dd>
						<span>配送费:￥</span><em><?php echo $a_view_data['goods'][0]['distribution']?></em>
					</dd>
				</dl>
			</div>
			<!-- 分享者 -->
			<?php }?>
				
			<!--价格开始-->
			<p class="price">
				<i class="fu">¥</i><?php echo $a_view_data['pric'][0]['price']?><i class="qi">起</i>
				<?php if (!empty($a_view_data['goods'][0]['supply_time']) && !empty($a_view_data['time'])) {$i=1;
                    foreach (explode(",", $a_view_data['goods'][0]['supply_time']) as $time) {
                       if (!empty($time) && in_array($time, $a_view_data['time'])) {
                        if ($a_view_data['goods'][0]['today_stock'] != 0) {if($i==1){?>
                	<a class="joinCart" href="login?oldurl=<?php echo $this->router->get_url(); ?>;">加入购物车</a>
                <?php $i++;} } } } } else {if ($a_view_data['goods'][0]['today_stock'] != 0) {?>
                	<a class="joinCart" href="login?oldurl=<?php echo $this->router->get_url(); ?>;">加入购物车</a>
                <?php } }?>				

			</p>
			<!--价格结束-->	
				
			<div class="starName">
					<p class="star">
						<span class="xing">
							<?php if ($a_view_data['payment'] >= 0 && $a_view_data['payment'] <= 20) {?>
								<i></i>
								<?php for ($i=0; $i < 4; $i++) {?>
								<i class="half"></i>
								<?php } ?>
							<?php } else if ($a_view_data['payment'] >= 21 && $a_view_data['payment'] <= 40) {?>
								<i></i>
								<i></i>
								<?php for ($i=0; $i < 3; $i++) {?>
								<i class="half"></i>
								<?php } ?>
							<?php } else if ($a_view_data['payment'] >= 41 && $a_view_data['payment'] <= 60) {?>
								<?php for ($i=0; $i < 3; $i++) {?>
								<i></i>
								<?php } ?>
								<i class="half"></i>
								<i class="half"></i>
							<?php } else if ($a_view_data['payment'] >= 61 && $a_view_data['payment'] <= 80) {?>
								<?php for ($i=0; $i < 4; $i++) {?>
								<i></i>
								<?php } ?>
								<i class="half"></i>
							<?php } else if ($a_view_data['payment'] >= 81 && $a_view_data['payment'] <= 100) {?>
							<?php for ($i=0; $i < 5; $i++) {?>
								<i></i>
								<?php } ?>
							<?php }?>
						</span>
						<span class="fen"><?php echo $a_view_data['payment']?></span>
					</p>
					<p class="name"><?php echo $a_view_data['goods'][0]['product_name']?></p>
				</div>	
				
			<!--产品描述开始-->
			<div class="describe">
				<p class="h3">产品描述</p>
				<p class="miao"><?php echo strip_tags($a_view_data['goods'][0]['pro_details'])?></p>
			</div>
			<!--产品描述结束-->
			<!--评价开始-->
			<div class="appraise">
				<p class="aTitle">
					<span class="ping">评价<i class="pNum">+<?php echo $a_view_data['out']?></i></span>
					<a class="seeMore" href="list_comment-<?php echo $this->router->get(1)?>-<?php echo $this->router->get(2)?>-<?php echo $this->router->get(3)?>">查看更多</a>
				</p>
				<div class="aList">
					<ul class="clearfix">
						<?php foreach ($a_view_data['name'] as $name) {?>
							<li><a href="javascript:;"><?php echo $name?></a></li>
						<?php }?>
					</ul>
				</div>
			</div>
			<!--评价结束-->
			<!--图片开始-->
			<div class="picture">
				<p class="aTitle">
					<span class="ping">图片<i class="pNum">+<?php echo count(explode(",", $a_view_data['goods'][0]['pro_image']))?></i></span>
				</p>
				<div class="picList">
					<ul class="clearfix">
						<?php foreach (explode(",", $a_view_data['goods'][0]['pro_image']) as $value) {?>
						<li><a href="javascript:;"><img src="<?php echo $value?>"/></a></li>
						<?php }?>
					</ul>
				</div>
				<!--<div class="addBtn">
					<a href="javascript:;"><img src="static/style_default/images/gouxiang_22.png"/></a>
				</div>-->
			</div>
			<!--图片结束-->
			<!--浅灰遮罩层开始-->
			<!--<div class="shade lightGrey"></div>-->
			<!--浅灰遮罩层结束-->
			<!--加入购物车弹框开始-->
				
			<!--加入购物车弹框结束-->
		</div>
		<!--遮罩层开始-->
		<div class="shade"></div>
		<!--遮罩层结束-->
		<!--图片弹框开始-->
		<div class="picBomb">
			<div class="close2">
				<a href="javascript:;"><img src="static/style_default/images/putin_06.png"/></a>
			</div>
			<div class="picWrap">
				<div class="picShow">
					<ul class="clearfix">
						<?php foreach (explode(",", $a_view_data['goods'][0]['pro_image']) as $value) {?>
						<li><img src="<?php echo $value?>"/></li>
						<?php }?>
					</ul>
				</div>
				<a class="left" href="javascript:;"><img src="static/style_default/images/left.png"/></a>
				<a class="right" href="javascript:;"><img src="static/style_default/images/right.png"/></a>
			</div>
		</div>
		<!--图片弹框结束-->
		
		<!-- 底部 -->
    	<form action="new_bill?oldurl=<?php echo $this->router->get_url(); ?>" class="iyyy" method="post">
    		<div class="bottom">
       			<div class="productPrice">
            		<em class="yuan">
               		 	<img src="static/style_default/images/bei_03.png" alt=""/>
                		<!-- <i id="oute"></i> -->
            		</em>
            		<em class="priceBox">
                		<span>￥<em id="poutt">0</em></span>
                		<em>
                    		<span>另需配送费</span><dfn>￥0</dfn>
                		</em>
            		</em>
        		</div>
        	<a href="login?oldurl=<?php echo $this->router->get_url(); ?>" class="totalBox">去结算</a>
         	<script>
        	$(".totalBox").click(function(){
            	$(".iyyy").submit();
        	})
        	</script>
    		</div>
    	</form>
    	<!-- 底部 -->
   		
   		<!-- <div class="lay"></div> -->
    	<!-- 提示 -->
    	<div class="tips">
        	<p>注意</p>
        	<span>确定要清空购物车吗</span>
        	<div class="tipsChoice">
            	<a class="cancelClear">取消</a>
            	<a class="sureClear" value="0">确定</a>
        	</div>
    	</div>
    	<div class="tipsBox">

    	</div>
	</body>
</html>
<script>
	zuji();
	function zuji() {
		var goods = $('#goods').attr('value');
		$.ajax({
			type : 'post',
			url  : 'footprint_add',
			data : {goods:goods,type:1},
			dataType : 'json',
			success  : function(data) {

			}
		})
	}
</script>
