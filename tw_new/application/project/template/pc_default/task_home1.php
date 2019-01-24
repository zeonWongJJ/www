<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<?php $this->display('inc_head_include', $a_view_data);?>
	</head>

	<body class="no-skin">
		<?php $this->display('inc_header', $a_view_data);?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<?php $this->display('inc_sidebar', $a_view_data);?>

				<?php $this->display('inc_menu_left', $a_view_data);?>

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<?php $this->display('inc_breadcrumb', $a_view_data); ?>

					<div class="page-content">
						<div class="page-header">
							<h1>
								任务列表
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo $a_view_data['title'];?>
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<div>
									<ul class="steps">
										<li data-step="1" class="active">
											<span class="step">1</span>
											<span class="title">Validation states</span>
										</li>

										<li data-step="2">
											<span class="step">2</span>
											<span class="title">Alerts</span>
										</li>

										<li data-step="3">
											<span class="step">3</span>
											<span class="title">Payment Info</span>
										</li>

										<li data-step="4">
											<span class="step">4</span>
											<span class="title">Other Info</span>
										</li>
									</ul>
								</div>
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<div class="" id="nestable">
											<ol class="dd-list">
												<li class="dd-item" data-id="1">
													<div class="dd-handle">
														<i class="normal-icon ace-icon fa fa-user red bigger-130"></i>
														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
														Item 1
														<i class="pull-right bigger-130 ace-icon fa fa-exclamation-triangle orange2"></i>
													</div>
												</li>

												<li class="dd-item" data-id="2">
													<div class="dd-handle btn-yellow">
														<i class="normal-icon ace-icon fa fa-user red bigger-130"></i>
														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
														Item 2 <br />das<br />fdsss
													</div>
													

													<ol class="dd-list">
														<li class="dd-item" data-id="3">
															<div class="dd-handle">
																Item 3
																<a data-rel="tooltip" data-placement="left" title="Change Date" href="#" class="pull-right tooltip-info btn btn-primary btn-mini btn-white btn-bold">
																	<i class="bigger-120 ace-icon fa fa-calendar"></i>
																</a>
															</div>
														</li>

														<li class="dd-item" data-id="4">
															<div class="dd-handle">
																<span class="orange">Item 4</span>
																<span class="lighter grey">
																	&nbsp; with some description
																</span>
															</div>
														</li>

														<li class="dd-item" data-id="5">
															<div class="dd-handle">
																Item 5
																<div class="pull-right action-buttons">
																	<a class="blue" href="#">
																		<i class="ace-icon fa fa-pencil bigger-130"></i>
																	</a>

																	<a class="red" href="#">
																		<i class="ace-icon fa fa-trash-o bigger-130"></i>
																	</a>
																</div>
															</div>

															<ol class="dd-list">
																<li class="dd-item item-orange" data-id="6">
																	<div class="dd-handle"> Item 6 </div>
																</li>

																<li class="dd-item item-red" data-id="7">
																	<div class="dd-handle">Item 7</div>
																</li>

																<li class="dd-item item-blue2" data-id="8">
																	<div class="dd-handle">Item 8</div>
																</li>
															</ol>
														</li>

														<li class="dd-item" data-id="9">
															<div class="dd-handle btn-yellow no-hover">Item 9</div>
														</li>

														<li class="dd-item" data-id="10">
															<div class="dd-handle">Item 10</div>
														</li>
													</ol>
												</li>

												<li class="dd-item" data-id="11">
													<div class="dd-handle">
														Item 11
														<span class="sticker">
															<span class="label label-success arrowed-in">
																<i class="ace-icon fa fa-check bigger-110"></i>
															</span>
														</span>
													</div>
												</li>

												<li class="dd-item" data-id="12">
													<div class="dd-handle">Item 12</div>
												</li>
											</ol>
										</div>
									</div>

								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php $this->display('inc_footer', $a_view_data);?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="static/pc_default/script/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="static/pc_default/script/jquery-1.11.3.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='static/pc_default/script/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="static/pc_default/script/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="static/pc_default/script/jquery.nestable.min.js"></script>

		<!-- ace scripts -->
		<script src="static/pc_default/script/ace-elements.min.js"></script>
		<script src="static/pc_default/script/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
			
				$('#nestable').nestable();
			
				$('.dd-handle a').on('mousedown', function(e){
					e.stopPropagation();
				});
				
				$('[data-rel="tooltip"]').tooltip();
			
			});
		</script>
	</body>
</html>
