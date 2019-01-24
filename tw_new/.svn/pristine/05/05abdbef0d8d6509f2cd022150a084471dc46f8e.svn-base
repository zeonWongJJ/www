/**
 * Created by 7du-29 on 2018/1/9.
 */
$(function(){
    $(".lay").hide();
    $(".sortContainer").hide();
    $(".screenContainer").hide();

    //搜索
    $("#search").focus(function(){
       $(".productContainer").hide();
    });

    //遮罩
    $(".lay").click(function(){
        $(this).hide();
        $(".sortContainer").hide();
        $(".screenContainer").hide();
    });

    $(".productNav>ul>li").click(function(){
        $(this).addClass("navCur");
        $(".productNav>ul>li").not($(this)).removeClass("navCur");
    });

    function show(ele){
        $(".lay").show();
        ele.show();
    }

    //排序
    $(".productSort").click(function(){
        show($(".sortContainer"));
        $(".screenContainer").hide();
    });
    $(".sortContainer>ul>li").click(function(){
        $(this).addClass("sortCur");
        $(".sortContainer>ul>li").not($(this)).removeClass("sortCur");
    });
    //筛选
    $(".screen").click(function(){
        show($(".screenContainer"));
        $(".sortContainer").hide();
    });

    var resLength=0;  //这个变量是为了存li的长度
    $('#search').keyup(function(event){
        console.log(event.which)
        var dat={
            wd:$('#search').val()
        };
        if($('#search').val()!=''){  //当输入框的值不为空的时候才能发送请求
            $.ajax({
                type:"get",
                url:"https://sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su",
                async:true,
                data:dat,
                dataType :'jsonp',       //已经跨域了
                jsonp:'cb',               //百度的回调函数
                success:function(res){
                    console.log(res.s);
                    for(var i=0;i<res.s.length;i++){
                        resLength=res.s.length;
                        oli_i=$('<li class="keyList">'+res.s[i]+'</li>');
                        console.log(oli_i.length);
                        $('.productKeyContainer>ul').append(oli_i);
                        //要实现点击某一条词的时候也能让输入框中出现点击的这条词，所以要在success里面设置
                        $(document).on("click",".keyList",function(){
                            console.log("sss");
                            $('#search').val($(this).text());
                        });
                    };
                },
                error:function(res){
                    console.log(res)
                }
            });
        }else{
            $('.productKeyContainer>ul').html('');    //如果输入框的词都删除了，把获取的数据结果也清空，因为已经获取到数据了，即使阻止再次发送请求也不会把已经获得的数据清除，所以这里直接用了最简单的办法，直接清空数据
        };
    });

    //点击百度一下这个按钮的时候也要实现跳转页面
    $('.goSearch').click(function(){
        if($('#search').val()!=''){
            window.location.href='https://www.baidu.com/s?wd='+$('#search').val();
            $('#search').val('');
            $('.productKeyContainer>ul').html('')
        };
    })
});











