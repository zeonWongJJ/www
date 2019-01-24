$(function(){
	//点击右边导航
	$('.rdR ul li').click(function(){
		$(this).addClass('rCurrent').siblings().removeClass('rCurrent');
	});
	//选择分量
	$('body').on('click','.chooseBox .component li',function(){
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	});
	//选择口味
	$('body').on('click','.chooseBox .taste li',function(){
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	});
	//选择温度
	$('body').on('click','.chooseBox .temperature li',function(){
		$(this).addClass('xCurrent').siblings().removeClass('xCurrent');
	});
	
	//显示点菜弹框
	$('body').on('click','.rDown .lList>ul>li>a',function(){
		$(this).next().show();
		if( $(".packageShow").hasClass("btnCur") ){
			$(".packageShow").removeClass("btnCur");
			$(".packageShow>a.sureBtn").remove();
		}
	});
	//关闭
	$('body').on('click','.dClose',function(){
		$('.detailBomb').hide();
	});

	//点击详情弹窗的 确定 按钮
	$('body').on('click','.btnBox>a',function(){
		var $this=$(this);
		var list=$this.parent().parent().parent().parent().parent().parent().parent();
		var menuTitle="";//设置属性分类的标题变量作为保存
		var menuName="";//设置属性分类的变量作为保存
		var cateTitle=$this.parent().parent().parent().parent().prev().children("p.lName");
		var cateList=$this.parent().parent().find("div.single>div.xuan>ul>li.xCurrent>a");
		cateTitle.each(function(){
			menuTitle+=$(this).html();
		});
		cateList.each(function(){
			menuName+=$(this).html()+"/";
		});

		//如果当前列表index==循环添加创建出的元素的class的index
		if( list.index()== $(".s"+list.index()).index() ){
			$(".packageShow>.s"+list.index()+">span").html( menuTitle);//将orderList的index作为循环出来的元素作为寻找的条件，并将累加的种类标题作为元素内容
			$(".packageShow>.s"+list.index()+">em").html(menuName);//将orderList的index作为循环出来的元素作为寻找的条件，并将累加的分类属性作为元素内容
		}
		empty();
		$('.detailBomb').hide();
	});

	// 数量操作，增加和减少
	$('body').on('click','.oRight a',function(){
		cart_add_subtract($(this).attr('product_index'), $(this).attr('class'));
	})

	$(".listContent>div").not( $(".listCur")).hide();
	$(".choiceNav>a").click(function(){
		var $this=$(this);
		$(this).addClass("chCur");
		$(".choiceNav>a").not($(this)).removeClass("chCur");
		if( $this.index()==$this.index() ){
			$(".c"+$this.index()).show();
			$(".c"+$this.index()).addClass("listCur");
			$(".listContent>div").not( $(".c"+$this.index())).hide();
			$(".listContent>div").not( $(".c"+$this.index())).removeClass("listCur");
		}
	});

	$(".listContent>div").each(function(i){
		$(this).addClass("c"+i);
	});
	
	//循环选项导航
	$(".choiceNav>a").each(function(i){
		/*在此元素下根据选项导航的个数来创建*/
		$(".packageShow").append($("<p class=\"s"+i+"\"><span></span><em></em></p>"+" + "));
	});

	empty();

	$(".sureBtn").hide();
	//判断内容是否为空
	function empty(){
		if( $(".packageShow>p>span").is(":empty") ){//如果此元素下的内容为空
			$(".packageShow>a").remove();
		}else{
			$(".packageShow").addClass("btnCur");
			$(".packageShow").append($("<a class='sureBtn' id='submit_btn'>选好了</a>"));
		}
	};

});

