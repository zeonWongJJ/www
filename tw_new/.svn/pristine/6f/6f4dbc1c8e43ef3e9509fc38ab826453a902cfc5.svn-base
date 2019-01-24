<?php include_once APPPATH . 'template/default/common/header.php'; ?>
<style>
    .upload_review_block {
        display: none;
    }

    #store_pic li {
        float: left;
        padding: 10px;
    }

    td {
        padding: 10px;
    }

    .show_img_box {
        display: inline-block;
        height: 250px;
        position: relative
    }

    .show_img_box .fuck_img_what {
        position: absolute;
        width: 100%;
        height: 250px;
        line-height: 250px;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.6);
        text-align: center;
        display: none;
    }

    .show_img_box:hover .fuck_img_what {
        display: block;
        cursor: pointer;
    }

    .show_img_box .fuck_img_what .layui-icon {
        font-size: 50px;
        color: #41aaff;
    }
</style>
<body class="childrenBody">
<div class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">门店名称</label>
        <div class="layui-input-block">
            <input type="text" name="store_name" class="layui-input" placeholder="门店名称">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">启用/暂用</label>
        <div class="layui-input-block">
            <input type="radio" name="store_status" value="1" title="启用">
            <input type="radio" name="store_status" value="2" title="暂用">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">地址</label>
        <div class="layui-input-block">
            <input type="text" name="store_address" class="layui-input" placeholder="门店地址">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-block">
            <input type="text" name="store_director" class="layui-input" placeholder="联系人">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">身份证</label>
        <div class="layui-input-block">
            <input type="text" name="store_id_card" class="layui-input" placeholder="门店联系人身份证">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系电话</label>
        <div class="layui-input-block">
            <input type="text" name="store_phone" class="layui-input" placeholder="联系电话">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">店铺服务范围</label>
        <div class="layui-input-block">
            <input type="text" name="store_range" class="layui-input" placeholder="店铺服务范围">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">店铺所在地区</label>
        <div class="layui-input-block">
            <input type="text" name="store_region" class="layui-input" placeholder="店铺所在地区">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">店铺描述</label>
        <div class="layui-input-block">
            <textarea name="store_info" placeholder="请输入店铺描述" class="layui-textarea"></textarea>
<!--            <input type="text" name="store_region" class="layui-input" placeholder="店铺描述">-->
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">身份证</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload_id_card_zm">
                <i class="layui-icon">&#xe67c;</i>上传身份证正面图片
            </button>
            <button type="button" class="layui-btn" id="upload_id_card_bm">
                <i class="layui-icon">&#xe67c;</i>上传身份证反面图片
            </button>
        </div>
        <table class="layui-input-block upload_review_block" id="upload_id_card_block" border="1"
               style="margin-top: 20px;">
            <tr>
                <td>身份证正面</td>
                <td>
                    <ul id="store_id_card_positive" style="width: 950px;"></ul>
                </td>
            </tr>
            <tr>
                <td>身份证背面</td>
                <td>
                    <ul id="store_id_card_opposite" style="width: 950px;"></ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">资质认证</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload_zzrz_zm">
                <i class="layui-icon">&#xe67c;</i>上传资质认证正面图片
            </button>
            <button type="button" class="layui-btn" id="upload_zzrz_fm">
                <i class="layui-icon">&#xe67c;</i>上传资质认证反面图片
            </button>
        </div>
        <table class="layui-input-block upload_review_block" id="upload_zzrz_block" border="1"
               style="margin-top: 20px;">
            <tr>
                <td>资质认证图片-正面</td>
                <td>
                    <ul id="store_zizhi_positive" style="width: 950px;"></ul>
                </td>
            </tr>
            <tr>
                <td>资质认证图片-反面</td>
                <td>
                    <ul id="store_zizhi_opposite" style="width: 950px;"></ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">店铺图片</label>
        <div id="review_store_licence" style="display: none; margin-bottom: 20px;">
            <img src="" width="120" height="100">
        </div>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload_store_pic">
                <i class="layui-icon">&#xe67c;</i>上传店铺图片
            </button>
            <span style="color: #FF0000;">* 最多允许上传9张图片</span>
        </div>
        <table class="layui-input-block upload_review_block" id="upload_store_pic_review" border="1"
               style="margin-top: 20px;">
            <tr>
                <td>店铺图片</td>
                <td>
                    <ul id="store_pic" style="width: 950px;"></ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="post_store">立即提交</button>
        </div>
    </div>
</div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>

