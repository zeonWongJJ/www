/**
 * Created by 7du-29 on 2017/10/20.
 */
$(function(){
    var headInput=$(".cateHead>a.c1>input");
    var headLabel=$(".cateHead>a.c1>label");
    var bottomInput=$("#bottomSelect");
    var bottomLabel=$(".bottomAllSelect>label");
    var cateAInput=$(".cateA>a.c1>input");
    var cateALabel=$(".cateA>a.c1>label");
    var cateBInput=$(".cateB>a.c1>input");
    var cateBLabel=$(".cateB>a.c1>label");
    var cateCInput=$(".cateC>a.c1>input");
    var cateCLabel=$(".cateC>a.c1>label");

    //添加Id
    function addId(ele,eleId){
        ele.each(function(i){
            $(this).prop("id",eleId+(i+1));
            $(this).next().prop("for",eleId+(i+1));
        });
    }
    addId(cateAInput,"a-");
    addId(cateBInput,"b-");
    addId(cateCInput,"c-");

    //全选
    function allSelect($this,cateA,cateB,cateC,cateAimg,cateBimg,cateCimg,bottom,bottomImg,classA,img1,img2){
        // console.log($this.prev());
        if( $this.prev().is(":checked") ){
            $this.prev().prop("checked",false);
            $this.children().attr("src",img2);
            cateA.prop("checked",false);
            cateB.prop("checked",false);
            cateC.prop("checked",false);
            cateA.next().removeClass(classA);
            cateB.next().removeClass(classA);
            cateC.next().removeClass(classA);
            cateAimg.attr("src",img2);
            cateBimg.attr("src",img2);
            cateCimg.attr("src",img2);
            bottom.prop("checked",false);
            bottomImg.attr("src",img2);
            $this.removeClass(classA);
            bottom.next().removeClass(classA);
        }else{
            $this.prev().prop("checked","checked");
            $this.children().attr("src",img1);
            cateA.prop("checked","checked");
            cateB.prop("checked","checked");
            cateC.prop("checked","checked");
            cateA.next().addClass(classA);
            cateB.next().addClass(classA);
            cateC.next().addClass(classA);
            cateAimg.attr("src",img1);
            cateBimg.attr("src",img1);
            cateCimg.attr("src",img1);
            bottom.prop("checked","checked");
            bottomImg.attr("src",img1);
            $this.addClass(classA);
            bottom.next().addClass(classA);
        }
    }

    headLabel.click(function(e){
        allSelect(
            $(this),
            $(".cateA>a.c1>input"),
            $(".cateB>a.c1>input"),
            $(".cateC>a.c1>input"),
            $(".cateA>a.c1>label>img"),
            $(".cateB>a.c1>label>img"),
            $(".cateC>a.c1>label>img"),
            $("#bottomSelect"),
            $(".bottomAllSelect>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        e.stopPropagation();
    });
    // 底部选择
    function bottomSelect($this,cateA,cateB,cateC,cateAimg,cateBimg,cateCimg,head,headImg,classA,img1,img2){
        // console.log($this.prev().is(":checked"))
        if( $this.prev().is(":checked") ){
            $this.prop("checked",false);
            $this.children().attr("src",img2);
            cateA.prop("checked",false);
            cateB.prop("checked",false);
            cateC.prop("checked",false);
            cateA.next().removeClass(classA);
            cateB.next().removeClass(classA);
            cateC.next().removeClass(classA);
            cateAimg.attr("src",img2);
            cateBimg.attr("src",img2);
            cateCimg.attr("src",img2);
            head.prop("checked",false);
            headImg.attr("src",img2);
            $this.removeClass(classA);
            head.next().removeClass(classA);
        }else{
            $this.prop("checked","checked");
            $this.children().attr("src",img1);
            cateA.prop("checked","checked");
            cateB.prop("checked","checked");
            cateC.prop("checked","checked");
            cateA.next().addClass(classA);
            cateB.next().addClass(classA);
            cateC.next().addClass(classA);
            cateAimg.attr("src",img1);
            cateBimg.attr("src",img1);
            cateCimg.attr("src",img1);
            head.prop("checked","checked");
            headImg.attr("src",img1);
            $this.addClass(classA);
            head.next().addClass(classA);
        }
    }
    bottomLabel.click(function(e){
        bottomSelect(
            $(this),
            $(".cateA>a.c1>input"),
            $(".cateB>a.c1>input"),
            $(".cateC>a.c1>input"),
            $(".cateA>a.c1>label>img"),
            $(".cateB>a.c1>label>img"),
            $(".cateC>a.c1>label>img"),
            $(".cateHead>a.c1>input"),
            $(".cateHead>a.c1>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        e.stopPropagation();
    });

    function checkedCate($this,head,headImg,bott,bottImg,classA,img1,img2){
        if( $this.prev().is(":checked") ){
            $this.prop("checked",false);
            $this.children().attr("src",img2);
            head.prop("checked",false);
            bott.prop("checked",false);
            headImg.attr("src",img2);
            bottImg.attr("src",img2);
            $this.removeClass(classA);
        }else{
            $this.prop("checked","checked");
            $this.children().attr("src",img1);
            $this.addClass(classA);
        }
    }

    function cateA($this,cateB,cateBimg,cateC,cateCimg,classA,img1,img2){
        if( $this.prev().is(":checked") ){
            cateB.prop("checked",false);
            cateBimg.attr("src",img2);
            cateC.prop("checked",false);
            cateCimg.attr("src",img2);
            cateB.next().removeClass(classA);
            cateC.next().removeClass(classA);
        }else{
            cateB.prop("checked","checked");
            cateBimg.attr("src",img1);
            cateC.prop("checked","checked");
            cateCimg.attr("src",img1);
            cateB.next().addClass(classA);
            cateC.next().addClass(classA);
        }
        // console.log(cateB)
    }

    function cateALen($this,cateA,cateALen,head,headImg,bott,bottImg,img1,img2){
        var len,classLen;
        if( $this.prev().is(":checked") ){
            cateALen.length--;
        }else{
            cateALen.length++;
            len=cateA.length;
            classLen=cateALen.length;
            if( len==classLen ){
                head.prop("checked","checked");
                bott.prop("checked","checked");
                headImg.attr("src",img1);
                bottImg.attr("src",img1);
            }
        }

    }

   // 产品分类单个删除
    $('.dele2').click(function() {
        var id = $(this).attr('value');
        $('.tips1').removeClass('hide');
        $('.quedi').unbind("click").click(function(){
            $.ajax({
                type : 'post',
                url  : 'attri_delete',
                data : {id:id,out:1},
                dataType : 'json',
                success  : function(data){
                    if (data.code == 33) {
                        $("#co_"+id).remove();
                    }
                }
            })
            $('.tips1').addClass('hide'); 
        })
    })
    //产品分类多个删除
    $('.bottomDelect1').click(function() {
        $('.tips1').removeClass('hide');
        $('.quedi').click(function() {
            // 获取所有选中的分类
            var id = new Array();
            var i = 0;
            $(".checked").each(function(index, el) {
                id[i] = $(this).attr('value');
                i++;
            });
            // console.log(id);
            if (id.length > 0) {
                $.ajax({
                    type : 'post',
                    url  : 'attri_delete',
                    data : {id:id,out:2},
                    dataType : 'json',
                    success  : function(ret) {
                        if (ret.code == 33) {
                            for (var i=0; i<ret.data.length; i++) {
                                $("#co_"+ret.data[i]).remove();
                            }
                        }
                    }
                })
                $('.tips1').addClass('hide');
            }
        })
    })
    
    //产品分类单个启动
    $('.upta1').click(function() {
        var id = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'attri_switch',
            data : {id : id},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 20) {
                    if (data.kou == 2) {
                        $("#up_"+id).html('<img src="./static/style_default/image/pro_33.png" />');
                    } else {
                         $("#up_"+id).html('<img src="./static/style_default/image/pro_10.png" />');
                    }
                };
            }
        })
    })
    // 产品分类多个启动
   $('.bottomProvisional1').click(function(){
         $(".checked").each(function(index, el) {
            var id = $(this).attr('value');
            $.ajax({
            type : 'post',
            url  : 'attri_switch',
            data : {id : id},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 20) {
                    if (data.kou == 2) {
                        $("#up_"+id).html('<img src="./static/style_default/image/pro_33.png" />');
                    } else {
                         $("#up_"+id).html('<img src="./static/style_default/image/pro_10.png" />');
                    }
                };
            }
        })
         })
   })

    //点击取消
    $('.quchu').click(function() {
        $('.tips').addClass('hide');
        $('.tips1').addClass('hide');
    })

    //一级分类
    cateALabel.click(function(e){
        checkedCate(
            $(this),
            $(".cateHead>a.c1>input"),
            $(".cateHead>a.c1>label>img"),
            $("#bottomSelect"),
            $(".bottomAllSelect>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        cateA(
            $(this),
            $(this).parent().parent().find(".cateB>a.c1>input"),
            $(this).parent().parent().find(".cateB>a.c1>label>img"),
            $(this).parent().parent().find(".cateB>.cateC>a.c1>input"),
            $(this).parent().parent().find(".cateB>.cateC>a.c1>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        cateALen(
            $(this),
            $(".cateA>a.c1>input"),
            $(".cateA>a.c1>input:checkbox:checked"),
            $(".cateHead>a.c1>input"),
            $(".cateHead>a.c1>label>img"),
            $("#bottomSelect"),
            $(".bottomAllSelect>label>img"),
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        e.stopPropagation();
    });

    function cateB($this,cateC,cateCimg,classA,img1,img2){
        if( $this.prev().is(":checked") ){
            cateC.prop("checked",false);
            cateCimg.attr("src",img2);
            cateC.next().removeClass(classA);
        }else{
            cateC.prop("checked","checked");
            cateCimg.attr("src",img1);
            cateC.next().addClass(classA);
        }
    }


    //二级分类
    cateBLabel.click(function(e){
        checkedCate(
            $(this),
            $(".cateHead>a.c1>input"),
            $(".cateHead>a.c1>label>img"),
            $("#bottomSelect"),
            $(".bottomAllSelect>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        cateB(
            $(this),
            $(this).parent().parent().find(".cateC>a.c1>input"),
            $(this).parent().parent().find(".cateC>a.c1>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        e.stopPropagation();
    });

    //三级分类
    cateCLabel.click(function(e){
        checkedCate(
            $(this),
            $(".cateHead>a.c1>input"),
            $(".cateHead>a.c1>label>img"),
            $("#bottomSelect"),
            $(".bottomAllSelect>label>img"),
            "checked",
            "static/style_default/image/pro_23.png",
            "static/style_default/image/pro_07.png"
        );
        e.stopPropagation();
    })

});













