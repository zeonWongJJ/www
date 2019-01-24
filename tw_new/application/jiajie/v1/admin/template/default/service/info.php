<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody" style="background: #efefef">
    <div class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">所属分类</label>
            <div class="layui-input-block" style="line-height: 36px;">
                <span id="service_level"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属店铺</label>
            <div class="layui-input-block">
                <span id="service_store" style="line-height: 36px;"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">服务标题</label>
            <div class="layui-input-block">
                <input disabled type="text" name="service_name" class="layui-input" placeholder="服务标题">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">服务内容</label>
            <div class="layui-input-block">
                <textarea disabled class="layui-textarea" name="service_info" id="service_info" cols="30" rows="10"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">服务收费</label>
            <div class="layui-input-block">
                <input disabled type="text" name="service_remuneration" class="layui-input" placeholder="服务收费" style="width: 200px; display: inline-block;"> / <span id="sfdw"></span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">服务地址</label>
            <div class="layui-input-block">
                <input disabled type="text" name="service_address_name" class="layui-input" placeholder="服务地址">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">已售数量</label>
            <div class="layui-input-block">
                <input disabled type="text" name="service_sold" class="layui-input" placeholder="已售数量">
            </div>
        </div>

    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>