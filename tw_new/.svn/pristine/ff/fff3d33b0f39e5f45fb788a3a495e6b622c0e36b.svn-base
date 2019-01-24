            $.ajaxSettings.async = false;
            $.getJSON("script/address_json_data.js", function(jsonString){
            json_address_data=jsonString;
            close='<a href="javascript:;" id="cityClose" class="close"></a>';

            first_grade();
            });
            //获取第一级地图信息
            function first_grade(){
                $("#cityMBox").children(".gctBox").remove();
                var first_grade_data='<div class="gctBox" id="ctbox_1" style="display: block;">';
                for(var item in json_address_data['first']){ 

                first_grade_data+='<span><a data-grade="first" data-parentid='+json_address_data['first'][item]['area_parent_id']+'  data-deep='+json_address_data['first'][item]['area_deep']+' href="javascript:;" title="'+json_address_data['first'][item]['area_name']+'" class="address_detail" data='+json_address_data['first'][item]['area_id']+' >'+json_address_data['first'][item]['area_name']+'</a></span>';
                };
                first_grade_data+="</div>";
                $("#cityMBox").append(first_grade_data);
            }
            //点击详细地图数据
             $(document).on("click",'.address_detail',function () {
                //赋值给选项卡

                var select_string='<b>'+$(this).text()+'</b><i></i>';
                $("#pct_"+$(this).attr("data-deep")).html(select_string);

                //地址id
                var detail_id=$(this).attr("data");
                //地址深度
                var detail_deep=$(this).attr("data-deep");
                //地址父节点
                var parent_detail_id=$(this).attr("data-parentid")

                var grade_data='';
                //下一级等级
                var next_index=parseInt(detail_deep)+1;
                //选项卡标签
                var address_index_string='<a href="javascript:;" id="pct_'+next_index+'" class="grade_index"><b>请选择</b><i></i></a>';

                var grade=[];
                grade[1]='first';
                grade[2]='second';
                grade[3]='third';
                if(next_index!=4){
                //新增选项卡
                $("#pct_"+detail_deep).attr("data",parent_detail_id);
                $("#pct_"+detail_deep).nextAll(".grade_index").remove();//删除多余选项卡
                $("#pct_"+detail_deep).after(address_index_string);//新增选项卡
                $("#pct_"+next_index).siblings().removeClass("cur");//去掉选中样式
                $("#pct_"+next_index).addClass("cur");//给新增的选项卡添加选中样式


                //新增详细地址内容
                var first_grade_data='<div class="gctBox" id="ctbox_'+next_index+'" style="display: block;">';
                for(var item in json_address_data[grade[next_index]][detail_id]){ 

                first_grade_data+='<span><a data-grade="'+grade[detail_deep]+'" data-parentid='+json_address_data[grade[next_index]][detail_id][item]['area_parent_id']+ ' data-deep='+json_address_data[grade[next_index]][detail_id][item]['area_deep']+' href="javascript:;" title="'+json_address_data[grade[next_index]][detail_id][item]['area_name']+'" class="address_detail" data='+json_address_data[grade[next_index]][detail_id][item]['area_id']+' >'+json_address_data[grade[next_index]][detail_id][item]['area_name']+'</a></span>';
                };
                first_grade_data+="</div>";

                //地址详情的框
                $("#cityMBox").children(".gctBox").css("display","none");
                $("#cityMBox").append(first_grade_data);

              }else{
                //三级地址都选中完毕后赋值给选框
                $(".gCity").css("display","none");
                var all_address=$("#pct_1").text()+"-"+$("#pct_2").text()+"-"+$("#pct_3").text();
                $("#stockaddress").text(all_address);
                $("input[name=area_info]").attr("value",all_address);
                $("input[name=area_id]").attr("value",detail_id);
                $("input[name=city_id]").attr("value",parent_detail_id);

              }
            })
            //点击目录头,隐藏后续的选项卡
            $(document).on('click','.grade_index',function(){
                $(this).nextAll(".grade_index").remove();
                var pre=$(this).attr("data");
                $(this).children("b").text("请选择:");
                $(this).addClass("cur");
                if(pre==0){
                  //如果选择first地区,执行加载first地区函数
                  first_grade();
                }else{
                  //否则触发父级按钮
                $(".address_detail[data="+pre+"]").click();
                }
            })
                 //点击其他地方消失地区选框
       

                // $("body").click(function(e){
                //     alert(e.target.id);
                //     if(e.target.id=='stockaddress'){
                //          $("#stockaddress").click();
                //     }else{
                //          $("#stockaddress").click();
                //     }
           
                // })
        
            // $("body").not(".city").click(function(){
            //     alert("123");
            // })
            //点击选地区按钮
            $("#stockaddress").click(function(){
                //如果地址框是隐藏的


                    if($(".gCity").is(':hidden')){

                        $(".gCity").fadeIn();
                           
                    }else{
                         $(".gCity").fadeOut();
                    }

            });

            //点击关闭按钮
            $("#cityClose").click(function(){
              $(".gCity").fadeOut();
            });
       