layui.config({
    base: "assets/js/modules/"
}).use(['rule_common', 'form', 'layer', 'fetch'], function () {
    var $ = window.jQuery,
        form = layui.form,
        fetch = layui.fetch
        , rule_common = layui.rule_common;

    rule_common.render(0);

    fetch.ajax('/auth.rule.level', {}, function (data) {
        var str = '';

        data.forEach(function (current) {
            str += '<option value="' + current.rule_level + '">' + current.level_name + '</option>';
        });

        $('#inner_rule_level').html(str);
    });

    form.on('submit(post_rule)', function (data) {
        data.field.rule_enable = data.field.rule_enable == 'on' ? 1 : 0;
        data.field.is_menu = data.field.is_menu == 'on' ? 1 : 0;

        fetch.ajax('/auth.rule.add', data.field, function () {
            sessionStorage.removeItem('nav_bar_str');
            parent.layer.closeAll();
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});