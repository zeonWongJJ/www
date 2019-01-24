layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'utils'], function () {
    var table = layui.table,
        layer = parent.layer || layui.layer,
        form = layui.form,
        utils = layui.utils,
        $ = layui.jquery,
        grid = layui.grid,
        fetch = layui.fetch
        , tableIns
        , cols = [[ //表头
            {type: 'checkbox', fixed: 'left'}
            , {field: 'service_name', title: '服务标题'}
            // , {field: 'service_info', title: '服务内容', width: 120}
            , {field: 'service_remuneration', title: '服务费用', width: 120}
            , {field: 'service_address_name', title: '服务地址名称'}
            , {field: 'service_sold', title: '已售数量/人次', width: 220, sort: true}
            , {
                field: 'id', title: '操作', width: 180, fixed: 'right', templet: function (d) {
                    var str = '<a title="查看详情" href="javascript:void(0);" class="grid_action" data-type="show_detail" data-id="' + d.id + '"><i class="layui-icon layui-icon-list"></i></a>';
                    str += '<a title="删除服务" href="javascript:void(0);" style="color: #ff4365" class="grid_action" data-type="delete_detail" data-id="' + d.id + '"><i class="layui-icon layui-icon-close-fill"></i></a>';
                    if (d.service_is_show == 1) {
                        str += ' <i class="layui-icon layui-icon-ok" style="color: #4a82ff; font-size: 14px;">已审核</i>';
                    } else if (d.service_is_show == 2) {
                        str += '<a href="javascript:;" class="grid_action" data-type="show_no_pass_reason" data-id="' + d.id + '"><i class="layui-icon layui-icon-close" style="color: #FF5722; font-size: 14px;">已拒绝</i></a>';
                    } else {
                        str += '<a title="审核该需求" href="javascript:void(0);" class="grid_action" data-id="' + d.id + '" data-type="examine"><i class="layui-icon layui-icon-ok"></i></a>';
                    }
                    /* else {
                                        str += '<a href="javascript:;" class="grid_tool_btn" data-id="' + d.id + '" data-type="examine"><i class="layui-icon layui-icon-circle-dot" style="color:#FF5722; font-size: 14px;"> 审核该服务</i></a>';
                                    }*/
                    return str;
                }
            }
        ]];
    $(window).one("resize", function () {
        tableIns = grid.init(cols, '/service.list');
    }).resize();

    $(function () {
        $('[data-type=delete_all]').click(function () {
            fetch.ajax('/service.delete', {
                id: get_select_id()
            }, function () {
                tableIns.reload();
            });
        });
        utils.initPage({
            grid_active: {
                examine: function () { // 审核一条需求
                    var id = $(this).data('id');
                    layer.confirm('请选择审核操作？', {
                            btn: ['通过', '不通过']
                        }, function (index) {
                            fetch.ajax('/service.examine-' + id, {
                                'pass': 1,
                            }, function () {
                                tableIns.reload();
                                layer.close(index);
                            })
                        }
                        , function () {
                            layer.prompt({title: '填写审核不通过理由，并确认', formType: 2}, function (pass, index) {
                                var load_index = layer.load(1, {
                                    shade: [0.5, '#fff']
                                });
                                fetch.ajax('/service.examine-' + id, {
                                    'pass': 2,
                                    'reason': pass
                                }, function () {
                                    tableIns.reload();
                                    layer.close(load_index);
                                    layer.close(index);
                                });
                            });
                        });
                }
                , delete_detail: function () { // 删除一条服务
                    var id = $(this).data('id');
                    layer.confirm('确认删除服务？', {
                        btn: ['确认', '取消']
                    }, function () {
                        fetch.ajax('/service.delete-' + id, {}, function () {
                            tableIns.reload();
                        })
                    })
                }
                , show_detail: function () { // 显示一条详情
                    var id = $(this).data('id')
                        , index = layui.layer.open({
                        title: "查看服务详情",
                        type: 2,
                        content: "service.update?" + id
                    });
                    layui.layer.full(index);
                }
                , show_no_pass_reason: function () { // 获取审核未通过理由
                    var id = $(this).data('id')

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

        /**
         * 数据表格事件集
         * @type {{examine: examine}}
         */
        var grid_active = {
            show_no_pass_reason: function () {
                var id = $(this).data('id');
                var load_index = layer.load(1, {
                    shade: [0.5, '#fff']
                });
                fetch.ajax('/service.nopass.reason-' + id, {}, function (data) {
                    layer.close(load_index);
                    layer.alert(data.reason, {icon: 6});
                });
            }
            , service_details: function () { // todo::显示指定服务详情

            }
        };

        /**
         * 页面事件集
         * @type {{examineSelect: examineSelect}}
         */
        var page_active = {
            examineSelect: function () { // 审核选中
                // 获取选中id，并过滤已被拒绝的
                var checkStatus = table.checkStatus('id'),
                    data = checkStatus.data,
                    ids = [];

                $.each(data, function (index, element) {
                    element.service_is_show == 0 && ids.push(element.id);
                });

                fetch.ajax('/service.examine', {
                    id: ids
                }, function () {
                })
            },
        };

        $('body').on('click', '.grid_tool_btn', function () {
            var type = $(this).data('type');
            grid_active[type] ? grid_active[type].call(this) : '';
        });

        $('.page_active').click(function () {
            var type = $(this).data('type');
            page_active[type] ? page_active[type].call(this) : '';
        });
    });
});