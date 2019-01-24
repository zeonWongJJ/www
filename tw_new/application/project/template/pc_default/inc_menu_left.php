<ul class="nav nav-list">
	<li class="">
		<a href="<?php echo $this->router->url('index');?>">
			<i class="menu-icon fa fa-home blue"></i>
			<span class="menu-text"> 主页 </span>
		</a>

		<b class="arrow"></b>
	</li>
	
	<li class="open<?php /* if (in_array($this->router->get_index(), ['task_list', 'task_add', 'publish_not', 'publish_finsh', 'partake_not', 'partake_finsh', 'task_wait', 'task_all', 'task_home', 'task_detail'])) {echo 'open';}*/?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-wrench grey"></i>
			<span class="menu-text"> 任务 </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="">
				<a href="<?php echo $this->router->url('task_wait');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					尚未完成
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('publish_not');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					我发表未完成
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('publish_finsh');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					我发表已完成
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('partake_not');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					我参与未完成
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('partake_finsh');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					我参与已完成
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('task_all');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					全部任务
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('task_add');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					添加任务
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	
	<li class="open<?php /* if (in_array($this->router->get_index(), ['notice_custom', ''])) {echo 'open';}*/?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-bullhorn orange"></i>
			<span class="menu-text"> 通知管理 </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="">
				<a href="<?php echo $this->router->url('notice_receive');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					通知列表
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('notice_custom');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					发送通知
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	
	<li class="open<?php /* if (in_array($this->router->get_index(), ['task_group_list', 'task_group_add', 'question_add'])) {echo 'open';}*/?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-paperclip green"></i>
			<span class="menu-text"> 任务组 </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="">
				<a href="<?php echo $this->router->url('task_group_list');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					任务组列表
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('task_group_add');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					添加任务组
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('question_add');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					提交问题
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	
	<li class="open<?php /* if (in_array($this->router->get_index(), ['project_list', 'project_add'])) {echo 'open';}*/?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list purple"></i>
			<span class="menu-text"> 项目中心 </span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<li class="">
				<a href="<?php echo $this->router->url('project_list');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					项目列表
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo $this->router->url('project_add');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					创建项目
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
</ul><!-- /.nav-list -->