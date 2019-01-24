<?php $this->view->display('header') ?>
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">后台管理模板</div>
			<ul>
				<li><a href="#" class="active">首页</a></li>
				<li><a href="#">管理页</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：<?php echo $_SESSION['user_id']; ?>admin</li>
				<li><a href="pass.html" target="main">修改密码</a></li>
				<li><a href="#">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

<?php $this->view->display('sidebar') ?>

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="info.html" frameborder="0" width="100%" height="100%" name="main"></iframe> 
	</div>
	<!--主体部分 结束-->

<?php $this->view->display('footer') ?>