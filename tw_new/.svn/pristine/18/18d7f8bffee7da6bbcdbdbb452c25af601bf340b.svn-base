<?php
$this->load->model('task_model');
$this->load->model('user_model');
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
			margin: 5px 0px !important;
			line-height: 13px;
		   background:#eee;
		}
		.progress .bar{
			font-size: 10px;
		}
		</style>
		<!-- HTML5 Support for IE -->
		<!--[if lt IE 9]>
		<script src="static/pc_default/script2/html5shim.js"></script>
		<![endif]-->
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
									任务组列表
								</small>
								<a href="<?php echo $this->router->url('task_group_add');?>">
								<button class="btn btn-info" type="button">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									添加任务组
								</button>
								</a>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<div class="clearfix">
									<div class="pull-right tableTools-container"></div>
								</div>
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													<th class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th class="center">问题列表</th>
													<th>项目</th>
													<th>任务组名称</th>
													<th>问题数量</th>
													<th class="hidden-480">任务数量</th>

													<th>
														<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
														完成比例
													</th>
													<th>创建人</th>
													<th class="hidden-480">创建时间</th>

													<th></th>
												</tr>
											</thead>

											<tbody>
											<?php
											$this->load->model('user_model');
											foreach ($a_view_data['group'] as $a_group) {
												$a_project_name = $this->project_model->get_names($a_group['id_project']);
											?>
												<tr>
													<td class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</td>

													<td class="center ">
														<div class="action-buttons">
															<a href="#" class="green bigger-140 show-details-btn" title="Show Details">
																<i class="ace-icon fa fa-angle-double-down"></i>
																<span class="sr-only">详细</span>
															</a>
														</div>
													</td>

													<td>
														<a href="<?php echo $this->router->url('project_list', [$a_group['id_project']]);?>"><?php echo $a_project_name['project_name']; if (isset($a_project_name['project_name_parent'])) { echo " / {$a_project_name['project_name_parent']}";}?></a>
													</td>
													<td><a href="<?php echo $this->router->url('task_list', [$a_group['id_task_group']]);?>"><?php echo $a_group['name'];?></a></td>
													<td><?php echo $a_group['question_total'];?></td>
													<td class="hidden-480"><?php echo $a_group['task_total'];?></td>
													<td>
														<div class="progress progress-animated progress-striped active">
															<div class="progress-bar progress-bar-warning"  data-percentage="<?php echo (empty($a_group['task_ratio_finsh']) && empty($a_group['task_total'])) ? 100 : $a_group['task_ratio_finsh'];?>" style="line-height:13px">
																<span class="sr-only">100% Complete</span>
															</div>
														</div>
													</td>
													<td><?php echo $this->user_model->get_name($a_group['id_user']);?></td>
													<td class="hidden-480">
														<?php echo date('Y-m-d H:i:s', $a_group['time_create']);?>
													</td>

													<td>
														<div class="hidden-sm hidden-xs btn-group">
															<button class="btn btn-xs btn-success">
																<i class="ace-icon fa fa-check bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-info">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-danger">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-warning">
																<i class="ace-icon fa fa-flag bigger-120"></i>
															</button>
														</div>

														<div class="hidden-md hidden-lg">
															<div class="inline pos-rel">
																<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
																	<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
																</button>

																<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																	<li>
																		<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																			<span class="blue">
																				<i class="ace-icon fa fa-search-plus bigger-120"></i>
																			</span>
																		</a>
																	</li>

																	<li>
																		<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
																		</a>
																	</li>

																	<li>
																		<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr class="detail-row">
													<td colspan="10">
														<div class="table-detail">
															<div class="row">
																
																<div class="col-xs-12 col-sm-7">
																	<div class="space visible-xs"></div>

																	<div class="profile-user-info profile-user-info-striped">
																	<?php
																	$a_task_group = $this->task_model->get_question($a_group['id_task_group']);
																	foreach ($a_task_group as $a_task) {
																		switch ($a_task['state']) {
																			case 0:
																				$s_state_icon = 'fa-times red';
																				break;
																			case 10:
																				$s_state_icon = 'fa-exclamation-circle orange';
																				break;
																			case 30:
																				$s_state_icon = 'fa-ban light';
																				break;
																			case 50:
																				$s_state_icon = 'fa-exclamation-circle orange';
																				break;
																			default:
																				$s_state_icon = 'fa-check green';
																		}
																	?>
																		<div class="profile-info-row">
																			<div class="profile-info-name"> <i class="ace-icon fa <?php echo $s_state_icon;?>"></i> <?php echo $this->user_model->get_name($a_task['id_user']);?> </div>

																			<div class="profile-info-value">
																				<a href="<?php echo $this->router->url('task_home', [$a_task['id_task']]);?>" target="_blank"><span> <?php echo $a_task['title'];?> </span></a>
																			</div>
																		</div>
																	<?php
																	}
																	?>

																	</div>
																</div>

																<div class="col-xs-12 col-sm-3">
																	<div class="space visible-xs"></div>
																	<h4 class="header blue lighter less-margin">Send a message to Alex</h4>

																	<div class="space-6"></div>

																	<form>
																		<fieldset>
																			<textarea class="width-100" resize="none" placeholder="Type something…"></textarea>
																		</fieldset>

																		<div class="hr hr-dotted"></div>

																		<div class="clearfix">
																			<label class="pull-left">
																				<input type="checkbox" class="ace" />
																				<span class="lbl"> Email me a copy</span>
																			</label>

																			<button class="pull-right btn btn-sm btn-primary btn-white btn-round" type="button">
																				Submit
																				<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
																			</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
													</td>
												</tr>
												<?php
												}
												?>
												


											</tbody>
										</table>
										<div class="modal-footer no-margin-top">
											<ul class="pagination pull-right no-margin">
												<li><?php echo $this->pages->link_style_one($this->router->url('task_group_list', [0, ''], false, false));?></li>
											</ul>
										</div>
									</div><!-- /.span -->
								</div><!-- /.row -->

								

								<div class="row">
									<div class="col-xs-12">
										<div class="hide">
											<table id="dynamic-table" class="table table-striped table-bordered table-hover hide">
												
											</table>
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
		<script src="static/pc_default/script/jquery.dataTables.min.js"></script>
		<script src="static/pc_default/script/jquery.dataTables.bootstrap.min.js"></script>
		<script src="static/pc_default/script/dataTables.buttons.min.js"></script>
		<script src="static/pc_default/script/buttons.flash.min.js"></script>
		<script src="static/pc_default/script/buttons.html5.min.js"></script>
		<script src="static/pc_default/script/buttons.print.min.js"></script>
		<script src="static/pc_default/script/buttons.colVis.min.js"></script>
		<script src="static/pc_default/script/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="static/pc_default/script/ace-elements.min.js"></script>
		<script src="static/pc_default/script/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>
		
	<!-- 加载mac-Bootstrap js-->
	<script src="static/pc_default/script2/custom.js"></script> <!-- Custom codes -->
	</body>
</html>
