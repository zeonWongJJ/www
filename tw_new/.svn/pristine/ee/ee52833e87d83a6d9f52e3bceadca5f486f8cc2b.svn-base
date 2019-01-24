layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element'], function () {
    var form = layui.form,
        grid = layui.grid,
        table = layui.table,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        jQuery = $ = layui.jquery,

        gridInstance,
        cols = [[
            {field: 'entity_title', title: '用户'},
            {field: 'entity_title', width: 200, title: '现有积分'},
            {field: 'user_id', width: 200, title: '操作'}
        ]];

    $(window).one('resize', function () {
        gridInstance = grid.init(cols, '/assets.jifen.list');
    }).resize();
});