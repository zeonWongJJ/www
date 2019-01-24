layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'grid', 'utils'], function () {
    var grid = layui.grid
        , form = layui.form
        , fetch = layui.fetch
        , layer = parent.layer || layui.layer
        , $ = layui.$
        , utils = layui.utils
        , gridInstance

        , cols = [[
        /*{type: 'checkbox', fixed: 'left'}
        ,*/ {field: 'user_name', title: '账号'}
        , {field: 'user_nicename', title: '姓名'}
        , {
            field: 'user_sex', title: '性别', templet: function (d) {
                if (d.user_sex == 1) {
                    return '男';
                } else if (d.user_sex == 2) {
                    return '女';
                } else {
                    return '未知';
                }
            }
        }
        , {field: 'role_name', title: '管理员角色'}
        , {field: 'user_phone', title: '手机号码'}
        , {field: 'user_email', title: '手机邮箱'}
        , {field: 'add_at', title: '添加时间'}
        , {
            field: 'is_enable', title: '启用/暂用', templet: function (d) {
                var checked = d.is_enable == 0 ? '' : 'checked';
                return '<input data-id="' + d.user_id + '" type="checkbox" lay-filter="change_admin_enable" name="is_enable" lay-skin="switch" ' + checked + '>';
            }
        }
        , {
            field: 'user_id', title: '操作', templet: function (d) {
                var action = '<a href="javascript:;" class="grid_action" data-id="' + d.user_id + '" data-type="delete_item"><i class="layui-icon layui-icon-delete"></i></a>';
                action += '<a href="javascript:;" class="grid_action" data-id="' + d.user_id + '" data-type="update_item"><i class="layui-icon layui-icon-edit"></i></a>';
                return action;
            }, fixed: 'right'
        }
    ]];

    $(window).resize(function () {
        gridInstance = grid.init(cols, '/admin.list');
    }).resize();

    $(function () {
        utils.initPage({
            page_active: {
                admin_add: function () {
                    var index = layui.layer.open({
                        title: "新增管理员",
                        type: 2,
                        content: "admin.insert",
                        end: function () {
                            gridInstance.reload();
                        }
                    });
                    layui.layer.full(index);
                }
            }
            , grid_active: {
                delete_item: function () {
                    var id = $(this).data('id');
                    layer.confirm('确认删除此用户吗？', {
                        btn: ['确认', '取消'] //按钮
                    }, function () {
                        fetch.ajax('/admin.delete-' + id, {}, function () {
                            parent.layer.closeAll();
                            gridInstance.reload();
                        });
                    })
                }
                , update_item: function () {
                    var id = $(this).data('id')
                        , index = layui.layer.open({
                        title: "修改管理员",
                        type: 2,
                        content: "admin.update?" + id,
                        end: function () {
                            gridInstance.reload();
                        }
                    });
                    layui.layer.full(index);
                }
            }
        })
    });

    /**
     * 监听滑动
     */
    form.on('switch(change_admin_enable)', function (data) {
        var id = $(this).data('id');
        fetch.ajax('/admin.enable-' + id, {}, function () {
            gridInstance.reload();
        });
    });
});