<?php include_once APPPATH . 'template/default/common/header.php'; ?>
<style>
    .layui-form-label {
        width: 100px;
    }
    .layui-input {
        width: 160px;
        float: left;
    }
    .layui-input-block span {
        display: inline-block;
        height: 38px;
        line-height: 38px;
        margin-left: 5px;
    }
</style>
<body class="childrenBody">
<div class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">服务员最高劳务报酬</label>
        <div class="layui-input-block">
            <input type="text" name="service_remuneration" class="layui-input" placeholder="服务员最高劳务报酬">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">店铺分成</label>
        <div class="layui-input-block">
            <input type="text" name="shop_division" class="layui-input" placeholder="店铺分成">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">平台实际所得</label>
        <div class="layui-input-block">
            <input type="text" name="platform_actual_income" class="layui-input" placeholder="平台实际所得">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">0星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return_0" name="star_rated_return_0" class="layui-input" placeholder="0星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">1星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return" name="star_rated_return_1" class="layui-input" placeholder="1星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">2星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return" name="star_rated_return_2" class="layui-input" placeholder="2星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">3星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return" name="star_rated_return_3" class="layui-input" placeholder="3星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">4星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return" name="star_rated_return_4" class="layui-input" placeholder="4星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">5星获得的报酬比例</label>
        <div class="layui-input-block">
            <input type="text" data-name="star_rated_return" name="star_rated_return_5" class="layui-input" placeholder="5星获得的报酬比例">
            <span>%</span>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block" style="margin-left: 130px;">
            <button class="layui-btn" lay-submit lay-filter="post_store">立即提交</button>
        </div>
    </div>
</div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>
