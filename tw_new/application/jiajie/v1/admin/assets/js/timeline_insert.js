layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'grid', 'utils', 'timeline_common'], function () {
    var form = layui.form
        , utils = layui.utils
        , fetch = layui.fetch
        , timeline_common = layui.timeline_common
        , layer = parent.layer || layui.layer;

    form.on('submit(post_admin)', function (data) {
        var field = data.field;
        fetch.ajax('/timeline.add', field, function () {
            parent.layer.closeAll();
        })
    })
});