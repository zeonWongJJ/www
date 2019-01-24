<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>查看物流</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="style/reset.css">
<link rel="stylesheet" type="text/css" href="style/main.css">
<link rel="stylesheet" type="text/css" href="style/member.css">
</head>
<body>
<header id="header">
	<div class="header-wrap">
        <a class="header-back" href="javascript:history.back();"><span>返回</span> </a>
        <h2>物流信息</h2>
    </div>
</header>
<div class="order-delivery-wp" id="order-delivery">
	<div class="order-delivery-wrapper">
		<?php if(!empty($a_view_data['state']['wuliu'])){?>
		<?php echo $a_view_data['state']['tips']?>
		<ul class="order-delivery-infolist">
			
			<?php echo $a_view_data['state']['wuliu']?>
		</ul>
		<?php } else {?>
			<div class="no-record">
                暂无物流信息
            </div>
		   
		<?php }?>
	</div>
	
</div>
<?php echo $this->display('footer1');?>
</body>
</html>
