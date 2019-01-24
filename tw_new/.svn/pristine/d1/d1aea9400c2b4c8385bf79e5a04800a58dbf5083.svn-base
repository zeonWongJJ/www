layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table'], function () {
    var $ = layui.jquery,
        layer = layui.layer,
        form = layui.form,
        fetch = layui.fetch,
        selectIds = [],
        href = window.location.href,
        id = href.split('?')[1];

    $(function () {
        getChecked();
        getListRows();

        var active = {
            allow_post: function () {
                var _selected = [];
                $.each($('input:checkbox:checked'),function() {
                    _selected.push($(this).val());
                });
                fetch.ajax('/auth.role.assign-' + id, {
                    assign_ids: _selected
                }, function (data) {
                    parent.layer.closeAll()
                });
            }
        };

        $('.page_action').click(function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });

    var _newmenus = [];

    function getListRows() {
        fetch.ajax('/auth.rule.list', {
            'rule_enable': 1,
            'limit': 99999
        }, function (data) {
            $.each(data, function (index, element) {
                _newmenus['id_' + element.id] = element;
            });

            console.log(_newmenus);
            initTreeGrid();
        })
    }

    function initTreeGrid() {
        fetch.ajax('/auth.rule.list', {
            'data-set': 'tree',
            'condition': {
                'rule_enable': 1
            }
        }, function (data) {
            _initTreeGrid(data);
            window.$('#example-advanced').treetable();
        })
    }

    /**
     * 初始化树形grid
     * @param data
     * @private
     */
    function _initTreeGrid(data) {
        $.each(data, function (index, element) {
            console.log(element)
            var has_child = undefined != element.children
                , grid_dom = '<tr data-tt-id="' + element.id + '"';
            grid_dom += element.parent_id == 0 ? '' : 'data-tt-parent-id="' + element.parent_id + '"';
            grid_dom += '>';
            grid_dom += '<td>' + before_rule_name(element.id) + '&nbsp;' + element.rule_name + '</td>';
            grid_dom += '</tr>';

            $('#main_table').append(grid_dom);
            if (has_child) {
                _initTreeGrid(element.children);
            }
        });
    }
    
    function getChecked() {
        fetch.ajax('/auth.role.assigned-' + id, {}, function (data) {
            selectIds = data;
        })
    }

    function before_rule_name(id) {
        var checked = $.inArray(id, selectIds) > -1 ? 'checked' : ''
            , checkbox = '<input onclick="checknode(this);" level="' + _get_level(id) + '" '+checked+' type="checkbox" name="rule_select_ids" value="' + id + '"/>';
        return checkbox;
    }

    function _get_level(id, i = 0) {
        if (_newmenus['id_' + id]['parentid'] == 0) {
            return i;
        } else {
            i++;
            return _get_level(_newmenus['id_' + id]['parentid'], i);
        }
    }
});
