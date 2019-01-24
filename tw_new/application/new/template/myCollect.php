<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/myCollect.css"/>
    <script src="../js/jquery-1.8.2.min.js"></script>
    <script src="../js/flexible.js"></script>
    <script src="../js/myCollect.js"></script>
    <title></title>
</head>
<body>
<!--  我的足迹 -->
<div class="myCollect">
    <!--  头部  -->
    <div class="headTitle">
        <p>
            <span class="collectServe">收藏的服务</span>
            <span class="collectServant">收藏的服务者</span>
            <em class="edit">编辑</em>
        </p>
    </div>
    <!--  头部  -->
    <!--  足迹列表 -->
    <div class="collectList">
        <ul>
            <?php foreach ($a_view_data['demand'] as $key => $value): ?>
                <li value="<?php echo $value['cid']; ?>">
                    <i>
                        <img src="../img/cost.png" alt=""/>
                        <em class="hide">
                            <img src="../img/fuxuan5.png" alt=""/>
                        </em>
                    </i>
                    <div class="costInfo">
                        <p>
                            <span>
                                <em>番禺钟村&nbsp;<?php echo $value['title']; ?></em>
                                <br/>
                                <s <?php if($value['guarantee_long']==0){ echo "style='display:none'"; } ?>>保修</s>
                            </span>
                            <em>
                                <span><500m</span>
                                <em>¥<?php echo $value['price']; ?></em>
                            </em>
                        </p>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <!--  足迹列表 -->
    <!--  收藏的服务者 -->
    <div class="servant hide">
        <?php foreach ($a_view_data['server'] as $key => $value): ?>
            <div class="servantCon" value="<?php echo $value['cid']; ?>">
                <i class="hide"><img src="../img/fuxuan5.png" alt=""/></i>
                <div class="servantInfo">
                    <i>
                        <img src="<?php echo $value['photo']; ?>" alt=""/>
                        <em <?php if($value['auth_level']!=3){ echo "style='display:none;'"; } ?>><img src="../img/qiye.png" alt=""/></em>
                    </i>
                    <p>
                        <span><?php echo $value['username']; ?></span>
                        <img src="../img/nan.png" alt=""/>
                        <b>
                            <em>番禺区</em><<dfn>500m</dfn>
                        </b>
                    </p>
                    <span><?php echo $value['service_appellation']; ?></span>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <!--  收藏的服务者 -->
    <!--  底部删除栏 -->
    <div class="bottomDelete hide" onclick="delete_collect()">
        删除(<span>1</span>)
    </div>
    <!--  底部删除栏 -->
</div>
<!--  我的足迹 -->
</body>
</html>


<script>

function delete_collect() {
    var del_ids = new Array();
    var i = 0;
    $(".selectedOn").each(function(){
        del_ids[i] = $(this).attr('value');
        i++;
    });
    $(".servantOn").each(function(){
        del_ids[i] = $(this).attr('value');
        i++;
    });
    var ids = del_ids.join('-');
    $.ajax({
        url: '<?php echo $this->router->url('delete_collect'); ?>',
        type: 'post',
        dataType: 'json',
        data: {ids: ids},
        success: function(data){
            console.log(data);
        }
    })
}
</script>
