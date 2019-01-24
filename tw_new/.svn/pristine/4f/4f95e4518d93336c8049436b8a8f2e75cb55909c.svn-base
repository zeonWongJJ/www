<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <body class="childrenBody">
<form class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">上级</label>
        <div class="layui-input-block">
            <select id="tree-box" name="parent_id"></select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" name="rule_sort" class="layui-input" lay-verify="required"
                   placeholder="菜单排序，数字越大排序越靠前">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">规则名称</label>
        <div class="layui-input-block">
            <input type="text" name="rule_name" class="layui-input newsName" lay-verify="required"
                   placeholder="规则名称">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-block">
            <input type="text" name="rule_controller" class="layui-input newsName" lay-verify="required"
                   placeholder="所属控制器">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-block">
            <input type="text" name="rule_action" class="layui-input newsName" lay-verify="required"
                   placeholder="所属方法">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">路由参数</label>
        <div class="layui-input-block">
            <input type="text" name="rule_router_param" class="layui-input newsName" placeholder="路由参数">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-block">
            <input type="checkbox" name="rule_enable" lay-skin="switch" lay-text="ON|OFF">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否为菜单</label>
        <div class="layui-input-block">
            <input type="checkbox" name="is_menu" lay-skin="switch" lay-text="ON|OFF">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">认证等级</label>
        <div class="layui-input-block">
            <select name="rule_level" id="inner_rule_level">
                <option value=""></option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="post_rule">立即提交</button>
        </div>
    </div>
</form>
<script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>
