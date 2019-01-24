<?php $this->view->display('header') ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">权限管理</a> &raquo; 权限列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="<?php echo $this->router->url('manager_add'); ?>"><i class="fa fa-plus"></i>新增权限</a>
                    <!-- <a href="#"><i class="fa fa-recycle"></i>批量删除</a> -->
                    <!-- <a href="#"><i class="fa fa-refresh"></i>更新排序</a> -->
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">权限名称</th>
                        <th>路由地址</th>
                        <th>是否显示到菜单列表</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($a_view_data)){ ?>
                    <?php foreach ($a_view_data as $key => $value): ?>
                    <tr>
                        <td class="tc"><?php echo $value['auth_name'] ?></td>
                        <td>
                            <?php echo $value['action_url'] ?>
                        </td>
                        <td>
                            <?php echo $value['type'] ?>
                        </td>
                        <td>
                            <a href="<?php echo $this->router->url('auth_edit',['auth_id' => $value['auth_id']]); ?>">修改</a>
                            <a href="#">移除</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php } ?>
                    
                </table>

            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->



</body>
</html>