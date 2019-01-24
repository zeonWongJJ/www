<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Cache-Control" content="max-age=7200" />
	<title></title>

<?php echo $this->display('header');?>
<script type="text/javascript" src="js/toolbar.js"></script>

  <div class="content_coll">
    <div class="content_coll_top">
  <div class="collect_l"><i class="ticon evaluat-ticon"></i><span>我的评价</span><br />
  <p class="font4">因为品质，所以选择。我们期待您十分满意的评价！ </p>
 </div></div>
 <hr style=" width:1000px;height:1px;border:0px;background-color:#D5D5D5;color:#D5D5D5; margin-left:20px;"/>
  <div class="user-evalu">
  <div id="user-evalu-con"  class="user-evalu-con">
  <?php if (empty($a_view_data['thre'])) {?>
    <div class="product">
  <ul>
    <span class='t'>您还没有评价记录.....</span>     </ul>
  </div>
    <?php } else {?>
   <?php foreach ($a_view_data['thre'] as $key => $value) { ?>
    <div class="user-evalu-box">
        <a href="<?php echo get_config_item('index')?>/item-<?php echo $value['geval_goodsid']?>.html" target="_blank">
        <div class="avatar">
        <img  src="<?php echo get_config_item('goods_img')?><?php echo $value['geval_storeid']?>/<?php echo $value['geval_goodsimage']; ?>" width="93" height="93">       
        </div>
        <div class="collect-grayline"></div> 
        <u class="jiao"></u>
        </a>
        <div class="user-evalu-txt">
    <div class="evalu_info">
        <span class="star-s<?php echo $value['geval_scores']; ?>" id=""></span>
        <span class="txt-height">
        <?php echo $value['geval_content']; ?>
        </span>
    </div> 
    <div class="evalu-pic">
        <?php foreach ($value['geval_image'] as $v){
              if ( ! empty($v) ) {
                echo '<a href="javascript:;" ><img src="' . $v . '" width="60" height="60" alt=""></a>';
              }else 
                continue;
            } 
             ?>
    </div>
    <div class="evalu-data">
        <span><i class="ico1"></i><?php echo date('Y-m-d H:s A',$value['geval_time_create']); ?></span>
    </div>
    <div class="clear"></div>
    <div class="interReply_box">
      <?php if (empty($value['geval_remark'])) {?>
        
      <?php } else {?>
        <ul class="reply_list">
             <li class="businessReply">
              <div class="up clearfix">
                <i class="whiteLine"></i>
                    <div class="t">
                        <div class="face">
                             <!-- <img src="<?php echo $value['store_label'];?>" width="40" height="40"> -->
                             <img src="image/store.png" width="40" height="40">
                        </div>
                    </div>
                    <div class="m">
                        <p class="user">
                                  <span><?php echo $value['geval_storename']; ?></span>
                            <span>：</span>
                            <span><?php echo $value['geval_remark'];?></span>
                        </p>
                    </div>
                </div>
            </li>
        </ul>
      <?php }?>
    </div>
    </div>
  </div>
  
   <?php }?>
    
    </div>
    </div>
    </div> 
  
<div id="Turnpage"> 
    <?php echo $a_view_data['page']; ?>
</div>
<?php }?>
<div class="clear"></div>
</div>
</div>
</div>
<?php echo $this->display('footer');?> 
</body>
</html>
<script>
    $("#Turnpage a").each(function(i){
        var str = '<b>';
        var num = $(this).text();
        var num1 = $(this).html();
        if( ! isNaN(num) ){
            num1.indexOf(str)!=-1?$(this).addClass('num').css('display','inline-block'):$(this).addClass('num').css('display','none');
        }else{
            $(this).addClass('abled');
        }
    });
</script>