<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>
    <script src="https://cache.amap.com/lbs/static/es5.min.js"></script>
    <body class="childrenBody">

    <div class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">所属分类</label>
            <div class="layui-input-block" style="line-height: 36px;">
                <span id="demand_level"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属店铺</label>
            <div class="layui-input-block">
                <span id="demand_store" style="line-height: 36px;"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">需求标题</label>
            <div class="layui-input-block">
                <input disabled type="text" name="subject_title" class="layui-input" placeholder="需求标题">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">需求内容</label>
            <div class="layui-input-block">
                <textarea disabled class="layui-textarea" name="demand_info" id="service_info" cols="30"
                          rows="10"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">需求佣金</label>
            <div class="layui-input-block">
                <input disabled type="text" name="demand_remuneration" class="layui-input" placeholder="服务收费"
                       style="width: 200px; display: inline-block;"> / <span id="sfdw"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
                <input style="width: 250px; display: inline-block" disabled type="text" name="demand_address_name"
                       class="layui-input" placeholder="需求服务地址">
                <span>
                    <cite>门牌号:</cite>
                    <input style="width: 400px; display: inline-block" disabled type="text" name="demand_house_number"
                           class="layui-input" placeholder="需求服务的门牌号">
                    <!--                    <a id="open_map" title="查看该服务的大致位置" style="color: #41aaff; margin-left: 5px;" href="javascript:void(0);" class="page_action" data-type="show_demand_map"><i class="layui-icon layui-icon-find-fill"></i> 查看地图</a>-->
                </span>
            </div>
        </div>
    </div>

    <table class="layui-table" id="order_info_table">
        <colgroup>
            <col width="100">
            <col width="100">
            <col width="100">
            <col width="75">
            <col width="45">
            <col width="45">
            <col width="70">
            <col width="60">
            <col width="60">
        </colgroup>
        <thead>
        <tr>
            <th>下单时间</th>
            <th>付款时间</th>
            <th>接单时间</th>
            <th>支付方式</th>
            <th>应付款</th>
            <th>实付款</th>
            <th>抵扣方式</th>
            <th>抵扣额</th>
            <th>订单状态</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td id="add_time"></td>
            <td id="pay_time"></td>
            <td id="receipt_at"></td>
            <td id="order_pay_way"></td>
            <td id="order_amount"></td>
            <td id="order_actual_amount"></td>
            <td id="order_deductible_type"></td>
            <td id="order_deductible_count"></td>
            <td id="order_status" class="fuck_flash"></td>
        </tr>
        </tbody>
    </table>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>