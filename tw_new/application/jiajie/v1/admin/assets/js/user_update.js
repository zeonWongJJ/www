layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'laydate', 'upload'], function () {
    var laydate = layui.laydate,
        form = layui.form,
        fetch = layui.fetch,
        upload = layui.upload,
        jQuery = $ = layui.jquery;

    $(function(){
        var href = window.location.href;
        var id = href.split('?')[1];

        $('#user_password').html('<input type="password" name="user_password" class="layui-input" placeholder="不填默认使用原密码">');
        $('#user_password2').html('<input type="password" name="user_password2" class="layui-input" placeholder="不填默认使用原密码">');

        fetch.ajax('/user.get-'+id, {}, function (res) {
            form.val("user_info", {
                "user_name": res.user_name
                ,"user_sex": res.user_sex
                ,"user_phone": res.user_phone
                ,"user_email": res.user_email
                ,"user_score": res.user_score
                ,"user_balance": res.user_balance
            });
        });

        form.on('submit(submit_user_info)', function (data) {

            var password = $('[name=user_password]').val();
            var password2 = $('[name=user_password2]').val();

            if (password == password2) {
                fetch.ajax('/user.update-' + id, data.field, function (res) {

                });
            } else {
                layer.msg('两次密码输入不一致');
            }
            return false;
        })
    });
});