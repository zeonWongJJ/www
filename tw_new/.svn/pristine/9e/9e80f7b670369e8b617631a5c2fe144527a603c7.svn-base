<?php
$a_color = [
	0 => 'orange',
	1 => 'dark',
	2 => 'blue',
	3 => 'green',
	4 => 'red',
	5 => 'blue2',
	6 => 'green2',
	7 => 'red2',
	8 => 'green3',
	9 => 'blue3',
	10 => 'red3',
	11 => 'purple',
	12 => 'pink',
	13 => 'grey'
];
if ($a_view_data['id_project_parent']) {
	$s_url = 'task_group_list';
	$s_btn_style = 'btn-primary';
	$s_progress_style = 'infobox-purple';
	$s_link_name = '进入任务组列表';
} else {
	$s_url = 'project_list';
	$s_btn_style = 'btn-warning';
	$s_progress_style = 'infobox-green';
	$s_link_name = '进入子项目';
}
?>
<!DOCTYPE html>
<html lang="en">
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
						<?php $this->display('inc_setting', $a_view_data); ?>

						<div class="page-header">
							<h1>
								项目中心
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									项目列表
								</small>
								<a href="<?php echo $this->router->url('project_add');?>">
								<button class="btn btn-info" type="button">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									添加项目
								</button>
								</a>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
								<?php
								if (isset($a_view_data['project']) && is_array($a_view_data['project']))
								foreach ($a_view_data['project'] as $a_project) {
									$i_total_task += $a_project['task_total'];
									$i_total_task_start += $a_project['task_start'];
									$i_total_task_finsh += $a_project['task_finsh'];
									$i_total_task_time_total += $a_project['task_time_total'];
									$i_total_task_time_start += $a_project['task_time_start'];
									$i_total_task_finsh_not += $a_project['task_finsh_not'];
									$i_total_time_finsh += $a_project['task_time_finsh'];
									$i_total_time_finsh_not += $a_project['task_time_finsh_not'];
								?>
									<div class="col-xs-6 col-sm-3 pricing-box">
										<div class="widget-box widget-color-<?php echo ($a_view_data['id_project_parent']) ? 'blue2' : 'orange' ?>">
											<div class="widget-header">
												<h5 class="widget-title bigger lighter"><?php echo $a_project['name'];?></h5>
												<a class="text-right col-md-offset-1" href="#">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>
											</div>

											<div class="widget-body">
												<div class="widget-main">
													<ul class="list-unstyled spaced2">
														<li>
															<i class="ace-icon fa fa-signal purple"></i>
															总任务数：<?php echo $a_project['task_total'];?>
														</li>
														
														<li>
															<i class="ace-icon fa fa-fighter-jet green"></i>
															进行中任务数：<?php echo $a_project['task_start'];?>
														</li>

														<li>
															<i class="ace-icon fa fa-flask red"></i>
															待完成任务数：<?php echo $a_project['task_finsh_not'];?>
														</li>

														<li>
															<i class="ace-icon fa fa-check blue"></i>
															已完成任务数：<?php echo $a_project['task_finsh'];?>
														</li>
														
														<li>
															<i class="ace-icon fa fa-cutlery green"></i>
															进行中的任务工时：<?php echo $a_project['task_time_start'];?>
														</li>

														<li>
															<i class="ace-icon fa fa-flask red"></i>
															待完成的任务工时：<?php echo $a_project['task_time_finsh_not'];?>
														</li>

														<li>
															<i class="ace-icon fa fa-check-square-o blue"></i>
															已完成的任务工时：<?php echo $a_project['task_time_finsh'];?>
														</li>
													</ul>

													<hr />
													<div class="infobox <?php echo $s_progress_style;?> infobox-dark center">
														<div class="infobox-progress">
															<div class="easy-pie-chart percentage" data-percent="<?php echo $a_project['task_ratio_finsh'];?>" data-size="<?php echo $a_project['task_ratio_finsh_not'];?>">
																<span class="percent"><?php echo $a_project['task_ratio_finsh'];?></span>%
															</div>
														</div>

														<div class="infobox-data">
															<div class="infobox-content">任务</div>
															<div class="infobox-content">完成比例</div>
														</div>
													</div>
												</div>

												<div>
													<a href="<?php echo $this->router->url($s_url, [$a_project['id_project']]);?>" class="btn btn-block <?php echo $s_btn_style;?>">
														<i class="ace-icon fa fa-hand-o-right bigger-110"></i>
														<span><?php echo $s_link_name;?></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<?php
									}
									?>
									
								</div>

								<div class="space-24"></div>
								<h3 class="header smaller red">概览</h3>

								<div class="row">
									<div class="col-xs-4 col-sm-3 pricing-span-header">
										<div class="widget-box transparent">
											<div class="widget-header">
												<h5 class="widget-title bigger lighter">统计</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<ul class="list-unstyled list-striped pricing-table-header">
														<li>总项目数：<?php echo count($a_view_data['project']);?></li>
														<li>总任务数：<?php echo $i_total_task;?></li>
														<li>进行中任务数：<?php echo $i_total_task_start;?></li>
														<li>待完成任务数：<?php echo $i_total_task_finsh_not;?></li>
														<li>总完成任务数：<?php echo $i_total_task_finsh;?></li>
														<li>总任务工时：<?php echo $i_total_task_time_total;?></li>
														<li>进行中任务工时：<?php echo $i_total_task_time_start;?></li>
														<li>待完成任务工时：<?php echo $i_total_time_finsh_not;?></li>
														<li>已完成任务工时：<?php echo $i_total_time_finsh;?></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xs-8">
										<div id="piechart-placeholder"></div>
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

		<!--[if lte IE 8]>
		  <script src="static/pc_default/script/excanvas.min.js"></script>
		<![endif]-->
		<script src="static/pc_default/script/jquery.easypiechart.min.js"></script>
		
		<!-- ace scripts -->
		<script src="static/pc_default/script/ace-elements.min.js"></script>
		<script src="static/pc_default/script/ace.min.js"></script>
		<script src="static/pc_default/script/jquery-ui.custom.min.js"></script>
		<script src="static/pc_default/script/jquery.ui.touch-punch.min.js"></script>
		<script src="static/pc_default/script/jquery.sparkline.index.min.js"></script>
		<script src="static/pc_default/script/jquery.flot.min.js"></script>
		<script src="static/pc_default/script/jquery.flot.pie.min.js"></script>
		<script src="static/pc_default/script/jquery.flot.resize.min.js"></script>
		<!-- inline scripts related to this page -->
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'70%' , 'min-height':'300px'});
			  var data = [
				{ label: "进行中任务",  data: <?php echo $i_total_task_time_total ? round($i_total_task_time_start / $i_total_task_time_total, 2) : 0;?>, color: "#68BC31"},
				{ label: "未完成任务",  data: <?php echo $i_total_task_time_total ? round($i_total_time_finsh_not / $i_total_task_time_total, 2) : 0;?>, color: "#FFA54F"},
				{ label: "已完成任务",  data: <?php echo $i_total_task_time_total ? round($i_total_time_finsh / $i_total_task_time_total, 2) : 100;?>, color: "#2091CF"},
				//{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				//{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							radius: 1,
							label: {
								show: true,
								radius: 3/4,
								formatter: function(label, series){
									return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
								},
								background: { opacity: 0 }
							}
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
	</body>
</html>