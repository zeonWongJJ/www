<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>商品列表</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="./style/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./style/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="./style/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<link rel="stylesheet" href="./style/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="./style/chosen.css" />
		<link rel="stylesheet" href="./style/datepicker.css" />
		<link rel="stylesheet" href="./style/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="./style/daterangepicker.css" />
		<link rel="stylesheet" href="./style/colorpicker.css" />

		<!-- fonts -->


		<!-- ace styles -->

		<link rel="stylesheet" href="./style/ace.min.css" />
		<link rel="stylesheet" href="./style/ace-rtl.min.css" />
		<link rel="stylesheet" href="./style/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="./style/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="./js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="./js/html5shiv.js"></script>
		<script src="./js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<?php $this->display('header'); ?>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<?php $this->display('sidebar'); ?> 

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#">商品列表</a>
							</li>

							<!-- <li class="active">Form Elements</li> -->
						</ul><!-- .breadcrumb -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								商品列表
							</h1>
							<h1 style="float:right">
								<a href="<?php echo $this->router->url('goods'); ?>">返回商品页</a>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php
									/**
									 * [select 默认选中框]
									 * @param  [string] $val [默认值]
									 * @param  [string] $id  [选中值]
									 * @return [strint]      [selected='selected']
									 */
									function select($val,$id){
										if($val == $id){
											echo "selected='selected'";
										}else{
											echo '';
										}
										} ?>
								<form class="form-horizontal">

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品名称 </label>
										<div class="col-sm-9">
											<input type="text" readonly='readonly' required="required" name="goods_name" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_name'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品广告词 </label>
										<div class="col-sm-9">
											<input type="text" readonly='readonly' required="required" name="goods_jingle" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_jingle'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品关键词 </label>
										<div class="col-sm-9">
											<input type="text" readonly='readonly' required="required" name="keywords" id="form-field-1" value="<?php echo $a_view_data['goods']['keywords'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 店铺名称 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select"  name="store_id" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择店铺名称--</option>
												<?php foreach ($a_view_data['list']['store'] as $key => $value): ?>
												<option <?php select($a_view_data['goods']['store_id'],$value['store_id']) ?> data="<?php echo $value['store_name'] ?>" value="<?php echo $value['store_id'] ?>"><?php echo $value['store_name'] ?></option>
												<?php endforeach ?>
											</select>
											<input type="hidden" name="store_name" value="">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 品牌名称 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="brand_id" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择品牌名称--</option>
												<?php foreach ($a_view_data['list']['brand'] as $key => $value): ?>
												<option <?php select($a_view_data['goods']['brand_id'],$value['brand_id']) ?> value="<?php echo $value['brand_id'] ?>"><?php echo $value['brand_name'] ?></option>
												<?php endforeach ?>
											</select>
											<input type="hidden" name="brand_name" value="">
										</div>
									</div>

									<div class="form-group form-g">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品分类 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="gc_id_1" name="gc_id_1" >
												<option value="">--请选择--</option>
												<?php foreach ($a_view_data['list']['gc_id_1'] as $key => $value): ?>
													<option <?php select($a_view_data['goods']['gc_id_1'],$value['gc_id']) ?> value="<?php echo $value['gc_id'] ?>"><?php echo $value['gc_name'] ?></option>
												<?php endforeach ?>
											</select>
											<select disabled="disabled" class="gc_id_2" name="gc_id_2" id="area_city">
												<option value="">--请选择--</option>
												<?php foreach ($a_view_data['list']['gc_id_2'] as $key => $value): ?>
													<option <?php select($a_view_data['goods']['gc_id_2'],$value['gc_id']) ?> value="<?php echo $value['gc_id'] ?>"><?php echo $value['gc_name'] ?></option>
												<?php endforeach ?>
											</select>
											<select disabled="disabled" class="gc_id_3" name="gc_id_3" id="area_town">
												<option value="">--请选择--</option>
												<?php foreach ($a_view_data['list']['gc_id_3'] as $key => $value): ?>
													<option <?php select($a_view_data['goods']['gc_id_3'],$value['gc_id']) ?> value="<?php echo $value['gc_id'] ?>"><?php echo $value['gc_name'] ?></option>
												<?php endforeach ?>
											</select>
											<input type="hidden" name="gc_id_1_name" value="">
											<input type="hidden" name="gc_id_2_name" value="">
											<input type="hidden" name="gc_id_3_name" value="">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  地区  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="areaid_1" name="areaid_1" id="areaid_1" >
												<option value="">--请选择省--</option>
												<?php foreach ($a_view_data['list']['areaid_1'] as $key => $value): ?>
												<option <?php select($a_view_data['goods']['areaid_1'],$value['area_id']) ?> value="<?php echo $value['area_id'] ?>"><?php echo $value['area_name'] ?></option>
												<?php endforeach ?>
											</select>
											<select disabled="disabled" class="areaid_2" name="areaid_2" id="areaid_2" >
												<option value="">--请选择市--</option>
												<?php foreach ($a_view_data['list']['areaid_2'] as $key => $value): ?>
												<option <?php select($a_view_data['goods']['areaid_2'],$value['area_id']) ?> value="<?php echo $value['area_id'] ?>"><?php echo $value['area_name'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 运费模板 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="transport_id" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择运费模板--</option>
												<?php foreach ($a_view_data['list']['transport'] as $key => $value): ?>
												<option <?php select($a_view_data['goods']['transport_id'],$value['id']) ?> data="<?php echo $value['sprice'] ?>" value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
												<?php endforeach ?>
											</select>
											<input type="hidden" name="transport_title" value="">
											<input type="hidden" name="goods_freight" value="">
										</div>
									</div>


									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品价格 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" name="goods_price" required="required" min="0" id="form-field-1" placeholder="商品价格" value="<?php echo $a_view_data['goods']['goods_price'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 市场价 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" name="goods_marketprice" required="required" min="0" id="form-field-1" placeholder="市场价" value="<?php echo $a_view_data['goods']['goods_marketprice'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 促销类型 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="goods_promotion_type" id="form-field-select-3" >
												<option value="">--请选择促销类型--</option>
												<option <?php select($a_view_data['goods']['goods_promotion_type'],0) ?> value="0">无促销</option>
												<option <?php select($a_view_data['goods']['goods_promotion_type'],1) ?> value="1">团购</option>
												<option <?php select($a_view_data['goods']['goods_promotion_type'],2) ?> value="2">限时折扣</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品促销价格 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" name="goods_promotion_price" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_promotion_price'] ?>"  placeholder="商品促销价格" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品折扣价格 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" name="goods_discount" id="form-field-1" placeholder="商品折扣价格" value="<?php echo $a_view_data['goods']['goods_discount'] ?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 库存报警值 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" value="<?php echo $a_view_data['goods']['goods_storage_alarm'] ?>" name="goods_storage_alarm" id="form-field-1" placeholder="库存报警值" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品点击数量 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" min="0" required="required" name="goods_click" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_click'] ?>" placeholder="商品点击数量" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 销售数量 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" min="0" required="required" name="goods_salenum" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_salenum'] ?>" placeholder="销售数量" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 收藏数量 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" value="<?php echo $a_view_data['goods']['goods_collect'] ?>" required="required" min="0" name="goods_collect" id="form-field-1" placeholder="收藏数量" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品库存 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" min="0" value="<?php echo $a_view_data['goods']['goods_storage'] ?>" required="required" name="goods_storage" id="form-field-1" placeholder="商品库存" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 每个商品能使用的积分 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" value="<?php echo $a_view_data['goods']['deductible_point'] ?>" required="required" min="0" name="deductible_point" id="form-field-1" placeholder="每个商品能使用的积分" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 指定产品的赠送积分数 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" min="0" required="required" name="goods_feng" id="form-field-1" value="<?php echo $a_view_data['goods']['goods_feng'] ?>" placeholder="指定产品的赠送积分数" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品主图 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="file"  name="goods_image" id="form-field-1" placeholder="商品主图" class="col-xs-10 col-sm-5" />
											<img src="<?php echo get_config_item('img_path') . $a_view_data['goods']['store_id'] . '/' . $a_view_data['goods']['goods_image'] ?>" alt="">
										</div>
										<input type="hidden" name="goods_image" value="<?php echo $a_view_data['goods']['goods_image'] ?>">
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   商品付款方式   </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="payment" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择商品付款方式--</option>
												<option <?php select($a_view_data['goods']['payment'],'online') ?> value="online">余额支付</option>
												<option <?php select($a_view_data['goods']['payment'],'offline') ?> value="offline">货到付款</option>
												<option <?php select($a_view_data['goods']['payment'],'alipay') ?> value="alipay">支付宝</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 类型   </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="type_id" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择类型--</option>
												<?php foreach ($a_view_data['list']['type'] as $key => $value): ?>
													<option <?php select($a_view_data['goods']['type_id'],$value['type_id']) ?> value="<?php echo $value['type_id'] ?>"><?php echo $value['type_name'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>

		

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 评价数 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" name="evaluation_count" value="<?php echo $a_view_data['goods']['evaluation_count'] ?>" id="form-field-1" placeholder="评价数" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 好评星级 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" name="evaluation_good_star" value="<?php echo $a_view_data['goods']['evaluation_good_star'] ?>" id="form-field-1" max="5" min="0" placeholder="好评星级" class="col-xs-10 col-sm-5" />
										</div>
									</div>



									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  商品状态  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="goods_state" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择商品状态--</option>
												<option <?php select($a_view_data['goods']['goods_state'],0) ?> value="0">下架</option>
												<option <?php select($a_view_data['goods']['goods_state'],1) ?>  value="1">正常</option>
												<option <?php select($a_view_data['goods']['goods_state'],10) ?> value="10">违规（禁售）</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  商品审核  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="goods_verify" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择商品审核--</option>
												<option <?php select($a_view_data['goods']['goods_verify'],0) ?> value="0">通过</option>
												<option <?php select($a_view_data['goods']['goods_verify'],1) ?> value="1">未通过</option>
												<option <?php select($a_view_data['goods']['goods_verify'],10) ?> value="10">审核中</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品锁定 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="goods_lock" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择商品锁定--</option>
												<option <?php select($a_view_data['goods']['goods_lock'],0) ?> value="0">未锁</option>
												<option <?php select($a_view_data['goods']['goods_lock'],1) ?> value="1">已锁</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  商品推荐  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="goods_commend" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择商品推荐方式--</option>
												<option <?php select($a_view_data['goods']['goods_commend'],0) ?> value="0">推荐</option>
												<option <?php select($a_view_data['goods']['goods_commend'],1) ?> value="1">不推荐</option>
											</select>
										</div>
									</div>

									

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">  是否为虚拟商品  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="is_virtual" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否为虚拟商品--</option>
												<option <?php select($a_view_data['goods']['is_virtual'],0) ?>  value="0">否</option>
												<option <?php select($a_view_data['goods']['is_virtual'],1) ?> value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 虚拟商品有效期 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" name="virtual_indate" value="<?php echo $a_view_data['goods']['virtual_indate'] ?>" id="form-field-1" placeholder="虚拟商品有效期" class="col-xs-10 col-sm-5" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 虚拟商品购买上限 </label>
										<div class="col-sm-9">
											<input readonly='readonly' type="number" required="required" min="0" name="virtual_limit" value="<?php echo $a_view_data['goods']['virtual_limit'] ?>" id="form-field-1" placeholder="虚拟商品购买上限" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否允许过期退款   </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="virtual_invalid_refund" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否允许过期退款--</option>
												<option <?php select($a_view_data['goods']['virtual_invalid_refund'],0) ?> value="0">否</option>
												<option <?php select($a_view_data['goods']['virtual_invalid_refund'],1) ?>  value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否为F码商品  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="is_fcode" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否为F码商品--</option>
												<option <?php select($a_view_data['goods']['is_fcode'],0) ?> selected="selected" value="0">否</option>
												<option <?php select($a_view_data['goods']['is_fcode'],1) ?> value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否是预约商品  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="is_appoint" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否是预约商品--</option>
												<option <?php select($a_view_data['goods']['is_appoint'],0) ?> value="0">否</option>
												<option <?php select($a_view_data['goods']['is_appoint'],1) ?> value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否是预售商品  </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="is_presell" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否是预售商品--</option>
												<option <?php select($a_view_data['goods']['is_presell'],0) ?> value="0">否</option>
												<option <?php select($a_view_data['goods']['is_presell'],1) ?> value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否拥有赠品 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="have_gift" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否拥有赠品--</option>
												<option <?php select($a_view_data['goods']['have_gift'],0) ?> value="0">否</option>
												<option <?php select($a_view_data['goods']['have_gift'],1) ?>  value="1">是</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">   是否为平台自营 </label>
										<div class="col-sm-9">
											<select disabled="disabled" class="width-40 chosen-select" name="is_own_shop" id="form-field-select-3" data-placeholder="Choose a Country...">
												<option value="">--请选择是否为平台自营--</option>
												<option <?php select($a_view_data['goods']['is_own_shop'],0) ?> value="0">否</option>
												<option <?php select($a_view_data['goods']['is_own_shop'],1) ?> value="1">是</option>
											</select>
										</div>
									</div>
									
									<!-- 商品描述 -->

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品描述 </label>
										<div class="col-sm-9">
											<textarea disabled="disabled" style="width:370px;height: 100px;" name="description" required="required"><?php echo $a_view_data['goods']['description'] ?></textarea>
										</div>
									</div>
									
									<!-- 商品内容 -->

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品内容 </label>
										<div class="col-sm-9" style="height:800px">
											<textarea disabled="disabled" id="editor" name="goods_body"><?php echo $a_view_data['goods']['goods_body'] ?></textarea>
										</div>
									</div>
						           
									<div class="space-4"></div>

						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->


		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='./js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='./js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='./js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="./js/bootstrap.min.js"></script>
		<!-- <script src="./js/typeahead-bs2.min.js"></script>-->
		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="./js/excanvas.min.js"></script>
		<![endif]-->

		<script src="./js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="./js/jquery.ui.touch-punch.min.js"></script>
		<script src="./js/chosen.jquery.min.js"></script>
		<script src="./js/fuelux/fuelux.spinner.min.js"></script>
		<script src="./js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="./js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="./js/date-time/moment.min.js"></script>
		<script src="./js/date-time/daterangepicker.min.js"></script>
		<script src="./js/bootstrap-colorpicker.min.js"></script>
		<script src="./js/jquery.knob.min.js"></script>
		<script src="./js/jquery.autosize.min.js"></script>
		<script src="./js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="./js/jquery.maskedinput.min.js"></script>
		<script src="./js/bootstrap-tag.min.js"></script>

		<!-- ace scripts -->

		<script src="./js/ace-elements.min.js"></script>
		<script src="./js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				$(".chosen-select").chosen(); 
				$('#chosen-multiple-style').on('click', function(e){
					var target = $(e.target).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					 else $('#form-field-select-4').removeClass('tag-input-style');
				});
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
				
				
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1]+"";
			
						if(! ui.handle.firstChild ) {
							$(ui.handle).append("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('a').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				
				$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
			
				//dynamically change allowed formats by changing before_change callback function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var before_change
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "icon-picture";
						before_change = function(files, dropped) {
							var allowed_files = [];
							for(var i = 0 ; i < files.length; i++) {
								var file = files[i];
								if(typeof file === "string") {
									//IE8 and browsers that don't support File Object
									if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
								}
								else {
									var type = $.trim(file.type);
									if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
											|| ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )//for android's default browser which gives an empty string for file.type
										) continue;//not an image so don't keep this file
								}
								
								allowed_files.push(file);
							}
							if(allowed_files.length == 0) return false;
			
							return allowed_files;
						}
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "icon-cloud-upload";
						before_change = function(files, dropped) {
							return files;
						}
					}
					var file_input = $('#id-input-file-3');
					file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
					file_input.ace_file_input('reset_input');
				});
			
			
			
			
				
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'icon-caret-up', icon_down:'icon-caret-down'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			
			
				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
				
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#colorpicker1').colorpicker();
				$('#simple-colorpicker-1').ace_colorpicker();
			
				
				$(".knob").knob();
				
				
				//we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
				var tag_input = $('#form-field-tags');
				if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) 
				{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
					  }
					);
				}
				else {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				
			
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
			});
		</script>
	<!-- <div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div> -->
</body>
</html>

<!-- 引入我需要的JS样式 -->
<script type="text/javascript" charset="utf-8" src="./js/plus.js"></script>

<!--导入在线编辑器 -->
<script type="text/javascript" charset="utf-8" src="./ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="./ue/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="./ue/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
	// alert(document.domain);
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');


    function isFocus(e){
        alert(UE.getEditor('editor').isFocus());
        UE.dom.domUtils.preventDefault(e)
    }
    function setblur(e){
        UE.getEditor('editor').blur();
        UE.dom.domUtils.preventDefault(e)
    }
    function insertHtml() {
        var value = prompt('插入html代码', '');
        UE.getEditor('editor').execCommand('insertHtml', value)
    }
    function createEditor() {
        enableBtn();
        UE.getEditor('editor');
    }
    function getAllHtml() {
        alert(UE.getEditor('editor').getAllHtml())
    }
    function getContent() {
        var arr = [];
        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getContent());
        alert(arr.join("\n"));
    }
    function getPlainTxt() {
        var arr = [];
        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getPlainTxt());
        alert(arr.join('\n'))
    }
    function setDisabled() {
        UE.getEditor('editor').setDisabled('fullscreen');
        disableBtn("enable");
    }

    function setEnabled() {
        UE.getEditor('editor').setEnabled();
        enableBtn();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UE.getEditor('editor').selection.getRange();
        range.select();
        var txt = UE.getEditor('editor').selection.getText();
        alert(txt)
    }

    function getContentTxt() {
        var arr = [];
        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
        arr.push("编辑器的纯文本内容为：");
        arr.push(UE.getEditor('editor').getContentTxt());
        alert(arr.join("\n"));
    }
    function hasContent() {
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UE.getEditor('editor').hasContents());
        alert(arr.join("\n"));
    }
    function setFocus() {
        UE.getEditor('editor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UE.getEditor('editor').destroy();
    }
    function disableBtn(str) {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            if (btn.id == str) {
                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
            } else {
                btn.setAttribute("disabled", "true");
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++];) {
            UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
        }
    }

    function getLocalData () {
        alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
    }

</script>

