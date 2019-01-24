layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid'], function () {
    var $ = layui.jquery,
        grid = layui.grid,
        fetch = layui.fetch;

    var cols = [[ //表头
        {field: 'user_name', title: '用户名',  width: 120}
        , {
            field: 'user_sex', title: '性别', width: 60, templet: function (d) {
                var sex;
                switch (parseInt(d.user_sex)) {
                    case 1:
                        sex = '男';
                        break;
                    case 2:
                        sex = '女';
                        break;
                    case 0:
                    default:
                        sex = '未知';
                        break;
                }
                return sex;
            }
        }
        , {field: 'user_realname', title: '姓名', width: 80, templet: function (d) {
                return d.user_realname ? d.user_realname : '无';
        }}
        , {field: 'service_address_name', title: '用户手机', width: 120}
        , {field: 'user_email', title: '用户邮箱', width: 120}
        , {field: 'service_sold', title: '已售数量/人次', width: 220, sort: true}
        , {
            field: 'id', title: '操作', templet: function (d) {
                var str = '<a href="javascript:;" class="layui-btn layui-btn-ms fix-lh ser_details" data-id="' + d.id + '">详情</a>';
                str += d.service_status == 1
                    ? '<a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-ms fix-lh ser_off" data-id="' + d.id + '">强制下架</a>'
                    : '<a href="javascript:;" class="layui-btn layui-btn-warm layui-btn-ms fix-lh ser_on" data-id="' + d.id + '">强制上架</a>';
                return str;
            }
        }
    ]];

    $(function () {
        grid.init(cols, '/member.list-user');
    });
});
