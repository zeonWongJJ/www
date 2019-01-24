<?php
// 项目
$a_projects = $this->db->get('project', ['id_parent' => 0], 'id_project, id_parent, name, task_ratio_finsh');
$i_project_count = count($a_projects);

// 通知
$i_notice_total = $this->db->get_total('notice', ['id_receiver' => $_SESSION['user']['id_user'], 'state' => 30]);
$a_notices = $this->db->get('notice', ['id_receiver' => $_SESSION['user']['id_user'], 'state' => 30], 'content, time_create, link', ['state' => 'DESC', 'time_create' => 'ASC'], 0, 5);
?>
<div id="navbar" class="navbar navbar-default ace-save-state" style="background: #000;">
	<div class="navbar-container ace-save-state" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<div class="navbar-header pull-left">
			<a href="index.html" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					碧落
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey dropdown-modal">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-tasks"></i>
						<span class="badge badge-grey"><?php echo $i_project_count;?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-check"></i>
							共 <?php echo $i_project_count;?> 个项目
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<?php
								foreach ($a_projects as $a_project) {
									if ($a_project['id_parent'] == 0) {
								?>
								<li>
									<a href="<?php echo $this->router->url('project_list', [$a_project['id_project']]);?>">
										<div class="clearfix">
											<span class="pull-left"> <?php echo $a_project['name'];?> </span>
											<span class="pull-right"> <?php echo $a_project['task_ratio_finsh'];?> % </span>
										</div>

										<div class="progress progress-mini">
											<div style="width:<?php echo $a_project['task_ratio_finsh'];?>%" class="progress-bar"></div>
										</div>
									</a>
								</li>
								<?php
									}
								}
								?>
							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="#">
								See tasks with details
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>

				<li class="purple dropdown-modal">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-bell icon-animated-bell"></i>
						<span class="badge badge-important"><?php echo $i_notice_total;?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<?php echo $i_notice_total;?>条通知
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar navbar-pink">
								<?php
								foreach ($a_notices as $a_notice) {
								?>
								<li>
									<a href="<?php echo $a_notice['link'];?>">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
												<?php echo $a_notice['content'];?>
											</span>
											<span class="pull-right badge badge-info"><?php echo date('Y-m-d H:i:s', $a_notice['time_create']);?></span>
										</div>
									</a>
								</li>
								<?php
								}
								?>

							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="<?php echo $this->router->url('notice_receive');?>">
								查看全部通知
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>

				<li class="green dropdown-modal">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
						<span class="badge badge-success">5</span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-envelope-o"></i>
							5 Messages
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<li>
									<a href="#" class="clearfix">
										<img src="assets/images/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Alex:</span>
												Ciao sociis natoque penatibus et auctor ...
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span>a moment ago</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#" class="clearfix">
										<img src="assets/images/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Susan:</span>
												Vestibulum id ligula porta felis euismod ...
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span>20 minutes ago</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#" class="clearfix">
										<img src="assets/images/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Bob:</span>
												Nullam quis risus eget urna mollis ornare ...
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span>3:15 pm</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#" class="clearfix">
										<img src="assets/images/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Kate:</span>
												Ciao sociis natoque eget urna mollis ornare ...
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span>1:33 pm</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#" class="clearfix">
										<img src="assets/images/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Fred:</span>
												Vestibulum id penatibus et auctor  ...
											</span>

											<span class="msg-time">
												<i class="ace-icon fa fa-clock-o"></i>
												<span>10:09 am</span>
											</span>
										</span>
									</a>
								</li>
							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="inbox.html">
								See all messages
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>

				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="static/pc_default/image/avatars/avatar3.png" alt="Jason's Photo" />
						<span class="user-info">
							<small>欢迎,</small>
							<?php echo $_SESSION['user']['name_user'];?>
						</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="#">
								<i class="ace-icon fa fa-cog"></i>
								Settings
							</a>
						</li>

						<li>
							<a href="profile.html">
								<i class="ace-icon fa fa-user"></i>
								Profile
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="<?php echo $this->router->url('logout')?>">
								<i class="ace-icon fa fa-power-off"></i>
								注销
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div>