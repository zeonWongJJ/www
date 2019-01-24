/**
 * Created by 7du-29 on 2017/9/19.
 */
$(function(){
    //产品名称
    function keyCode(codeNum,eleThis,findEle1,findEle2,img1,img2){
        var limitNum =codeNum;
        var pattern = '还可以输入' + limitNum + '字符/汉字';
        findEle1.html(pattern);
        var remain = eleThis.val().length;
        if(remain >codeNum){
            pattern = "字数超过限制！";
            findEle2.attr("src",img2);
        }else{
            var result = limitNum - remain;
            pattern = '还可以输入' + result + '字符/汉字';
            findEle2.attr("src",img1);
        }
        findEle1.html(pattern);
    }
    //产品名称
    $("#product_name").keyup(function(){
        keyCode(9,$(this),$(".productName>span>em"),$(".productName>span>img"),"images/t_03.png","images/f_03.png");
    });

    //产品描述
    $("#describe").keyup(function(){
        keyCode(200,$(this),$(".productDescribe>span>em"),$(".productDescribe>span>img"),"images/t_03.png","images/f_03.png");
    });

    //产品分类
    $("#product_cate_A").change(function(){
        $("#product_cate_A option").each(function(i){
            if($(this).attr("selected")){
                $(".product_cate_B").hide();
                $(".product_cate_B").eq(i).show();
            }
        });
    });
    $("#product_cate_A").change();

    //产品关键字
    $("#key_word").keydown(function(e){
        e.preventDefault();
        if(e.keyCode==13){
            if($(this).val()!=""){
                $(this).next(".containerCate").append($("<span class='tag'>"+$(this).val()+"<img src='images/pro_19.png'>"+"</span>"));
                $(this).val("");
            }else{
                alert( "请输入");
            }
        }
    })
    $(".tag>img").live("click",function(){
        $(this).parent("span.tag").remove();
    });

    // 初始化插件
    $("#product_pic").zyUpload({
        width            :   "650px",                 // 宽度
        height           :   "400px",                 // 宽度
        itemWidth        :   "120px",                 // 文件项的宽度
        itemHeight       :   "100px",                 // 文件项的高度
        url              :   "/upload/UploadAction",  // 上传文件的路径
        multiple         :   true,                    // 是否可以多个文件上传
        dragDrop         :   true,                    // 是否可以拖动上传文件
        del              :   true,                    // 是否可以删除文件
        finishDel        :   false,  				  // 是否在上传文件完成后删除预览
        /* 外部获得的回调接口 */
        onSelect: function(files, allFiles){                    // 选择文件的回调方法
            console.info("当前选择了以下文件：");
            console.info(files);
            console.info("之前没上传的文件：");
            console.info(allFiles);
        },
        onDelete: function(file, surplusFiles){                     // 删除一个文件的回调方法
            console.info("当前删除了此文件：");
            console.info(file);
            console.info("当前剩余的文件：");
            console.info(surplusFiles);
        },
        onSuccess: function(file){                    // 文件上传成功的回调方法
            console.info("此文件上传成功：");
            console.info(file);
        },
        onFailure: function(file){                    // 文件上传失败的回调方法
            console.info("此文件上传失败：");
            console.info(file);
        },
        onComplete: function(responseInfo){           // 上传完成的回调方法
            console.info("文件上传完成");
            console.info(responseInfo);
        }
    });

    $(".cateDisplay>em").click(function(){
        if($(this).index()==1){
            $(this).parent("li.cateDisplay").find(".sure>img").attr("src","images/pro_36.png");
            $(".cateDisplay>em.deny>img").attr("src","images/pro_38.png");
        }else if($(this).index()==2){
            $(this).parent("li.cateDisplay").find(".deny>img").attr("src","images/pro_36.png");
            $(".cateDisplay>em.sure>img").attr("src","images/pro_38.png");
        }
    })

})









