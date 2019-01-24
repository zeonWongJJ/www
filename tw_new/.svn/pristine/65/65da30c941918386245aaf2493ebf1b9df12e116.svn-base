$(function(){
	//点击分享
	$('body').on('click','.head .share',function(){
		$('.shade').show();
		$('.shareBomb').show();
	})
	//关闭弹框
	$('.shareBomb .cancel a').click(function(){
		$('.shade').hide();
		$('.shareBomb').hide();
	})

	//点击小图显示大图弹框
	$('body').on('click','.head .img',function(){
		var liIndex = $(this).index();
		$('.shade').show();
		$('.picBomb').show();
		$('.picBomb .picShow ul li').eq(liIndex).addClass('show').siblings().removeClass('show');
	})
	//关闭大图弹框
	$('.picBomb .close2 a').click(function(){
		$('.shade').hide();
		$('.picBomb').hide();
	})
	//点击右键
	$('body').on('click','.picBomb .picWrap .right',function(){
		$('.picBomb .picShow ul li.show').next().addClass('show').siblings().removeClass('show');
	})
	//点击左键
	$('body').on('click','.picBomb .picWrap .left',function(){
		$('.picBomb .picShow ul li.show').prev().addClass('show').siblings().removeClass('show');
	})
})
