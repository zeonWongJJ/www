<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody" style="background: #efefef">
    <blockquote class="layui-elem-quote news_search">
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal page_action" data-type="admin_add">+ 添加管理员</a>
        </div>
    </blockquote>
    <div class="layui-form news_list">
        <div style="background: #fff">
            <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
        </div>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>