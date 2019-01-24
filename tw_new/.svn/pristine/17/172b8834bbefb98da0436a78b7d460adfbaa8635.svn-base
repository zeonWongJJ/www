layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'utils'], function () {
    var fetch = layui.fetch,
        utils = layui.utils,
        $ = layui.jquery,
        grid = layui.grid,
        table = layui.table,
        gridInstance;

    var cols = [[
            {type: 'checkbox', fixed: 'left'},
            {field: 'subject_title', title: '需求标题'},
            {field: 'demand_contact_name', title: '联系人', width: 120},
            {field: 'demand_telephone', title: '联系手机', width: 140}
            , {field: 'demand_service_at', title: '需求预约时间', width: 180}
            // {
            //     field: 'demand_is_show', title: '审核', templet: function (d) {
            //         return d.demand_is_show == 1
            //             ? '<i class="layui-icon layui-icon-reply-fill" style="color: #009688;"> 已审核</i>'
            //             : '<a href="javascript:;" class="grid_tool_btn" data-id="' + d.id + '" data-type="examine"><i class="layui-icon layui-icon-circle-dot" style="color:#FF5722;"> 审核该需求</i></a>';
            //     }
            // },
            , {
                field: 'id', title: '操作', fixed: 'right', width: 180, templet: function (d) { //
                    var str = '<a href="javascript:;" class="grid_action" data-id="' + d.id + '" data-type="demand_detail"><i class="layui-icon layui-icon-list" style="color:#1E9FFF;"></i></a>';
                    str += '<a href="javascript:;" class="grid_action" data-type="del_demand" data-id="' + d.id + '"><i class="layui-icon layui-icon-unlink" style="color:#FF5722;"></i></a>';

                    d.demand_is_show = parseInt(d.demand_is_show);

                    console.log(d.demand_is_show)

                    if (d.demand_is_show === 1) {
                        str += '<i class="layui-icon layui-icon-ok">已通过</i>'
                    } else if (d.demand_is_show === 2) {
                        str += '<a title="查看未通过理由" href="javascript:void(0);" class="grid_action" data-type="show_no_pass_reason" data-id="' + d.id + '"><i class="layui-icon layui-icon-close"></i>查看理由</a>'
                    } else if (d.demand_is_show === 0) {
                        str += '<a title="审核该需求" class="grid_action" data-id="' + d.id + '" data-type="examine_row" href="javascript:void(0);" style="color: #1fff98"><i class="layui-icon layui-icon-ok"></i>审核需求</a>';
                    }

                    return str;
                }
            }
        ]]
    ;

    $(window).resize(function () {
        gridInstance = grid.init(cols, '/demand.list');
    }).resize();

    $(function () {
        function reloadGrid() {
            gridInstance.reload();
        }

        utils.initPage({
            grid_active: {
                demand_detail: function () {
                    var id = $(this).data('id')
                        , index = layui.layer.open({
                        title: "查看服务详情",
                        type: 2,
                        content: "demand.update?" + id
                    });
                    layui.layer.full(index);
                }
                , examine_row: function () {
                    var id = $(this).data('id');
                    layer.confirm('请选择审核操作？', {
                            btn: ['通过', '不通过']
                        }, function (index) {
                            fetch.ajax('/demand.examine-' + id, {
                                'pass': 1,
                            }, function () {
                                gridInstance.reload();
                                layer.close(index);
                            })
                        }
                        , function () {
                            layer.prompt({title: '填写审核不通过理由，并确认', formType: 2}, function (pass, index) {
                                var load_index = layer.load(1, {
                                    shade: [0.5, '#fff']
                                });
                                fetch.ajax('/demand.examine-' + id, {
                                    'pass': 2,
                                    'reason': pass
                                }, function () {
                                    gridInstance.reload();
                                    layer.close(load_index);
                                    layer.close(index);
                                });
                            });
                        });
                }
                , show_no_pass_reason: function () {
                    var id = $(this).data('id');
                    fetch.ajax('/demand.get.reason-' + id, {}, function (data) {
                        layer.alert(data.reason)
                    })
                }
            }
        });

        /**
         * 获取表格选中的id
         * @returns {any[]}
         */
        function get_select_id() {
            var checkStatus = table.checkStatus('id'),
                data = checkStatus.data,
                ids = [];

            $.each(data, function (index, element) {
                ids.push(element.id);
            });

            return ids;
        }

        var active = {
            deleteSelect: function () { // 删除选中
                fetch.ajax('/demand.delete', {
                    id: get_select_id()
                }, function () {
                    reloadGrid();
                })
            },
            examineSelect: function () { // 审核选中
                fetch.ajax('/demand.examine', {
                    id: get_select_id()
                }, function () {
                    reloadGrid();
                })
            },
            refreshGrid: function () { // 刷新表格
                reloadGrid();
            }
        };

        var grid_action = {
            del_demand: function () { // 表格内删除一行
                var id = $(this).data('id');
                fetch.ajax('/demand.delete-' + id, {}, function () {
                    reloadGrid();
                });
            },
            examine: function () { // 审核表格内一行
                var id = $(this).data('id');
                fetch.ajax('/demand.examine-' + id, {}, function () {
                    reloadGrid();
                });
            }
        };

        $('.news_search .layui-btn').click(function (e) {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        $('.childrenBody').on('click', '.grid_tool_btn', function () {
            var type = $(this).data('type');
            grid_action[type] ? grid_action[type].call(this) : '';
        });
    });
})
;
