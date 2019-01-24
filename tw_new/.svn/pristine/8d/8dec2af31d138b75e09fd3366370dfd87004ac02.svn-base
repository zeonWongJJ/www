layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'utils'], function () {
    var $ = layui.jquery,
        fetch = layui.fetch,
        utils = layui.utils,
        form = layui.form;

    $(function () {
        init_config();
        utils.initPage({
            page_active: {
                update_level: function () {
                    var index = layui.layer.msg('加载中', {
                        icon: 16
                        , shade: 0.01
                    });
                    fetch.ajax('/store.update.level', {
                        section: $('input[name=store_level_section]').val()
                    }, function () {
                        layer.close(index);
                        init_config();
                    })
                }
            }
        });
        form.on('switch(config)', function (data) {
            var switch_key = $(data.elem).attr('name'),
                checked = data.elem.checked,
                setValue = checked ? 'true' : 'false';

            fetch.ajax('/config.setting-' + switch_key, {
                config_value: setValue
            }, function () {
                init_config();
            });
        });
        form.on('submit(set_config)', function(data){
            var field = data.field;
            fetch.ajax('/config.setting', {
                item: field
            }, function (data) {

            });
        });

        /**
         * 初始化配置项
         */
        function init_config() {
            var load_index = layer.load(1, {
                shade: [0.5, '#fff']
            });
            $('#string_type_config').html('');
            $('#bool_type_config').html('');
            fetch.ajax('/config.count', {
                config_enable: 1
            }, function (data) {
                var count = data._count;
                fetch.ajax('/config.list', {
                    rows: count
                }, function (data) {
                    $.each(data, function (index, element) {
                        if (element.config_var_type == 'string') {
                            $('#string_type_config').append(render_string_config_input(element.config_key, element.config_value, element.config_info, element.config_remark));
                        } else if (element.config_var_type == 'bool') {
                            $('#bool_type_config').append(render_bool_config_input(element.config_key, element.config_value, element.config_info));
                        } /*else {
                            if (element.config_key == 'open_demand_examine' || element.config_key == 'open_service_examine') {
                                $('input[name=' + element.config_key + ']').attr('checked', element.config_value == 1);
                            } else if (element.config_key == 'store_level_section') {
                                $('input[name=' + element.config_key + ']').val(element.config_value)
                            }
                        }*/
                    });
                    layer.close(load_index);
                    form.render();
                });
            });
        }

        /**
         * 渲染一个文本输入框
         * @param name
         * @param value
         * @param remark
         * @returns {string}
         */
        function render_string_config_input(name, value, remark, _remark) {
            return '<div class="layui-form-item">\n' +
                '        <label class="layui-form-label">' + remark + '</label>\n' +
                '        <div class="layui-input-block">\n' +
                '          <input type="text" name="' + name + '" value="' + value + '" class="layui-input">\n' +
                '          <span style="color: #ff2222"> * '+_remark+'</span>' +
                '        </div>\n' +
                '      </div>';
        }

        function render_bool_config_input(name, value, remark) {
            var checked = value === 'true' ? 'checked' : '';
            return '<div class="layui-col-xs3 sys_config_item">\n' +
            '                                <div class="grid-demo grid-demo-bg1 sys_config_inner">\n' +
            '                                    <p class="sys_config_title">'+remark+'</p>\n' +
            '                                    <input '+checked+' type="checkbox" name="'+name+'" lay-skin="switch" lay-filter="config" lay-text="ON|OFF">\n' +
            '                                </div>\n' +
            '                            </div>';
        }
    });
});