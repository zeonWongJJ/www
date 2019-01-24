<?php include_once APPPATH . 'template/default/common/header.php'; ?>
    <style>
        .layui-table-cell {
            height: 36px;
            line-height: 36px;
        }

        .cafeNav {
            padding: 0 20px;
            font-size: 14px;
            background: white;
        }

        .cafeNav > ul > li > a, .cafeNav > ul > li > i, .cafeNav > ul > li > em, .cafeNav > ul, .cafeNav > ul > li {
            display: inline-block;
            vertical-align: middle;
        }

        .cafeNav > ul > li {
            margin-left: 30px;
        }

        .cafeNav > ul > li > a {
            padding: 12px 0;
            color: #999;
            cursor: pointer;
        }

        .cafeNav > ul > li > a.cafeCur {
            color: #5d3719;
            border-bottom: 2px solid #5d3719;
        }
    </style>
    <body class="childrenBody" style="background: #efefef">
    <div class="layui-form news_list">
        <div class="cafeNav">
            <ul>
                <li><a class="page_action" data-type="cafe_filter" data-map="all" href="javascript:void(0);">所有订单<span
                                id="all"></span></a></li>
                <li><a class="page_action" data-type="cafe_filter" data-map="pending_payment"
                       href="javascript:void(0);"><span
                                class="layui-badge-dot layui-bg-blue"></span> 待付款<span id="pending_payment"></span></a>
                </li>
                <li><a class="page_action" data-type="cafe_filter" data-map="pending_ordering"
                       href="javascript:void(0);"><span
                                class="layui-badge-dot layui-bg-orange"></span> 待接单<span
                                id="pending_ordering"></span></a></li>
                <li><a class="page_action" data-type="cafe_filter" data-map="in_service"
                       href="javascript:void(0);"><span
                                class="layui-badge-dot layui-bg-green"></span> 服务中<span id="in_service"></span></a></li>
                <li><a class="page_action" data-type="cafe_filter" data-map="completed" href="javascript:void(0);"><span
                                class="layui-badge-dot layui-bg-cyan"></span> 交易完成<span id="completed"></span></a></li>
                <li><a class="page_action" data-type="cafe_filter" data-map="closed" href="javascript:void(0);">已关闭<span
                                id="closed"></span></a></li>
            </ul>
        </div>
        <!--<div class="dynamicCate">
            <ul>
                <li class="advancedOptions">
                    <span>高级选项：</span>
                    <dl>
                        <dd class="auditStatusBox" style="background: white; border: 1px solid rgb(255, 255, 255);">
                            <span>审核状态</span>
                            <i class="layui-icon layui-icon-down"></i>
                            <div class="auditStatus show_box" style="display: none">
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="all" class="page_action">全部</a>
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="1" class="page_action">已通过</a>
                                <a href="javascript:;" data-type="filter_audit_status" data-filter="0" class="page_action">未通过</a>
                            </div>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>-->
        <div style="background: #ffffff;">
            <table class="layui-table" lay-filter="service" id="grid_contrainer"></table>
        </div>
    </div>
<?php include_once APPPATH . 'template/default/common/footer.php'; ?>