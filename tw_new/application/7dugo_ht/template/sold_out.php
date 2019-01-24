<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>下架商品列表</title>
		<!-- basic styles -->

		<link href="./style/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./style/font-awesome.min.css" />

		

		<link rel="stylesheet" href="./style/ace.min.css" />
		<link rel="stylesheet" href="./style/ace-rtl.min.css" />

		<script src="./js/ace-extra.min.js"></script>
		<script src="script/jquery-1.8.3.js"></script>
		<script src="js/layer.js"></script>
	</head>

	<style>
	/*消息弹框*/
	.message_box{
	    left: 50%;
	    top: 50%;
	    margin-left: -160px;
	    margin-top: 60px;
	    width: 320px;
	    height:120px;
	    padding: 20px;
	    position: relative;
	    box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.25);
	    background: #ffffff;
	}
	.message_box h2,
	.message_box p{
	    font-size: 16px;
	    color: #333333;
	}
	.message_box p{
	    margin-top: 10px;
	}
	.message_box .btn{
	    padding: 0;
	}
	.message_box div:first-child{
	}
	.message_box .btn button{
	    width:60px;
	    height:30px;
	    border: 1px solid #cccccc;
	    border-radius: 5px;
	    margin: 0 30px;
	}
	.message_box .btn .active{
	    background: #3f8654;
	    border-color: #3f8654;
	    color: #ffffff;
	}
	</style>

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
								<a href="/">首页</a>
							</li>
							<li class="active">商品列表</li>
						</ul><!-- .breadcrumb -->

					</div>
				<!-- <form action="<?php echo $this->router->url('del_goods'); ?>" method="post"> -->
					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue"><a href="goods.html" >商品列表</a><a href="sold_out.html" style="margin-left: 30px;">下架商品列表</a></h3>
										
										<div class="table-responsive">
											<table id="sample-table-2" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace au_check" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>编号</th>
														<th style="width: 300px">商品名称</th>
														<th>店铺名称</th>
														<th>商品价格</th>
														<th>促销类型</th>
														<th>商品库存</th>
														<th>商品是否推荐</th>
														<th class="hidden-480">商品审核状态</th>

														<th>
															<!-- <i class="icon-time bigger-110 hidden-480"></i> -->
															商品点击量
														</th>
														<th class="hidden-480">商品状态</th>

														<th>
															<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                                                <a class="blue" href="<?php echo $this->router->url('add_goods'); ?>">
                                                                    <i class="icon-plus-sign bigger-130"></i>添加商品
                                                                </a>
                                                            </div>
														</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($a_view_data as $key => $value): ?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" name="del_goods[]" value="<?php echo $value['goods_id'] ?>" class="ace au_check" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<?php echo $key + 1; ?>
														</td>
														<td>
															<a href="<?php echo $this->router->url('goods_list',['goods_id' => $value['goods_id']]); ?>">
															<?php echo $value['goods_name']; ?>
															</a>
														</td>
														<td>
															<?php echo $value['store_name']; ?>
														</td>
														<td>
															<?php echo $value['goods_price']; ?>
														</td>
														<td>
															<?php echo $value['goods_promotion_type']; ?>
														</td>
														<td>
															<?php echo $value['goods_storage']; ?>
														</td>
														<td>
															<?php echo $value['goods_commend']; ?>
														</td>
														<td class="hidden-480">
															<?php echo $value['goods_verify']; ?>
														</td>
														<td>
															<?php echo $value['goods_click']; ?>
														</td>

														<td class="hidden-480">
															<span class="label label-sm label-warning"><?php echo $value['goods_state']; ?></span>
														</td>

														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
																<!-- <a class="blue" href="#">
																	<i class="icon-zoom-in bigger-130"></i>
																</a> -->

																<a class="green" href="<?php echo $this->router->url('update_goods',['goods_id' => $value['goods_id']]); ?>">
																	<i class="icon-pencil bigger-130"></i>
																</a>

																<!-- <a class="red"  href="#"> -->
																<a  data="<?php echo $value['goods_id'] ?>" class="red del_goods"  href="#">
																	<i class="icon-trash bigger-130"></i>
																</a>
															</div>

															<div class="visible-xs visible-sm hidden-md hidden-lg">
																<div class="inline position-relative">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
																		<i class="icon-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
																		<li>
																			<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																				<span class="blue">
																					<i class="icon-zoom-in bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="icon-edit bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																				<span class="red">
																					<i class="icon-trash bigger-120"></i>
																				</span>
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</td>
													</tr>
												<?php endforeach ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->
						<button type="button" class="del_goods_form">删除选中商品</button>
						<button type="button" class="sold_off_form">下架选中商品</button>
						<button type="button" class="new_stock_form">上架选中商品</button>
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
				<!-- </form> -->
				<!-- <div id="box" class="dn">
					<div class="message_box dn">
			            <div>
			                <h2>重要提示</h2>
			                <p>*确认要删除商品吗？</p>
			            </div>
			            <div class="btn">
			                <button class="active affirm">确认</button>
			                <button class="abolish">取消</button>
			            </div>
	        		</div>
	        	</div> -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->



		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='./js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->


		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='./js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="./js/bootstrap.min.js"></script>
		<!-- <script src="./js/typeahead-bs2.min.js"></script> -->

		<!-- page specific plugin scripts -->

		<script src="./js/jquery.dataTables.min.js"></script>
		<script src="./js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->

		<!-- <script src="./js/ace-elements.min.js"></script> -->
		<script src="./js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,null, null,null, null,null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
	
</body>
</html>
<script src="./js/plus.js"></script>