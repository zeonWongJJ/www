<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<?php $this->display('inc_head_include', $a_view_data);?>
	</head>

	<body class="no-skin">
		<?php $this->display('inc_header', $a_view_data); ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			
			<div id="sidebar" class="sidebar responsive ace-save-state">
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
						<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>

									欢迎进入
									<strong class="green">
										项目管理系统
										<small>(v0.01)</small>
									</strong>,
									如果你不需要看下面的操作介绍，那就进入 <a href="<?php echo $this->router->url('project_list');?>" class="orange">[项目]</a> 开始体验吧！
								</div>
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="widget-body">
										<div class="widget-main padding-8">
											<div id="profile-feed-1" class="profile-feed">
											<?php
											foreach ($a_view_data['action'] as $a_action) {
												$a_cont = json_decode($a_action['content'], true);
												switch ($a_action['type']) {
													case 10:
														$s_color = '#228B22';
														$s_desc = '接手';
														break;
													case 20:
														$s_color = '#EE9A00';
														$s_desc = '提议';
														break;
													case 30:
														$s_color = '#008B00';
														$s_desc = '过程';
														break;
													case 40:
														$s_color = '#1E90FF';
														$s_desc = '完成';
														break;
												}
											?>
												
												<div class="timeline-container">
												
												<div class="timeline-label">
													<span class="label arrowed-in-right label-lg" style="color:<?php echo $s_color;?>;">
														<b><?php echo $s_desc;?></b>
													</span>
												</div>
												
												<div class="timeline-items">
													<div class="timeline-item clearfix">
														<div class="timeline-info">
															<img alt="Susan't Avatar" src="static/pc_default/image/avatars/avatar5.png" />
															<span class="label label-info label-sm"><?php echo $this->user_model->get_name($a_action['id_user']);?></span>
														</div>

														<div class="widget-box transparent" style="border-left: 3px solid <?php echo $s_color;?>;">
															<div class="widget-header widget-header-small">
																<h5 class="widget-title smaller pull-left">
																	<a href="<?php echo $this->router->url('task_home', [$a_action['id_task']]);?>" class="blue"> <?php echo $this->task_model->get_name($a_action['id_task']);?></a>
																	<span class="grey"> [<?php echo $this->project_model->get_name($a_action['id_project']);?>]  / [<?php echo $this->project_model->get_name($a_action['id_project_parent']);?>] </span>
																</h5>
																
																<span class="widget-toolbar no-border">
																	<i class="ace-icon fa fa-clock-o bigger-110"></i>
																	<?php echo date('Y-m-d H:i:s', $a_action['time_create']);?>
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
																	<?php echo $this->content_model->pre($a_cont['content']);?>
																	<div class="space-6"></div>

																	<!--div class="widget-toolbox clearfix">
																		<div class="pull-right action-buttons">
																			<a href="javascript:void(0)" onclick="task_detail_show(<?php echo $a_task['id_task'];?>)">
																				<i id="icon_<?php echo $a_task['id_task'];?>" class="ace-icon fa fa-chevron-down green bigger-130"></i>
																			</a>

																			<a href="#">
																				<i class="ace-icon fa fa-pencil blue bigger-125"></i>
																			</a>
																		</div>
																	</div-->
																</div>
															</div>
														</div>
													</div>
												</div><!-- /.timeline-items -->
											</div><!-- /.timeline-container -->
											<?php
											}
											?>
											</div>
										</div>
									</div>

									
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php $this->display('inc_footer', $a_view_data); ?>

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
				
				//$('#nestable').nestable('collapseAll');
				
				//$('#nestable > ol > li').nestable('expandAll');
			});
		</script>
	</body>
</html>
