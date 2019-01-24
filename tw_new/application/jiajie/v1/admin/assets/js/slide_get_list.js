layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch'], function () {
    var fetch = layui.fetch,
        layer = parent.layer || layui.layer,
        form = layui.form,
        jQuery = $ = layui.jquery;

    $(window).one("resize", function () {
        $('.ruleAdd_btn').click(function () {
            var index = layui.layer.open({
                title: "添加幻灯片",
                type: 2,
                content: "slide.insert",
                end: function () {
                    window.history.go(0)
                }
            });
            layui.layer.full(index);
        });
        $("#example-advanced").on('click', '.update_slide_btn', function (data) {
            var index = layui.layer.open({
                title: "修改幻灯",
                type: 2,
                content: "slide.update?" + $(this).data('id'),
            });
            layui.layer.full(index);
        });
    }).resize();

    $(function () {
        // 获取总数
        fetch.ajax('/slide.count', {}, function (data) {
            var count = data._count;
            if (count > 0) {
                fetch.ajax('/slide.list', {
                    'rows': count
                }, function (data) {
                    var list = data;
                    $('#main_table').html(initTable(list));
                    form.render();
                    window.$('#example-advanced').treetable();
                });
            }
        });


        $("#example-advanced").on('click', '.delete_slide_btn', function () {
            var id = $(this).data('id');
            var index = layui.layer.msg('加载中', {
                icon: 16
                , shade: 0.01
            });
            var pic = '';
            fetch.ajax('/slide.get-'+id, {}, function (res) {
                pic = res.slide_img_url
            })

            fetch.ajax('/slide.delete-' + id, {}, function (res, error) {
                sessionStorage.removeItem('nav_bar_str');
                layui.layer.close(index);
                window.history.go(0);

                if (error == 0) {
                    fetch.ajax('/slide.remove.image', {'remove_path':pic}, function (res) {

                    });
                }
            })
        });
    });


    var tableData = '';

    function initTable(data) {
        data.forEach(function (current) {

            switch (current.slide_type) {
                case '0':
                    current.slide_type = '首页轮播';
                    break;
            }

            tableData += '<tr data-tt-id="' + current.id + '"';
            if (current.parent_id > 0) {
                tableData += 'data-tt-parent-id="' + current.parent_id + '"';
            }
            tableData += '>';
            tableData += '<td>' + current.slide_name + '</td>';
            tableData += '<td>' + current.slide_href + '</td>';
            tableData += '<td><img src="' + window.config.api_prefix + '/' + current.slide_img_url + '" width="80"/></td>';
            tableData += '<td>' + renderSwitch(current.slide_show, 'slide_show', current.id) + '</td>';
            tableData += '<td>' + current.slide_type +'</td>';
            tableData += '<td>' + renderBtnGroup(current.id) + '</td>';
            tableData += '</tr>';
        });
        return tableData;
    }

    /**
     * 根据状态渲染一个开关控件
     * @param state
     * @returns {string}
     */
    function renderSwitch(state, name, id) {
        var open_or_close = state == 1 ? 'checked' : '';
        var switch_str = '<div class="layui-input-block">\n' +
            '      <input ' + open_or_close + ' type="checkbox" id="' + id + '" name="' + name + '" lay-skin="switch" lay-filter="change_status"  lay-text="ON|OFF">\n' +
            '    </div>';
        return switch_str;
    }

    form.on('switch(change_status)', function (data) {
        var id = data.elem.id;
        fetch.ajax('/slide.display', {id: id}, function (res) {

        })
    });

    function renderBtnGroup(id) {
        var button_str = '<button class="layui-btn layui-btn-normal layui-btn-xs update_slide_btn" data-id="' + id + '" style="height: 22px; line-height: 22px;">修改</button>';
        button_str += '<button class="layui-btn layui-btn-danger layui-btn-xs delete_slide_btn"  data-id="' + id + '" style="height: 22px; line-height: 22px;">删除</button>';
        return button_str;
    }

});
