/**
 * Created by 7du-29 on 2018/3/19.
 */
$(function(){
    //$(".groupContent>div>ul").hide();
    // 原始图片
    upload_update();
    //鼠标移入显示
    $(document).on("mouseenter",".groupContent>div",function(){
        $(this).children("ul").show();
        $(this).css("border-bottom","white");
        $(this).children("ul").css("border-top","white");
    });

    //鼠标移出隐藏
    $(document).on("mouseleave",".groupContent>div",function(){
        $(this).children("ul").hide();
        $(this).css("border-bottom","1px solid #ddd");
        $(this).children("ul").css("border-top","1px solid #ddd");
    });

    // $(document).on("click",".groupName>ul>li",function(){
    //     if( $(this).hasClass("nameCur") ){
    //         $(this).removeClass("nameCur");
    //         $(this).find("a>img").attr("src","/static/style_default/image/qx_05.png");
    //     }else{
    //         $(this).addClass("nameCur");
    //         $(this).find("a>img").attr("src","/static/style_default/image/qx_03.png");
    //     }
    // });

    // //点击"加号"生成选项
    // $(document).on("click",".addOption",function(){
    //     $(".optionContainer").append(
    //     '<div class="optionlist">' +
    //         '<p>选项1</p>'+
    //         '<img src="/static/style_default/image/pro_19.png" alt=""/>'+
    //         '<div class="groupContent">' +
    //             '<div class="groupCate">'+
    //                 '<a>'+
    //                     '<span>请选择产品分类</span>'+
    //                     '<img src="/static/style_default/image/xia.png" alt=""/>'+
    //                 '</a>'+
    //                 '<ul>'+
    //                     '<li><a>挝的啡</a></li>'+
    //                     '<li><a>挝的啡</a></li>'+
    //                     '<li><a>挝的啡</a></li>'+
    //                 '</ul>'+
    //             '</div>'+
    //             '<div class="groupName">' +
    //                 '<a>'+
    //                     '<span>请选择产品名称</span>'+
    //                     '<img src="/static/style_default/image/xia.png" alt=""/>'+
    //                 '</a>'+
    //                 '<ul>'+
    //                     '<li>' +
    //                         '<a>' +
    //                             '<span>大椰挝啡</span>'+
    //                             '<img src="/static/style_default/image/qx_05.png" alt=""/>'+
    //                         '</a>' +
    //                     '</li>'+
    //                 '</ul>'+
    //             '</div>'+
    //         '</div>'+
    //     '</div>');
    // });
    // //删除选项
    // $(document).on("click",".optionlist>img",function(){
    //     $(this).parent().remove();
    // });
    
    //产品供应区间
     $(".productBox>a").click(function(){
        if( $(this).hasClass("check") ){
            $(this).removeClass("check");
            $(this).children("img").remove();
        }else{
            $(this).addClass("check");
            $(this).append($("<img src='/static/style_default/image/ac_03.png'/>"));
        }
        var i = 0;
        var time_arr = new Array();
        $('.productBox .check').each(function(index, el) {
            time_arr[i] = $(this).attr('value');
            i++;
        });
        var time_str = time_arr.join(',');
        $("input[name='supply_time']").val(time_str);
    });

    var initState={
        packageName:true,
        packageSort:true,
        packageTime:true,
        packagePrice:true,
        packageCate:true,
        packageKey:true,
        packagePic:true
    };

    //套餐名称
    $('#packageName').keyup(function(){
        var limitNum =14;
        var pattern = '还可以输入' + limitNum + '字符/汉字';
        $('.package_name>span>em').html(pattern);
        var remain = $(this).val().length;
        if(remain >14){
            pattern = "字数超过限制！";
            $('.package_name>span>img').attr("src","/static/style_default/image/f_03.png");
            initState.packageName=false;
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            $('.package_name>span>img').attr("src","/static/style_default/image/t_03.png");
            initState.packageName=true;
        }
        $('.package_name>span>em').html(pattern);
    });
    $("#packageName").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $(".package_name>span").removeClass("hide");
            $('.package_name>span>img').attr("src","/static/style_default/image/f_03.png");
            $('.package_name>span>em').html("请输入");
            initState.packageName=false;
        }else{
            $(".package_name>span").removeClass("hide");
            $('.package_name>span>img').attr("src","/static/style_default/image/t_03.png");
            $('.package_name>span>em').html("");
            initState.packageName=true;
        }
    });
    //排序
    $("#packageSort").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $('.package_sort>span').removeClass("hide");
            $('.package_sort>span>img').attr("src","/static/style_default/image/f_03.png");
            $('.package_sort>span>em').html("请输入");
            initState.packageSort=false;
        }else{
            $('.package_sort>span').removeClass("hide");
            $('.package_sort>span>img').attr("src","/static/style_default/image/t_03.png");
            $('.package_sort>span>em').html("");
            initState.packageSort=true;
        }
    });
    //价钱
    $("#packagePrice").blur(function(){
        var val=$(this).val();
        if( val=="" ){
            $('.package_price>span').removeClass("hide");
            $('.package_price>span>img').attr("src","/static/style_default/image/f_03.png");
            $('.package_price>span>em').html("请输入");
            initState.packagePrice=false;
        }else{
            $('.package_price>span').removeClass("hide");
            $('.package_price>span>img').attr("src","/static/style_default/image/t_03.png");
            $('.package_price>span>em').html("");
            initState.packagePrice=true;
        }
    });

    //套餐组合
    // $(document).on("click",".groupName>ul>li",function(){
    //     var listLen=$(".optionlist").length;
    //     if( $(this).hasClass("nameCur") ){
    //         $(this).parent().parent().parent().parent().addClass("curLen");
    //         if( listLen==$(".curLen").length ){
    //             $('.package_mix>span').removeClass("hide");
    //             $('.package_mix>span>img').attr("src","/static/style_default/image/t_03.png");
    //             $('.package_mix>span>em').html("");
    //             initState.packageCate=true;
    //         }else{
    //             $('.package_mix>span').removeClass("hide");
    //             $('.package_mix>span>img').attr("src","/static/style_default/image/f_03.png");
    //             $('.package_mix>span>em').html("请继续选择其他选项");
    //             initState.packageCate=false;
    //         }
    //     }else{
    //         $('.package_mix>span').removeClass("hide");
    //         $('.package_mix>span>img').attr("src","/static/style_default/image/f_03.png");
    //         $('.package_mix>span>em').html("请继续选择其他选项");
    //         initState.packageCate=false;
    //     }
    // });

    //关键字
    $("#package_key").blur(function(){
        if( $(".containerCate>span").length>0 ){
            $(".packageKey>span").removeClass("hide");
            $(".packageKey>span>img").attr("src","/static/style_default/image/t_03.png");
            $(".packageKey>span>em").html("");
            initState.packageKey=true;
        }else{
            $(".packageKey>span").removeClass("hide");
            $(".packageKey>span>img").attr("src","/static/style_default/image/f_03.png");
            $(".packageKey>span>em").html("请输入关键字后按下回车");
            initState.packageKey=false;
        }
    });
    $("#package_key").keydown(function(e){
        if(e && e.keyCode==13){
            if($(this).val()!=""){
                $(this).next(".containerCate").append($("<span class='tag'>"+$(this).val()+"<img src='/static/style_default/image/pro_19.png'>"+"</span>"));
                $(this).val("");
                e.preventDefault();
                pro_keywords();
            }else{
                alert( "请输入");
                e.preventDefault();
            }
        }
    });
    $(".tag>img").live("click",function(){
        var tagLen=$(".containerCate>span.tag").length-1;
        $(this).parent("span.tag").remove();
        pro_keywords();
        if( tagLen==0 ){
            $(".packageKey>span").removeClass("hide");
            $(".packageKey>span>img").attr("src","/static/style_default/image/f_03.png");
            $(".packageKey>span>em").html("请输入关键字后按下回车");
            initState.packageKey=false;
        }
        console.log( tagLen );
    });
    //图片上传
    $("#upload_box").click(function(){
        if( $(".minbox").length<=0 ){
            initState.packagePic=false;
        }else{
            initState.packagePic=true;
        }
    });

    //提交
    $("#reSub").click(function(){
    	//判断产品供应是否有选中
    	if( $(".productBox>a.check").length==0 ){
    		initState.packageTime=false;
    	}else{
    		initState.packageTime=true;
    	}
        if( initState.packageName && initState.packageSort && initState.packageTime && initState.packagePrice && initState.packageCate && initState.packageKey && initState.packagePic ){
            $(this).submit();
        }else{
            alert("有选项未输入或未选择");
            return false;
        }
    });
});

function pro_keywords() {
    var i = 0;
    var key_arr = new Array();
    $('.containerCate span').each(function(index, el) {
        if ($.trim($(this).text()) != '') {
            key_arr[i] = $.trim($(this).text());
            i++;
        }
    });
    if (key_arr.length > 0) {
        $("input[name='antistop']").val(key_arr.join(','));
    } else {
        $("input[name='antistop']").val('');
    }
}












