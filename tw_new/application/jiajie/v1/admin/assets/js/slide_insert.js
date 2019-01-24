layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'laydate', 'upload'], function () {
    var laydate = layui.laydate,
    form = layui.form,
    fetch = layui.fetch,
    upload = layui.upload
    $ = jQuery = layui.jquery;

    laydate.render({
        elem: '#start_time', //指定元素
        type: 'datetime',
        format: 'yyyy-MM-dd HH:mm:ss'
    });

    laydate.render({
        elem: '#end_time', //指定元素
        type: 'datetime',
        format: 'yyyy-MM-dd HH:mm:ss'
    });

    form.on('submit(add_slide)', function (data) {
        fetch.ajax('/slide.add', data.field, function (res) {
            if (res.error == 1) {
                var pic = $('[name=slide_img_url]').val();

                fetch.ajax('/slide.remove.image', {'remove_path':pic}, function (res) {

                });
            }
        });
        return false;
    })

    var uploadInst = upload.render({
        elem: '#slide_img_url' //绑定元素
        ,url: window.config.api_prefix + '/upload.image' //上传接口
        ,headers: {
            'X-Token':  fetch.get_token(),
        }
        ,accept:'images'
        ,acceptMime: 'image/*'
        ,done: function(res){
            layer.msg(res.msg);
            if (res.error == 0) {
                var pic = res.data.path;

                $('[name=slide_img_url]').val(pic);
            }
        }
        ,error: function(){
            //请求异常回调
        }
        ,field:'image'
    });
});