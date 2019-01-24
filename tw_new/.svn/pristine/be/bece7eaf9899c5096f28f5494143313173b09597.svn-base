/**
 * Created by 7du-29 on 2017/11/18.
 */
$(function(){
    var headCheck=$(".footprintList>dl>dt>a>img");
    var childCheck=$(".footprintList>dl>dd>img");

    headCheck.css("display","none");
    childCheck.css("display","none");
    //编辑
    $(".edit").live("click",function(){
        headCheck.removeClass("checkHead");
        headCheck.attr("src","/static/style_default/images/check_06.png");
        childCheck.removeClass("checkChild");
        childCheck.attr("src","/static/style_default/images/check_06.png");
        $(this).removeClass().addClass("complete").html("完成");
        headCheck.css("display","inline-block");
        childCheck.css("display","inline-block");
        $(".listContent>em").css("width","7.16rem");
        $(".footprintList>dl>dd>a>em>dfn>span").css("margin-left","2.5rem");
        $(".bottom").css("display","block");
        $("input[name='isedit']").val('2');
        new_check();
    });
    //完成
    $(".complete").live("click",function(){
        $(this).removeClass().addClass("edit").html("编辑");
        headCheck.css("display","none");
        childCheck.css("display","none");
        $(".listContent>em").css("width","7.73rem");
        $(".footprintList>dl>dd>a>em>dfn>span").css("margin-left","3rem");
        $(".bottom").css("display","none");
        $("input[name='isedit']").val('1');
        new_check();
    });

    //头部选择
    function editCheckHead($this,classA,classB,childLen,img1,img2){
        if( $this.hasClass(classA) ){
            $this.removeClass(classA);
            $this.attr("src",img2);
            childLen.removeClass(classB);
            childLen.attr("src",img2);
        }else{
            $this.addClass(classA);
            $this.attr("src",img1);
            childLen.addClass(classB);
            childLen.attr("src",img1);
        }
    }

    headCheck.click(function(){
        editCheckHead(
            $(this),
            "checkHead",
            "checkChild",
            $(this).parent().parent().parent().find("dd>img"),
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
    childCheck.click(function(){
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
        $(".pjoTitle>a.complete").removeClass("complete").addClass("edit").html("编辑");
        headCheck.css("display","none");
        childCheck.css("display","none");
        headCheck.removeClass("checkHead");
        headCheck.attr("src","/static/style_default/images/check_06.png");
        childCheck.removeClass("checkChild");
        childCheck.attr("src","/static/style_default/images/check_06.png");
        $(".bottom").css("display","none");
        $("input[name='isedit']").val('1');
        new_check();
    });
    //删除
    $(".delete").click(function(){
        var checkHeadLen=$(".footprintList>dl>dt>a>img.checkHead");
        var checkChildLen=$(".footprintList>dl>dd>img.checkChild");
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
                url: 'footprint_delete',
                type: 'POST',
                dataType: 'json',
                data: {del_arr: del_arr},
                success: function(res) {
                    console.log(res);
                }
            })

            $(".checkHead").parent().parent().parent().remove();
            $(".checkChild").parent().remove();
            headCheck.css("display","none");
            childCheck.css("display","none");
            headCheck.removeClass("checkHead");
            headCheck.attr("src","/static/style_default/images/check_06.png");
            childCheck.removeClass("checkChild");
            childCheck.attr("src","/static/style_default/images/check_06.png");
            $(".pjoTitle>a").removeClass().addClass("edit").html("编辑");
            $(".bottom").css("display","none");
            $(".tips").css("left","4.2rem");
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("删除成功");
            new_check();
        }else{
            $(".tips").css("left","3.5rem");
            $(".tips").stop().show(100).delay(3000).hide(100);
            $(".tips").html("请选择要删除的选项");
        }
    });
});




















