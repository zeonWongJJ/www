<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>地址列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/member.css">
    <script type="text/javascript" src="script/jquery-1.js"></script>
</head>
	<style>
		.madr-tlt a{display:none;}
	</style>
<body>
	<script>
		$(window).load(function(){
			
			$("#address_list ul li").click(function(){
				addressPre(this);
                var car = $(".defaultAddress").val();
                $.ajax({
                    type : "POST",
                    url : "<?php echo $this->router->url('upaddress');?>",
                    data: "car="+car,
                    dataType : "json",
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    success : function(data) {
                       if(data == 1){
                            alert("设置成功！");
                        } else {
                            alert("设置失败！");
                        }
                    }
                });
			})
			
			function addressPre(ele){
				$(ele).addClass("defaultAddress");
				$(ele).css("border","1px solid #D9434E");
				$(ele).children("p").css("background","#D9434E");
				$(ele).children("p").children("span").css("color","white");
				$(ele).children("p").find("a").css({"display":"block","color":"white"});
				$(ele).siblings().removeClass("defaultAddress");
				$(ele).siblings().children("p").find("a").css("display","none");
				$(ele).siblings().children("p").children("span").css("color","#999999");
				$(ele).siblings().css("border","1px solid #999999");
				$(ele).siblings().children("p").css("background","white");
				$(ele).siblings().children("p").children("span").css("color","#6D6D6D");
				$(ele).siblings().children("p").children("span").next().css("color","#D9434E");
			}
			
			$(".madrc-opera>a").click(function(){
				event.stopPropagation();
			})
            
			
		});
	</script>
    <header id="header">
        <div class="header-wrap">
            <a class="header-back" href="member.html"><span>返回</span> </a>
            <h2>地址列表</h2>
        </div>
    </header>
    <div class="address-list" id="address_list">
    <div class="footer" id="footer">
        <?php if ( ! empty($a_view_data)) { ?>
		<ul>
	        <?php foreach ($a_view_data as  $address) {
                if ($address['is_default'] == 1) {
            ?>
            <li value="<?php echo $address['address_id']?>" style="border: 1px solid rgb(217, 67, 78);" style="background: rgb(217, 67, 78);">
                <p class="madr-tlt clearfix" style="background: rgb(217, 67, 78);">
                    <span class="madrt-name" style="color: white;">姓名 ：<?php echo $address['true_name']?></span>&nbsp&nbsp;
                    <span class="madrt-phone" style="color: white;">电话 ：<?php echo $address['mob_phone']?></span>
                    <span class="madrt-type fright" style="color: white;"></span>
                    <a href="" style="color: white; float: right; display: block;">默认地址</a>
                </p>
                <div class="madr-cnt">
                    <p>地址 ：<?php echo $address['area_info']?><?php echo $address['address']?></p>
                    <p class="madrc-opera">
                        <a href="address_opera_edit-<?php echo $address['address_id']?>.html">编辑</a>&nbsp;|
                        <a href="address_ajax_delete-<?php echo $address['address_id']?>.html" class="deladdress">删除</a>
                    </p>
                </div>
            </li>
            <?php } else {?>
            <li value="<?php echo $address['address_id']?>">
                <p class="madr-tlt clearfix">
                    <span class="madrt-name">姓名 ：<?php echo $address['true_name']?></span>&nbsp&nbsp;
                    <span class="madrt-phone">电话 ：<?php echo $address['mob_phone']?></span>
                    <span class="madrt-type fright"></span>
                    <a href="" style='color:white; float:right'>默认地址</a>
                </p>
                <div class="madr-cnt">
                    <p>地址 ：<?php echo $address['area_info']?><?php echo $address['address']?></p>
                    <p class="madrc-opera">
						<a href="address_opera_edit-<?php echo $address['address_id']?>.html">编辑</a>&nbsp;|
                        <a href="address_ajax_delete-<?php echo $address['address_id']?>.html" class="deladdress">删除</a>
                    </p>
                </div>
            </li>
	        <?php } }?>
        </ul>
        <?php } else {?>
            <div class="no-record">
                暂无记录
            </div>
        <?php }?>
		<a class="add_address mt10" href="address_opera.html">添加新地址</a>
    </div>
</div>
 <?php echo $this->display('footer1');?>
</body>
</html>