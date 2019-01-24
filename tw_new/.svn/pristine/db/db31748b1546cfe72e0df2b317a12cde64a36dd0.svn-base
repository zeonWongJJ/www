<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/consumablesApplication.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/consumablesApplication.js"></script>
    <title></title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
       <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 耗材申请 -->
        <div class="consumablesApplication">
            <p>耗材管理>耗材申请</p>
            <div class="consumablesContent">
                <!-- 查找 -->
                <div class="searchStore">
                    <form action="store" method="post" id="formId">
                        <input type="text" placeholder="店铺名称" onfocus="javascript:if(this.value=='材料名称')this.value='';" name="name"/>
                        <i onclick="document.getElementById('formId').submit();"><img src="static/style_default/image/s_03.png" alt=""/></i>
                    </form>
                </div>
                <!-- 查找 -->
                <!-- 申请列表 -->
                <ul class="consumablesList">
                    <li class="cateHead">
                        <em class="v1">
                            <!-- <img src="static/style_default/image/pro_07.png" alt=""/> -->
                            <p>
                                <!-- <span>全选</span> -->
                                <span style="margin-left:60px">店铺名称</span>
                            </p>
                        </em>
                        <em class="v2" style="text-align:center;">申请材料</em>
                        <em class="v3">申请数量</em>
                        <em class="v4">总金额</em>
                        <em class="v5">耗材备注</em>
                        <em class="v6">联系电话</em>
                        <em class="v7">申请时间</em>
                        <em class="v8 stateBox" style="">
                            <span><?php if ($this->router->get(2) == 0) {
                            	echo "全部状态";
                            } else if ($this->router->get(2) == 1) {
                            	echo "已通过";
                            } else if ($this->router->get(2) == 2) {
                            	echo "待处理";
                            } else if ($this->router->get(2) == 3) {
                            	echo "已拒绝";
                            } else if ($this->router->get(2) == 4) {
                            	echo "关闭";
                            }?></span>
                            <img src="static/style_default/image/pro_13.png" alt=""/>
                            <div class="state hide">
                                <a href="<?php echo $this->router->url('store', [$this->general->base64_convert($a_view_data['a_name']),'i_store' => 0,'i_pag' => 1]); ?>">全部状态</a>
                                <a href="<?php echo $this->router->url('store', [$this->general->base64_convert($a_view_data['a_name']),'i_store' => 1,'i_pag' => 1]); ?>">已通过</a>
                                <a href="<?php echo $this->router->url('store', [$this->general->base64_convert($a_view_data['a_name']),'i_store' => 2,'i_pag' => 1]); ?>">待处理</a>
                                <a href="<?php echo $this->router->url('store', [$this->general->base64_convert($a_view_data['a_name']),'i_store' => 3,'i_pag' => 1]); ?>">已拒绝</a>
                                <a href="<?php echo $this->router->url('store', [$this->general->base64_convert($a_view_data['a_name']),'i_store' => 4,'i_pag' => 1]); ?>">关闭</a>
                            </div>
                        </em>
                        <em class="v9">操作</em>
                    </li>
					<?php foreach ($a_view_data['cons'] as $cons) {?>
                    <li class="cateBody">
                        <!--品种-->
                            <em class="v1">
                               <!--  <img src="static/style_default/image/pro_07.png" alt="" /> -->
                                <p >
                                    <span><?php echo $cons['store_name']?></span>
                                </p>
                            </em>
                            <em class="v2">
                                <?php foreach ($a_view_data['sup'] as $sup) { if ($sup['consumption_id'] != 'i') {if ($cons['cons_id'] == $sup['cons_id']) {foreach ($a_view_data['consu'] as $con) {if ($sup['consumption_id'] == $con['consumption_id']) {?>
                                    <p><span><?php echo $con['consu_name']?></span></p>
                                <?php }}}}}?>
                            </em>
                            <em class="v3">
                                <?php foreach ($a_view_data['sup'] as $sup) {  if ($sup['consumption_id'] != 'i') {if ($cons['cons_id'] == $sup['cons_id']) {?>
                                        <p><span><?php echo $sup['goods_aout']?></span></p>
                                    <?php }}}?>
                            </em>
                            <em class="v4"><?php foreach ($a_view_data['sup'] as $sup) {if ($sup['consumption_id'] != 'i') {if ($cons['cons_id'] == $sup['cons_id']) { $ttp[$cons['cons_id']] += $sup['mone'];}}}?><?php echo $ttp[$cons['cons_id']]?></em> 
                            <em class="v5"><?php echo $cons['shop_remark'];?></em>
                            <em class="v6"><?php echo $cons['phone'];?><?php echo $cons['phone_number'];?></em>
                            <em class="v7"><?php echo date('Y-m-d H:i', $cons['add_time']);?></em>
                            <em class="v8"><?php if ($cons['audit'] == 1) {
                            	echo "已通过";
                            } else if ($cons['audit'] == 2) {
                            	echo "待处理";
                            } else if ($cons['audit'] == 3) {
                            	echo "已拒绝";
                            } else if ($cons['audit'] == 4) {
                            	echo "关闭";
                            }?></em>
                            <em class="v9">
                            <?php if ($cons['audit'] == 2) {?>
                            	<a href="javascript:;" onclick="ratify(<?php echo $cons['cons_id']; ?>)">批准</a>
                                <a href="javascript:;" onclick="refuse(<?php echo $cons['cons_id']; ?>)">拒绝</a>
                            <?php } else if ($cons['audit'] == 4) {?>
                            	关闭
                            <?php } else if ($cons['audit'] == 1) {?>
                            	<a href="javascript:;" onclick="via(<?php echo $cons['cons_id']; ?>)">查看</a>
	                    	<?php } else if ($cons['audit'] == 3) {?>
	                    		<a href="javascript:;" onclick="novia(<?php echo $cons['cons_id']; ?>)">查看</a>
                            <?php }?>
                               
                            </em>
                        <!--品种-->
                    </li>
					<?php }?>
                </ul>
                <!-- 申请列表 -->
            </div>
        </div>
        <!-- 耗材申请 -->

        <!--  底部选项 -->
        <!-- <div class="bottomTool">
            <a class="bottomAllSelect">
                <img src="static/style_default/image/pro_07.png" alt=""/>
                <span>全选</span>
            </a>
            <a class="bottomDelect">
                <img src="static/style_default/image/pro_26.png" alt=""/>
                <span>删除</span>
            </a>
        </div> -->
        <!--  底部选项 -->

        <!-- 分页 -->
        <div class="page">
            <!-- <ul>
                <li><a href="" class="prevPage"><img src="static/style_default/image/np_03.png" alt=""/></a></li>
                <li><a href="" class="pageCur">1</a></li>
                <li><a href="" class="">2</a></li>
                <li><a href="" class="">3</a></li>
                <li><a href="" class="">4</a></li>
                <li><a href="" class="">5</a></li>
                <li><a style="background:none;">...</a></li>
                <li><a href="" class="">10</a></li>
                <li><a href="" class="nextPage"><img src="static/style_default/image/np_05.png" alt=""/></a></li>
                <li><a style="background:none;">共计<em> 56 </em>条数据</a></li>
            </ul> -->
            <?php echo $a_view_data['pages']?>
        </div>
        <!-- 分页 -->

        <!--  弹出层 -->
        <div class="popLay jiu hide">
            <em>已拒绝此耗材申请</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="popBtn"/>
            <p class="jujue">
            </p>
            <div class="popBtn">
                <em>确认</em>
            </div>
        </div>
        <!--  弹出层  -->
		<!--  弹出层 -->
        <div class="popLay pass hide">
            <em>已批准此耗材申请</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="popBtn"/>
            <p class="ttyp">
            </p>
            <div class="popBtn">
                <em>确认</em>
            </div>
        </div>
        <!--  弹出层  -->
        <!--  重要提示 -->
        <div class="tips rati hide">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="popBtn"/>
            <p>
                <span>* 确认要批准此耗材申请吗？</span>
                <em>备注</em>
                <input type="text" id="applyCcon" placeholder="输入备注内容" value="" />
            </p>
            <div class="tipsBtn">
                <em class="qued">确定</em>
                <a class="popBtn">再看看</a>
            </div>
        </div>
        <!--  重要提示 -->
		<!--  重要提示 -->
        <div class="tips reject hide">
            <em>重要提示</em>
            <img src="static/style_default/image/pro_19.png" alt="" class="popBtn"/>
            <p>
                <span>* 确认要拒绝此耗材申请吗？</span>
                <em>备注</em>
                <input type="text" id="apply" placeholder="输入备注内容" value="" />
            </p>
            <div class="tipsBtn">
                <em class="rtys">确定</em>
                <a class="popBtn">再看看</a>
            </div>
        </div>
        <!--  重要提示 -->
    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>
<script>
	//批准查看
	function via(cons_id) {
		$('.pass').removeClass("hide");
		$('.jiu').addClass("hide");
		$('.ttyp').empty();
        $.ajax({
        	type : 'post',
        	url  : 'store_pass',
        	data : {id:cons_id},
        	dataType : 'json',
        	success  : function(data) {
        		shij = getLocalTime(data.alter_time);
        		html = '<span>'+data.back_remark+'</span><span>'+shij+'</span>';
    			$('.ttyp').html(html);
        	}
        })
    }
    //拒绝查看
	function novia(cons_id) {
		$('.jiu').removeClass("hide");
		$('.pass').addClass("hide");
		$('.jujue').empty();
        $.ajax({
        	type : 'post',
        	url  : 'store_pass',
        	data : {id:cons_id},
        	dataType : 'json',
        	success  : function(data) {
        		shij = getLocalTime(data.alter_time);
        		html = '<span>'+data.back_remark+'</span><span>'+shij+'</span>';
    			$('.jujue').html(html);
        	}
        })
    }
    //通过触发
    function ratify(cons_id) {
    	$('.rati').removeClass("hide");
    	$('.qued').attr('value', cons_id);
		$('#applyCcon').val("");
    }
	$('.qued').click(function(){
		var id   = $(this).val();
		var name = $('#applyCcon').val();
		$.ajax({
			type : 'post',
			url  : 'touch_off',
			data : {id:id,name:name,ster:1},
			dataType : 'json',
			success : function(data) {
				if (data == 58) {
					alert('此订单门店已取消，无法通过！');
				} else if (data == 33) {
					window.location.reload();
				} else {
					alert('失败，请重试！');
				};
				
			}
		})
	})
	 //拒绝触发
    function refuse(cons_id) {
    	$('.reject').removeClass("hide");
    	$('.rtys').val(cons_id);
    }
	$('.rtys').click(function(){
		var id   = $(this).val();
		var name = $('#apply').val();
		$.ajax({
			type : 'post',
			url  : 'touch_off',
			data : {id:id,name:name,ster:2},
			dataType : 'json',
			success : function(data) {
				if (data == 58) {
					alert('此订单门店已取消，无法通过！')
				} else if (data == 66) {
					window.location.reload();
				} else {
					alert('失败，请重试！');
				};
				
			}
		})
	})
    $('.popBtn').click(function() {
    	$('.popLay').addClass("hide");
    	$('.rati').addClass("hide");
    	$('.reject').addClass("hide");
    }) 
	/**       
	* 时间戳转换日期       
	* @param <int> unixTime  待时间戳(秒)       
	* @param <bool> isFull  返回完整时间(Y-m-d 或者 Y-m-d H:i:s)       
	* @param <int> timeZone  时区       
	*/
	function getLocalTime(nS) {     
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
    } 
</script>