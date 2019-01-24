<?php include_once APPPATH . 'template/default/common/header.php';?>
    <style>
        .grid_action {
            margin-right: 10px;
        }
    </style>
    <body class="childrenBody" style="background: #efefef">
    <div class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="time_line_title" class="layui-input" placeholder="时间线标题">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-block">
                <input type="text" id="time_line_at" name="time_line_at" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否显示</label>
            <div class="layui-input-block">
                <input type="radio" name="time_line_is_show" value="0" title="不显示">
                <input type="radio" name="time_line_is_show" value="1" title="显示" checked>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">时间轴内容</label>
            <div class="layui-input-block">
                <textarea name="time_line_connect" placeholder="时间轴内容" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="post_admin">立即提交</button>
            </div>
        </div>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php';?>