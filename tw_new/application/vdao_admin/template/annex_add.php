<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML,ASP,PHP,SQL">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="static/style_default/style/common.css"/>
    <link rel="stylesheet" href="static/style_default/style/public.css"/>
    <link rel="stylesheet" href="static/style_default/style/releaseSupplies.css"/>
    <script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script src="static/style_default/script/public.js"></script>
    <script src="static/style_default/script/releaseSupplies.js"></script>
    <title>发布耗材</title>
</head>
<body style="background:#efefef;">
<!--  后台管理 -->
<div class="productClassification">
    <?php echo $this->display('header'); ?>
    <!--  右侧内容 -->
    <article>
        <!--  标题 -->
        <?php echo $this->display('top'); ?>
        <!--  标题 -->

        <!-- 发布耗材-->
        <div class="releaseList">
            <p>耗材管理>耗材列表>发布耗材</p>
            <!-- 发布耗材 -->
            <div class="newSupplies">
                <div class="suppliesTitle">
                    <span>发布耗材</span>
                </div>
                <div class="newSuppliesContent">
                    <form action="<?php echo $this->router->url('annex_add')?>" method="post">
                        <ul>
                            <li class="suppliesName">
                                <em><s>*</s>耗材名称</em>
                                <input type="text" id="supplies_name" placeholder="输入14字符/汉字" name="name" />
                                <s class="hide">
                                    <img src="static/style_default/image/f_03.png" alt=""/>
                                    <em>还可以输入14字符/汉字</em>
                                </s>
                            </li>
                            <li class="suppliesCate">
                                <em><s>*</s>耗材分类</em>
                                <select name="id_1" id="supplies_cate_A">
                                    <option value="0">请选择</option>
                                    <?php foreach ($a_view_data as $value) {?>
                                    <option value="<?php echo $value['id']?>"><?php echo $value['cons_name']?></option>
                                    <?php }?>
                                </select>
                                <select name="id_2" class="supplies_cate_B hide">
                                
                                </select>
                                <select name="id_3" class="supplies_cate_C hide">

                                </select>
                                <s class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <em></em>
                                </s>
                            </li>
                            <li class="suppliesPrice">
                                <em><s>*</s>单价</em>
                                <input type="text" id="supplies_price" onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" name="price"/>
                                <em style="width:30px; margin-right:0;">元</em>
                                <s class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <em></em>
                                </s>
                            </li>
                            <li class="suppliesUnit">
                                <em><s>*</s>单位</em>
                                <input type="text" id="supplist_unit" name="units" />
                                <s class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <em></em>
                                </s>
                            </li>
                            <li class="suppliesStock">
                                <em><s>*</s>库存</em>
                                <input type="text" id="supplist_stock" onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" name="amount"/>
                                <s class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <em></em>
                                </s>
                            </li>
                            <li class="suppliesWarning">
                                <em><s>*</s>预警值</em>
                                <input type="text" id="supplist_warning" onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" name="prewaning"/>
                                <s class="hide">
                                    <img src="static/style_default/image/t_03.png" alt=""/>
                                    <em></em>
                                </s>
                            </li>
                        </ul>
                        <input type="submit" value="确定发布" id="suppliesSub"/>
                    </form>

                </div>
            </div>
            <!-- 发布耗材 -->
        </div>
        <!-- 发布耗材 -->



    </article>
    <!--  右侧内容 -->
</div>
<!--  后台管理 -->
</body>
</html>