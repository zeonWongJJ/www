<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody" style="background: #efefef">
    <blockquote class="layui-elem-quote news_search">
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal page_action" data-type="timeline_add">+ 添加时间线事件</a>
        </div>
    </blockquote>
    <div style="background: #ffffff;">
        <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>