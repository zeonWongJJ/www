layui.config({
    base: "assets/js/modules/"
}).use(['jquery', 'layer', 'fetch', 'grid', 'utils', 'laytpl'], function () {
    var $ = layui.jquery
        , grid = layui.grid
        , fetch = layui.fetch
        , form = layui.form
        , laytpl = layui.laytpl
        , utils = layui.utils
        , gridInstance
        , cols = [[ //表头
        {field: 'pl_time', title: '变动时间', width: 180}
        , {field: 'pl_description', title: '积分变动详情', width: 350}
        , {field: 'pl_item', title: '积分状态', width: 120}
        , {
            field: 'pl_type', title: '积分数', width: 120, templet: function (d) {
                var op = d.pl_type == 1 ? '+' : '-';
                return op + d.pl_variation
            }
        }
        , {field: 'pl_score', title: '积分盈余', width: 120}
    ]]
        , href = window.location.href
        , id = href.split('?')[1];

    $(function () {
        fetch.ajax('/user.info.get-' + id, {}, function (data) {
            var getTpl = $('#dom_for_user_info').html(),
                view = $('#userInfo_box');
            laytpl(getTpl).render(data, function (html) {
                view.html(html);
            });
        });
        gridInstance = grid.init(cols, '/user.jifen.list-' + id);
    });
});