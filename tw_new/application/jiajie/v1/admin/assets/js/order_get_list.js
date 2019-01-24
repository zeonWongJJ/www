layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'table', 'grid', 'element', 'laytpl'], function () {
    var form = layui.form,
        grid = layui.grid,
        laytpl = layui.laytpl,
        element = layui.element,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        fetch = layui.fetch,
        jQuery = $ = layui.jquery,

        gridInstance,
        cols = [[
            {
                field: 'order_sn', title: '下单用户', templet: function (d) {
                    var img_src = d.user_pic == '' ? 'https://vdao-mobile.7dugo.com/static/style_default/images/tou_03.png' : d.user_pic;
                    var str = '<img src="' + img_src + '" width="30" height="30" style="margin-right: 10px;">';
                    str += d.user_name ? d.user_name : d.user_phone;
                    return str;
                }
            },
            {field: 'order_name', width: 200, title: '订单商品'},
            {field: 'add_time', title: '下单时间', width: 180},
            {field: 'order_sn', title: '订单编号'},
            // {
            //     field: 'order_status', title: '订单进度', templet: function (d) {
            //         if (d.order_status == 4) {
            //             var str = '<div class="layui-progress">\n' +
            //                 '  <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>\n' +
            //                 '</div>';
            //             str += '<p style="font-size: 12px; text-align: center">已关闭</p>';
            //             return str;
            //         }
            //         // 计算进度条
            //         var percent = (parseInt(d.order_process) + 1) * 20,
            //             str = '';
            //         // console.log(d.order_process, percent);
            //         str += '<div class="layui-progress">\n' +
            //             '  <div class="layui-progress-bar" lay-percent="' + percent + '%"></div>\n' +
            //             '</div>';
            //         str += '<p style="font-size: 12px">' +
            //             '<span style="float: left">拍下</span>' +
            //             '<span style="float: right">完成</span>' +
            //             '</p>';
            //         str += '<p style="text-align: center; cursor: pointer;">' + status + '</p>\n';
            //         return str;
            //     }
            // },
            {
                field: 'order_actual_amount', title: '应付/实付', width: 200, templet: function (d) {
                    return '￥' + d.order_amount + '/ ￥' + d.order_actual_amount;
                }
            },
            {
                field: 'order_sn', title: '操作', templet: function (d) {
                    var status = '',
                        str = '';
                    switch (parseInt(d.order_state)) {
                        case 0:
                            status = '待付款';
                            break;
                        case 1:
                            status = '待确认';
                            break;
                        case 2:
                            status = '待服务';
                            break;
                        case 3:
                            status = '服务中';
                            break;
                        case 4:
                            status = '已取消';
                            break;
                        case 5:
                            status = '交易完成';
                            break;
                        default:
                            status = '状态异常';
                    }
                    str += ' <span class="layui-badge-dot layui-bg-orange"> </span> <span style="font-size: 12px">' + status + '</span>';
                    str += '<a href="javascript:;" class="grid_action" data-url="'+window.config.root_url+'order.update?'+d.order_sn+'" data-type="order_detail"><cite>订单详情</cite></a>';
                    return str;
                }
            }
        ]];

    $(window).one('resize', function () {
        gridInstance = grid.init(cols, '/order.list', {
            'a.order_type <>': 3
        });
        // form.render();
    }).resize();


    $(function () {
        $('.advancedOptions dd').mouseover(function () {
            $(this).find('.show_box').show();
        }).mouseout(function () {
            $(this).find('.show_box').hide();
        });

        function get_count() {
            fetch.ajax('/order.list.count', {
                condition: {
                    'order_type <>': 3
                }
            }, function (data) {
                var count = 0;
                $.each(data, function (key, value) {
                    count += parseInt(value);
                    $('#' + key).html('(' + value + ')')
                });
                // $('#all').html('(' + count + ')');
            })
        };

        get_count();

        /**
         * 页面事件定义
         * @type {{}}
         */
        var page_active = {
                cafe_filter: function () {
                    var map = $(this).data('map')
                        , condition = {
                        'a.order_type <>': 3
                    };

                    if ('all' === map) {
                        delete(condition['a.order_status']);
                    } else if ('pending_payment' === map) {
                        condition['a.order_state'] = 0;
                        condition['a.order_rate'] = 0;
                    } else if ('pending_ordering' === map) {
                        condition['a.order_state'] = 1;
                        condition['a.order_belong_store_id'] = 0;
                    } else if ('in_service' === map) {
                        condition['a.order_state'] = 3;
                    } else if ('completed' === map) {
                        condition['a.order_rate'] = 1;
                    } else if ('closed' === map) {
                        condition['a.order_state'] = 5;
                    }
                    gridInstance.reload({
                        where: {
                            condition: condition
                        },
                        done: function () {
                            element.render();
                            get_count();
                        }
                    });
                    // 选中样式
                    $(this).parents('.cafeNav').find('a').removeClass('cafeCur');
                    $(this).addClass('cafeCur');
                }
            },
            /**
             * 表格事件定义
             * @type {{}}
             */
            grid_active = {
                order_detail: function () {
                    parent.addTab($(this));
                    // var id = $(this).data('id')
                    //     , index = layui.layer.open({
                    //     title: "查看订单详情",
                    //     type: 2,
                    //     content: "order.update?" + id,
                    //     end: function () {
                    //         gridInstance.reload();
                    //     }
                    // });
                    // layui.layer.full(index);
                    // layer.close(index);
                }
            };

        $('.page_action').click(function () {
            var type = $(this).data('type');
            page_active[type] ? page_active[type].call(this) : '';
        });
        $('body').on('click', '.grid_action', function () {
            var type = $(this).data('type');
            grid_active[type] ? grid_active[type].call(this) : '';
        });
    })
});