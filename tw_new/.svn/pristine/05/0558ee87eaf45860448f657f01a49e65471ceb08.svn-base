layui.define(['layer', 'upload', 'utils'], function (exports) {
    var $ = layui.jquery,
        layer = layui.layer,
        utils = layui.utils,
        upload = layui.upload;

    $(function () {
        utils.initPage({
            grid_active: {
                show_big_img: function () {
                    console.log($(this))
                }
                , remove_img_item: function () {
                    var parents = $(this).parents('.show_img_box');
                    parents.parents('li').remove();
                }
            }
        })
    });
    // 身份证正面上传
    upload.render({
        elem: '#upload_id_card_zm'
        , url: window.config.api_prefix + '/upload.image'
        , field: 'image'
        , headers: {
            'X-Token': sessionStorage.getItem('user_token')
            , 'X-SOURCE-SIGN': 'admin'
        }
        , done: function (res) {
            var html = '<li>' +
                render_img_box('store_id_card_positive', res.data.path, 1) +
                '</li>';
            $('#store_id_card_positive').html(html);
            $('#upload_id_card_block').show();
        }
    });

    // 身份证反面上传
    upload.render({
        elem: '#upload_id_card_bm'
        , url: window.config.api_prefix + '/upload.image'
        , field: 'image'
        , headers: {
            'X-Token': sessionStorage.getItem('user_token')
            , 'X-SOURCE-SIGN': 'admin'
        }
        , done: function (res) {
            var html = '<li>' +
                render_img_box('store_id_card_opposite', res.data.path) +
                '</li>';
            $('#store_id_card_opposite').html(html);
            $('#upload_id_card_block').show();
        }
    });

    // 上传店铺图片
    upload.render({
        elem: '#upload_store_pic'
        , url: window.config.api_prefix + '/upload.image'
        , field: 'image'
        , multiple: true
        , number: 9
        , headers: {
            'X-Token': sessionStorage.getItem('user_token')
            , 'X-SOURCE-SIGN': 'admin'
        }
        , done: function (res) {
            var length = $('#store_pic').children('li').length
                , str = '<li>' +
                render_img_box('store_pic', res.data.path) +
                '</li>';

            if (length < 9) {
                $('#store_pic').append(str);
                $('#upload_store_pic_review').show();
            } else {
                layer.msg('最多允许上传9张图片');
                return false;
            }
        }
    });

    // 上传资质认证正面图片
    upload.render({
        elem: '#upload_zzrz_zm'
        , url: window.config.api_prefix + '/upload.image'
        , field: 'image'
        , multiple: true
        , number: 9
        , headers: {
            'X-Token': sessionStorage.getItem('user_token')
            , 'X-SOURCE-SIGN': 'admin'
        }
        , done: function (res) {
            var html = '<li>' +
                render_img_box('store_zizhi_positive', res.data.path) +
                '</li>';
            $('#store_zizhi_positive').html(html);
            $('#upload_zzrz_block').show();
        }
    });

    // 上传资质认证反面图片
    upload.render({
        elem: '#upload_zzrz_fm'
        , url: window.config.api_prefix + '/upload.image'
        , field: 'image'
        , multiple: true
        , number: 9
        , headers: {
            'X-Token': sessionStorage.getItem('user_token')
            , 'X-SOURCE-SIGN': 'admin'
        }
        , done: function (res) {
            var html = '<li>' +
                render_img_box('store_zizhi_opposite', res.data.path) +
                '</li>';
            $('#store_zizhi_opposite').html(html);
            $('#upload_zzrz_block').show();
        }
    });



    exports('store.common', {});
});

/**
 * 渲染图片表格
 * @param name
 * @param img
 * @returns {string}
 */
function render_img_box(name, img) {
    var img_src = window.config.api_prefix + '/' + img
        , dom = '<div class="show_img_box">' +
        '<img data-src="' + img + '" src="' + img_src + '" width="400" height="250">' +
        '<div class="fuck_img_what">' +
        '<a href="javascript:;" title="点击删除" class="grid_action" data-type="remove_img_item"><i class="layui-icon layui-icon-delete"></i></a>' +
        '<a href="javascript:;" title="点击放大" class="grid_action" data-type="show_big_img"><i class="layui-icon layui-icon-picture-fine"></i></a></div>' +
        '</div>';

    return dom;
}

/**
 * 计算请求参数
 * @param data
 */
function get_field(data) {
    var field = data.field;
    // field += '&store_id_card_positive='+ $('#store_id_card_positive').find('img').eq(0).attr('src').replace(window.config.api_prefix, '');

    // 获取店铺负责人身份证图片
    field.store_id_card_positive = $('#store_id_card_positive').find('img').eq(0).data('src');
    field.store_id_card_positive && field.store_id_card_positive.replace(window.config.api_prefix, '');
    field.store_id_card_opposite = $('#store_id_card_opposite').find('img').eq(0).data('src');
    field.store_id_card_opposite && field.store_id_card_opposite.replace(window.config.api_prefix, '');

    // 获取店铺资质认证图片
    field.store_zizhi_positive = $('#store_zizhi_positive').find('img').eq(0).data('src');
    field.store_zizhi_positive && field.store_zizhi_positive.replace(window.config.api_prefix, '');
    field.store_zizhi_opposite = $('#store_zizhi_opposite').find('img').eq(0).data('src');
    field.store_zizhi_opposite && field.store_zizhi_opposite.replace(window.config.api_prefix, '');

    field.store_pic = [];
    var store_pic = $('#store_pic').find('li');
    store_pic.length > 0 && $.each(store_pic, function (index, element) {
        field.store_pic.push(
            $(element).find('img').eq(0).data('src').replace(window.config.api_prefix, '')
        );
    });
    delete(field.image);
    return field;
    // fetch.ajax('/store.' + type + '-admin', field, function (rs) {
    //     parent.layer.closeAll();
    // }, 'post')
}
