$(function(){	
	lenFun();
	$('.txt').keydown(function(){
		lenFun();
	})
	
	//获取图片框的宽度
	var liLen = $('.content .imgBox li').length;
	var ulWidth = liLen*76;
	$('.content .imgBox ul').css('width',''+ulWidth+'%');
	
	//获取点赞图片框的宽度
	var goodLen = $('.goodBox1 .people li').length;
	var goodWidth = goodLen*25;
	$('.goodBox1 .people ul').css('width',''+goodWidth+'%');
	
	//获取点赞图片框的宽度
	var shareLen = $('.shareBox .people li').length;
	var shareWidth = shareLen*25;
	$('.shareBox .people ul').css('width',''+shareWidth+'%');
})
//评论框的高度
function lenFun (){
	var txtLen = ($('.intBox').height() + 90)/75;
	$('.content').css('padding-bottom',''+txtLen+'rem');
}
