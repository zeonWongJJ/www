layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element', 'utils', 'tree', 'cate_common'], function () {
    var form = layui.form,
        grid = layui.grid,
        table = layui.table,
        cate_common = layui.cate_common,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        utils = layui.utils,
        tree = layui.tree,
        jQuery = $ = layui.jquery,

        href = window.location.href,
        id = href.split('?')[1];

    $(function () {
        initPage();
        cate_common.renderUpload();

        function initPage() {
            // initTreeSturct();
            fetch.ajax('/category.get-' + id, {}, function (data) {
                $.each(data, function (key, value) {
                    if (key === 'parent_id') {
                        $('select[name=parent_id] option[value=' + value + ']').attr('selected', true);
                    } else if (key === 'pay_type') {
                        $('input[name=pay_type][type=radio][value=' + value + ']').attr('checked', true);
                    } else {
                        $('input[name=' + key + ']').val(value)
                    }
                    $('#store_id_card_positive').html(
                        '<li>' +
                        render_img_box(data.cate_icon)
                        + '</li>'
                    );
                    $('#upload_cate_ico_block').show();

                });
                cate_common.render(data.parent_id);

                form.render();
            });
        }

        /**
         * 生成生成树形下拉菜单
         */
        function initTreeSturct() {
            fetch.ajax('/category.list', {
                'data-set': 'tree',
                field: 'parent_id, id, cat_name as name'
            }, function (data) {
                data.unshift({
                    'name': '==顶级分类==',
                    'id': 0
                });
                layui.tree({
                    elem: '#tree-options' //传入元素选择器
                    , nodes: data
                    , click: function (node) {
                        if (node.id != 0) {
                            fetch.ajax('/category.get-' + node.id, {}, function (data) {
                                $('input[name=pay_type][type=radio][value=' + data.pay_type + ']').attr('checked', true);

                            })
                        }
                        $('input[name=parent_id]').val(node.id);
                        $('input#parent_text').val(node.name);
                        form.render();
                    }
                });
                // $('#pid_contrainer').html('<option value="0">===作为顶级分类===</option>');
                // _initTreeSturct(data);
                // form.render();
            });
        }

        /**
         * 递归生成树形下拉菜单
         * @param data
         * @param level
         * @returns {string}
         * @private
         */
        function _initTreeSturct(data) {
            var _tree_struct_dom = '';
            $.each(data, function (index, element) {
                var has_child = undefined != element.children;
                _tree_struct_dom += '<option value="' + element.id + '">' + utils.repeat("--", parseInt(element.level)) + element.cat_name + '</option>';
                $('#pid_contrainer').append(_tree_struct_dom);
                if (has_child) {
                    _initTreeSturct(element.children);
                }
            });
        };
    });


    /**
     * 提交表单
     */
    form.on('submit(post_cate)', function (data) {
        fetch.ajax('/category.update-' + id, data.field, function () {
            parent.layer.closeAll();
        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});
