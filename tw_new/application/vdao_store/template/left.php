        	<!-- 导航 开始-->
	        <nav>
	            <!-- 头像开始-->
	            <div class="sculpture">
	            	<?php $a_store = $this->db->get_row('store', ['store_id'=> $_SESSION['store_id']]); ?>
	                <img src="<?php if (!empty($a_store['store_touxiang'])) { echo $a_store['store_touxiang']; } else { echo 'static/style_default/images/l_03.png'; } ?>" />
	                <h4><?php echo $_SESSION['store_name']; ?></h4>
	                <span><?php echo $_SESSION['manager_name']; ?></span>
	            </div>
	            <!-- 头像结束 -->
	            <!-- 导航列表 -->
	            <div class="navList">
	                <ul>
	                    <li>
	                        <a href="<?php echo $this->router->url('index'); ?>">
	                             <i><img src="./static/style_default/images/nav_03.png" /></i>
	                            <span>首页</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="<?php echo $this->router->url('store_set'); ?>">
	                            <i><img src="./static/style_default/images/nav_06.png" /></i>
	                            <span>门店设置</span>
	                        </a>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_09.png" /></i>
	                            <span> 产品管理</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('store_product'); ?>">
	                                    <span>餐饮管理</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('office_showlist'); ?>">
	                                    <span>会议管理</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('package_showlist'); ?>">
	                                    <span>套餐管理</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_12.png" /></i>
	                            <span>订单管理</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('delivery'); ?>">
	                                    <span>餐饮订单</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('appointment_order',['cate'=>1]); ?>">
	                                    <span>会议订单</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('appointment_order',['cate'=>2]); ?>">
	                                    <span>座位订单</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_15.png" /></i>
	                            <span>评价管理</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('coffee_room'); ?>">
	                                    <span>餐饮评价</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('comment_room'); ?>">
	                                    <span>会议评价</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_18.png" /></i>
	                            <span>耗材管理</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('consumable'); ?>">
	                                    <span>耗材库存</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('consumable_apply'); ?>">
	                                    <span>耗材申请记录</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_21.png" /></i>
	                            <span>门店资金</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('balance_showlist'); ?>">
	                                    <span>资金管理</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('account_showlist'); ?>">
	                                    <span>结算管理</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li>
	                        <a href="javascript:;">
	                            <i><img src="./static/style_default/images/nav_24.png" /></i>
	                            <span>权限设置</span>
	                            <b class="suo"></b>
	                        </a>
	                        <ul>
	                            <li>
	                                <a href="<?php echo $this->router->url('group_showlist'); ?>">
	                                    <span>角色列表</span>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="<?php echo $this->router->url('manager_showlist'); ?>">
	                                    <span>管理员列表</span>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                </ul>
	            </div>
	            <!-- 导航列表 -->
	        </nav>
	        <!-- 导航结束-->