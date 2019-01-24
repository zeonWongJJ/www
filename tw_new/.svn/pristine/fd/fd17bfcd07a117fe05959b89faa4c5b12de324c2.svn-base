<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>用户修改</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="./style/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="./style/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="./style/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<link rel="stylesheet" href="./style/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="./style/chosen.css" />
		<link rel="stylesheet" href="./style/datepicker.css" />
		<link rel="stylesheet" href="./style/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="./style/daterangepicker.css" />
		<link rel="stylesheet" href="./style/colorpicker.css" />

		<link rel="stylesheet" href="./style/ace.min.css" />
		<link rel="stylesheet" href="./style/ace-rtl.min.css" />
		<link rel="stylesheet" href="./style/ace-skins.min.css" />
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
								<a href="#">用户修改</a>
							</li>

							<!-- <li class="active">Form Elements</li> -->
						</ul><!-- .breadcrumb -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								用户修改
							</h1>
							<h1 style="float:right">
								<a href="<?php echo $this->router->url('user'); ?>">返回用户列表</a>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<?php foreach ($a_view_data as $key => $value): ?>
								<ul>
									<li>用户ID ：<?php echo $value['member_id']?></li>
									<li>用户名 ：<?php echo $value['member_name']?></li>
									<li>用户状态 ：
										<form action="update_user1-<?php echo $value['member_id']?>" method="post">
											<select id="state" name="state">
												<option value="<?php echo $value['member_state']?>"><?php if ($value['member_state'] == 1) {?>
														正常
													<?php } else {?>
														冻结
													<?php }?>
												</option>	
												<option value="1">正常</option>
												<option value="0">冻结</option>			
											</select>
											<input type="submit" name="submit" value="确定" />
										</form>
									</li>
								</ul>
							<?php endforeach ?>
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
		</div><!-- /.main-container -->
</body>
</html>

<!-- 引入我需要的JS样式 -->
<script type="text/javascript" charset="utf-8" src="./js/plus.js"></script>

<!--导入在线编辑器 -->
<script type="text/javascript" charset="utf-8" src="./ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="./ue/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="./ue/lang/zh-cn/zh-cn.js"></script>



