<?php
$this->load->model('content_model');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<?php $this->display('inc_head_include', $a_view_data);?>
		<!-- 加载mac-Bootstrap样式和js-->
		<style type="text/css">
		.navbar .progress{
			margin-bottom: 0px;
			padding: 0px !important;
			margin: 0px !important;
		}
		.progress{
			height: 12px;
			border-radius: 6px;
			margin: 9px 0px !important;
			line-height: 13px;
		    background:#FF0000;
		}
		.progress .bar{
			font-size: 10px;
		}
		</style>
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
						<?php $this->display('inc_setting', $a_view_data); ?>
						
						<div class="page-header">
							<h1>
								<?php echo $a_view_data['title'];?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									任务列表
								</small>
								<a href="<?php echo $this->router->url('task_add', [$this->router->get(1)]);?>">
								<button class="btn btn-info" type="button">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									添加任务
								</button>
								</a>
								
								<a href="<?php echo $this->router->url('question_add', [$this->router->get(1)]);?>">
								<button class="btn btn-danger" type="button">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									提交问题
								</button>
								</a>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">

								<div id="timeline-1">
									<div class="row">
										<div class="col-xs-12">
										<?php
										$a_letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
										$a_color = ['label-warning', 'label-info', 'label-danger', 'label-inverse', 'label-success', 'label', 
													'label-warning label-white', 'label-info label-white', 'label-danger label-white', 
													'label-inverse label-white', 'label-success label-white', 'label label-white'];
										$i = 0;
										$i_j = 1;
										foreach ($a_view_data['task'] as $a_group) {
											foreach($a_group as $a_task) {
												$a_desc = json_decode($a_task['desc'], true);
										?>
											<div class="timeline-container">
												<div class="timeline-label">
													<span class="label <?php echo $a_color[$i];?> arrowed-in-right label-lg">
														<b><?php echo $a_letter[$i];?></b>
													</span>
												</div>

												<div class="timeline-items">
													<div class="timeline-item clearfix">
														<div class="timeline-info">
															<img alt="Susan't Avatar" src="static/pc_default/image/avatars/avatar1.png" />
															<span class="label label-info label-sm"><?php echo $this->user_model->get_name($a_task['id_user']);?></span>
														</div>

														<div class="widget-box transparent">
															<div class="widget-header widget-header-small">
																<h5 class="widget-title smaller pull-left">
																	<a href="#" class="blue">任务<?php echo $i_j;?>：</a>
																	<span class="grey"><?php echo $a_task['title'];?></span>
																</h5>
																<div class="col-sm-1"></div>
																<div class="col-sm-3 form-inline progress progress-animated progress-striped active" style="padding-left:0px;padding-right:0px;">
																	<div class="progress-bar progress-bar-warning" style="border-radius: 6px;line-height: 13px;" data-percentage="<?php echo $a_task['ratio_finsh'] ? $a_task['ratio_finsh'] : 0;?>">
																		<span class="sr-only">100% Complete</span>
																	</div>
																</div>
																<span class="widget-toolbar no-border">
																	<i class="ace-icon fa fa-clock-o bigger-110"></i>
																	<?php echo date('Y-m-d H:i:s', $a_task['time_create']);?>
																</span>

																<span class="widget-toolbar">
																	<a href="#" data-action="reload">
																		<i class="ace-icon fa fa-refresh"></i>
																	</a>

																	<a href="#" data-action="collapse">
																		<i class="ace-icon fa fa-chevron-up"></i>
																	</a>
																</span>
															</div>

															<div class="widget-body">
																<div class="widget-main">
																	<?php echo $this->content_model->pre($a_desc['desc']);?>
																	<div class="space-6"></div>

																	<div class="widget-toolbox clearfix">
																		<div class="pull-left">
																			<i class="ace-icon fa fa-hand-o-right grey bigger-125"></i>
																			<a href="<?php echo $this->router->url('task_home', [$a_task['id_task']]);?>" class="bigger-110" target="_blank">查看详细 &hellip;</a>
																		</div>

																		<div class="pull-right action-buttons">
																			<a href="javascript:void(0)" onclick="task_detail_show(<?php echo $a_task['id_task'];?>)">
																				<i id="icon_<?php echo $a_task['id_task'];?>" class="ace-icon fa fa-chevron-down green bigger-130"></i>
																			</a>

																			<a href="#">
																				<i class="ace-icon fa fa-pencil blue bigger-125"></i>
																			</a>
																		</div>
																	</div>
																</div>
															</div>
															<iframe class="hide" src="" id="iframe_<?php echo $a_task['id_task'];?>" style="width:100%; height:500px; border:0px;">你的浏览器不支持框架</iframe>
															
														</div>
													</div>
												</div><!-- /.timeline-items -->
											</div><!-- /.timeline-container -->
										<?php
												$i_j++;
											}
											$i++;
										}
										?>

										</div>
									</div>
								</div>

								

								<!-- PAGE CONTENT ENDS -->
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

		<!-- ace scripts -->
		<script src="static/pc_default/script/ace-elements.min.js"></script>
		<script src="static/pc_default/script/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		
		<!-- 加载mac-Bootstrap js-->
		<script src="static/pc_default/script2/custom.js"></script> <!-- Custom codes -->
		<script>
		function task_detail_show(id) {
			if ($('#iframe_' + id).hasClass("hide")) {
				$('#icon_' + id).removeClass('fa-chevron-down');
				$('#icon_' + id).addClass('fa-chevron-up');
				$('#iframe_' + id).attr('src', 'task_detail-' + id);
				$('#iframe_' + id).removeClass('hide');
			} else {
				$('#iframe_' + id).addClass('hide');
				$('#icon_' + id).removeClass('fa-chevron-up');
				$('#icon_' + id).addClass('fa-chevron-down');
			}
		}
		
		</script>
	</body>
</html>
