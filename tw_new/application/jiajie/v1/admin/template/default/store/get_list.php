<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody">
    <div class="dynamicCate" style="margin-top: 0;">
        <ul>
            <li class="advancedOptions" style="padding-top: 0;">
                <span>高级选项：</span>
                <dl>
                    <dd class="auditStatusBox" style="background: white; border: 1px solid rgb(255, 255, 255);">
                        <span>店铺状态</span>
                        <i class="layui-icon layui-icon-down"></i>
                        <div class="auditStatus show_box" style="display: none">
                            <a href="javascript:;" data-type="filter_audit_status" data-filter="all"
                               class="page_action">全部</a>
                            <a href="javascript:;" data-type="filter_audit_status" data-filter="1" class="page_action">正常</a>
                            <a href="javascript:;" data-type="filter_audit_status" data-filter="2" class="page_action">关闭</a>
                            <a href="javascript:;" data-type="filter_audit_status" data-filter="0" class="page_action">未审核</a>
                            <a href="javascript:;" data-type="filter_audit_status" data-filter="-1" class="page_action">审核不通过</a>
                        </div>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-form news_list">
        <form id="searchform" action="http://vdao-admin.7dugo.com/store_search.html" method="post">
<!--            <a class="addStorePage page_action" href="javascript:;" data-type="add_store">-->
<!--                <i class="layui-icon layui-icon-add-circle"></i> 添加门店</a>-->
            <div class="searchStore">
                <input type="text" name="keywords" placeholder="门店名称" required="">
                <i class="layui-icon layui-icon-search page_action" data-type="search_store_name"
                   style="line-height: 34px; text-align: center; cursor: pointer"></i>
            </div>
        </form>
        <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>
