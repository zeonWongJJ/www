layui.config({
    base: "assets/js/modules/"
}).use(['admin_common', 'form', 'layer', 'fetch', 'utils'], function () {
    var $ = layui.jquery,
        form = layui.form,
        utils = layui.utils,
        admin_common = layui.admin_common,
        fetch = layui.fetch,
        href = window.location.href
        , id = href.split('?')[1];

    $(function () {
        function renderRow() {
            fetch.ajax('/admin.get-' + id, {}, function (data) {
                if (data) {
                    $.each(data, function (key, value) {
                        if ('user_sex' == key) {
                            $('input[name=user_sex][value=' + value + ']').attr('checked', true)
                        } else if ('user_password' == key) {
                            $('input[name=user_password]').attr('placeholder', '不填为不修改');
                        } else if ('user_role' == key) {
                            $('#addRoleLevel').find('a[data-roleid=' + value + ']').append(
                                admin_common.render_position_img()
                            );
                            $('input[name=' + key + ']').val(value)
                        } else {
                            $('input[name=' + key + ']').val(value)
                        }
                    });
                    form.render();
                }
            });
        }

        admin_common.render_role_list(renderRow);

        // 确认密码输入框隐藏、显示事件
        $('input[name=user_password_2]').parents('.layui-form-item').hide();
        $('input[name=user_password]').bind('input propertychange', function () {
            if ('' == $('input[name=user_password]').val()) {
                $('input[name=user_password_2]').parents('.layui-form-item').hide();
            } else {
                $('input[name=user_password_2]').parents('.layui-form-item').show();
            }
        });

        form.on("submit(post_admin)", function (data) {
            var field = data.field;
            if (field.user_password && field.user_password != field.user_password_2) {
                parent.layer.msg('密码不相同');
                return;
            }
            fetch.ajax('/admin.update-' + id, field, function () {
                parent.layer.closeAll();
            });
        });
    });
});