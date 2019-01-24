$(function(){
	//点击表情
	$('body').on('click','.appBox .rFace .good',function(){
		$(".rFace .bad").removeClass('yBad');
		$(".rFace .soso").removeClass('ySoso');
		$(this).toggleClass('yGood');
		if ($(this).hasClass('yGood')) {
			$("input[name='comment_cate']").val('1');
		} else {
			$("input[name='comment_cate']").val('');
		}
	})
	$('body').on('click','.appBox .rFace .soso',function(){
		$(".rFace .good").removeClass('yGood');
		$(".rFace .bad").removeClass('yBad');
		$(this).toggleClass('ySoso');
		if ($(this).hasClass('ySoso')) {
			$("input[name='comment_cate']").val('2');
		} else {
			$("input[name='comment_cate']").val('');
		}
	})
	$('body').on('click','.appBox .rFace .bad',function(){
		$(".rFace .good").removeClass('yGood');
		$(".rFace .soso").removeClass('ySoso');
		$(this).toggleClass('yBad');
		if ($(this).hasClass('yBad')) {
			$("input[name='comment_cate']").val('3');
		} else {
			$("input[name='comment_cate']").val('');
		}
	})

	//点击标签
	$('body').on('click','.appBox .tag a',function(){
		$(this).toggleClass('tChoose');
		var tag_arr = new Array();
		var i = 0;
		$(".tag .tChoose").each(function(index, el) {
			tag_arr[i] = $(this).text();
			i++;
		});
		var tag_str = tag_arr.join(',');
		$("input[name='comment_tags']").val(tag_str);
	})

	//输入点评字数减少
	$('.appBox .txtDiv .txt').keydown(function(){
		var len = $(this).val().length;
		var num = 200 - len;
		$(this).siblings('.num').children('span:eq('+0+')').text(num);
		$(this).siblings('.num').children('span:eq('+0+')').css('color','red');
	})

	//选择服务态度/质量
	$('body').on('click','.manner .star i',function(){
		var tIndex = $(this).index();
		var sLen = $(this).closest('.star').find('.sChoose').length;
		if(tIndex == 0 && $(this).hasClass('sChoose') && sLen == 1){
			$(this).removeClass('sChoose');
			$(this).parent().siblings('.very').text('');
		}else{
			$(this).addClass('sChoose');
			$(this).prevAll().addClass('sChoose');
     		$(this).nextAll().removeClass('sChoose');
     		if(tIndex == 0){
     			$(this).parent().siblings('.very').text('非常差');
     		}else if(tIndex == 1){
     			$(this).parent().siblings('.very').text('差');
     		}else if(tIndex == 2){
     			$(this).parent().siblings('.very').text('一般');
     		}else if(tIndex == 3){
     			$(this).parent().siblings('.very').text('好');
     		}else if(tIndex == 4){
     			$(this).parent().siblings('.very').text('非常好');
     		}
		}
		var i = 0;
		var j = 0;
		$(".service_star .sChoose").each(function(index, el) {
			i++;
		});
		$(".goods_star .sChoose").each(function(index, el) {
			j++;
		});
		$("input[name='service_score']").val(i);
		$("input[name='goods_score']").val(j);
	})

	//退出评价
	$('.head .back').click(function(){
		$('.shade').show();
		$('.outBomb').show();
	})
	$('.outBomb .cancel').click(function(){//关闭弹框
		$('.shade').hide();
		$('.outBomb').hide();
	})

	//提交成功提示
	$('.head .submit').click(function(){
		// 提交表单
		$("#commentform").submit();
		$('.blackTips').show();
		setTimeout(function(){
			$('.blackTips').hide();
		},1100)
	})

	//勾选匿名评价
	$('.hideName .gou').click(function(){
		$(this).toggleClass('hasGou');
		if ($(this).hasClass('hasGou')) {
			$("input[name='is_anonymous']").val('1');
		} else {
			$("input[name='is_anonymous']").val('0');
		}
	})
})


function imgChange(obj1, obj2) {
   //获取点击的文本框
   var file = document.getElementById("file");
   //存放图片的父级元素
   var imgContainer = document.getElementsByClassName(obj1)[0];
   //获取的图片文件
   var fileList = file.files;
   console.log(fileList );
   //文本框的父级元素
   var input = document.getElementsByClassName(obj2)[0];
   var imgArr = [];
   //遍历获取到得图片文件
   for (var i = 0; i < fileList.length; i++) {
      var imgUrl = window.URL.createObjectURL(file.files[i]);
      imgArr.push(imgUrl);
      var img = document.createElement("img");
      img.setAttribute("src", imgArr[i]);
      var imgAdd = document.createElement("div");
      imgAdd.setAttribute("class", "z_addImg");
      if( $(".z_addImg").length!=9 ){
         imgAdd.appendChild(img);
         imgContainer.appendChild(imgAdd);
      }
   };
   if( $(".z_addImg").length>=9  ){
      $(".tips").stop().show(100).delay(3000).hide(100);
      $(".tips").html("图片不能超过9张！");
   }

   imgRemove();
};

function imgRemove() {
   var imgList = $(".z_addImg");
   var mask =$(".z_mask")[0];
   var cancel =$(".z_cancel")[0];
   var sure = $(".z_sure")[0];
   for (var j = 0; j < imgList.length; j++) {
      imgList[j].index = j;
      imgList[j].onclick = function() {
         var t =this;
         console.log(this);
         mask.style.display = "block";
         cancel.onclick = function() {
            mask.style.display = "none";
         };
         sure.onclick = function() {
            mask.style.display = "none";
            t.remove();
         };
      }
   };
};
