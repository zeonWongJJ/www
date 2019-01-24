<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name=”viewport” content=”width=device-width, initial-scale=1″ />
<meta http-equiv="Cache-Control" content="max-age=7200" />
	<title></title>
  
 	<?php echo $this->display('header');?>
	<script type="text/javascript" src="js/toolbar.js"></script>
	<script src="js/layer.js"></script>

  <div class="content_coll">
  <div class="content_coll_top">
  <div class="collect_l"><i class="ticon collect-ticon"></i><span class="font3">我的收藏</span><br />
  <p class="font4">先下手为强，钜惠商品抢先收藏！</p></div>

	<div class="collect_r">
	<div class="batch-operate" style="display:none">
         <span class="op-btn u-check"><i></i><em>全选</em></span>
              <a  class="op-btn u-cart"><em>加入购物车</em></a>
          <span class="op-btn u-unfollow"><em>删除收藏</em></span>
       </div>
      	<div class="collect_r1">
      	全部管理
   		</div>
	  <div class="collect_r2">
	  <form action="" method="post" name="collection">
      	<input class="userName" style="z-index:101;" type="" name="collection" placeholder="搜索我的收藏" value="" required>
      </form>
	</div>
	</div></div>
    <hr style=" width:1000px;height:1px;border:0px;background-color:#D5D5D5;color:#D5D5D5; margin-left:20px;"/>
  <div class="product">
  <ul>
  	<?php if(empty($a_view_data)) { ?>
  		<span class='t'>您没有收藏商品...</span>
  		<?php } else if ($a_view_data['id'] == 1) {?>
  			<span class='t'>您的宝贝收藏中没有与"<?php echo $_SESSION['bbt_collection']?>"相关的宝贝哦!</span>
  		<?php } else {?>
  	<?php foreach ($a_view_data as $key => $value) { ?>
    <li <?php if($key != 0 && $key/6 == 1){
    		echo "style='margin-left:14px'";
    	} ?> >
		<div class="item-check">
            <i class="i-check"></i>
            <input type="hidden" name="" class="fav" value="<?php echo $value['fav_id']; ?>">
            <div class="item-mask"></div>
		</div>
		<div class="hd">
		<div class="hd-con">
		<a href="<?php echo get_config_item('index')?>/item-<?php echo $value['fav_id']?>.html" title="" target="_blank">
		<img src="<?php echo get_config_item('goods_img')?><?php echo $value['store_id']?>/<?php echo $value['goods_image']; ?>">
		</a>
		</div>
		</div>
			<div class="bd">            
			<h4 class="name">                            
				<a class="name" href="javascript:;" title="" target="_blank"><?php echo $value['goods_name']; ?></a>            
			</h4>            
			<p class="price"><span>¥<?php echo $value['goods_price']; ?></span></p>
		</div>
		<div class="tools tools-bottom">
			<a href="javascript:;">
				<i class="ace-icon ace-icon-link"></i>
			</a>
			<!-- <a href="<?php echo $this->router->url("collection",['', $value['fav_id']]); ?>"> -->
			<a href="<?php echo $this->router->url("collection",['', $value['fav_id']]); ?>">
				<i class="ace-icon  ace-icon-cart"></i>
			</a>
			<a href="<?php echo $this->router->url("collection",[$value['fav_id']]); ?>">
				<i class="ace-icon  ace-icon-del"></i>
			</a>
		</div>
    </li>
    <?php } }?>
    
  </ul>
  </div>
</div>
<?php echo $this->display('footer');?>
</div>



</body>
</html>
<script>
function delayer(){
	window.location = "<?php echo $this->router->url('collection');?>";
}
$('.collect_r1').click(function(){
	if ($('.collect_r1').attr('class') == 'collect_r1'){
		$(this).text('完成管理');
		$(this).addClass("on");
		$('.item-check').css("display","block");
		$('.tools-bottom').css("display","none");
		$('.batch-operate').css("display","block");
	} else if ($('.collect_r1').attr('class') == 'collect_r1 on') {
		var res = [];	
		$('.i-check').each(function(i){
			if($(this).attr('class')=="i-check on"){
				res[i] = $(this).siblings('.fav').val();	
			}
		});
		$.ajax({
            type : "POST",
            url : "<?php echo $this->router->url('collection');?>",
            data: "fav="+res,
            success : function(data)
                {
                   	if(data == 'collection'){
                   		layer.msg('关注修改成功');
                   		setTimeout("delayer()", 2000);
                   	} else {
                   		layer.msg('关注没有任何变化');
                   		setTimeout("delayer()", 2000);
                   	}
                }          
        });
	}
});
$('.item-mask').click(function(){
	if($(this).siblings('.i-check').attr("class")=="i-check on"){
		$(this).siblings('.i-check').css('background','url(../image/address.png) no-repeat -95px -50px');
		$(this).siblings('.i-check').removeClass("on");
	}else{
		$(this).siblings('.i-check').css('background','url(../image/address.png) no-repeat -95px 0px');
		$(this).siblings('.i-check').addClass("on");
	}
});
$('.u-check').click(function(){
	if($(this).text() == "全选"){
		$(this).children('em').text('取消全选');
		$('.i-check').addClass("on");
		$(this).children('i').css('background','url(../image/check.png) no-repeat 0 -30px');
		$('.i-check').css('background','url(../image/address.png) no-repeat -95px 0px');
	}else{
		$(this).children('em').text('全选');
		$('.i-check').removeClass("on");
		$(this).children('i').css('background','url(../image/check.png) no-repeat 0 0px');
		$('.i-check').css('background','url(../image/address.png) no-repeat -95px -50px');
	}
});
$('.userName').click(function(){
	if(event.keyCode==13){ 
		$(".userName").submit(); 
	} 
});
$('.u-cart').click(function(){
		var value="";
	$(".i-check.on").each(function(){
		value=$(this).siblings("input[type=hidden]").attr("value")+","+value;
	})
	var goods_id=value.substring(0,value.length-1);
	$.ajax({
		type : "POST",
		url : "<?php echo $this->router->url('gods');?>",
		data : "gods="+goods_id,
		success : function(data) {
			if(data >= 99){
                   		layer.msg('加入购物车成功');
                   		setTimeout("delayer()", 2000);
                   	} else {
                   		layer.msg('加入购物车失败！');
                   		setTimeout("delayer()", 2000);
                   	}
		}
	})
})
$('.u-unfollow').click(function(){
	var res = [];	
	$('.i-check').each(function(i){
		if($(this).attr('class')=="i-check"){
			res[i] = $(this).siblings('.fav').val();	
		}
	});
	$.ajax({
        type : "POST",
        url : "<?php echo $this->router->url('collection');?>",
        data: "fav="+res,
        success : function(data)
            {
               	if(data == 'collection'){
               		layer.msg('删除收藏成功！');
               		setTimeout("delayer()", 2000);
               	} else {
               		layer.msg('没有任何变化');
               		setTimeout("delayer()", 2000);
               	}
            }          
    });
});
</script>