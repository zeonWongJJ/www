layui.define(['layer', 'fetch', 'form', 'upload'], function (exports) {
    var $ = window.jQuery || layui.$
        , form = layui.form
        , fetch = layui.fetch
        , upload = layui.upload
        , common = {
        renderUpload: function () {
            upload.render({
                elem: '#upload_cate_img'
                , url: window.config.api_prefix + '/upload.image'
                , field: 'image'
                , headers: {
                    'X-Token': sessionStorage.getItem('user_token')
                    , 'X-SOURCE-SIGN': 'admin'
                }
                , done: function (res) {
                    var html = '<li>' +
                        render_img_box(res.data.path) +
                        '</li>';
                    $('#store_id_card_positive').html(html);
                    $('#upload_cate_ico_block').show();
                    $('input[name=cate_icon]').val(res.data.path);
                }
            });
        }
        , render: function (select_id) {
            fetch.ajax('/category.count', {}, function (res) {
                fetch.ajax('/category.list', {
                    rows: res._count,
                    field: 'cat_name as name, id, parent_id as parentid'
                }, function (res) {
                    if (res) {
                        fetch.ajax('utils.get.tree.options', {
                            source_data: res
                            , select_id: select_id
                        }, function (res) {
                            if (res.option) {
                                var options = '<option value="0">==作为一级菜单==</option>' + res.option;
                                $('#tree-box').html(options);
                                $('#tree-box').find('option').removeAttr('selected');
                                $('#tree-box').find('option[value=' + select_id + ']').attr('selected', true);
                                form.render();
                            }
                        })
                    }
                })
            });
        }
    }
    exports('cate_common', common);
});

/**
 * 渲染图片表格
 * @param img
 * @returns {string}
 */
function render_img_box(img) {
    var img_src = window.config.api_prefix + '/' + img
        , dom = '<div class="show_img_box">' +
        '<img data-src="' + img + '" src="' + img_src + '" width="90" height="90">' +
        '<div class="fuck_img_what">' +
        '<a href="javascript:;" title="点击删除" class="grid_action" data-type="remove_img_item"><i class="layui-icon layui-icon-delete"></i></a>' +
        '<a href="javascript:;" title="点击放大" class="grid_action" data-type="show_big_img"><i class="layui-icon layui-icon-picture-fine"></i></a></div>' +
        '</div>';

    return dom;
}
