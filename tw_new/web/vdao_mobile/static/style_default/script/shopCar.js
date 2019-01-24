$(function(){
	//点击管理
	$('.title .guan').click(function(){
		var tTxt = $(this).text();
		if(tTxt == '管理'){
			$('.main .control').show();
			$(this).text('完成');
		}else if(tTxt == '完成'){
			$('.main .control').hide();
			$(this).text('管理');
		}
	})

	//全选
	$(".allCho").click(function(){
		var $this=$(this);//保存this
		var choLen=$(".singleCho").length;//复选框的个数
		var singLen=$(".singleHas").length;//勾选的个数
		var totoal=0;
		if( $this.hasClass("allHas") ){
			$(".sDiv").removeClass("id");
			$this.removeClass("allHas");
			$(".singleCho").removeClass("singleHas");
			$(".smallTot>.jian").html("0");//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
		}else{
			$(".sDiv").addClass("id");
			$this.addClass("allHas");
			$(".singleCho").addClass("singleHas");
			$(".smallTot>.jian").html(choLen);//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
		}
		var cart_arr = new Array();
		var i = 0;
		$('.singleHas').each(function(index, el) {
			cart_arr[i] = $(this).attr('value');
			i++;
		});
		cart_ids = cart_arr.join(',');
		$("input[name='cart_ids']").val(cart_ids);
	});

	//勾选
	$(".singleCho").click(function(){
		var choLen;//复选框的个数
		var singLen;//勾选的个数
		var totoal=0;
		var $this=$(this);//保存this

		if( $this.hasClass("singleHas") ){//如果有这个Class
			choLen=$(".singleCho").length;//复选框的个数
			singLen=$(".singleHas").length;//勾选的个数
			singLen--;
			$this.removeClass("singleHas");
			$this.next(".sDiv").removeClass("id");
			$(".smallTot>.jian").html(singLen);//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
			if( singLen==choLen ){//如果勾选的总数等于复选框的总数
				$(".allCho").addClass("allHas");//全选勾上
			}else{
				$(".allHas").removeClass("allHas");//全选去掉
			}
		}else{//没有这个Class
			$this.next(".sDiv").addClass("id");
			$this.addClass("singleHas");
			choLen=$(".singleCho").length;//复选框的个数
			singLen=$(".singleHas").length;//勾选的个数
			$(".smallTot>.jian").html(singLen);//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
			if( singLen==choLen ){//当复选框的个数等于勾选的个数
				$(".allCho").addClass("allHas");
			}else{
				$(".allHas").removeClass("allHas");
			}
		}
		var cart_arr = new Array();
		var i = 0;
		$('.singleHas').each(function(index, el) {
			cart_arr[i] = $(this).attr('value');
			i++;
		});
		cart_ids = cart_arr.join(',');
		$("input[name='cart_ids']").val(cart_ids);
	});
	single();
	function single(){
		var choLen;//复选框的个数
		var singLen;//勾选的个数
		var totoal=0;
		var $this=$(this);//保存this
		if( $this.hasClass("singleHas") ){//如果有这个Class
			choLen=$(".singleCho").length;//复选框的个数
			singLen=$(".singleHas").length;//勾选的个数
			singLen--;
			$this.removeClass("singleHas");
			$this.next(".sDiv").removeClass("id");
			$(".smallTot>.jian").html(singLen);//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
			if( singLen==choLen ){//如果勾选的总数等于复选框的总数
				$(".allCho").addClass("allHas");//全选勾上
			}else{
				$(".allHas").removeClass("allHas");//全选去掉
			}
		}else{//没有这个Class
			$this.next(".sDiv").addClass("id");
			$this.addClass("singleHas");
			choLen=$(".singleCho").length;//复选框的个数
			singLen=$(".singleHas").length;//勾选的个数
			$(".smallTot>.jian").html(singLen);//底部小计
			$(".singleHas").each(function(i){
				totoal+=$(this).next().find(".quantity>.qNum").html()*$(this).next().find(".describe>.money>.qian").html();
			});
			$(".smallMon1").html(totoal.toFixed(2));
			$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
			if( singLen==choLen ){//当复选框的个数等于勾选的个数
				$(".allCho").addClass("allHas");
			}else{
				$(".allHas").removeClass("allHas");
			}
		}
		var cart_arr = new Array();
		var i = 0;
		$('.singleHas').each(function(index, el) {
			cart_arr[i] = $(this).attr('value');
			i++;
		});
		cart_ids = cart_arr.join(',');
		$("input[name='cart_ids']").val(cart_ids);
	}

	//增加商品
	$(".add").click(function(){
		var $this=$(this);//保存this
		var num=$this.next(".qNum").html();//获取当前商品的件数
		var curPrice=$this.parent().prev().children("p.money").children("i.qian").html();//当前商品的总价格
		var totoal=0;//初始化累加的变量
		Number(num++);//点击增加1件

		if( $(".singleHas").length<2 ){//当勾选的个数只有一个的时候
			$(".singleHas").each(function(){//循环勾选中的长度
				if( $this.parent().parent().prev().hasClass("singleHas") ){//当前的复选框是否有Class
					//累加 当前的商品件数剩以当前商品的单价
					totoal+=(Number($this.next(".qNum").html())+1)*$this.parent().prev().children("p.money").children("i.qian").html();
					$(".smallMon1").html(Number(totoal).toFixed(2));//将累加的结果放回小计
					$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
				}
			})
		}else if(  $(".singleHas").length>1 ){//当勾选的个数大于一个的时候
			$(".singleHas").each(function(i){//循环勾选中的长度
				//累加 当前的商品件数剩以当前商品的单价
				totoal+=(Number($(this).next().find(".quantity>.qNum").html()))*$(this).next().find(".describe>.money>.qian").html();
			});
			if( $this.parent().parent().prev().hasClass("singleHas") ){//当前的复选框是否有Class
				$(".smallMon1").html((Number(totoal)+Number(curPrice)).toFixed(2));//将累加的结果放回小计
				$(".allMon").html((Number($(".peisong").html())+(Number(totoal)+Number(curPrice))).toFixed(2));//总计
			}
		}

		$this.next(".qNum").html(num); //获取增加后的件数再放回当前商品的件数里
		$(this).siblings('.buynum').attr("value", num);

		// ajax请求更改购物车数量
		var cart_id = $this.attr('value');
		$.ajax({
			url: 'shopcar_update',
			type: 'POST',
			dataType: 'json',
			data: {cart_id: cart_id, num:num},
			success: function (res) {
				console.log(res);
			}
		})

	});

	//减少商品
	$(".less").click(function(){
		var $this=$(this);//保存this
		var num=$this.prev(".qNum").html();//获取当前商品的件数
		var curPrice=$this.parent().prev().children("p.money").children("i.qian").html();//当前商品的总价格
		var totoal=0;//初始化累加的变量
		Number(num--);//点击减少1件

		if( num<=1 ){ //如果当前件数少于等于0
			$this.prev(".qNum").html("1"); //获取当前商品的件数设为0
			$(this).siblings('.buynum').attr("value", 1);
		}else{
			$this.prev(".qNum").html(num); //否则将获取减少后的件数再放回当前商品的件数里
			$(this).siblings('.buynum').attr("value", num);
		}

		if( $(".singleHas").length<2 ){//当勾选的个数只有一个的时候
			$(".singleHas").each(function(){//循环勾选中的长度
				if( $this.parent().parent().prev().hasClass("singleHas") ){//当前的复选框是否有Class
					//累加 当前的商品件数剩以当前商品的单价
					totoal+=(Number($this.prev(".qNum").html()))*$this.parent().prev().children("p.money").children("i.qian").html();
					$(".smallMon1").html(Number(totoal).toFixed(2));//将累加的结果放回小计
					$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
				}
			})
		}else if(  $(".singleHas").length>1 ){//当勾选的个数大于一个的时候
			$(".singleHas").each(function(i){//循环勾选中的长度
				//累加 当前的商品件数剩以当前商品的单价
				totoal+=(Number($(this).next().find(".quantity>.qNum").html()))*$(this).next().find(".describe>.money>.qian").html();
			});
			if( $this.parent().parent().prev().hasClass("singleHas") ){//当前的复选框是否有Class
				$(".smallMon1").html(Number(totoal).toFixed(2));//将累加的结果放回小计
				$(".allMon").html((Number($(".peisong").html())+totoal).toFixed(2));//总计
			}
		}

		// ajax请求更改购物车数量
		var cart_id = $this.attr('value');
		$.ajax({
			url: 'shopcar_update',
			type: 'POST',
			dataType: 'json',
			data: {cart_id: cart_id, num:num},
			success: function (res) {
				console.log(res);
			}
		})

	});

	// 添加收藏夹
	$('.addIn').click(function() {
		var ind = '';
		$('.id').each(function(){
			ind += $(this).attr('value')+",";
		})
		var id = ind.substring(0, ind.length-1);
		if (id != '') {
			$.ajax({
				type : 'post',
				url  : 'collection_add',
				data : {id:id,type:3},
				dataType : 'json',
				success  : function(data) {
					// console.log(data);
					if (data.code == 200) {
						window.location.reload();
					}
				}
			})
		};

	})

	// 删除购物车
	$('.delete').click(function() {
		$(".chooseBox>a").removeClass("allHas");
		var ind = '';
		$('.singleHas').each(function(){
			ind += $(this).attr('value')+",";
		});
		var id = ind.substring(0, ind.length-1);
		if (id != '') {
			$.ajax({
				type : 'post',
				url  : 'shop_dele',
				data : {id:id},
				dataType : 'json',
				success  : function(data) {
					// console.log(data);
					if (data.code == 200) {
						window.location.reload();
						
					}
				}
			})
		};

	})

	//订单结算
	$('.countMoney .goCount').click(function(){
		if($("input[name='cart_ids']").val()){
			var len = $('.singleHas').length;
			$(this).children('input').remove();
			$("form").submit();
		}else{
			alert("请选择结算商品!");
		}
		
	})

})