/**
 * Created by 7du-29 on 2017/9/14.
 */
$(function (){
    // 路径配置
    require.config({
        paths: {
            echarts: 'http://echarts.baidu.com/build/dist'
        }
    });

    // 使用
    require(
        [
            'echarts',
            'echarts/chart/pie'
        ],
        function drawBar(ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('pieMain'));

            var option = {

                calculable : true,
                series : [
                    {
                        name:'访问来源',
                        type:'pie',
                        radius : '60%',
                        center: ['50%', '50%'],
                        data:[
                            {value:100, name:'暂停使用（1）'},
                            {value:310, name:'使用中（4）'},
                            {value:234, name:'空闲中（4）'},
                            {value:135, name:'故障中（2）'}
                        ],
                        itemStyle: {
                            normal: {
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#3e50b4','#2095f2','#e81d62','#ccdb38'
                                    ];
                                    return colorList[params.dataIndex];
                                }
                            }
                        }
                    }

                ]
            };


            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );

    //查看详情
    $(".cofeOrderList>a.c5").click(function(){
        $(".cafeOrders").removeClass("hide");
    })
    //关闭窗口
    $(".closeLay>span").click(function(){
        $(".cafeOrders").addClass("hide");
    })

    //店铺概况
    $(".survetTit>span").click(function(){
        if($(this).hasClass("room_tit")){
            $(".roomNum").removeClass("hide");
            $(".productNum").addClass("hide");
            $(this).addClass("surCur");
            $(".survetTit>span").not($(this)).removeClass("surCur");
        }else if($(this).hasClass("product_tit")){
            doProgress();
            $(".roomNum").addClass("hide");
            $(".productNum").removeClass("hide");
            $(this).addClass("surCur");
            $(".survetTit>span").not($(this)).removeClass("surCur");
        }
    })


})

//生产量
function SetProgress(progress) {
    if (progress) {
        $(".progress").css("width", ((String(progress))/1000)*100+"%"); //控制#loading div宽度
    }
}
var i = 0;
function doProgress() {
    if (i > 1000) {
        return;
    }
    if (i <= 730) {
        setTimeout("doProgress()",10);
        SetProgress(i);
        i+=10;
    }
}















