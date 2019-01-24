<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>用户列表</title>
		<!-- basic styles -->

		<link href="./style/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./style/font-awesome.min.css" />

		

		<link rel="stylesheet" href="./style/ace.min.css" />
		<link rel="stylesheet" href="./style/ace-rtl.min.css" />

		<script src="./js/ace-extra.min.js"></script>
	</head>

	<style>
	/*消息弹框*/
	.message_box{
	    left: 50%;
	    top: 50%;
	    margin-left: -160px;
	    margin-top: 60px;
	    width: 320px;
	    height:120px;
	    padding: 20px;
	    position: relative;
	    box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.25);
	    background: #ffffff;
	}
	.message_box h2,
	.message_box p{
	    font-size: 16px;
	    color: #333333;
	}
	.message_box p{
	    margin-top: 10px;
	}
	.message_box .btn{
	    padding: 0;
	}
	.message_box div:first-child{
	}
	.message_box .btn button{
	    width:60px;
	    height:30px;
	    border: 1px solid #cccccc;
	    border-radius: 5px;
	    margin: 0 30px;
	}
	.message_box .btn .active{
	    background: #3f8654;
	    border-color: #3f8654;
	    color: #ffffff;
	}
	</style>

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
							<li class="active">用户列表</li>
						</ul><!-- .breadcrumb -->

					</div>
					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue"><a href="user.html" >用户列表</a><a href="latest_user.html" style="margin-left: 30px;">登录用户列表</a></h3>
										<div class="pot">
										<form action="user-<?php echo isset($_POST['id']) ? $_POST['id'] : '';?>-<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>-<?php echo isset($_POST['tesname']) ? $_POST['tesname'] : '';?>-<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>-<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : '';?>-" method="post">
											用户id ：<input type="text" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : '';?>">
											用户名 ：<input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
											真实姓名 ：<input type="text" name="tesname" value="<?php echo isset($_POST['tesname']) ? $_POST['tesname'] : '';?>">
											邮箱 ：<input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>">
											手机 ：<input type="text" name="mobile" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : '';?>">
											<input type="submit" value="确定" >
										</form>
										</div>
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
														<th>用户ID</th>
														<th style="width: 300px">用户名称</th>
														<th>用户真实姓名</th>
														<th>用户手机号</th>
														<th>用户邮箱</th>
														<th>用户积分</th>
														<th>用户冻结</th>
														<th>用户登录时间</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($a_view_data['member'] as $key => $value): ?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" name="del_goods[]" value="<?php echo $value['member_id'] ?>" class="ace au_check" />
																<span class="lbl"></span>
															</label>
														</td>
														<td>
															<?php echo $value['member_id']; ?>
														</td>
														<td>
															<?php echo $value['member_name']; ?>
														</td>
														<td>
															<?php echo $value['member_truename']; ?>
														</td>
														<td>
															<?php echo $value['member_mobile']; ?>
														</td>
														<td>
															<?php echo $value['member_email']; ?>
														</td>
														<td>
															<?php echo $value['member_points']; ?>
														</td>
														
														<?php if ($value['member_state'] == 1) {?>
														<td>  
															正常
														<?php } else { ?>
														<td style="color: #F50808;"> 
														 	冻结
													 	<?php }?>
														</td>
														<td>
															<?php if (empty($value['member_time_login'])) {?>
																暂时无记录
															<?php } else {?>
															<?php echo date("Y-m-d", $value['member_time_login']);?>
															<?php }?>
														</td>

														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

																<a class="green" href="<?php echo $this->router->url('update_user',['member_id' => $value['member_id']]); ?>">
																	修改
																</a>

																<a  data="<?php echo $value['member_id'] ?>" class="red del_goods"  href="<?php echo $this->router->url('true_user',['member_id' => $value['member_id']]); ?>">
																	详情
																</a>
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
												<?php endforeach ?>
												</tbody>
											</table>
											<?php echo $a_view_data['page']?>
										</div>
									</div>
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->
						<!-- <button type="button" class="del_goods_form">删除选中商品</button> -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div>	
</body>
</html>