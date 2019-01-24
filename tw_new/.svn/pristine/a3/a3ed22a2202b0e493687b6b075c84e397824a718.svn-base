/**
 *
 */
layui.define(['layer', 'fetch', 'form'], function (exports) {
    var $ = window.jQuery || layui.$
        , form = layui.form
        , fetch = layui.fetch
        , common = {
            render: function (select_id) {
                fetch.ajax('/auth.rule.count', {}, function (res) {
                    fetch.ajax('/auth.rule.list', {
                        rows: res._count
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
                                    $('#tree-box').find('option[value='+select_id+']').attr('selected', true);
                                    form.render();
                                }
                            })
                        }
                    })
                });
            }
        };

    exports('rule_common', common);
});