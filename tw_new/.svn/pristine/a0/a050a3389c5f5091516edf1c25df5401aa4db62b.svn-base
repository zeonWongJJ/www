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
								<a href="/">首页</a>
							</li>
							<li class="active">订单列表</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">订单列表</h3>
										

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
														<th>订单ID</th>
														<th>订单编号</th>
														<th>店铺名称</th>
														<th>购买者</th>
														<th>订单生成时间</th>
														<th>订单总价</th>
														<th>支付方式</th>
														<th>订单状态</th>
														<th class="hidden-480">操作</th>


													<!-- 	<th>
															<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                                                <a class="blue" href="">
                                                                    <i class="icon-plus-sign bigger-130"></i>添加商品
                                                                </a>
                                                            </div>
														</th> -->
													</tr>
												</thead>

												<tbody>
												<?php foreach($a_view_data['order_data'] as $key=>$value){?>
													<tr data-order-id=<?php echo $value['order_id']?>>
														<td class="center">
															<label>
																<input type="checkbox" class="ace au_check" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>
															<?php echo $value['order_id']; ?>
														</td>
														<td>
															<a href="#">
															<?php echo $value['order_sn']; ?>
															</a>
														</td>
														<td>
															<?php echo $value['store_name']; ?>
														</td>
														<td>
															<?php echo $value['buyer_name']; ?>
														</td>
														<td>
															<?php echo $value['time_create']; ?>
														</td>
														<td>
															<?php echo $value['order_amount']; ?>
														</td>
														<td>
															<?php echo $value['payment_type']; ?>
														</td>
														<td class="hidden-480">
															<?php echo $value['order_type']; ?>
														</td>



												

														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
																<!-- <a class="blue" href="#">
																	<i class="icon-zoom-in bigger-130"></i>
																</a> -->

												<a target="_blank" href="<?php echo $this->router->url('order_details',[$value['order_id']])?>"><button class="btn btn-success">查看详情</button></a>
																<?php if($value['order_state']==20){?>
																<button class="btn btn-info">设置物流</button>
																<?php }?>
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
											<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->
					<!-- 	<div>删除选中商品</div> -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->


			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

<div class="col-xs-12 col-sm-4" style="position:fixed;top:40%;margin-left:50%;right:25.66%;display:none">
											<div class="widget-box">
												<div class="widget-header">
													<h4>Text Area</h4>

													<div class="widget-toolbar">
														<a href="#" data-action="collapse">
															<i class="icon-chevron-up"></i>
														</a>

														<a href="#" data-action="close1">
															<i class="icon-remove"></i>
														</a>
													</div>
												</div>

												<div class="widget-body">
													<div class="widget-main">
														<div>
															<label for="form-field-8">物流公司:</label>

														
														<select >
														<?php foreach($a_view_data['express'] as $key=>$value){?>
															<option value="<?php echo $value['e_code']?>" data="<?php echo $value['id']?>"><?php echo $value['e_name']?></option>
														<?php }?>

															</select>
														</div>

												
														<div>
															<label for="form-field-11">物流单号:</label>
															<input type="text" style="width:50%">

													<button class="btn btn-danger">保存物流</button>
														</div>

													</div>
												</div>

											</div>

	</div>


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
			      null, null,null, null, null,null, null,null,
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
<script>
$(function(){
	//点击设置物流
	$(document).on("click",".btn-info",function(){

	    express_num="";
	    express_code="";
	    express_company_id="";
	    order_id="";
		//显示选择框
		$(".col-xs-12.col-sm-4").css("display","block");
		//清空已写入的文本
		$(".col-xs-12.col-sm-4").find("input[type=text]").val("");
		var order_string=$(this).parents("td").siblings("td:eq(1)").text();
		//拿到order_id
		order_id = order_string.replace(/[^0-9]/ig,""); 

	})

	//点击关闭  物流窗
	$("a[data-action='close1']").unbind("click").click(function(){
		$(".col-xs-12.col-sm-4").fadeOut();
	})
	//点击设置
	$(".col-xs-12.col-sm-4").find("button").click(function(){
		express_num=$(this).siblings("input").val();
		express_code=$(".widget-main").find("select").val();
		express_company_id=$("option[value="+express_code+"]").attr("data");

		if(express_num=="" || express_code=="" || express_company_id==""){
			alert("请填写物流单号或者物流公司编码");
		}else{
			set_express();
		}
	})

	//发送设置物流数据
	function set_express(){
		var data={};
		data['express_code']=express_code;
		data['express_num']=express_num;
		data['order_id']=order_id;
		data['express_company_id']=express_company_id;
		
		var status=true;
		    $.ajax({
                  type: 'POST',
                  data: data,
                  url : "<?php echo $this->router->url('set_express');?>",
                  beforeSend:function(){
                  
                  },
                  success: function(status) {

					if(status!=0){
	                    var json = eval('(' + status + ')');
	                    if( !json['result']){
	                    	alert(json['message']);
	                    }else{
	                    	alert("设置物流成功");
	                    	//隐藏设置物流窗口
	                    	$("a[data-action='close1']").click();
	                    	//隐藏 设置物流按钮
	                    	$("tr[data-order-id="+order_id+"]").find(".btn-info").remove();
	                    	express_num="";
	                    	express_code="";
	                    	express_company_id="";
	                    	order_id="";

	                    }
					}else{
						alert("操作失败，请稍后再试或联系技术人员");
					}
         
                  },
                  error: function() {
                      alert('请检查网络配置,稍后再试');
                  }
              });
	}

	// $(".btn-success").click(function(){
	// 	window.open("http://www.jb51.net"); 
	// })
})
</script>
<script src="./js/plus.js"></script>