layui.define(['layer', 'fetch', 'form', 'utils', 'laydate'], function (exports) {
    var form = layui.form
        , laydate = layui.laydate
        , main = {};

    //执行一个laydate实例
    laydate.render({
        elem: '#time_line_at' //指定元素
    });

    exports('timeline_common', main);
});