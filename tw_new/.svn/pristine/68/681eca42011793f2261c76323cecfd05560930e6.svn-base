/**
 * Created by 7du-29 on 2017/8/15.
 */
$(function(){
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
            'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main'));

            var option = {

                xAxis : [
                    {
                        type : 'category',
                        data : ['1','2','3','4','5','6','7','8','9','10','11','12'],
                        splitLine:{
                            show:false
                        },
                        axisTick : {
                            show:false
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#818181'
                            }
                        }
            }
                ],
                yAxis : [
                    {
                        type : 'value',
                        min:'0',
                        max:'900',
                        splitNumber:10,
                        axisLabel:{
                            textStyle:{
                                color:'#16c6ff'
                            }
                        },
                        splitLine:{
                            show:true,
                            lineStyle:{
                                color: ['#16c6ff'],
                                width: 1,
                                type: 'solid'
                            }
                        }
                    }

                ],
                series : [

                    {
                        type:'bar',
                        data:[270, 420, 510, 345,390, 465, 380, 545, 420, 310, 225, 650],
                        itemStyle: {
                            normal: {
                                //好，这里就是重头戏了，定义一个list，然后根据所以取得不同的值，这样就实现了，
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#16c6ff','#16c6ff','#16c6ff','#16c6ff','#16c6ff',
                                        '#16c6ff','#16c6ff','#16c6ff','#16c6ff','#16c6ff',
                                        '#16c6ff','#16c6ff','#16c6ff','#16c6ff','#16c6ff'
                                    ];
                                    return colorList[params.dataIndex];

                                },
                                //以下为是否显示，显示位置和显示格式的设置了
                                label: {
                                    show: true,
                                    position: 'top',
//                             formatter: '{c}'
                                    formatter: '{b}\n{c}'
                                }
                            }
                        },
                        barWidth:30
                    }
                ]
            };


            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
})



