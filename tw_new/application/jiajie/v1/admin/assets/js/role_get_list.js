layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table'], function () {
    var $ = layui.jquery,
        layer = layui.layer,
        form = layui.form,
        fetch = layui.fetch;


    $(function () {
        initGrid(); // 加载数据

        /**
         * 页面事件
         * @type {{role_add: role_add}}
         */
        var page_active = {
            role_add: function () { // 新增角色组
                var index = layui.layer.open({
                    title: "新增角色组",
                    type: 2,
                    content: "role.insert",
                    end: function () {
                        initGrid();
                    }
                });
                layui.layer.full(index);
            },
            refresh_grid: function () { // 重载一次表格
                window.location.reload();
            }
        };

        /**
         * 表格事件
         * @type {{grid_update: grid_update}}
         */
        var grid_active = {
            grid_update: function () { // 修改一条记录
                // 判断是否操作
                var can_action = $(this).hasClass('layui-btn-disabled');
                if (!can_action) {
                    var index = layui.layer.open({
                        title: "修改角色组",
                        type: 2,
                        content: "role.update?" + $(this).data('id'),
                        end: function () {
                            window.location.reload();
                        }
                    });
                    layui.layer.full(index);
                } else {
                    layer.msg('不能操作');
                }
            },

            grid_delete: function () {
                var can_action = $(this).hasClass('layui-btn-disabled');
                if (!can_action) {
                    var id = $(this).data('id');
                    layer.confirm('确认操作?', {icon: 3, title: '提示'}, function (index) {
                        fetch.ajax('/auth.role.delete-' + id, {}, function () {
                            layer.close(index);
                            window.location.reload();
                        })
                    })
                } else {
                    layer.msg('不能操作');
                }
            },

            grid_allow_rule: function () {
                var can_action = $(this).hasClass('layui-btn-disabled');
                if (!can_action) {
                    var id = $(this).data('id'),
                        index = layui.layer.open({
                            title: "分配权限",
                            type: 2,
                            content: "role.allow?" + id
                        });
                    layui.layer.full(index);
                } else {
                    layer.msg('不能操作');
                }
            }
        };

        $('.page_action').click(function () {
            var type = $(this).data('type');
            page_active[type] ? page_active[type].call(this) : '';
        });

        $('#example-advanced').on('click', '.grid_action', function () {
            var type = $(this).data('type');
            grid_active[type] ? grid_active[type].call(this) : '';
        });
    });


    function initGrid() {
        var loadLayer = layer.load(1);
        fetch.ajax('/auth.role.list', {
            'data-set': 'tree'
        }, function (data) {
            $('#main_table').html('');

            _initGridDOM(data);
            window.$('#example-advanced').treetable();

            form.render();
            layer.close(loadLayer);
        });
    }

    /**
     * 递归生成表格
     * @param data
     * @private
     */
    function _initGridDOM(data) {
        $.each(data, function (index, element) {
            if (element.id == 1) {
                return true;
            }
            var _gridDOM = '<tr data-tt-id="' + element.id + '"',
                has_child = typeof element.children != "undefined";

            _gridDOM += element.parent_id == 0 ? '' : 'data-tt-parent-id="' + element.parent_id + '"';
            _gridDOM += '>';
            _gridDOM += '<td>' + element.role_name + '</td>';
            _gridDOM += '<td>' + element.role_info + '</td>';
            _gridDOM += '<td>' + renderSwitch(element, 'rule_enable', element.id) + '</td>';
            _gridDOM += '<td>' + renderBtnGroup(element) + '</td>';
            _gridDOM += '</tr>';

            $('#main_table').append(_gridDOM);

            if (has_child) {
                _initGridDOM(element.children);
            }
        });
    }

    /**
     * 根据状态渲染一个开关控件
     * @returns {string}
     * @param row
     * @param name
     * @param id
     */
    function renderSwitch(row, name, id) {
        var open_or_close = row.role_status == 1 ? 'checked' : '',
            disabled = row.can_del == 1 ? '' : 'disabled';
        var switch_str = '<div class="layui-input-block">' +
            '<input ' + disabled + ' data-id="' + id + '" ' + open_or_close + ' type="checkbox" name="' + name + '" lay-skin="switch" lay-filter="role_switch" lay-text="ON|OFF">' +
            '</div>';
        return switch_str;
    }

    /**
     * 渲染表格操作按钮
     * @param id
     * @returns {string}
     */
    function renderBtnGroup(row) {
        var disabled = row.can_del == 1 ? 'layui-btn-normal' : 'layui-btn-disabled'
            , button_str = '<button class="layui-btn layui-btn-xs grid_action ' + disabled + '" data-type="grid_update" data-id="' + row.id + '" style="height: 22px; line-height: 22px;">修改</button>';
        // button_str += '<button class="layui-btn layui-btn-xs grid_action ' + disabled + ' " data-type="grid_allow_rule" data-id="' + row.id + '" style="height: 22px; line-height: 22px;">分配权限</button>';
        button_str += '<button class="layui-btn layui-btn-xs grid_action " data-type="grid_allow_rule" data-id="' + row.id + '" style="height: 22px; line-height: 22px;">分配权限</button>';
        button_str += '<button class="layui-btn layui-btn-danger layui-btn-xs grid_action ' + disabled + '" data-type="grid_delete" data-id="' + row.id + '" style="height: 22px; line-height: 22px;">删除</button>';
        return button_str;
    }

    /**
     * 规则开关监听
     */
    form.on('switch(role_switch)', function (data) {
        var id = $(data.elem).data('id');
        var index = layui.layer.msg('加载中', {
            icon: 16
            , shade: 0.01
        });
        fetch.ajax('/auth.role.enable-' + id, {}, function () {
            layui.layer.close(index)
        });
    });
});
