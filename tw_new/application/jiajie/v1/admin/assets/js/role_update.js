layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'utils', 'role_common'], function () {
    var $ = layui.jquery,
        form = layui.form,
        utils = layui.utils,
        role_common = layui.role_common,
        fetch = layui.fetch,
        href = window.location.href,
        id = href.split('?')[1];

    $(function () {
        initPage();
    });

    function initPage() {
        fetch.ajax('/auth.role.get-' + id, {}, function (data) {
            // 设置表单数据
            $.each(data, function (key, value) {
                if (key === 'role_status' && value == 1) {
                    // 根据实际情况渲染开关
                    $('input[name=role_status]').attr('checked', true);
                } else if (key === 'role_info') {
                    $('textarea[name=role_info]').html(value);
                } else if (key === 'parent_id') {
                    $('select[name=role_info] option[value='+value+']').attr('selected', 'selected');
                }
                $('input[name=' + key + ']').val(value)
            });
            role_common.init(data.parent_id)
            form.render();
        });
    }

    /**
     * 提交表单
     */
    form.on('submit(post_role)', function (data) {
        data.field.role_status = data.field.role_status == 'on' ? 1 : 0;

        fetch.ajax('/auth.role.update-' + id, data.field, function () {
            parent.layer.closeAll();
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});
