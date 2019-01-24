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
        {field: 'ub_time', title: '变动时间', width: 180}
        , {field: 'ub_description', title: '余额变动详情', width: 350}
        , {field: 'ub_item', title: '变化项目', width: 120}
        , {field: 'ub_money', title: '余额数', width: 120}
        , {field: 'ub_balance', title: '余额盈余', width: 120}
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
        gridInstance = grid.init(cols, '/user.balance.list-' + id)
    });
});