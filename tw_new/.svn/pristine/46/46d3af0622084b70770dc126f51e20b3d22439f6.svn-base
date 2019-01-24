layui.define(['jquery', 'table', 'element', 'form'], function (exports) {
    var table = layui.table
        , form = layui.form
        , element = layui.element;

    var grid = {
        init: function (columns, url, where) {
            var grid_instance = table.render({
                elem: '#grid_contrainer'
                , cellMinWidth: 30
                , id: 'id'
                , url: window.config.api_prefix + url + '-admin' //数据接口
                , page: true //开启分页
                , method: 'POST'
                , headers: {
                    'X-Token': sessionStorage.getItem('user_token')
                }
                , loading: true
                , where: where
                , response: {
                    statusName: 'error'
                    , statusCode: 0
                    , msgName: 'msg'
                    , countName: 'count'
                    , dataName: 'data'
                }
                , cols: columns
                , done: function () {
                    element.render();
                    form.render();
                }
            });

            return grid_instance;
        }
    };

    exports('grid', grid);
});