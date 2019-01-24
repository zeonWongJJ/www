layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'timeline_common', 'utils'], function () {
    var fetch = layui.fetch
        , form = layui.form
        , timeline_common = layui.timeline_common
        , href = window.location.href
        , id = href.split('?')[1];

    $(function () {
        fetch.ajax('/timeline.get-' + id, {}, function (data) {
            $.each(data, function (key, val) {
                if ('time_line_is_show' === key) {
                    $('input[name=time_line_is_show]value[' + value + ']').attr('checked', true)
                } else if ('time_line_connect' === key) {
                    $('[name=time_line_connect]').html(val)
                } else {
                    $('input[name=' + key + ']').val(val)
                }
            });

            form.render();
        })
    });
});