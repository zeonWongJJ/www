layui.define(['layer', 'fetch', 'form'], function (exports) {
    var $ = window.jQuery || layui.$
        , form = layui.form
        , fetch = layui.fetch
        , common = {
        init: function (select_id) {
            fetch.ajax('/auth.role.count', {}, function (rs) {
                fetch.ajax('/auth.role.list', {
                    rows: rs._count
                    , field: 'role_name as name, id, parent_id as parentid'
                }, function (data) {
                    fetch.ajax('utils.get.tree.options', {
                        source_data: data
                        , select_id: select_id
                    }, function (res) {
                        if (res.option) {
                            var options = '<option value="0">==无上级==</option>' + res.option
                            $('#tree-box').html(options);
                            $('#tree-box').find('option').removeAttr('selected');
                            $('#tree-box').find('option[value='+select_id+']').attr('selected', true);
                            form.render();
                        }
                    })
                })
            })
        }
    };
    exports('role_common', common);
});
