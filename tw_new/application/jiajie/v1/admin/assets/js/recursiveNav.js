/*
* 递归处理左边的菜单
* @author rusice <liruizhao970302@outlook.com>
*/
var str = '';
function navBar(data) {
    data.forEach(function(currentValue, index, arr) {
        var has_child = false != currentValue.children;
        str += '<li class="layui-nav-item">' +
            '<a href="javascript:;">' +
            '<i class="layui-icon" data-icon="'+currentValue.icon+'">'+currentValue.icon+'</i>' +
            '<cite>'+currentValue.title+'</cite>' +
            has_child ? '<span class="layui-nav-more"></span>' : '' +
            '</a>';
        if (has_child) {
            str += '<dl class="layui-nav-child">' +
                '<dd></dd>' +
                '</dl>';
        }
        str += '</li>';

    });
}