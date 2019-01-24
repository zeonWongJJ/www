layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'utils'], function () {
    var $ = layui.jquery,
        form = layui.form,
        layer = layui.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        grid = layui.grid,
        gridInstance,
        cols = [[
            {field: 'id', title: '店铺编号'}
            , {field: 'store_name', title: '名称', width: 200}
            , {field: 'store_address', title: '地址'}
            , {
                field: 'store_linkman', title: '联系人', width: 250, templet: function (d) {
                    return d.store_director + ':' + d.store_phone
                }
            }
            , {
                field: 'store_state', title: '启用/暂用', width: 120, templet: function (d) {
                    var checked = '';
                    switch (parseInt(d.store_status)) {
                        case 1:
                            checked = 'checked';
                            break;
                        case 2:
                        case 0:
                        default:
                            checked = '';
                            break;
                    }
                    return '<input type="checkbox" name="store_state" lay-skin="switch" data-id="' + d.id + '" lay-filter="change_state" lay-text="ON|OFF" ' + checked + '>';
                }
            }
            , {
                field: 'id', title: '操作', width: 160, fixed: 'right', templet: function (d) {
                    var str = '<a href="javascript:;" data-type="delete_item" data-id="' + d.id + '" class="grid_action"><i class="layui-icon layui-icon-delete"></i></a>';
                    str += '<a href="javascript:;" class="grid_action" data-type="update_item" data-id="' + d.id + '" class="grid_action"><i class="layui-icon layui-icon-edit"></i></a>';
                    str += '<a style="margin-right: 5px;" title="店铺订单结算设置" href="javascript:;" class="grid_action" data-type="settlement_setting" data-id="' + d.id + '" class="grid_action"><i class="layui-icon layui-icon-set"></i></a>';
                    if (d.store_status == 0) {
                        str += '<a href="javascript:;" class="grid_action" data-type="shenhe_item" data-id="' + d.id + '" class="grid_action"><i class="layui-icon layui-icon-ok"></i></a>';
                    } else if (d.store_status == 1) {
                        str += '<span style="color: #089118">已通过</span>'
                    } else if (d.store_status == -1) {
                        str += '<span style="color: #913022">已拒绝</span>'
                    } else if (d.store_status == 2) {
                        str += '<span style="color: #913022">已关闭</span>'
                    }
                    return str;
                }
            }
        ]];

    $(window).one('resize', function () {
        gridInstance = grid.init(cols, '/store.list', {
            condition: {
                'a.store_parent_id': 0
            }
        });
        // form.render();
    }).resize();

    $(function () {
        $('.advancedOptions dd').mouseover(function () {
            $(this).find('.show_box').show();
        }).mouseout(function () {
            $(this).find('.show_box').hide();
        });
        utils.initPage({
            grid_active: {
                show_licence: function () {
                    var licence_img_src = $(this).data('licence');
                    window.open(window.config.api_prefix + '/' + licence_img_src);
                },
                update_item: function () {
                    var id = $(this).data('id'),
                        index = layui.layer.open({
                            title: "更新店铺",
                            type: 2,
                            content: "store.update?" + id,
                            end: function () {
                                window.history.go(0)
                            }
                        });
                    layui.layer.full(index);
                },
                delete_item: function () {
                    var id = $(this).data('id');
                    layer.confirm('确定要删除门店吗，此操作不可逆？', {
                        btn: ['确认', '取消'] //按钮
                    }, function () {
                        fetch.ajax('/store.delete-' + id, {}, function () {
                            layer.close(index);
                            gridInstance.reload()
                        })
                    });
                }
                , shenhe_item: function () {
                    var id = $(this).data('id');
                    layer.confirm('请选择审核操作？', {
                            btn: ['通过', '不通过']
                        }, function (index) {
                            fetch.ajax('/store.shenhe-' + id, {
                                pass: 1
                            }, function (data) {
                                gridInstance.reload();
                                layer.close(index);
                            })
                        }
                        , function () {
                            layer.prompt({title: '填写审核不通过理由，并确认', formType: 2}, function (pass, index) {
                                var load_index = layer.load(1, {
                                    shade: [0.5, '#fff']
                                });
                                fetch.ajax('/store.shenhe-' + id, {
                                    'pass': 2,
                                    'reason': pass
                                }, function () {
                                    layer.close(load_index);
                                    layer.close(index);
                                });
                                layer.close(load_index);
                                layer.close(index);
                            });
                        });
                }
                , settlement_setting: function () {
                    var id = $(this).data('id'),
                        index = layui.layer.open({
                            title: "店铺订单结算策略",
                            type: 2,
                            area: ['500px', '700px'],
                            content: "store.settlement?" + id,
                            end: function () {
                                window.history.go(0)
                            }
                        });
                }
            },
            page_active: {
                search_store_name: function () {
                    gridInstance.reload({
                        where: {
                            condition: {
                                'a.store_name': '%' + $('input[name=keywords]').val() + '%'
                            }
                        }
                    })
                }
                , add_store: function () {
                    var index = layui.layer.open({
                        title: "新增店铺",
                        type: 2,
                        content: "store.insert",
                        end: function () {
                            window.history.go(0)
                        }
                    });
                    layui.layer.full(index);
                }
                , filter_audit_status: function () {
                    var status = $(this).data('filter');
                    if (status !== 'all') {
                        var condition = {
                            'a.store_status': status
                        };
                    } else {
                        var condition = [];
                    }
                    gridInstance.reload({
                        where: {
                            condition: condition
                        }
                    })
                }
            }
        })
    });

    form.on('switch(change_state)', function (data) {
        var id = $(data.elem).data('id');

        fetch.ajax('/store.auditing-' + id, {}, function () {
            gridInstance.reload();
        }, function () {
            gridInstance.reload();
        });
    });
});
