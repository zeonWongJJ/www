<?php include_once APPPATH . 'template/default/common/header.php';?>
    <style>
        .grid_action {
            display: inline-block;
            margin-left: 10px;
        }
    </style>
    <body class="childrenBody">
    <blockquote class="layui-elem-quote news_search">
<!--        <div class="layui-inline">-->
<!--            <a class="layui-btn layui-btn-normal newsAdd_btn">添加服务</a>-->
<!--        </div>-->
        <div class="layui-inline">
            <a href="javascript:void(0);" class="layui-btn page_action" data-type="delete_all">批量删除</a>
        </div>
<!--        <div class="layui-inline">-->
<!--            <a class="layui-btn audit_btn">批量删除</a>-->
<!--        </div>-->
    </blockquote>
    <div class="layui-form news_list">
        <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php';?>