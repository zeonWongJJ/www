<?php
$this->load->model('user_model');
$this->load->model('action_model');
$this->load->model('content_model');
$this->load->model('action_model');
if ($this->router->get_index() == 'task_home') {
	$b_is_home = true;
} else {
	$b_is_home = false;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->display('inc_head_include', $a_view_data);?>
		<!--[if !IE]> -->
		<script src="static/pc_default/script/jquery-2.1.4.min.js"></script>
		<!-- <![endif]-->
		<!--[if IE]>
		<script src="static/pc_default/script/jquery-1.11.3.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<?php if ($b_is_home) {$this->display('inc_header', $a_view_data);} ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php
			if ($b_is_home) {
			?>
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
			<?php
			}
			?>

			<div class="main-content">
				<div class="main-content-inner">
					<?php if ($b_is_home) {$this->display('inc_breadcrumb', $a_view_data);} ?>

					<div class="page-content">
						<?php if ($b_is_home) {$this->display('inc_setting', $a_view_data);} ?>
						<?php
						if ($b_is_home) {
						?>
						<div class="row">
							<div class="widget-box widget-color-red2">
								<div class="widget-header widget-header-small">
									<h5 class="widget-title smaller"><?php echo $a_view_data['task']['title'];?></h5>

									<span class="widget-toolbar no-border">
										<i class="ace-icon fa fa-clock-o bigger-110"></i>
										<?php echo date('Y-m-d H:i:s', $a_view_data['task']['time_create']);?>
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
										<?php $a_desc = json_decode($a_view_data['task']['desc'], true); echo $this->content_model->pre($a_desc['desc']);?>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						?>

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<div class="dd dd-draghandle" id="nestable" style="max-width:100%">
											<ol class="dd-list">
												
												
												<?php
												foreach ($a_view_data['procedure'] as $a_procedure) {
													$a_content = json_decode($a_procedure['content'], true);
													switch ($a_procedure['state']) {
														case 0:
															$s_state_icon = 'ace-icon ';
															$s_state_color = 'red';
															break;
														case 10:
															$s_state_icon = 'ace-icon ';
															$s_state_color = 'orange';
															break;
														default:
															$s_state_icon = 'ace-icon ';
															$s_state_color = 'blue';
													}
												?>
												<li class="dd-item dd2-item" data-id="19">
													<div class="dd-handle dd2-handle">
														<i class="normal-icon ace-icon fa fa-bars <?php echo $s_state_color;?> bigger-130"></i>

														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
													</div>
													<div class="dd2-content widget-header widget-box">
														<a href="#procedure-<?php echo $a_procedure['id_procedure'];?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
															<i class="ace-icon fa fa-circle-o bigger-130"></i>
															<div class="col-sm-6 <?php echo $s_state_color;?>"><?php echo mb_substr($a_content['content'], 0, 25);?></div>
															<div class="col-sm-2">[<?php echo $this->user_model->get_name($a_procedure['id_user']);?>] => [<?php echo $this->user_model->get_name($a_procedure['executor']);?>]</div>
															<div class="col-sm-2"><?php echo date('Y-m-d H:i:s', $a_procedure['time_create']);?></div>
														</a>
														<div class="panel-collapse collapse" id="procedure-<?php echo $a_procedure['id_procedure'];?>">
															<div class="panel-body" style="color:#000; font-weight:normal;">
																<?php echo $this->content_model->pre($a_content['content']);?>
															</div>
														</div>
													</div>
													
													<ol class="dd-list">
														<?php
														$a_action = $this->action_model->get_procedure($a_procedure['id_procedure']);
														foreach($a_action as $a_act) {
															$a_cont = json_decode($a_act['content'], true);
															$s_type_class = '';
															switch ($a_act['type']) {
																case 10:
																	$s_type_color = 'green';
																	$s_type_class = 'fab fa-angellist ';// far fa-hand-peace
																	break;
																case 20:
																	$s_type_color = 'red';
																	$s_type_class = 'far fa-question-circle '; //fas fa-exclamation-circle far fa-bug  fas fa-bug fal fa-bug
																	break;
																case 40:
																	$s_type_color = 'blue';
																	$s_type_class = 'fas fa-check-circle ';//far fa-check-circle 
																	break;
																default:
																	$s_type_color = 'green';
																	$s_type_class = 'fas fa-fast-forward ';
															}
														?>
														<li class="dd-item dd2-item" data-id="16">
															<div class="dd-handle dd2-handle">
																<i class="normal-icon ace-icon <?php echo $s_type_class . $s_type_color;?> bigger-130"></i>

																<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
															</div>
															<div class="dd2-content widget-header widget-box">
															
																<a href="#act-<?php echo $a_act['id_action'];?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
																	<i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
																	<i class="ace-icon fa fa-circle-o bigger-130"></i>
																	<div class="col-sm-6 <?php echo $s_type_color;?>"><?php echo mb_substr($a_cont['content'], 0, 25);?></div>
																	<div class="col-sm-2">[<?php echo $this->user_model->get_name($a_act['id_user']);?>] => [<?php echo $this->user_model->get_name($a_procedure['executor']);?>]</div>
																	<div class="col-sm-2"><?php echo date('Y-m-d H:i:s', $a_act['time_create']);?></div>
																</a>
																<div class="panel-collapse collapse" id="act-<?php echo $a_act['id_action'];?>">
																	<div class="panel-body" style="color:#000; font-weight:normal;">
																		<?php echo $this->content_model->pre($a_cont['content']);?>
																	</div>
																</div>
															</div>
														</li>
														<?php
														}
														?>

														<li class="dd-item dd2-item alert-info" data-id="18">
															<form class="form-horizontal" role="form" method="post" action="<?php echo $this->router->url('action_add');?>">
																<div class="form-group" style="margin:10px">
																	<div class="col-xs-12 col-sm-2"> </div>
																	<h3 class="header lighter blue">
																		<i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
																		添加动作
																	</h3>
																</div>
																
																<div class="form-group has-warning">
																	<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 描述： </label>

																	<div class="col-xs-12 col-sm-5">
																		<textarea class="autosize-transition form-control"  name="content"></textarea>
																	</div>
																</div>
																
																<div class="form-group has-warning">
																	<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">动作类型：</label>

																	<div class="col-xs-12 col-sm-5">
																		<input name="type" class="ace" type="radio" value="10">
																		<span class="lbl"> 接手 </span>
																		
																		<input name="type" class="ace" type="radio" value="20">
																		<span class="lbl"> 提议 </span>
																		
																		<input name="type" class="ace" type="radio" value="30" checked="checked">
																		<span class="lbl"> 过程 </span>
																		
																		<input name="type" class="ace" type="radio" value="40">
																		<span class="lbl"> 完成 </span>
																	</div>
																</div>
																
																<div class="form-group">
																	<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 通知： </label>

																	<div class="col-xs-12 col-sm-5">
																		<?php  echo $this->user_model->get_user_select(['name' => 'notifier_action']);?>
																	</div>
																</div>
																<input type="hidden" name="project" value="<?php echo $a_view_data['task']['id_project'];?>" />
																<input type="hidden" name="project_parent" value="<?php echo $a_view_data['task']['id_project_parent'];?>" />
																<input type="hidden" name="task_group" value="<?php echo $a_view_data['task']['id_task_group'];?>" />
																<input type="hidden" name="task" value="<?php echo $a_view_data['task']['id_task'];?>" />
																<input type="hidden" name="procedure" value="<?php echo $a_procedure['id_procedure'];?>" />
																
																<div class="clearfix">
																	<div class="col-md-offset-3 col-md-9">
																		<button class="btn btn-info" type="submit" id="form_submit">
																			<i class="ace-icon fa fa-check bigger-110"></i>
																			提交动作
																		</button>
																	</div>
																</div>
															</form>
														</li>
													</ol>
												</li>
												<?php
												}
												?>
												
											</ol>
										</div>
									</div>
								</div><!-- PAGE CONTENT ENDS -->
								
								<div class="hr hr-16 hr-dotted"></div>
								<form class="form-horizontal" role="form" method="post" action="<?php echo $this->router->url('procedure_add');?>">
									
									<div class="form-group">
										<div class="col-xs-12 col-sm-2"> </div>
										<h3 class="header lighter green">
											<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>
											添加流程
										</h3>
									</div>
									
									<div class="form-group has-warning">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 描述： </label>

										<div class="col-xs-12 col-sm-5">
											<textarea class="autosize-transition form-control"  name="content"></textarea>
										</div>
									</div>
									
									<div class="form-group has-warning">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">计划用时（小时）</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" name="hour" />
												<i class="ace-icon fa fa-leaf"></i>
											</span>
										</div>
									</div>
									
									<div class="form-group">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 指派： </label>

										<div class="col-xs-12 col-sm-5">
											<?php  echo $this->user_model->get_user_select(['name' => 'executor', 'multiple' => false]);?>
										</div>
									</div>
									
									<div class="form-group">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 通知： </label>

										<div class="col-xs-12 col-sm-5">
											<?php  echo $this->user_model->get_user_select(['name' => 'notifier']);?>
										</div>
									</div>
									<input type="hidden" name="project" value="<?php echo $a_view_data['task']['id_project'];?>" />
									<input type="hidden" name="project_parent" value="<?php echo $a_view_data['task']['id_project_parent'];?>" />
									<input type="hidden" name="task_group" value="<?php echo $a_view_data['task']['id_task_group'];?>" />
									<input type="hidden" name="task" value="<?php echo $a_view_data['task']['id_task'];?>" />
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" id="form_submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												发起流程
											</button>
										</div>
									</div>
								</form>
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
			
				$('.dd').nestable();
			
				$('.dd-handle a').on('mousedown', function(e){
					e.stopPropagation();
				});
				
				$('[data-rel="tooltip"]').tooltip();
				$('#nestable').nestable('collapseAll');
				
			});
			
		</script>
	</body>
</html>