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
        var submit_button = '<button class="layui-btn" lay-submit lay-filter="edit_slide">修改幻灯</button>';
        var origin_pic = '';

        $('#submit_button').html(submit_button);

        fetch.ajax('/slide.get-'+id, {}, function (res) {
            if (res.slide_show_start_time == '0') {
                res.slide_show_start_time = '';
            }

            if (res.slide_show_end_time == '0') {
                res.slide_show_end_time = '';
            }
            form.val("updata-info", {
                "slide_name": res.slide_name
                ,"slide_sort": res.slide_sort
                ,"slide_href": res.slide_href
                ,"slide_type": res.slide_type
                ,"slide_show": res.slide_show
                ,"slide_show_start_time": res.slide_show_start_time
                ,"slide_show_end_time": res.slide_show_end_time
                ,"slide_img_url": res.slide_img_url
            });

            origin_pic = res.slide_img_url;
        });

        form.on('submit(edit_slide)', function (data) {
            fetch.ajax('/slide.update-' + id, data.field, function (res, error) {
                var pic = $('[name=slide_img_url]').val();

                if (error == 0 && pic != origin_pic) {
                    //数据修改成功，且已经修改了图片，把原图片删除
                    fetch.ajax('/slide.remove.image', {'remove_path':origin_pic}, function (res, error) {
                        if (error == 0) {
                            origin_pic = pic;
                        }
                    });
                } else if(error == 1 && pic != origin_pic) {
                    //数据修改不成功，且修改了图片，把新上传的图片删除
                    fetch.ajax('/slide.remove.image', {'remove_path':pic}, function (res) {

                    });
                }
            });
            return false;
        })
    });

    var uploadInst = upload.render({
        elem: '#slide_img_url' //绑定元素
        ,url: window.config.api_prefix + '/upload.image' //上传接口
        ,headers: {
            'X-Token':  fetch.get_token(),
        }
        ,accept:'images'
        ,acceptMime: 'image/*'
        ,done: function(res, index, upload){
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
});