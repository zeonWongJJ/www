<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>耗材管理-耗材申请记录</title>
		<link rel="stylesheet" href="static/style_default/style/common.css"/>
        <link rel="stylesheet" href="static/style_default/style/header.css"/>
        <link rel="stylesheet" href="static/style_default/style/consumptiveManage_applyRecord.css"/>       
        <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
        <script src="static/style_default/script/common.js" type="text/javascript" charset="utf-8"></script>
        <script src="static/style_default/script/consumptiveManage_applyRecord.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<!-- 头部 开始-->
        <?php echo $this->display('top'); ?>
        <!-- 头部结束 -->
        <div class="bottom clearfix">
        	<!-- 导航 开始-->
	        <?php echo $this->display('left'); ?>
	        <!-- 导航结束-->
	        <!--右边内容开始-->
	        <div class="rightSide">
	        	<!--面包屑导航开始-->
        		<div class="breadNav">
        			<a href="javascript:;">耗材管理</a>
        			<span>></span>
        			<a href="javascript:;">耗材申请记录</a>
        		</div>
	        	<!--面包屑导航结束-->
	        	<!--表格模块开始-->
	        	<div class="tableModule">	        		
	        		<!--表格列表开始-->
	        		<div class="tableBox">
	        			<ul>
	        				<li class="thead">	        						        					
	        					<span>申请时间</span>
	        					<span>申请材料</span>
	        					<span>申请数量</span>
	        					<span>总金额</span>	
	        					<span>申请备注</span>	        						        					
	        					<span class="state">
	        						<a href="javascript:;" class="staTitle"><s><?php if ($this->router->get(1) == 0) {
	        							echo "全部状态";
	        						} else if ($this->router->get(1) == 1) {
	        							echo "已通过";
	        						} else if ($this->router->get(1) == 2) {
	        							echo "待处理";
	        						} else if ($this->router->get(1) == 3) {
	        							echo "已拒绝";
	        						} else if ($this->router->get(1) == 4) {
	        							echo "已取消";
	        						}?></s><i></i></a>
	        						<ul class="stateSelect">
	        							<li><a href="<?php echo $this->router->url('consumable_apply', ['audit' => 0,'i_page' => 1])?>">全部状态</a></li>
	        							<li><a href="<?php echo $this->router->url('consumable_apply', ['audit' => 1,'i_page' => 1])?>">已通过</a></li>
	        							<li><a href="<?php echo $this->router->url('consumable_apply', ['audit' => 2,'i_page' => 1])?>">待处理</a></li>
	        							<li><a href="<?php echo $this->router->url('consumable_apply', ['audit' => 3,'i_page' => 1])?>">已拒绝</a></li>
	        							<li><a href="<?php echo $this->router->url('consumable_apply', ['audit' => 4,'i_page' => 1])?>">已取消</a></li>
	        						</ul>
	        						<div class="zhe"></div>
	        					</span>
	        					<span>操作</span>
	        				</li>
							<?php foreach ($a_view_data['apply'] as $apply) {?>
	        				<li class="row">	        					
	        					<span><?php echo date('Y-m-d H:i', $apply['add_time'])?></span>
	        					<span class="material">
	        						<?php foreach ($a_view_data['sup'] as $sup) { if ($sup['consumption_id'] != 'i') {if ($apply['cons_id'] == $sup['cons_id']) {foreach ($a_view_data['con'] as $con) {if ($sup['consumption_id'] == $con['consumption_id']) {?>
	        							<i><?php echo $con['consu_name']?></i>
	        						<?php }}}}}?>
	        					</span>
	        					<span class="number">
	        						<?php foreach ($a_view_data['sup'] as $sup) {  if ($sup['consumption_id'] != 'i') {if ($apply['cons_id'] == $sup['cons_id']) {?>
	        							<i><?php echo $sup['goods_aout']?></i>
	        						<?php }}}?>
	        					</span>
	        					<span><?php foreach ($a_view_data['sup'] as $sup) {if ($sup['consumption_id'] != 'i') {if ($apply['cons_id'] == $sup['cons_id']) { $ttp[$apply['cons_id']] += $sup['mone'];}}}?><?php echo $ttp[$apply['cons_id']]?></span>	
	        					<span><?php echo $apply['shop_remark']?></span>	
	        					<?php if ($apply['audit'] == 2) {?>
	        						<span>待处理</span>
		        					<span class="control li_<?php echo $apply['cons_id']; ?>">
		        						<a href="javascript:;" class="cancel" onclick="abolish(<?php echo $apply['cons_id']; ?>)">取消</a>
		        						<a href="consumable_up-<?php echo $apply['cons_id']; ?>" class="revise">修改</a>
		        					</span>
	        					<?php } else if ($apply['audit'] == 1) {?>
	        						<span>已通过</span>
		        					<span class="control">	        						
		        						<a href="javascript:;" class="look"  onclick="via(<?php echo $apply['cons_id']; ?>)">查看</a>
		        					</span>
	        					<?php } else if ($apply['audit'] == 3) {?>
	        						<span>已拒绝</span>
		        					<span class="control">				
		        						<a href="javascript:;" class="refLook"  onclick="jiujue(<?php echo $apply['cons_id']; ?>)">查看</a>
		        						<a href="consumable_reapply-<?php echo $apply['cons_id']?>" class="refApply">再次申请</a>
		        					</span>
	        					<?php } else if ($apply['audit'] == 4) {?>
	        						<span>已取消</span>
		        					<span class="control">				
		        						<a href="consumable_reapply-<?php echo $apply['cons_id']?>" class="conApply">再次申请</a>
		        					</span>
	        					<?php }?>        					
	        				</li>
							<?php }?>
	        			</ul>
	        			
	        		</div>
	        		<!--表格列表结束-->
	        	</div>
	        	<!--表格模块结束-->	 
	        	<!--分页开始-->
	        	<div class="page">
	        		<?php echo $a_view_data['pages']?>
	        		
		            <span style="background:none">共计<em> <?php echo $a_view_data['total']?> </em>条数据</span>
	        	</div>
	        	<!--分页结束-->
	        </div>
	        <!--右边内容结束-->		        
	        <!--已拒绝弹框开始-->  
	        <!--<div class="delePart refuseBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p class="ttyp"></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure close">确认</a>      		
	        	</div>
	        </div>-->
	        <!--已拒绝弹框 结束--> 
	        <!--已通过弹框开始-->  
	        <div class="delePart passBomb">
	        	<a href="javascript:;" class="close"></a>
	        	<p class="ttyp">已通过此耗材申请</p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure close">确认</a>
	        		
	        	</div>
	        </div>
	        <!--已通过弹框结束--> 
	        <!-- 取消申请耗材弹框开始-->
	        <div class="delePart deleSingle cancelBomb">
	        	<p >重要提示</p>
	        	<p class="p2">*<span>确定要取消此部分耗材申请吗？</span></p>
	        	<p class="p3">*<span>取消后不可以恢复</span></p>
	        	<div class="btnBox">
	        		<a href="javascript:;" class="sure">确认</a>
	        		<a href="javascript:;" class="think">取消</a>
	        	</div>
	        </div>
	        <!--取消申请耗材弹框结束-->
	</body>
</html>
<script>
    // 取消
	function abolish(cons_id) {
		$('body').on('click','.tableBox .cancel',function(){
			$('.cancelBomb').show();
			$('.sure').click(function(){
				$.ajax({
					url: '<?php echo $this->router->url('consumable_abolish'); ?>',
					type: 'POST',
					dataType: 'json',
					data: {id: cons_id},
					success: function(data) {
						if (data == 55) {
							$('.delePart').hide();
							// alert('修改成功！');
							// window.location.reload();
							$('.li_'+cons_id).html('<a href="consumable_reapply-'+cons_id+'" class="conApply">再次申请</a>');
						} else {
							$('.delePart').hide();
							alert('后台处理，不能修改！');
							// window.location.reload();
						};
					}
				})	
			})
		})
	}
	//批准查看
	function via(cons_id) {
		console.log(cons_id);
		$('.passBomb').show();
		$('.ttyp').empty();
        $.ajax({
        	type : 'post',
        	url  : 'consumable_pass',
        	data : {id:cons_id},
        	dataType : 'json',
        	success  : function(data) {
        		// console.log(data);
        		shij = getLocalTime(data.alter_time);
        		html = '<p>已通过此耗材申请</p>'
			        	+'<p class="p2">*<span>备注：'+data.back_remark+'</span></p>'
			        	+'<p class="p3">*<span>批准时间：'+shij+'</span></p>';
        		
    			$('.ttyp').html(html);
        	}
        })
    }
	//拒绝查看
	function jiujue(cons_id) {
		console.log(cons_id);
		$('.passBomb').show();
		$('.ttyp').empty();
        $.ajax({
        	type : 'post',
        	url  : 'consumable_pass',
        	data : {id:cons_id},
        	dataType : 'json',
        	success  : function(data) {
        		// console.log(data);
        		shij = getLocalTime(data.alter_time);
        		html = '<p>已拒绝此耗材申请</p>'
			        	+'<p class="p2">*<span>备注：'+data.back_remark+'</span></p>'
			        	+'<p class="p3">*<span>拒绝时间：'+shij+'</span></p>';
        		
    			$('.ttyp').html(html);
        	}
        })
    }
    function getLocalTime(nS) {     
   		return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
	}   
</script>