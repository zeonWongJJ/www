<!--公共头部开始-->
<link rel="shortcut icon" href="image/bitbug_favicon.ico" />
<link rel="stylesheet" href="style/UserCenter.css">
<script type="text/javascript" src="script/jquery-1.8.3.js"></script>
</head>

<body>
<div class="main">
    <div class="top">
      <div class="top_l">
            <img src="image/logo.png" width="189" height="64">
            <a class="mall" href="http://www.7dugo.com"></a>
            <a class="doctor" href="http://www.wangyi120.com/"></a>
        </div>
    <div class="top_r"><a href="javascript:;"> <span style="position:relative;"><img src="image/bell.png" width="24" height="24"> 
        <?php if ( ! empty($_SESSION['message'])) { ?>
            <i><?php echo $_SESSION['message']?></i>
        <?php } else { ?>
           
        <?php }?>
    
</span></a>
    <a><img src="image/avatar.png" width="60" height="60" style="border-radius:50%; margin-left:15px;" >
    <span style=" margin-left:0"><?php echo $_SESSION['user_name']?></span></a>
    <a href="<?php echo $this->router->url('logout');?>"><b class="Signout" title="退出"></b></a>
    </div>    
    </div>
    <div class="nav">
        <ul>
            <li class="li_index">
                <a href="index.html" >
                    <img src="image/userWhite.png" /><br>
                    <span>我的柒度</span>
                </a>
            </li>
            <li class="li_money li_consume li_recharge li_deposit">
                <a href="money.html">
                    <img src="image/money.png" /><br>
                    <span>资产中心</span>
                </a>
            </li>
            <li class="li_order_form li_order_details">
                <a href="order_form.html">
                    <img src="image/orders.png" /><br>
                    <span>我的订单</span>
                </a>
            </li>
      <!--       <li>
                <a href="#">
                    <img src="image/Shopping_Cart.png" /><br>
                    <span>购物车</span>
                </a>
            </li> -->
            <li class="li_collection">
                <a href="collection.html">
                    <img src="image/collect.png" /><br>
                    <span>宝贝收藏</span>
                </a>
            </li>
            <li class="li_evaluation">
                <a href="evaluation.html">
                    <img src="image/comment.png" /><br>
                    <span>我的评价</span>
                </a>
            </li>
            <li class="li_address">
                <a href="address.html">
                    <img src="image/adress.png" /><br>
                    <span>收货地址</span>
                </a>
            </li>
        </ul>
    </div> 
    <script>
  // background:url(image/hint.png) no-repeat;color:#1fbba6; padding-left:30px;
var strUrl=window.location.href; 
var arrUrl=strUrl.split("/"); 
var arr={};
var strPage=arrUrl[arrUrl.length-1]; //123.html
if(strPage==""){
    arr[0]='index';
    var image_name='index';
}else{

    var filename=strPage.split("."); // 123      html
    var pre=filename[filename.length-2];
    var arr=pre.split("-"); 

    if(arr[0]=='money' || arr[0]=='consume' || arr[0]=='recharge' || arr[0]=='deposit') {
        var image_name='money';
    } else if (arr[0]=='order_form' || arr[0]=='order_details') {
        var image_name='order_form';

    } else if (arr[0]==undefined) {
        var image_name='index';
        arr[0]='index';

    } else {
        var image_name=arr[0];
    }

}
// alert(arr[0]);
$(".li_"+arr[0]).css({"background":"url(image/hint.png) no-repeat"});
$(".li_"+arr[0]).children("a").css({"color":"#1fbba6"});
$(".li_"+arr[0]).children("a").children("img").attr("src","image/"+image_name+"_l.png");

    </script>
<!--公共头部 结束-->
