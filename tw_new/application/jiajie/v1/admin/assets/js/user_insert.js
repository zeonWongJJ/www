layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'laydate', 'upload'], function () {
    var laydate = layui.laydate,
        form = layui.form,
        fetch = layui.fetch,
        upload = layui.upload,
        jQuery = $ = layui.jquery;

    form.on('submit(submit_user_info)', function (data) {
        var password = $('[name=user_password]').val();
        var password2 = $('[name=user_password2]').val();

        if (password == password2) {
            fetch.ajax('/user.add', data.field, function (res) {

            });
        } else {
            layer.msg('两次密码输入不一致');
        }
        return false;
    })
});