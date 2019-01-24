<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/receivingAddress.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/flexible.js"></script>
    <script src="static/style_default/script/receivingAddress.js"></script>
    <title>收货地址</title>
</head>
<body>
    <!-- 拉框 -->
    <?php echo $this->display('head'); ?>
    <!-- 收货地址  -->
    <div class="receivingAddress">
        <p class="pjoTitle">
            <a href="new_bill?oldurl=<?php echo $_GET['oldurl'];?>"><img src="static/style_default/images/yongping_03.png" alt=""/></a>
            <span>收货地址</span>
        </p>
    </div>
    <!-- 收货地址  -->
    <!-- 地址列表 -->
    <div class="address">
        <!-- 不在配送范围 -->
        <div class="rangeNone">
            <ul class="addressList">
                <?php foreach ($a_view_data['addre'] as $addre) {?>
                <!-- <p>不在配送范围内</p> -->
                <li class="listInfo li_<?php echo $addre['address_id']?>">
                    <dl>
                        <dd class="userInfo">
                            <span><?php echo $addre['user_name']?></span>
                            <em><?php echo $addre['mob_phone']?></em>
                        </dd>
                        <dd class="addressInfo">
                            <?php echo $addre['address']?><?php echo $addre['house']?>
                        </dd>
                        <dd class="addressTool">
                            <?php if ($addre['is_default'] == 1) {?>
                            <div class="choDefault choCur" value="<?php echo $addre['address_id']?>">
                                <img src="static/style_default/images/addr_03.png" alt="">
                                <span>已设为默认</span>
                            </div>
                            <?php } else {?>
                            <div class="choDefault" value="<?php echo $addre['address_id']?>">
                                <img src="static/style_default/images/check_06.png" alt=""/>
                                <span>设为默认</span>
                            </div>
                            <?php }?>

                            <div class="operation">
                                <a class="edit"  href="address_update-<?php echo $addre['address_id']?>?add=address&oldurl=<?php echo $_GET['oldurl'];?>">
                                    <img src="static/style_default/images/addr_10.png" alt=""/>
                                    <span>编辑</span>
                                </a>
                                <a class="del" onclick="dele(<?php echo $addre['address_id']?>);" href="javascript:;">
                                    <img src="static/style_default/images/addr_07.png" alt=""/>
                                    <span>删除</span>
                                </a>
                            </div>
                        </dd>
                    </dl>
                </li>
                <?php }?>
            </ul>
        </div>
        
        <!-- 新增地址 -->
        <a class="addAddress" href="<?php echo $this->router->url('address_add')?>?add=address&oldurl=<?php echo $_GET['oldurl'];?>">
            <img src="static/style_default/images/addr_15.png" alt=""/>
            <span>新增地址</span>
        </a>
        <!-- 新增地址 -->

        <!-- 不在配送范围 -->
    </div>
    <!-- 地址列表 -->
</body>
</html>
<script type="text/javascript">
    function dele(address_id) {
        $.ajax({
            type : 'post',
            url  : '<?php echo $this->router->url('address_delete')?>',
            data : {id:address_id},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                    $(".li_"+address_id).remove();
                };
            }
        })
    }

</script>