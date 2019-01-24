layui.config({
    base: "assets/js/modules/"
}).use(['rule_common', 'form', 'layer', 'fetch', 'tree', 'utils'], function () {
    var /*jQuery = $ = layui.jquery,*/
        $ = window.jQuery,
        form = layui.form,
        rule_common = layui.rule_common
        utils = layui.utils,
        fetch = layui.fetch,
        select_id = 0;

    $(function () {
        var href = window.location.href;
        var id = href.split('?')[1];

        if (id) {
            // 获取认证等级列表
            fetch.ajax('/auth.rule.level', {}, function (data) {
                var str = '';

                data.forEach(function (current) {
                    str += '<option value="' + current.rule_level + '">' + current.level_name + '</option>';
                });

                $('#inner_rule_level').html(str);
                form.render();
            });

            fetch.ajax('/auth.rule.get-' + id, {}, function (data) {
                $.each(data, function (key, value) {
                    if (key == 'rule_enable' || key == 'is_menu') {
                        value == 1 && $('input[name=' + key + ']').attr('checked', true)
                    } else if (key == 'rule_level') {
                        $('select[name=' + key + ']').find('option[value=' + value + ']').attr('selected', true);
                    } else {
                        $('input[name=' + key + ']').val(value)
                    }
                });
                rule_common.render(data.parent_id);
                form.render();
            });

            form.on('submit(post_rule)', function (data) {
                data.field.rule_enable = data.field.rule_enable == 'on' ? 1 : 0;
                data.field.is_menu = data.field.is_menu == 'on' ? 1 : 0;

                fetch.ajax('/auth.rule.update-' + id, data.field, function () {
                    sessionStorage.removeItem('nav_bar_str');
                    parent.layer.closeAll();
                });
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });
        }
    });
});