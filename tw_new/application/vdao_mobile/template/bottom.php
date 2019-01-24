<!-- 底部导航 -->
    <div class="botNav">
        <a class="li_index" href="index">
            <img src="static/style_default/images/nav1.png" />
            <img src="static/style_default/images/bn1.png" />
            <span>首页</span>
        </a>
        <a class="li_product_category" href="n_goods_list">
            <img src="static/style_default/images/nav2.png" />
            <img src="static/style_default/images/bn2.png" />
            <span>分类</span>
        </a>
        <a class="li_mood_showlist" href="mood_showlist">
            <img src="static/style_default/images/nav3.png" />
            <img src="static/style_default/images/bn3.png" />
            <span>动态</span>
        </a>
        <a  class="li_shopping" href="shopping">
            <img src="static/style_default/images/nav4.png" />
            <img src="static/style_default/images/bn4.png" />
            <span>购物车</span>
        </a>
        <a class="li_user_center" href="nuser_center">
            <img src="static/style_default/images/nav5.png" />
            <img src="static/style_default/images/bn5.png" />
            <span>会员</span>
        </a>
    </div>
    <!-- 底部导航 -->
<script>
var strUrl=window.location.href; 
var arrUrl=strUrl.split("/"); 
var arr={};
var strPage=arrUrl[arrUrl.length-1]; 
var filename=strPage.split("."); // 123      html
if (filename[1] == undefined) {
    var arr=strPage.split("-");   
} else {
    var pre=filename[filename.length-2];
    var arr=pre.split("-");    
};
if (arr[0] == '') {
    arr[0] = 'index';
};
// console.log(arr[0]);
$(".li_"+arr[0]).addClass('pgCur');
</script>