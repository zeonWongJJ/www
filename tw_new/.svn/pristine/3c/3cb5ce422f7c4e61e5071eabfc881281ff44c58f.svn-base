<?php $this->view->display('header') ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">管理员管理</a> &raquo; 添加管理员
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="<?php echo $this->router->url('manager_add'); ?>"><i class="fa fa-plus"></i>新增管理员</a>
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
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc">ID</th>
                        <th>用户名</th>
                        <th>角色名称</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($a_view_data)){ ?>
                    <?php foreach ($a_view_data as $key => $value): ?>
                        
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="<?php echo $value['id'] ?>"></td>
                        <td class="tc"><?php echo $value['id'] ?></td>
                        <td>
                            <?php echo $value['username'] ?>
                        </td>
                        <td>
                            <?php echo $value['role_name'] ?>
                        </td>
                        <td>
                            <a href="#">修改</a>
                            <a href="#">删除</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php } ?>
                    
                </table>

                <div class="page_list">
                    <ul>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->



</body>
</html>