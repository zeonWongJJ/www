layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch'], function () {
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        jQuery = $ = layui.jquery;

    $(window).one("resize", function () {
        $("#example-advanced").on('click', '.update_rule_btn', function (e) {
            var index = layui.layer.open({
                title: "修改规则",
                type: 2,
                content: "rule.update?" + $(this).data('id'),
                end: function () {
                    window.history.go(0)
                }
            });
            layui.layer.full(index);
        });
    }).resize();

    $(function () {
        initTable();

        $('.ruleAdd_btn').click(function () {
            var index = layui.layer.open({
                title: "新增规则",
                type: 2,
                content: "rule.insert",
                end: function () {
                    window.history.go(0)
                }
            });
            layui.layer.full(index);
        });

        // 移除规则
        $('#example-advanced').on('click', '.update_remove_btn', function () {
            var index = layui.layer.msg('加载中', {
                icon: 16
                , shade: 0.01
            });

            var id = $(this).data('id');
            fetch.ajax('/auth.rule.delete-' + id, {}, function () {
                sessionStorage.removeItem('nav_bar_str');
                layui.layer.close(index);
                window.history.go(0);
            })
        })
    });

    /**
     * 规则开关监听
     */
    form.on('switch(rule_switch)', function (data) {
        var id = $(data.elem).data('id')
            , index = layui.layer.msg('加载中', {
            icon: 16
            , shade: 0.01
        });
        fetch.ajax('/auth.rule.enable-' + id, {}, function () {
            sessionStorage.removeItem('nav_bar_str');
            layui.layer.close(index)
        })
    });

    function initTable() {
        fetch.ajax('/auth.rule.list', {
            'data-set': 'tree',
            // 'condition': {
            //     'is_menu': 1
            // }
        }, function (data) {
            _makeGrid(data);
            window.$('#example-advanced').treetable();
            form.render();
        });
    }

    var grid_dom = '';

    function _makeGrid(data) {
        $.each(data, function (index, element) {
            var has_child = undefined != element.children;

            grid_dom = '<tr data-tt-id="' + element.id + '"';
            grid_dom += element.parent_id == 0 ? '' : 'data-tt-parent-id="' + element.parent_id + '"';
            grid_dom += '>';
            grid_dom += '<td>' + element.rule_name + '</td>';
            // grid_dom += '<td>' + element.rule_controller + '</td>';
            // grid_dom += '<td>' + element.rule_action + '</td>';
            grid_dom += '<td>' + renderSwitch(element.rule_enable, 'rule_enable', element.id) + '</td>';
            grid_dom += '<td>' + renderBtnGroup(element.id) + '</td>';
            grid_dom += '</tr>';

            $('#main_table').append(grid_dom);
            if (has_child) {
                _makeGrid(element.children);
            }
        });
    }

    /**
     * 根据状态渲染一个开关控件
     * @param state
     * @returns {string}
     */
    function renderSwitch(state, name, id) {
        var open_or_close = state == 1 ? 'checked' : '';
        var switch_str = '<div class="layui-input-block">' +
            '<input data-id="' + id + '" ' + open_or_close + ' type="checkbox" name="' + name + '" lay-skin="switch" lay-filter="rule_switch" lay-text="ON|OFF">' +
            '</div>';
        return switch_str;
    }

    function renderBtnGroup(id) {
        var button_str = '<button class="layui-btn layui-btn-normal layui-btn-xs update_rule_btn" data-id="' + id + '" style="height: 22px; line-height: 22px;">修改</button>';
        button_str += '<button class="layui-btn layui-btn-danger layui-btn-xs update_remove_btn" data-id="' + id + '" style="height: 22px; line-height: 22px;">删除</button>';
        return button_str;
    }
});