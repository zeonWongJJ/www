layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element', 'utils'], function () {
    var form = layui.form,
        grid = layui.grid,
        utils = layui.utils,
        element = layui.element,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        jQuery = $ = layui.jquery,
        cols = [[
            {field: 'time_line_title', width: 200, title: '时间线标题'}
            , {field: 'time_line_at', title: '时间线发生时间'}
            , {field: 'time_line_connect', title: '时间线内容'}
            , {
                field: 'time_line_is_show', title: '是否显示', templet: function (d) {
                    var open = d.time_line_is_show == 1 ? 'checked' : '';
                    return '<input ' + open + ' type="checkbox" data-id="' + d.id + '" lay-filter="change_show_timeline" name="switch" lay-skin="switch">';
                }
            }
            , {
                field: 'id', title: '操作', width: 120, templet: function (d) {
                    var str = '<a title="修改" href="javascript:void(0);" class="grid_action" data-id="' + d.id + '" data-type="update_item"><i class="layui-icon layui-icon-edit"></i></a>';
                    str += '<a title="删除" href="javascript:void(0);" class="grid_action" data-id="' + d.id + '" data-type="delete_item"><i class="layui-icon layui-icon-delete"></i></a>';
                    return str;
                }
            }
        ]]
        , gridInstance;

    $(window).resize(function () {
        gridInstance = grid.init(cols, '/timeline.list');
    }).resize();

    $(function () {
        utils.initPage({
            page_active: {
                timeline_add: function () {
                    var index = layui.layer.open({
                        title: "添加时间线事件"
                        , type: 2
                        , content: "timeline.insert"
                        , end: function () {
                            gridInstance.reload();
                        }
                    });
                    layui.layer.full(index);
                }
            }
            , grid_active: {
                delete_item: function () {
                    var pk_id = $(this).data('id')
                        , index = layer.confirm('确认删除？', {
                        btn: ['确认', '取消'] //按钮
                    }, function () {
                        fetch.ajax('/timeline.delete-' + pk_id, {}, function () {
                            layer.close(index);
                            gridInstance.reload();
                        })
                    });
                }
                , update_item: function () {
                    var pk_id = $(this).data('id')
                        , index = layui.layer.open({
                        title: "修改时间线事件"
                        , type: 2
                        , content: "timeline.update?" + pk_id
                        , end: function () {
                            gridInstance.reload();
                        }
                    });
                    layui.layer.full(index);
                }
            }
        });

        form.on('switch(change_show_timeline)', function () {
            var pk_id = $(this).data('id');
            fetch.ajax('/timeline.show-' + pk_id, {}, function () {
                gridInstance.reload();
            })
        })
    });
});