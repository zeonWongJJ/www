<?php
static $a_router = array('admin.insert' => array('class' => 'PC_Admin', 'method' => 'insert',), 'admin.update' => array('class' => 'PC_Admin', 'method' => 'update',), 'admin.delete' => array('class' => 'PC_Admin', 'method' => 'delete',), 'admin.get_one' => array('class' => 'PC_Admin', 'method' => 'getOne',), 'admin.get_list' => array('class' => 'PC_Admin', 'method' => 'getList',), 'category.insert' => array('class' => 'PC_Category', 'method' => 'insert',), 'category.update' => array('class' => 'PC_Category', 'method' => 'update',), 'category.delete' => array('class' => 'PC_Category', 'method' => 'delete',), 'category.get_one' => array('class' => 'PC_Category', 'method' => 'getOne',), 'category.get_list' => array('class' => 'PC_Category', 'method' => 'getList',), 'comment.insert' => array('class' => 'PC_Comment', 'method' => 'insert',), 'comment.update' => array('class' => 'PC_Comment', 'method' => 'update',), 'comment.delete' => array('class' => 'PC_Comment', 'method' => 'delete',), 'comment.get_one' => array('class' => 'PC_Comment', 'method' => 'getOne',), 'comment.get_list' => array('class' => 'PC_Comment', 'method' => 'getList',), 'config.index' => array('class' => 'PC_Config', 'method' => 'index',), 'demand.insert' => array('class' => 'PC_Demand', 'method' => 'insert',), 'demand.update' => array('class' => 'PC_Demand', 'method' => 'update',), 'demand.delete' => array('class' => 'PC_Demand', 'method' => 'delete',), 'demand.get_one' => array('class' => 'PC_Demand', 'method' => 'getOne',), 'demand.get_list' => array('class' => 'PC_Demand', 'method' => 'getList',), 'demand.review' => array('class' => 'PC_Demand', 'method' => 'review',), 'admin.index' => array('class' => 'PC_Home', 'method' => 'index',), 'index' => array('class' => 'PC_Home', 'method' => 'index',), 'jifen.insert' => array('class' => 'PC_Jifen', 'method' => 'insert',), 'jifen.update' => array('class' => 'PC_Jifen', 'method' => 'update',), 'jifen.delete' => array('class' => 'PC_Jifen', 'method' => 'delete',), 'jifen.get_one' => array('class' => 'PC_Jifen', 'method' => 'getOne',), 'jifen.get_list' => array('class' => 'PC_Jifen', 'method' => 'getList',), 'order.insert' => array('class' => 'PC_Order', 'method' => 'insert',), 'order.update' => array('class' => 'PC_Order', 'method' => 'update',), 'order.delete' => array('class' => 'PC_Order', 'method' => 'delete',), 'order.get_one' => array('class' => 'PC_Order', 'method' => 'getOne',), 'order.get_list' => array('class' => 'PC_Order', 'method' => 'getList',), 'role.allow' => array('class' => 'PC_Role', 'method' => 'allow',), 'role.insert' => array('class' => 'PC_Role', 'method' => 'insert',), 'role.update' => array('class' => 'PC_Role', 'method' => 'update',), 'role.delete' => array('class' => 'PC_Role', 'method' => 'delete',), 'role.get_one' => array('class' => 'PC_Role', 'method' => 'getOne',), 'role.get_list' => array('class' => 'PC_Role', 'method' => 'getList',), 'rule.insert' => array('class' => 'PC_Rule', 'method' => 'insert',), 'rule.update' => array('class' => 'PC_Rule', 'method' => 'update',), 'rule.delete' => array('class' => 'PC_Rule', 'method' => 'delete',), 'rule.get_one' => array('class' => 'PC_Rule', 'method' => 'getOne',), 'rule.get_list' => array('class' => 'PC_Rule', 'method' => 'getList',), 'service.insert' => array('class' => 'PC_Service', 'method' => 'insert',), 'service.update' => array('class' => 'PC_Service', 'method' => 'update',), 'service.delete' => array('class' => 'PC_Service', 'method' => 'delete',), 'service.get_one' => array('class' => 'PC_Service', 'method' => 'getOne',), 'service.get_list' => array('class' => 'PC_Service', 'method' => 'getList',), 'slide.insert' => array('class' => 'PC_Slide', 'method' => 'insert',), 'slide.update' => array('class' => 'PC_Slide', 'method' => 'update',), 'slide.delete' => array('class' => 'PC_Slide', 'method' => 'delete',), 'slide.get_one' => array('class' => 'PC_Slide', 'method' => 'getOne',), 'slide.get_list' => array('class' => 'PC_Slide', 'method' => 'getList',), 'store.insert' => array('class' => 'PC_Store', 'method' => 'insert',), 'store.update' => array('class' => 'PC_Store', 'method' => 'update',), 'store.delete' => array('class' => 'PC_Store', 'method' => 'delete',), 'store.get_one' => array('class' => 'PC_Store', 'method' => 'getOne',), 'store.get_list' => array('class' => 'PC_Store', 'method' => 'getList',), 'store.settlement' => array('class' => 'PC_Store', 'method' => 'settlement',), 'utils.get.tree.options' => array('class' => 'PC_Utils', 'method' => 'makeTreeOptions',), 'timeline.insert' => array('class' => 'PC_Timeline', 'method' => 'insert',), 'timeline.update' => array('class' => 'PC_Timeline', 'method' => 'update',), 'timeline.delete' => array('class' => 'PC_Timeline', 'method' => 'delete',), 'timeline.get_one' => array('class' => 'PC_Timeline', 'method' => 'getOne',), 'timeline.get_list' => array('class' => 'PC_Timeline', 'method' => 'getList',), 'user.insert' => array('class' => 'PC_User', 'method' => 'insert',), 'user.update' => array('class' => 'PC_User', 'method' => 'update',), 'user.delete' => array('class' => 'PC_User', 'method' => 'delete',), 'user.get_one' => array('class' => 'PC_User', 'method' => 'getOne',), 'user.get_list' => array('class' => 'PC_User', 'method' => 'getList',), 'user.login' => array('class' => 'PC_User', 'method' => 'login',), 'user.show_jifen_list' => array('class' => 'PC_User', 'method' => 'show_jifen_list',), 'user.show_balance_list' => array('class' => 'PC_User', 'method' => 'show_balance_list',), 'member.type' => array('class' => 'PC_User', 'method' => 'fuck_test',),);
