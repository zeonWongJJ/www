/**
 * Created by 7du-29 on 2017/11/18.
 */
$(function(){
    var storeHeadCheck=$(".storeList>dl>dt>a");//门店
    var storeChildCheck=$(".storeList>dl>dd>img");
    var productHeadCheck=$(".productList>dl>dt>a");//产品
    var productChildCheck=$(".productList>dl>dd>img");
    var officeHeadCheck=$(".officeList>dl>dt>a");//办公室
    var officeChildCheck=$(".officeList>dl>dd>img");

    storeHeadCheck.find("img").css("display","none");
    storeChildCheck.css("display","none");
    productHeadCheck.find("img").css("display","none");
    productChildCheck.css("display","none");
    officeHeadCheck.find("img").css("display","none");
    officeChildCheck.css("display","none");

    $(".listBox>div").not(".curList").css("display","none");
    //导航栏
    $(".colleNav>a").click(function(){
        var $this=$(this);//保存this
        $(".colleNav>a").not($this).removeClass("cur"); //除了自身以外隐藏
        $this.addClass("cur");
        $(".listBox>div").each(function(){
            $(".listBox>div").not($(".listBox>div").eq($this.index())).removeClass("curList");
            $(".listBox>div").not($(".listBox>div").eq($this.index())).css("display","none");
            $(".listBox>div").eq($this.index()).addClass("curList");
            $(".listBox>div").eq($this.index()).css("display","block");
        });
        $("input[name='coll_type']").val($(this).attr('value'));
    });

    //编辑
    $(".edit").live("click",function(){
        var curHead=$(".curList>dl>dt>a>img");
        var curChild=$(".curList>dl>dd>img");
        curHead.removeClass("checkHead");
        curHead.attr("src","/static/style_default/images/check_06.png");
        curChild.removeClass("checkChild");
        curChild.attr("src","/static/style_default/images/check_06.png");
        $(".colleNav").css("display","none");
        if($(".cur").index()==$(".curList").index()){
            curHead.css("display","inline-block");
            curChild.css("display","inline-block");
            $(".curList .listContent>em").css("width","7rem");
            $(".curList>dl>dd>a>em>dfn>span").css("margin-left","2.5rem");
        }
        $(this).removeClass().addClass("complete").html("完成");
        $(".bottom").css("display","block");
        $("input[name='isedit']").val('2');
    });
    //完成
    $(".complete").live("click",function(){
        var curHead=$(".curList>dl>dt>a>img");
        var curChild=$(".curList>dl>dd>img");
        curHead.css("display","none");
        curChild.css("display","none");
        $(".curList .listContent>em").css("width","7.73rem");
        $(".curList>dl>dd>a>em>dfn>span").css("margin-left","3rem");
        $(".colleNav").css("display","block");
        // $(this).removeClass().addClass("edit").html("编辑");
        $(".bottom").css("display","none");
        $("input[name='isedit']").val('1');
    });

    //头部选择
    function editCheckHead($this,classA,classB,childLen,img1,img2){
        if( $this.hasClass(classA) ){
            $this.removeClass(classA);
            $this.find("img").attr("src",img2);
            childLen.removeClass(classB);
            childLen.attr("src",img2);
        }else{
            $this.addClass(classA);
            $this.find("img").attr("src",img1);
            childLen.addClass(classB);
            childLen.attr("src",img1);
        }
    }

    storeHeadCheck.live('click', function(){
        editCheckHead(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });
    productHeadCheck.live('click', function(){
        editCheckHead(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });
    officeHeadCheck.live('click', function(){
        editCheckHead(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });

    //列表选择
    function editCheckChild($this,classA,classB,childLen,childClassLen,checkHead,img1,img2){
        var len,classLen;
        if( $this.hasClass(classB) ){
            $this.removeClass(classB);
            $this.attr("src",img2);
            childClassLen.length--;
        }else{
            $this.addClass(classB);
            $this.attr("src",img1);
            childClassLen.length++;
        }
        len=childLen.length;
        classLen=childClassLen.length;
        if( len==classLen ){
            checkHead.addClass(classA);
            checkHead.attr("src",img1);
        }else{
            checkHead.removeClass(classA);
            checkHead.attr("src",img2);
        }
    }
    storeChildCheck.live('click', function(){
        editCheckChild(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            $(this).parent().parent().find("dd>img.checkChild"),
            $(this).parent().parent().find("dt>a>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });
    productChildCheck.live('click', function(){
        editCheckChild(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            $(this).parent().parent().find("dd>img.checkChild"),
            $(this).parent().parent().find("dt>a>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });
    officeChildCheck.live('click', function(){
        editCheckChild(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().find("dd>img"),
            $(this).parent().parent().find("dd>img.checkChild"),
            $(this).parent().parent().find("dt>a>img"),
            "/static/style_default/images/check_03.png",
            "/static/style_default/images/check_06.png"
        );
    });

    //取消
    $(".cancel").click(function(){
        var curHead=$(".curList>dl>dt>a>img");
        var curChild=$(".curList>dl>dd>img");
        $(".pjoTitle>a").removeClass().addClass("edit").html("编辑");
        curHead.css("display","none");
        curChild.css("display","none");
        curHead.removeClass("checkHead");
        curHead.attr("src","/static/style_default/images/check_06.png");
        curChild.removeClass("checkChild");
        curChild.attr("src","/static/style_default/images/check_06.png");
        $(".colleNav").css("display","block");
        $(".bottom").css("display","none");
        $("input[name='isedit']").val('1');
    });
    //删除
    $(".delete").click(function(){
        var curHead=$(".curList>dl>dt>a>img");
        var curChild=$(".curList>dl>dd>img");
        var checkHeadLen=$(".curList>dl>dt>a>img.checkHead");
        var checkChildLen=$(".curList>dl>dd>img.checkChild");
        console.log( checkHeadLen.length );
        if( checkHeadLen.length!=0 || checkChildLen.length!=0 ){


            // 获取要删除的id
            var i = 0;
            var del_arr = new Array();
            $('.checkChild').each(function(index, el) {
                del_arr[i] = $(this).attr('value');
                i++;
            });

            // ajax发送删除请求
            $.ajax({
                url: 'collection_delete',
                type: 'POST',
                dataType: 'json',
                data: {del_arr: del_arr},
                success: function(res) {
                }
            })


            $(".checkHead").parent().parent().parent().remove();
            $(".checkChild").parent().remove();
            curHead.css("display","none");
            curChild.css("display","none");
            curHead.removeClass("checkHead");
            curHead.attr("src","/static/style_default/images/check_06.png");
            curChild.removeClass("checkChild");
            curChild.attr("src","/static/style_default/images/check_06.png");
            // $(".pjoTitle>a").removeClass().addClass("edit").html("编辑");
            $(".bottom").css("display","none");
            $(".tips").css("left","4.2rem");
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("删除成功");
            $(".colleNav").css("display","block");
        }else{
            $(".tips").css("left","3.5rem");
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("请选择要删除的选项");
            $(".colleNav").css("display","none");
        }

    });
});




















