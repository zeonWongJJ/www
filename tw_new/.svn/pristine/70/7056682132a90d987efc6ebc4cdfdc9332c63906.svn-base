layui.config({
    base: "assets/js/modules/"
}).use(['admin_common', 'form', 'layer', 'fetch', 'grid', 'utils'], function () {
    var form = layui.form
        , fetch = layui.fetch
        , layer = parent.layer || layui.layer
        , admin_common = layui.admin_common
        , $ = layui.$
        , utils = layui.utils;
    admin_common.render_role_list();
    form.on("submit(post_admin)", function (data) {
        var field = data.field;
        fetch.ajax('/admin.add', field, function () {
            parent.layer.closeAll();
        });
    });
})