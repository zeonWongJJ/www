/**
 * Created by 7du-29 on 2018/1/9.
 */
$(function(){
    $(".lay").hide();
    $(".sortContainer").hide();
    $(".screenContainer").hide();

    //����
    $("#search").focus(function(){
       $(".productContainer").hide();
    });

    //����
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

    //����
    $(".productSort").click(function(){
        show($(".sortContainer"));
        $(".screenContainer").hide();
    });
    $(".sortContainer>ul>li").click(function(){
        $(this).addClass("sortCur");
        $(".sortContainer>ul>li").not($(this)).removeClass("sortCur");
    });
    //ɸѡ
    $(".screen").click(function(){
        show($(".screenContainer"));
        $(".sortContainer").hide();
    });

    var resLength=0;  //���������Ϊ�˴�li�ĳ���
    $('#search').keyup(function(event){
        console.log(event.which)
        var dat={
            wd:$('#search').val()
        };
        if($('#search').val()!=''){  //��������ֵ��Ϊ�յ�ʱ����ܷ�������
            $.ajax({
                type:"get",
                url:"https://sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su",
                async:true,
                data:dat,
                dataType :'jsonp',       //�Ѿ�������
                jsonp:'cb',               //�ٶȵĻص�����
                success:function(res){
                    console.log(res.s);
                    for(var i=0;i<res.s.length;i++){
                        resLength=res.s.length;
                        oli_i=$('<li class="keyList">'+res.s[i]+'</li>');
                        console.log(oli_i.length);
                        $('.productKeyContainer>ul').append(oli_i);
                        //Ҫʵ�ֵ��ĳһ���ʵ�ʱ��Ҳ����������г��ֵ���������ʣ�����Ҫ��success��������
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
            $('.productKeyContainer>ul').html('');    //��������Ĵʶ�ɾ���ˣ��ѻ�ȡ�����ݽ��Ҳ��գ���Ϊ�Ѿ���ȡ�������ˣ���ʹ��ֹ�ٴη�������Ҳ������Ѿ���õ������������������ֱ��������򵥵İ취��ֱ���������
        };
    });

    //����ٶ�һ�������ť��ʱ��ҲҪʵ����תҳ��
    $('.goSearch').click(function(){
        if($('#search').val()!=''){
            window.location.href='https://www.baidu.com/s?wd='+$('#search').val();
            $('#search').val('');
            $('.productKeyContainer>ul').html('')
        };
    })
});











