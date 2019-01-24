layui.config({
    base: "assets/js/modules/"
}).use(['jquery', 'layer', 'fetch', 'grid', 'utils'], function () {
    var $ = layui.jquery
        , grid = layui.grid
        , fetch = layui.fetch
        , form = layui.form
        , utils = layui.utils
        , cols = [[ //表头
            {
                field: 'user_name', title: '用户', width: 150, templet:
                    function (d) {
                        var img = d.user_pic ? d.user_pic : 'static/style_default/images/tou_03.png',
                            str = '<img width="25" src="https://vdao-mobile.7dugo.com/' + img + '" style="margin-right: 15px;">';
                        str += d.user_name;

                        return str;
                    }
            }
            , {
                field: 'user_sex', title: '性別', width: 60, templet: function (d) {
                    var status = '';
                    switch (parseInt(d.user_sex)) {
                        case 1:
                            status = '男';
                            break;
                        case 2:
                            status = '女';
                            break;
                        default:
                            status = '未知';
                    }
                    return status;
                }
            }
            , {field: 'user_phone', title: '手机号码', width: 120}
            // , {field: 'user_email', title: '邮箱', width: 120}
            , {
                field: 'weixin_openid', title: '微信/QQ', align: 'center', width: 120, templet:
                    function (d) {
                        var wechat_icon_color = d.weixin_openid ? '#00d00b' : '#767676'
                            , qq_icon_color = d.qq_openid ? '#e91c2b' : '#767676'
                            ,
                            icon_status = '<i class="layui-icon layui-icon-login-wechat" style="color:' + wechat_icon_color + '"></i>';
                        icon_status += ' <i class="layui-icon layui-icon-login-qq" style="' + qq_icon_color + '"></i>';
                        return icon_status;
                    }
            }
            , {field: 'user_score', title: '积分', width: 80}
            , {field: 'user_balance', title: '余额', width: 80}
            , {
                field: 'user_state', title: '是否启用', width: 100, templet:
                    function (d) {
                        var str = '';
                        var open_or_close = d.user_state == 1 ? 'checked' : '';
                        str += '<input id="' + d.user_id + '"' + open_or_close + ' type="checkbox" name="user_state" lay-skin="switch" lay-filter="user_switch" lay-text="ON|OFF">';

                        return str;
                    }
            }
            , {
                field: 'id', title: '操作', width: 250, align: 'center', templet: function (d) {
                    var str = '';
                    str += '<a href="javascript:;" class="grid_tool_btn" data-type="update_user_btn" data-id="' + d.user_id + '" > 修改</a>';
                    str += '<a style="color: #ff2222;" href="javascript:;" class="grid_action" data-type="delete_user_btn" data-id="' + d.user_id + '"> 删除</a>';
                    str += '<a href="javascript:;" class="grid_action" data-type="show_user_jifen" data-url="' + window.config.root_url + 'user.show_jifen_list?' + d.user_id + '"><cite> 积分详情</cite></a>';
                    str += '<a href="javascript:;" class="grid_action" data-type="show_user_balance" data-url="' + window.config.root_url + 'user.show_balance_list?' + d.user_id + '"><cite> 余额详情</cite></a>';
                    return str;
                }
            }
        ]],
        gridInstance;

    form.on('switch(user_switch)', function (data) {
        var id = data.elem.id;
        fetch.ajax('/user.enable-' + id, {}, function () {
            gridInstance.reload();
        })
    });

    $(function () {
        gridInstance = grid.init(cols, '/member.list-user');

        utils.initPage({
            grid_active: {
                show_user_jifen: function () { // 积分详情
                    parent.addTab($(this));
                },
                show_user_balance: function () { // 余额详情
                    parent.addTab($(this));
                },
                update_user_btn: function () { // 更新用户
                    var index = layui.layer.open({
                        title: "修改用户",
                        type: 2,
                        content: "user.update?" + $(this).data('id'),
                        end: function () {
                            gridInstance.reload();
                        }
                    });
                    layui.layer.full(index);
                },
                delete_user_btn: function () { // 删除用户
                    var id = $(this).data('id');
                    layer.confirm('确定要删除用户吗，此操作不可逆？', {
                        btn: ['确认', '取消'] //按钮
                    }, function () {
                        // layer.msg('的确很重要', {icon: 1});
                        fetch.ajax('/user.delete-' + id, {}, function (data) {
                            layer.msg('删除成功', {icon: 1});
                            gridInstance.reload();
                        });
                    });
                }
            }
        })
        /*$('body').on('click', '.update_user_btn', function (data) {
            var index = layui.layer.open({
                title: "修改用户",
                type: 2,
                content: "user.update?" + $(this).data('id'),
                end: function () {
                    gridInstance.reload();
                }
            });
            layui.layer.full(index);
        });*/

        /*$('body').on('click', '.jifen_user_btn', function (data) {
            var index = layui.layer.open({
                title: "积分详情",
                type: 2,
                content: "user.jifen.list?124",
                // + $(this).data('id')
            });
            layui.layer.full(index);
        });

        $('body').on('click', '.delete_user_btn', function () {
            var id = $(this).data('id');
            var index = layui.layer.msg('加载中', {
                icon: 16
                , shade: 0.01
            });
            fetch.ajax('/user.delete-' + id, {}, function () {
                sessionStorage.removeItem('nav_bar_str');
                layui.layer.close(index);
                window.history.go(0);
            })
        });*/
    });
});
