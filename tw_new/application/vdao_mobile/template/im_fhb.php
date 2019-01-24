<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>发红包</title>
	<script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
</head>
<body>

<h1>发红包</h1>
<form action="im_fhb.html?access_token=544c2b398f29c4c859e082ff6184c60db01ba974" method="post">
	金额：<input type="text" name="hb_amount"><br>
	留言：<input type="text" name="hb_message"><br>
	密码：<input type="text" name="payment_code"><br>
	个数：<input type="text" name="hb_total" value="1"><br>
	付款方式：
	<select name="pay_type">
		<option value="1">余额</option>
		<option value="2">支付宝</option>
		<option value="3">微信</option>
		<option value="4">银行卡</option>
	</select>
	<br>
	<input type="submit" value="塞钱进红包">
	<br><br>
</form>
<form action="im_shb.html?access_token=544c2b398f29c4c859e082ff6184c60db01ba974" method="post">
	要领取的红包id:<input type="text" name="hb_fid">
	<input type="submit" value="领取红包">
</form>
<br><br>
<form action="im_hbdetail.html?access_token=544c2b398f29c4c859e082ff6184c60db01ba974" method="post">
	<h2>我的红包详情</h2>
	第<input type="text" name="pagesize">页<br>
	每页<input type="text" name="pagecount">条<br>
	<input type="submit" value="查询">
</form>

</body>
</html>

<script>




</script>