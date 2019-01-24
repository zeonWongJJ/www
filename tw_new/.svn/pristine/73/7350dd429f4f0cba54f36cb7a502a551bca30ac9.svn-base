layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'table', 'utils'], function () {
    var form = layui.form,
        grid = layui.grid,
        table = layui.table,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        jQuery = $ = layui.jquery,

        gridInstance,
        cols = [[
            {type: 'checkbox', fixed: 'left'}
            , {
                field: 'user_id', title: '用户', templet: function (d) {
                    var user_pic = d.user_pic == '' ? '/static/style_default/images/tou_03.png' : d.user_pic;
                    var str = '<img src="https://vdao-mobile.7dugo.com/' + user_pic + '" width="25" height="25" style="margin-right: 15px;">';
                    str += d.user_name;

                    return str;
                }
            }
            , {field: 'comment_content', title: '评论内容'}
            , {
                field: 'auditing_status', title: '审核状态', templet: function (d) {
                    var checked = d.auditing_status == 0 ? '' : 'checked';
                    return '<input data-id="' + d.comment_id + '" type="checkbox" lay-filter="change_comment_audit" name="auditing_status" lay-skin="switch" ' + checked + '>';
                }
            }, {
                field: 'id', title: '操作', width: 90, fixed: 'right', templet: function (d) {
                    var str = '<a href="javascript:;" class="grid_action" data-id="' + d.comment_id + '" data-type="delete_item"><i class="layui-icon layui-icon-delete"></i></a>';

                    return str;
                }
            }
        ]];

    $(window).one('resize', function () {
        gridInstance = grid.init(cols, '/comment.list');
        form.render();
    }).resize();

    $(function () {
        utils.initPage({
            grid_active: {
                delete_item: function () {
                    var id = $(this).data('id');
                    layer.confirm('确定要删除用户吗，此操作不可逆？', {
                        btn: ['确认', '取消'] //按钮
                    }, function () {
                        fetch.ajax('/comment.delete-' + id, {}, function () {
                            layer.close(index);
                            gridInstance.reload();
                        });
                    });
                }
            },
            page_active: {
                delete_all: function () { // 删除所有选中
                    var index = layui.layer.msg('加载中', {
                        icon: 16
                        , shade: 0.05
                    });
                    fetch.ajax('/comment.delete', {
                        id: get_selected_id()
                    }, function () {
                        layer.close(index);
                        gridInstance.reload();
                    });
                },
                audit_all: function () { // 审核选中
                    var index = layui.layer.msg('加载中', {
                        icon: 16
                        , shade: 0.01
                    });
                    fetch.ajax('/comment_update_auditing', {
                        id: get_selected_id(),
                        auditing_status: 1
                    }, function () {
                        layer.close(index);
                        gridInstance.reload();
                    });
                },
                filter_audit_status: function () {
                    var status = $(this).attr('data-filter');
                    if (status !== 'all') {
                        var condition = {
                            'a.auditing_status': status
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
            },
        });

        $('.advancedOptions dd').mouseover(function () {
            $(this).find('.show_box').show();
        }).mouseout(function () {
            $(this).find('.show_box').hide();
        });

        $('#user_name').blur(function () {
            var index = layui.layer.msg('加载中', {
                    icon: 16
                    , shade: 0.5
                }),
                val = $(this).val();
            if (!val) {
                gridInstance.reload({
                    where: {
                        condition: []
                    }, done: function () {
                        layer.close(index)
                    }
                });
            } else {
                var condition = [];
                if (utils.checkMobile(val)) {
                    condition = {
                        'b.user_phone': val
                    }
                } else {
                    condition = {
                        'b.user_name': val
                    }
                }

                gridInstance.reload({
                    where: {
                        condition: condition
                    }
                    , done: function () {
                        layer.close(index)
                    }
                })
            }
        });

        /**
         * 获取表格选中的id
         * @returns {any[]}
         */
        function get_selected_id() {
            var checkStatus = table.checkStatus('id'),
                data = checkStatus.data,
                ids = [];

            $.each(data, function (index, element) {
                ids.push(element.comment_id);
            });

            return ids;
        }
    });

    /**
     * 监听滑动
     */
    form.on('switch(change_comment_audit)', function (data) {
        var id = $(this).data('id');
        fetch.ajax('/comment.auditing-' + id, {
            'auditing_status': data.elem.checked ? 0 : 1
        }, function () {
            gridInstance.reload();
        });
    });
});