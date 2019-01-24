/**
 * Created by 7du-29 on 2017/9/21.
 */
$(function(){
	$(".tips").hide();
	$(".lay").hide();
	
    //ѡ�񿧷�����
    function choiceCafe(eleThis,add_class,ele){
        eleThis.addClass(add_class);
        ele.not(eleThis).removeClass(add_class);
    }

    $(".coffee_cate>span").click(function(){
        choiceCafe($(this),"cateCur",$(".coffee_cate>span"))
    });
    $(".coffee_type>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_type>span"))
    });
    $(".coffee_grade>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_grade>span"))
    });
    $(".coffee_key>span").click(function(){
        choiceCafe($(this),"typeCur",$(".coffee_key>span"))
    });

	// 改变当前分页的样式
    $('.page a').each(function(index, el) {
        if ($(this).attr('href') == '#') {
            $(this).css('background-color','#6e5c58');
            $(this).css('color','#ffffff');
        }
    });

    //��������
    $(".proDisable>img").click(function(){
        var id = $(this).attr("value");
        if(!($(this).hasClass("disabled"))){
            $.ajax({
                type : 'post',
                url  : 'product_switch',
                data : "id="+id,
                dataType : 'json',
                success  : function(data) {

                }
            })
            $(this).addClass("disabled");
            $(this).attr("src","static/style_default/image/pro_33.png");
        }else{
            $.ajax({
                type : 'post',
                url  : 'product_switch',
                data : "id="+id,
                dataType : 'json',
                success  : function(data) {

                }
            })
            $(this).removeClass("disabled");
            $(this).attr("src","static/style_default/image/pro_10.png");
        }
    });

    //������
    $(".productTips").click(function(e){
        $(this).next(".popLay").removeClass("hide");
        e.stopPropagation();
    });
    $(".popLay").click(function(e){
        e.stopPropagation();
    });
   $(document.body).click(function(){
       $(".popLay").addClass("hide");
   });
    $('.pop_dele').click(function() {
        var id = $(this).attr("value");
        $(".tips").show();
//      $(".lay").show();
        $(".tipsBtn>em").click(function(){
    		$.ajax({
            	type : 'post',
            	url  : 'product_delete',
            	data : "id="+id,
            	dataType : 'json',
            	success  : function(data) {
                	if (data == 200) {
                    	window.location.reload();
                	};
            	}
       	 	})
    	})
        
    });
    
    $(".tipsBtn>a").click(function(){
     	 $(".tips").hide();
    })
    
})



















