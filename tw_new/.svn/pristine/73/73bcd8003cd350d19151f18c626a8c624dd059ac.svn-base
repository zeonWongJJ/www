layui.config({
    base: "assets/js/modules/"
}).use(['form', 'fetch', 'utils', 'store.common'], function () {
    var $ = layui.jquery,
        form = layui.form,
        fetch = layui.fetch,
        utils = layui.utils;

    $(function () {
        form.render();
    });

    // 提交按钮事件
    form.on("submit(post_store)", function (data) {
        var field = get_field(data);
        fetch.ajax('/store.add', field, function () {
            parent.layer.closeAll();
        });
    });
});