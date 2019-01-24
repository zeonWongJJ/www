layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch'], function () {
    var form = layui.form,
        layer = parent.layer ? parent.layer : layui.layer,
        href = window.location.href,
        id = href.split('?')[1],
        fetch = layui.fetch;

    fetch.ajax('/store.get.customize-' + id, {}, function (res) {
        $.each(res, function (key, value) {
            $('input[name=' + key + ']').val(value);
        });
    }, function () {

    }, 'get');

    // 提交按钮事件
    form.on("submit(post_store)", function (data) {
        var field = data.field,
            isRateMatched = false,
            star_rated_return_str = '';
        $.each(field, function (key, value) {
            isRateMatched = key.match(/^star_rated_return_\d/);
            if (isRateMatched) {
                star_rated_return_str += value + '-';
                delete(field[key])
            }
        });
        field.star_rated_return = star_rated_return_str.substring(0, star_rated_return_str.length - 1); // 去掉最后一个 - 字符
        fetch.ajax('/store.get.customize-' + id, field, function () {
            layer.closeAll();
        });
        return false;
        // post_form('update', data, fetch);
    });
});
