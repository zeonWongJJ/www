/**
 * Created by 7du-29 on 2018/1/9.
 */
$(function(){
    $(".lay").hide();
    $(".sortContainer").hide();
    $(".screenContainer").hide();
    $(".openCate").hide();

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

    //侧面展开分类
    $(".cateDown").click(function(){
        $(".openCate").show();
        $(".lay").hide();
        $(".sortContainer").hide();
        $(".screenContainer").hide();
    });
    $(".backDown").click(function(){
        $(".openCate").hide();
    });
    // 分类
    $(".cateL>ul>li").click(function(){
        var id = $(this).attr('value');
        $.ajax({
           type : 'post',
           url  : 'product_categories',
           data : {id:id},
           dataType : 'json',
           success  : function(ros) {
                var html = '';
                if (ros.data.second == '') {
                    html += '<dl>';
                        html += '<dd class="Rcur">';
                            html += '<a href="product_list-0-'+id+'">';
                            html += '<img src="static/style_default/images/pp_03.png" alt=""/>';
                            html += '<span>全部</span>';
                            html += '</a>';
                        html += '</dd>';
                    html += '</dl>';
                } else {
                for(var it in ros.data.second) {
                    html += '<dl>';                    
                        html += '<dt>'+ros.data.second[it].pro_name+'</dt>';
                        html += '<dd class="Rcur">';
                            html += '<a href="product_list-0-'+ros.data.second[it].pro_pid+'-'+ros.data.second[it].pro_id+'">';
                            html += '<img src="static/style_default/images/pp_03.png" alt=""/>';
                            html += '<span>全部</span>';
                            html += '<em>'+ros.data.yon[it]+'</em>';
                            html += '</a>';
                        html += '</dd>';
                        for(var i in ros.data.third){
                            if (ros.data.third[i].pro_pid == ros.data.second[it].pro_id) {
                            html += '<dd class="">';
                            html += '<a href="product_list-0-'+ros.data.second[it].pro_pid+'-'+ros.data.third[i].pro_pid+'-'+ros.data.third[i].pro_id+'">';
                            html += '<img src="static/style_default/images/pp_03.png" alt=""/>';
                            html += '<span>'+ros.data.third[i].pro_name+'</span>';
                            html += '<em>'+ros.data.san[i]+'</em>';
                            html += '</a>';
                        html += '</dd>';
                        }};
                   html += '</dl>';
                } }
                $('.cateR').html(html);
           }
        });
        $(this).addClass("Lcur");
        $(".cateL>ul>li").not($(this)).removeClass("Lcur");
    });
    $(".cateR>dl>dd").click(function(){
        $(this).addClass("Rcur");
        $(".cateR>dl>dd").not($(this)).removeClass("Rcur");
    });


    $(".productNav>ul>li").click(function(){
        $(this).addClass("navCur");
        $(".productNav>ul>li").not($(this)).removeClass("navCur");
    });

    function show(ele){
        $(".lay").show();
        ele.show();
    }

    // 完成
    $('.complete').click(function() {
        var url  = $('.url').attr('value');
        var di   = $('.di').attr('value');
        var gao  = $('.gao').attr('value');
        var dada = $('.dada').attr('value');
        window.location.href= url+di+'-'+gao+'-'+dada;
        // $(".lay").hide();
        // $('.screenContainer').hide();
    })

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

    // 重置
    $('.reset').click(function() {
        $(".tese>a").removeClass("scCur"); 
        $('.dada').val(0);
        $('.di').val('');
        $('.gao').val('');
    })

    // 特色
    $(".tese>a").click(function(){
        // $(this).addClass("scCur");
        // $(".tese>a").not($(this)).removeClass("scCur");
        if( $(this).hasClass("scCur") ){
            $(this).removeClass("scCur"); 
            $('.dada').val(0);
        }else{
            $(this).addClass("scCur"); 
            $('.dada').val(1);
        }
    });

    var resLength=0;  //这个变量是为了存li的长度
    $('#search').keyup(function(event){
        // console.log(event.which)
        var dat={
            name:$('#search').val()
        };
        if($('#search').val()!=''){  //当输入框的值不为空的时候才能发送请求
            $.ajax({
                type: "get",
                url : "search",
                data:dat,
                dataType :'json',
                success:function(res){
                    if (res.code == 200) {
                        var oli_i = '';
                        for(var i in res.data) {
                            resLength=res.data.length;
                            oli_i += '<li class="keyList">'+res.data[i].product_name+'</li>';
                        };
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
        // if($('#search').val()!=''){
            window.location.href='product_list-0-0-0-0-'+$('#search').val();
            $('#search').val('');
            $('.productKeyContainer>ul').html('');
        // };
    })
});











