layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'grid', 'utils'], function () {
    var layer = parent.layer || layui.layer,
        form = layui.form,
        utils = layui.utils,
        $ = layui.jquery,
        fetch = layui.fetch,
        href = window.location.href,
        id = href.split('?')[1];

    $(function () {
        fetch.ajax('/service.get-' + id, {}, function (data) {
            $('#service_level').html(
                data.service_level_1_name + ' >> ' + data.service_level_2_name + ' >> ' + data.service_level_3_name
            );
            $('#service_store').html(
                '<a href="javascript:;"><i class="layui-icon layui-icon-layouts"></i><cite> ' + data.store_name + ' </cite></a>'
            );
            // 1：按时收费 2：按次数收费
            if (data.pay_way == 2) {
                $('#sfdw').html('次');
            } else {
                $('#sfdw').html('小时');
            }
            $('#service_info').html(data.service_info);
            $.each(data, function (key, value) {
                $('input[name=' + key + ']').val(value)
            });
        });
    });
});