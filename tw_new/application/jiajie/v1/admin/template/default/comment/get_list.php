<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody" style="background: #efefef">
    <div class="layui-form news_list">
        <div class="dynamicCate">
            <ul>
                <li class="searchUser">
                    <span>搜索：</span>
                    <input type="text" name="keywords" placeholder="用户名/手机号" id="user_name">
                </li>
                <li class="advancedOptions">
                    <span>高级选项：</span>
                    <dl>
                        <dd class="auditStatusBox" style="background: white; border: 1px solid rgb(255, 255, 255);">
                            <span>审核状态</span>
                            <i class="layui-icon layui-icon-down"></i>
                            <div class="auditStatus show_box" style="display: none">
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="all" class="page_action">全部</a>
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="1" class="page_action">已通过</a>
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="0" class="page_action">未通过</a>
                            </div>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
<!--        <div class="bottomTool">-->
<!--            <a class="bottomDelect page_action" href="javascript:;" data-type="delete_all">-->
<!--                <i class="layui-icon layui-icon-delete"></i>-->
<!--                <span>删除</span>-->
<!--            </a>-->
<!--            <a class="bottomHide page_action" data-type="audit_all">-->
<!--                <i class="layui-icon layui-icon-close-fill"></i>-->
<!--                <span>审核</span>-->
<!--            </a>-->
<!--        </div>-->
        <div style="background: #fff">
            <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
        </div>
        <div class="bottomTool">
            <a class="bottomDelect page_action" href="javascript:;" data-type="delete_all">
                <i class="layui-icon layui-icon-delete"></i>
                <span>删除</span>
            </a>
            <a class="bottomHide page_action" data-type="audit_all">
                <i class="layui-icon layui-icon-close-fill"></i>
                <span>审核</span>
            </a>
        </div>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>