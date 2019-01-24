layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element', 'utils'], function () {
    var form = layui.form,
        grid = layui.grid,
        table = layui.table,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        jQuery = $ = layui.jquery;

    $(function () {
        $('body').on('click', '.edit_btn', function () {
            var inputDOM = $(this).parent().find('input[name=cate_sort]:first'),
                sortNumber = inputDOM.val(),
                cateId = inputDOM.data('id');
            fetch.ajax('/category.update.sort-' + cateId, {
                sort: sortNumber
            }, function () {
                window.history.go(0);
            })
        }).on('focus', 'input[name=cate_sort]', function () {
            $(this).parents('div').find('.edit_btn').hide();
            var btnDOM = $(this).parent().find('.edit_btn:first');
            btnDOM.show();
        });


        utils.initPage({
            page_active: {
                add_category: function () { // 新增分类
                    var index = layui.layer.open({
                        title: "新增分类",
                        type: 2,
                        content: "category.insert",
                        end: function () {
                            window.history.go(0)
                        }
                    });
                    layui.layer.full(index);
                },
            }
            , grid_active: {
                update_item: function () {
                    var index = layui.layer.open({
                        title: "修改分类",
                        type: 2,
                        content: "category.update?" + $(this).data('id'),
                        end: function () {
                            window.history.go(0)
                        }
                    });
                    layui.layer.full(index);
                }
                , remove_item: function () {
                    var id = $(this).data('id'),
                        index = layer.confirm('确认删除？', {
                            btn: ['确定', '取消'] //按钮
                        }, function () {
                            fetch.ajax('/category.delete-' + id, {}, function (data) {
                                layer.close(index);
                                window.history.go(0);
                            });
                        })
                }
            }
        });

        function initTable() {
            fetch.ajax('/category.list', {
                'data-set': 'tree',
                // 'condition': {
                //     'is_menu': 1
                // }
                sort: {
                    cate_sort: 'desc',
                    id: 'desc'
                }
            }, function (data) {
                _makeGrid(data);
                window.$('#example-advanced').treetable();
                form.render();
            });
        };

        var grid_dom = '';

        function _makeGrid(data) {
            $.each(data, function (index, element) {
                var has_child = undefined != element.children;

                grid_dom = '<tr data-tt-id="' + element.id + '"';
                grid_dom += element.parent_id == 0 ? '' : 'data-tt-parent-id="' + element.parent_id + '"';
                grid_dom += '>';
                grid_dom += '<td>' + element.cat_name + '</td>';
                grid_dom += '<td>' + renderIsShow(element.cate_is_show, element.id) + '</td>';
                grid_dom += '<td>' + renderCateSort(element.cate_sort, element.id) + '</td>';
                grid_dom += '<td>' + renderPayWay(element.pay_type) + '</td>';
                grid_dom += '<td>' + renderBtnGroup(element.id) + '</td>';
                grid_dom += '</tr>';

                $('#main_table').append(grid_dom);
                if (has_child) {
                    _makeGrid(element.children);
                }
            });
        };

        function renderCateSort(cate_sort, id) {
            var inputDOM = '<div>\n' +
                '    <div>\n' +
                '      <input style="float:left;" type="text" data-id="' + id + '" class="cate_sort" name="cate_sort" value="' + cate_sort + '" placeholder="排序数值，越大排序越靠前">\n' +
                '      <div style="float: left; margin-top: 5px; display: none" class="layui-btn layui-btn-xs edit_btn">修改</div>' +
                '    </div>\n' +
                '  </div>';
            return inputDOM;
        }

        function renderBtnGroup(id) {
            var button_str = '<a style="color: #FF0000;" href="javascript:;" class="grid_action" data-id="' + id + '" data-type="update_item"> 修改</a>';
            button_str += '<a href="javascript:;" class="grid_action" data-id="' + id + '" data-type="remove_item"> 删除</a>';
            return button_str;
        };

        function renderPayWay(type) {
            var way_name = type == '1' ? '按时收费' : '按次收费',
                badge_color = type == '1' ? 'green' : 'cyan';
            return '<span style="padding: 2px 4px;" class="layui-badge layui-bg-' + badge_color + '">' + way_name + '</span>';
        }

        function renderIsShow(isShow, id) {
            var isChecked = isShow == 1 ? 'checked' : '';
            return ' <div class="layui-input-block">\n' +
                '      <input data-id="' + id + '" type="checkbox" name="switch" lay-filter="change_show" lay-skin="switch" ' + isChecked + '>\n' +
                '    </div>';
        }

        initTable();
    });

    form.on('switch(change_show)', function (data) {
        var id = $(this).data('id');
        fetch.ajax('/category.change.show-' + id, {}, function (res) {
            console.log(res);
        });
    });
});
