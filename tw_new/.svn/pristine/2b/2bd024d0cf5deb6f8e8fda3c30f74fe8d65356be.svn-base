layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element', 'utils', 'tree', 'cate_common'], function () {
    var form = layui.form,
        grid = layui.grid,
        table = layui.table,
        cate_common = layui.cate_common,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        tree = layui.tree,
        jQuery = $ = layui.jquery;

    $(function () {
        cate_common.render(0);
        cate_common.renderUpload();
    });

    /**
     * 提交表单
     */
    form.on('submit(post_cate)', function (data) {
        fetch.ajax('/category.add', data.field, function () {
            parent.layer.closeAll();
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});
