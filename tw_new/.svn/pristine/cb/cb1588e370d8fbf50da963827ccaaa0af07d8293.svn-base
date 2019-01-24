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
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            'echarts/chart/pie'
        ],
        function drawBar(ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('barMain'));

            var option = {

                calculable : true,
                legend:{
                    data:['月销售额'],
                    x:"right"
                },
                color:['#ff7977'],
                xAxis : [
                    {
                        type : 'category',
                        data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                        splitLine:{
                            show:false
                        },
                        axisTick : {
                            show:false
                        },
                        axisLabel:{
                            textStyle:{
                                color:'#818181',
                                fontSize:14
                            }
                        },
                        axisLine:{
                            lineStyle:{
                                color: "#cccccc"
                            }
                        }
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        min:'0',
                        max:'30000',
                        splitNumber:8,
                        axisLabel:{
                            textStyle:{
                                color:'#818181'
                            }
                        },
                        splitLine:{
                            show:true,
                            lineStyle:{
                                color:"#dcdcdc",
                                width: 1,
                                type: 'solid'
                            }
                        },
                        axisLine:{
                            lineStyle:{
                                color: "#cccccc"
                            }
                        }
                    }
                ],
                series : [
                    {
                        name:'月销售额',
                        type:'bar',
                        data:[18000, 26000,22231, 23000,23000,23000, 15000, 21000,23000,18000, 24000, 24500],
                        markPoint : {
                            data : [
                                {value : 22231, xAxis:3, yAxis:22231, symbolSize:22,color:'red'}
                            ],
                            itemStyle:{
                                normal:{
                                    color:"#798697"
                                }
                            },
                            effect:{
                                show: false,
                                type: 'scale',
                                loop: true,
                                period: 15,
                                scaleSize : 2,
                                bounceDistance: 10,
                                color : null,
                                shadowColor : null,
                                shadowBlur : 0
                            }
                        },
                        itemStyle: {
                            normal: {
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#ff7977','#ff7977','#ff7977','#ff7977','#ff7977',
                                        '#ff7977','#ff7977','#ff7977','#ff7977','#ff7977',
                                        '#ff7977','#ff7977','#ff7977','#ff7977','#ff7977'
                                    ];
                                    return colorList[params.dataIndex];
                                }
                            }
                        },
                        barWidth:25

                    }
                ]
            };


            // 为echarts对象加载数据
            myChart.setOption(option);
        }

    );
    $(".lay").height( $(document).height() );
    $(".showLay").hide();
    $(".lay").hide();
    $(".dynamicContent>li").click(function(){
    	$(".showLay").show();
    	 $(".lay").show();
    })

	$(".showLay").click(function(e){
    	e.stopPropagation();
	});

	$(".lay").click(function(){
    	$(".showLay").hide();
    	$(".lay").hide();
    	$(".tips").hide();
	});

})



