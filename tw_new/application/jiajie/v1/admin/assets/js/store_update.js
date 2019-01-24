layui.config({
    base: "assets/js/modules/"
}).use(['form', 'fetch', 'store.common'], function () {
    var $ = layui.jquery,
        form = layui.form,
        fetch = layui.fetch,
        href = window.location.href,
        id = href.split('?')[1];


    $(function () {
        fetch.ajax('/store.get-' + id, {}, function (data) {
            $.each(data, function (key, value) {
                if (key === 'store_state') {
                    $('input[name=store_status][value=' + value + ']').attr('checked', true);
                } else if (key === 'store_info') {
                    $('[name='+key+']').html(value);
                }
                $('input[type=text][name=' + key + ']').val(value);
            });
            form.render();
            // 显示身份证
            $('#store_id_card_positive').html(
                '<li>' +
                render_img_box('store_id_card_positive', data.store_id_card_positive)
                + '</li>'
            );
            $('#store_id_card_opposite').html(
                '<li>' +
                render_img_box('store_id_card_opposite', data.store_id_card_opposite)
                + '</li>'
            );
            $('#upload_id_card_block').show();
            // 显示资质认证图片
            $('#store_zizhi_positive').html(
                '<li>' +
                render_img_box('store_zizhi_positive', data.store_zizhi_positive)
                + '</li>'
            );
            $('#store_zizhi_opposite').html(
                '<li>' +
                render_img_box('store_zizhi_opposite', data.store_zizhi_opposite)
                + '</li>'
            );
            $('#upload_zzrz_block').show();
            // 店铺图片
            var store_pic = data.store_pic;
            if (store_pic) {
                $.each(store_pic, function (index, item) {
                    $('#store_pic').append(
                        '<li>' +
                        render_img_box('store_pic', item)
                        + '</li>'
                    );
                });
                $('#upload_store_pic_review').show();
            }
        });
    });

    // 提交按钮事件
    form.on("submit(post_store)", function (data) {
        var field = get_field(data);
        fetch.ajax('/store.update-' + id, field, function () {
            parent.layer.closeAll();
        });
        // post_form('update', data, fetch);
    });
});