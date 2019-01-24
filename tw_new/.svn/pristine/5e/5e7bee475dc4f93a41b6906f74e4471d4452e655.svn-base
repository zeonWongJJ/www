<?php
$b_is_home = true;
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
							
						<?php
						}
						?>

						<div class="row">
							<div class="col-xs-12">
								
								<form class="form-horizontal" role="form" method="post" action="<?php echo $this->router->url('notice_custom');?>">
									
									<div class="form-group">
										<div class="col-xs-12 col-sm-2"> </div>
										<h3 class="header lighter green">
											<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>
											即时发送自定义通知
										</h3>
									</div>
									
									<div class="form-group has-warning">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 通知内容： </label>

										<div class="col-xs-12 col-sm-5">
											<textarea class="autosize-transition form-control" name="content"></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right"> 通知： </label>

										<div class="col-xs-12 col-sm-5">
											<?php  echo $this->user_model->get_user_select(['name' => 'notifier']);?>
										</div>
									</div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" id="form_submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												发送通知
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