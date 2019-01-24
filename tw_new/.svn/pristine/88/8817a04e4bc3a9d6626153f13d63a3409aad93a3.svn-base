<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>产品管理-套餐管理</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/storePackage.css"/>
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/storePackage.js" type="text/javascript" charset="utf-8"></script>
        <style>
			.isshow {
				display: none;
			}
        </style>
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
        			<a href="javascript:;">产品管理</a><span>></span><a href="javascript:;">套餐管理</a>
        		</div>
	        	<!--面包屑导航结束-->

	        	<!--咖啡列单表开始-->
	        	<div class="coffeeModule clearfix">
	        		<!--下架产品开始-->
	        		<?php foreach ($a_view_data['product'] as $key => $value): ?>
	        		<div class="sigleModule <?php if ($value['ishavepro'] == 0) { echo 'upModule'; } ?>" id="tr_<?php echo $value['product_id']; ?>">
	        			<div class="imgBox">
	        				<?php if (!empty($value['pro_img'])) {
	        					echo '<img src="'.$value['pro_img'].'"/>';
	        				} else {
	        					echo '<img src="static/style_default/images/l_03.png"/>';
	        				} ?>
	        			</div>
	        			<div class="characterBox">
	        				<div class="title">
	        					<p class="h2"><a href="javascript:;"><?php echo $value['product_name']; ?></a></p>
	        					<p class="updown"><img src="static/style_default/images/tips_05.png"/></p>
	        					<?php if (!empty($value['ishavepro'])) { ?>
	        					<div class="stop">
	        						<a href="javascript:;" value="<?php echo $value['product_id']; ?>"><i class="stopImg"></i><span>下架产品</span></a>
	        					</div>
	        					<?php } else { ?>
	        					<div class="stop up">
	        						<a href="javascript:;" value="<?php echo $value['product_id']; ?>"><i class="stopImg"></i><span>上架产品</span></a>
	        					</div>
	        					<?php } ?>
	        				</div>
							<div class="stock <?php if (empty($value['ishavepro'])) { echo 'isshow'; } ?>" value="<?php echo $value['product_id']; ?>">
								<em>库存量</em>
								<img class="stockPrev" src="static/style_default/images/np_03.png" />
								<span id="stock_<?php echo $value['product_id']; ?>"><?php echo $value['today_stock']; ?></span>
								<img class="stockNext" src="static/style_default/images/np_05.png" />
							</div>
	        				<p class="describe"><a href="javascript:;">
                            <?php
                                $subject = strip_tags($value['pro_details']);//去除html标签
                                $pattern = '/\s/';//去除空白
                                $content = preg_replace($pattern, '', $subject);
                                $seodata = mb_substr($content, 0, 50);//截取100个汉字
                                echo $seodata;
                            ?>
	        				</a></p>
	        				<div class="proswitch <?php if ($value['prod_show'] == 1) { echo 'open'; } else { echo 'stopOpen'; } ?> <?php if (empty($value['ishavepro'])) { echo 'isshow'; } ?>" value="<?php echo $value['prod_show']; ?>" proid="<?php echo $value['product_id']; ?>">
	        					<?php if ($value['prod_show'] == 1) {
	        						echo '<span>启用</span> ';
	        						echo '<img src="static/style_default/images/pro_10.png"/>';
	        					} else {
	        						echo '<span>暂用</span> ';
	        						echo '<img src="static/style_default/images/pro_33.png"/>';
	        					} ?>
	        				</div>
	        				<div class="label">
	        					<div class="word">
	        						<?php if (!empty($value['antistop'])) {
	        							$keywords = explode(',', $value['antistop']);
	        							for ($i=0; $i < count($keywords); $i++) {
	        								echo '<span>'. $keywords[$i] .'</span>';
	        							}
	        						} ?>
	        					</div>
	        					<p class="price" title="<?php echo $value['price']; ?>"><?php echo $value['price']; ?>元</p>
	        				</div>
	        			</div>
	        		</div>
	        		<?php endforeach ?>
	        		<!--下架产品结束-->
	        	</div>
	        	<!--咖啡列单表结束-->
	        	<!--分页开始-->
	        	<div class="page">
					<?php echo $this->pages->link_style_one($this->router->url('package_showlist-', [], false, false)); ?>
		            <span style="background:none">共计<em> <?php echo $a_view_data['count']; ?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->
        </div>
	    <!--删除单个提示框开始-->
        <div class="delePart deleSingle">
        	<p>重要提示</p>
        	<p class="p2">*<span>确定要下架产品吗？</span></p>
        	<p class="p3">*<span>下架后，可重新上架此产品</span></p>
        	<p class="p4">
        		<span>预设每日库存:</span>
        		<input type="text" name="pro_stock" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')"  />
        	</p>
        	<div class="btnBox">
        		<a href="javascript:;" class="sure">确认</a>
        		<a href="javascript:;" class="think">取消</a>
        	</div>
        </div>
        <!--删除单个提示框结束-->

	</body>
</html>
