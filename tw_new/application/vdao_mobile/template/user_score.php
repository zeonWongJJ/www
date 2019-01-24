<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta content="yes" name="apple-touch-fullscreen">
		<title>我的积分</title>
		<link href="static/style_default/style/common.css" rel="stylesheet" type="text/css">
		<link href="static/style_default/style/myIntegral.css" rel="stylesheet" type="text/css" />
		<script src="static/style_default/script/flexible.js" type="text/javascript"></script>
		<script src="./static/style_default/plugin/jquery-1.8.2.min.js"></script>
	</head>
	<style type="text/css">
		.curBox,.goPoint{
			vertical-align: middle;
		}
		.curBox{
			display: inline-block;
			text-align: left;
			margin-left:0.6rem;
			margin-top:0.8rem;
			margin-bottom: 1rem;
		}
		.curBox>span{
			font-size:0.42rem;
			color:White;
		}
		.curBox>p{
			font-size:1.4rem;
			color:White;
			margin-top:0.3rem;
		}
		.goPoint{
			width:2rem;
			height:0.7rem;
			line-height:0.7rem;
			display: inline-block;
			text-align: center;
			margin-right:0.7rem;
			margin-top:2rem;
			float:right;
			font-size:0.4rem;
			border-radius: 0.1rem;
			cursor: pointer;
			background: white;
		}
		 .head{
	height: 1.733333rem;
	text-align: center;
	font-size: 0.426666rem;
	padding-top: 0.853333rem;
	background: white;
	position: relative;
	border-bottom: 1px solid #d7d7d7;
}
 .head i{
	font-style: normal;
}
 .head a.back{
	margin-top: 0.066666rem;
	width: 0.32rem;
	position: absolute;
	left: 0.533333rem;
	top: 0.2rem;
}
.explain_box{
	width:100%;
	height:100%;
	display: none;
}
 .content{
	background: white;
	padding-left: 0.4rem;
	margin-top: 0.266666rem;
}
.content .validTime{
	padding: 0.266666rem 0.4rem 0.266666rem 0;	
	border-bottom: 1px solid #D7D7D7;
}
.content .validTime .h3{
	font-size: 0.346666rem;
	color: #333333;
	font-weight: bold;
	margin-bottom: 0.093333rem;
}
.content .validTime .wen{
	font-size: 0.346666rem;
	color: #333333;
	line-height: 0.613333rem;
}
	.close{
		text-align: center;
		margin-top:0.4rem;
	}
	.close>img{
		width:0.4rem;
		cursor: pointer;
	}
	html,body{height:auto}
	</style>
	<body>
	<!-- 拉框开始 -->
    <?php echo $this->display('head'); ?>
    <!-- 拉框结束 -->
		<div class="main">
			<header class="head">
				<a class="back" href="https://vdao-mobile.7dugo.com/nuser_center "> <img src="static/style_default/images/dri_03.png"/></a>
				<i>我的积分</i>
				<a class="explain" ><img src="static/style_default/images/hsdf .png" alt="" /></a>
			</header>
			<div class="currentInt clearfix">
				<div class="curBox">
					<span>当前积分</span>
					<p><?php echo $a_view_data['user']['user_score']; ?></p>
				</div>
				<a href="new_withdraw_score-1" class="goPoint">提现</a>
				<!--<p class="p2 p2_a"><a class="" href="new_withdraw_score-1" style="">积分提现</a></p>--> 
			</div>
			
			<div class="detailList">
				<ul>
					<li class="title">
						<a href="javascript:;">
							<p class="type">积分明细</p>
							<i class="yellow"></i>
						</a>
					</li>
					<?php foreach ($a_view_data['score'] as $key => $value): ?>
					<li>
						<a href="score_detail-<?php echo $value['pl_id']; ?>">
							<p class="type"><?php echo $value['pl_item']; ?></p>
							<p class="time"><?php echo date('Y-m-d H:i:s', $value['pl_time']); ?></p>
							<p class="num"><?php if ($value['pl_type'] == 1) { echo '+'.$value['pl_variation']; } else { echo '-'.$value['pl_variation']; } ?></p>
						</a>
					</li>
					<?php endforeach ?>
				</ul>
				<!-- <span>更多记录</span> -->
			</div>
		</div>
		
		<div class="explain_box">
			
			<p class="close"><img  src="static/style_default/images/xx_03.png"/></p>
			<div class="content" style="padding-left:0">
				<img style="width:100%" src="static/style_default/images/poioo_02.png" alt="" />
			</div>
		</div>

	</body>
</html>

<script>

var page = 1;
var stop = true;
var recode = 200;
// 当滚动条滚到底时加载更多
$(window).scroll(function(){
	// console.log(111);
   var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
    if($(document).height() <= totalheight){

    	// console.log(recode);
        if (stop == true) {
        	setTimeout("user_scoremore()",1000);
            // user_scoremore();
        }
        if (recode == 400) {
            stop = false;
        }
    }
});

function user_scoremore() {
	page++;
	$.ajax({
		url: 'user_scoremore',
		type: 'POST',
		dataType: 'json',
		data: {page: page},
		success: function(res) {
			// console.log(res);
			if (res.code == 200) {
				var append_content = '';
				$.each(res.data, function(index, el) {
					append_content += '<li>';
					append_content += '<a href="score_detail-'+el.pl_id+'">';
					append_content += '<p class="type">'+el.pl_item+'</p>';
					append_content += '<p class="time">'+el.pl_time+'</p>';
					append_content += '<p class="num">';
					if (el.pl_type == 1) {
						append_content += '+'+el.pl_variation;
					} else {
						append_content += '-'+el.pl_variation;
					}
					append_content += '</p>';
					append_content += '</a>';
					append_content += '</li>';
				});
				$('.detailList ul').append(append_content);
			}else{
				recode = 400;
				stop = 400;
			}
		}
	})
}

$(".explain").click(function(){
	$(".explain_box").show();
	$(".main").hide();
})
$(".close>img").click(function(){
	$(".explain_box").hide();
	$(".main").show();
})
</script>
