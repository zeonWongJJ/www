<?php
$this->load->model('user_model');
$this->load->model('action_model');
$this->load->model('content_model');
if ($this->router->get_index() == 'task_home') {
	$b_is_home = true;
} else {
	$b_is_home = false;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<?php $this->display('inc_head_include', $a_view_data);?>
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
						<div class="row">
							<div class="col-xs-12">
								
								<!-- PAGE CONTENT BEGINS -->
								
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php if ($b_is_home) {$this->display('inc_footer', $a_view_data);}?>

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
				<?php
				if ( ! $b_is_home ) {
				?>
				$('#nestable').nestable('collapseAll');
				<?php
				}
				?>
				//$('#nestable > ol > li').nestable('expandAll');
			});
		</script>
	</body>
</html>
