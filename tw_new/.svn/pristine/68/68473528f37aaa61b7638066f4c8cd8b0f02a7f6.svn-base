layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'role_common'], function () {
    var $ = layui.jquery,
        form = layui.form,
        role_common = layui.role_common
        fetch = layui.fetch;

    $(function () {
        role_common.init(0);
    });

    /**
     * 提交表单
     */
    form.on('submit(post_role)', function (data) {
        data.field.role_status = data.field.role_status == 'on' ? 1 : 0;

        fetch.ajax('/auth.role.add', data.field, function () {
            parent.layer.closeAll();
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});
