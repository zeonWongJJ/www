<?php include_once APPPATH . 'template/default/common/header.php';?>
    <body class="childrenBody">

    <form class="layui-form" lay-filter="updata-info">

        <button type="button" class="layui-btn" id="slide_img_url" name="image">
            <i class="layui-icon">&#xe67c;</i>上传幻灯
        </button>
        <div class="layui-form-item">
            <label class="layui-form-label">幻灯名称</label>
            <div class="layui-input-block">
                <input type="text" name="slide_name" class="layui-input newsName" lay-verify="required" placeholder="幻灯名称">
            </div>
        </div>
        <input type="hidden" value="" name="slide_img_url" lay-verify="required">
        <div class="layui-form-item">
            <label class="layui-form-label">幻灯排序</label>
            <div class="layui-input-block">
                <input type="text" name="slide_sort" class="layui-input newsName" placeholder="数字越小，排序越前">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示</label>
            <div class="layui-input-block">
                <input type="radio" name="slide_show" value="0" title="不显示">
                <input type="radio" name="slide_show" value="1" title="显示" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">幻灯跳转地址</label>
            <div class="layui-input-block">
                <input type="text" name="slide_href" class="layui-input newsName" placeholder="https://www.baidu.com">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">幻灯类型</label>
            <div class="layui-input-block">
                <select name="slide_type">
                    <option value="">请选择一个类型</option>
                    <option value="0">首页轮播</option>
                    <option value="1">需求详情</option>
                    <option value="2">服务详情</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">幻灯显示开始时间</label>
            <div class="layui-input-block">
                <input type="text" name="slide_show_start_time" id="start_time" class="layui-input newsName" lay-verify="" placeholder="开始时间不选择默认为当前时间">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">幻灯结束时间</label>
            <div class="layui-input-block">
                <input type="text" name="slide_show_end_time" id="end_time" class="layui-input newsName" lay-verify="" placeholder="结束时间不选择默认为永久显示">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block" id="submit_button">
                <button class="layui-btn" lay-submit lay-filter="add_slide">添加幻灯</button>
            </div>
        </div>
    </form>
<?php include_once APPPATH . 'template/default/common/footer.php';?>