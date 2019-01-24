layui.config({
    base: "assets/js/modules/"
}).use(['form', 'layer', 'fetch', 'grid', 'utils', 'laytpl'], function () {
    var layer = parent.layer || layui.layer,
        form = layui.form,
        laytpl = layui.laytpl,
        utils = layui.utils,
        $ = layui.jquery,
        fetch = layui.fetch,
        href = window.location.href,
        id = href.split('?')[1];

    $(function () {
        fetch.ajax('/demand.get-' + id, {}, function (data) {
            $('#demand_level').html(
                data.demand_level_1_name + ' >> ' + data.demand_level_2_name + ' >> ' + data.demand_level_3_name
            );
            $('#demand_store').html(data.demand_store_name ? '<i class="layui-icon layui-icon-layer"> ' + data.demand_store_name + '</i>' : '未被接单');
            // 1：按时收费 2：按次数收费
            if (data.pay_way == 2) {
                $('#sfdw').html('次');
            } else {
                $('#sfdw').html('小时');
            }
            $('textarea[name=demand_info]').html(data.demand_info);
            $('#open_map').data('map-lal', data.demand_lal);
            $.each(data, function (key, value) {
                $('input[name=' + key + ']').val(value)
            });

            $.each(data.order_info, function (key, value) {
                if ('order_deductible_type' === key) {
                    var deductible_type_map = ['无抵扣', '余额抵扣', '积分抵扣'];
                    value = deductible_type_map[value]
                }
                if ('order_pay_way' === key) {
                    var pay_way_map = {
                        alipay: '支付宝'
                        , wechat: '微信'
                        , bankcard: '银行卡'
                    };
                    value = pay_way_map[value]
                }
                if ('order_status' === key) {
                    var order_status_map = ['待付款', '待接单', '待确认', '服务中', '待上门', '服务中', '已关闭'];
                    value = order_status_map[value]
                }
                $('#order_info_table').find('#' + key).html(value)
            });
        });

        function index(){
            $('.fuck_flash').css('color','#03a9f4');  //默认值
            setTimeout(" $('.fuck_flash').css('color','#fF0000')",100); //第一次闪烁
            setTimeout( "$('.fuck_flash').css('color','#ccc')",200); //第二次闪烁
        };
        window.setInterval(index, 400); //让index 多久循环一次

        utils.initPage({
            page_active: {}
        })
    });
});