/**
 * Created by 7du-29 on 2018/1/5.
 */
$(function(){
    $("#shareSub").attr("disabled",true);
    $(".lay").hide();
    $(".lay").height( $(document).height() );
    $(".regionContainer").hide();
    setDivCenter($(".tips"));

    //遮罩层
    $(".lay").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    });

    //选择地区
    $(".regionChoice").click(function(){
        $(".lay").show();
        $(".regionContainer").show();
    });
    $(".regionContainer>p>img").click(function(){
        $(".lay").hide();
        $(".regionContainer").hide();
    });
    choose_province();
    //初始化
    var state={
        productName:false,
        productPrice:false,
        productNum:false,
        productDeb:false,
        productAddr:false,
        productDelive:false
    };

    //验证
    $("#product_name").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productName=false;
        }else{
            state.productName=true;
        }
        valt();
    });
    $("#product_price").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productPrice=false;
        }else{
            state.productPrice=true;
        }
        valt();
    });
    $("#product_licence").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productNum=false;
        }else{
            state.productNum=true;
        }
        valt();
    });
    $("#product_describe").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productDeb=false;
        }else{
            state.productDeb=true;
        }
        valt();
    });
    $("#product_address").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productAddr=false;
        }else{
            state.productAddr=true;
        }
        valt();
    });
    $("#product_delive").keyup(function(){
        var val=$(this).val();
        if( val=="" ){
            state.productDelive=false;
        }else{
            state.productDelive=true;
        }
        valt();
    });

    function valt(){
        if( state.productName && state.productPrice && state.productNum && state.productDeb && state.productAddr && state.productDelive ){
            $("#shareSub").attr("disabled",false);
            $("#shareSub").css("background","#ff6633");
        }else{
            $("#shareSub").attr("disabled",true);
            $("#shareSub").css("background","#B5B5B5");
        }
    }
    valt();

    //让指定的DIV始终显示在屏幕正中间
    function setDivCenter(divName){
        var top = ($(window).height() - divName.height())/3;
        var left = ($(window).width() - divName.width())/2;
        var scrollTop = $(document).scrollTop();
//      var scrollLeft = $(document).scrollLeft();
        divName.css( { 'top' : top + scrollTop } );
    }

    var nagheight = $(window).height(); //浏览器时下窗口可视区域高度
    var nagwidth  = $(window).width(); //浏览器时下窗口可视区域宽
    var tiph   = $('.tipstwo').outerHeight();
    var tipw   = $('.tipstwo').outerWidth();
    $('.tipstwo').css('top', (nagheight-tiph)/2);
    $('.tipstwo').css('left', (nagwidth-tipw)/2);

});

var myimgnum = 0;
function imgChange(obj1, obj2) {
    //获取点击的文本框
    var file = document.getElementById("file");
    //存放图片的父级元素
    var imgContainer = document.getElementsByClassName(obj1)[0];
    //获取的图片文件
    var fileList = file.files;
    console.log(fileList);
    //文本框的父级元素
    var input = document.getElementsByClassName(obj2)[0];
    var imgArr = [];
    //console.log(file.files[i]);
    //遍历获取到得图片文件
    for (var i = 0; i < fileList.length; i++) {
        var imgUrl = window.URL.createObjectURL(file.files[i]);
        imgArr.push(imgUrl);
        var img = document.createElement("img");
        img.setAttribute("src", imgArr[i]);
        img.setAttribute("onclick","set_mainpic("+myimgnum+",'"+file.files[i].name+"')");
        var imgAdd = document.createElement("div");
        var link=document.createElement("a");
        var dele=document.createElement("i");
        var deleImg=document.createElement("img");
        deleImg.setAttribute("src","static/style_default/images/y_03.png");
        link.setAttribute("class","link");
        imgAdd.setAttribute("class", "z_addImg");
        imgAdd.setAttribute("id", "myimg_"+myimgnum);
        if( $(".z_addImg").length!=10 ){
            imgAdd.appendChild(link);
            dele.appendChild(deleImg);
            link.appendChild(img);
            link.appendChild(dele);
            $(".z_file").before(imgAdd);
        }
        myimgnum++;
    };
    if( $(".z_addImg").length>=10  ){
        $(".tips").stop().show(100).delay(3000).hide(100);
        $(".tips").html("最多上传10张图片");
    }

    imgRemove();
};

function imgRemove() {
    var imgList = $(".z_addImg");
    var mask =$(".z_mask")[0];
    var cancel =$(".z_cancel")[0];
    var sure = $(".z_sure")[0];
    imgList.each(function(i){
        imgList.eq(i).index=i;
        imgList.eq(i).find(".link>i").click(function(){
            var t=$(this).parent().parent();
            t.remove();
        })
    });
};