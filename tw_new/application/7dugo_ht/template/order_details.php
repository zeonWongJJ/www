<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>7dugou后台 </title>
		<!-- basic styles -->

		<link href="./style/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./style/font-awesome.min.css" />

		<link rel="stylesheet" href="./style/ace.min.css" />
		<link rel="stylesheet" href="./style/ace-rtl.min.css" />

		<script src="./js/ace-extra.min.js"></script>

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
								<a href="#">首页</a>
							</li>
							<li class="active">控制台</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<form class="form-horizontal" role="form">
	<?php foreach($a_view_data as $key=>$value){?>
	<?php if( $key!='商品信息[成交价]'){?>
		<div class="form-group">
			<label class="col-sm-5 control-label no-padding-right" for="form-input-readonly"><?php echo $key;?></label>
			<div class="col-sm-5">
				<input readonly="" type="text" class="col-xs-10 col-sm-10" id="form-input-readonly" value="<?php echo $value;?>">
				<span class="help-inline col-xs-12 col-sm-7">
			
				</span>
			</div>
		</div>
	<?php }else{?>


		<div class="form-group">
			<label class="col-sm-5 control-label no-padding-right" for="form-input-readonly"><?php echo $key;$i=0;?></label>
			<div class="col-sm-5">
				<input readonly="" type="text" class="col-xs-10 col-sm-10" id="form-input-readonly" value="<?php echo $a_view_data[$key][$i]['goods_name']. '  | '.$a_view_data[$key][$i]['goods_price'].' X '.$a_view_data[$key][$i]['goods_num'];?>">

				<span class="help-inline col-xs-12 col-sm-7">
			
				</span>
			</div>
		</div>
		<?php $count=count($a_view_data[$key]);
		for($i=1;$i<$count;$i++){
		?>
			<div class="form-group">
			<label class="col-sm-5 control-label no-padding-right" for="form-input-readonly"></label>
			<div class="col-sm-5">
				<input readonly="" type="text" class="col-xs-10 col-sm-10" id="form-input-readonly" value="<?php echo $a_view_data[$key][$i]['goods_name']. '  | '.$a_view_data[$key][$i]['goods_price'].' X '.$a_view_data[$key][$i]['goods_num'];?>">
				
				<span class="help-inline col-xs-12 col-sm-7">
			
				</span>
			</div>
		</div>
		<?php }}}?>



	

	
	

 


	</form>


	<!-- PAGE CONTENT ENDS -->
</div>


			</div><!-- /.main-container-inner -->

		
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
			      null, null,null, null, null,
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
