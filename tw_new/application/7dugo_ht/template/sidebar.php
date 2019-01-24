<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<!-- <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div> -->

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li class="active">
							<a href="">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 管理主页 </span>
							</a>
						</li>

					 	
				      <li>

						<a href="<?php echo $this->router->url("goods");?>" class="dropdown-toggle">
							<i class="icon-double-angle-right"></i>

							商品列表
							<!-- <b class="arrow icon-angle-down"></b> -->
						</a>

						 <li>
						<a href="<?php echo $this->router->url('order');?>" class="dropdown-toggle">
							<i class="icon-double-angle-right"></i>

							订单列表
							<!-- <b class="arrow icon-angle-down"></b> -->
						</a>
						</li>


						<!-- <ul class="submenu">
							<li>
								<a href="#">
									<i class="icon-leaf"></i>
									第一级
								</a>
							</li>

							<li>
								<a href="#" class="dropdown-toggle">
									<i class="icon-pencil"></i>

									第四级
									<b class="arrow icon-angle-down"></b>
								</a>

								<ul class="submenu">
									<li>
										<a href="#">
											<i class="icon-plus"></i>
											添加产品
										</a>
									</li>

									<li>
										<a href="#">
											<i class="icon-eye-open"></i>
											查看商品
										</a>
									</li>
								</ul>
							</li>
						</ul> -->
					</li>
					<li>
							<a href="<?php echo $this->router->url('user');?>" class="dropdown-toggle">
								<i class="icon-double-angle-right"></i>

								用户列表
								<!-- <b class="arrow icon-angle-down"></b> -->
							</a>
						</li>

					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>