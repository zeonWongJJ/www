	<style>
        /* 头部 */
        .headTopMax{ width:100%; height:3rem; position:fixed;  left:0; z-index:3;  background:url(static/style_default/images/headBg.png); background-repeat:no-repeat; background-size:10rem 2.8rem; }
        .headTopMax>ul{ text-align:center; margin-top:0.2rem; font-size:0; }
        .headTopMax>ul>li:first-child{ margin-left:0; }
        .headTopMax>ul>li{ margin-left:0.33rem; }
        .headTopMax>ul>li,.headTop>ul>li>a{ display:inline-block; position:relative; }
        .headTopMax>ul>li>a>img{ width:0.9rem; }
        .headTopMax>ul>li>a>span{ display:block; font-size:0.26rem; margin-top:0.1rem; }
        .headTopMax>ul>li>a>i{ width:0.4rem; height:0.4rem; line-height:0.4rem; position:absolute; top:0.3rem; right:-0.1rem; display:inline-block; font-size:0.2rem; font-style:normal; color:#ff6633; border-radius:50%; background:white; border:0.02rem solid #ff6633; }
        .xialaDD{ width:0.2rem; position:absolute; right:1.5rem; bottom:-0.6rem; }
   	</style>
   	<script src="static/style_default/plugin/jquery-1.8.2.min.js"></script>
    <script>
        $(function(){
           $(".headTopMax").css("top","-3rem");
           $(".xialaDD").on("swipe",function(){
                $(".headTopMax").css("top","3rem");
            });
            $(".xialaDD").click(function(){
                if( $(this).hasClass("showNav") ){
                    $(this).removeClass("showNav");
                    $(".headTopMax").animate({"top":"-3rem"},100);
                }else{
                    $(this).addClass("showNav");
                    $(".headTopMax").animate({"top":"0"},100)
                    $.ajax({
                        url : 'oute',
                       dataType : 'json',
                       success:function(res) {
                          $('.image>i').text(res);
                       }
                   })
                }
            })
        })
    </script>
<!-- 头部 -->
<div class="headTopMax">
    <ul>
        <li>
            <a href="index" >
                <img src="static/style_default/images/home.png" alt=""/>
                <span>首页</span>
            </a>
        </li>
        <li>
            <a href="product_category" >
                <img src="static/style_default/images/cafesss.png" alt=""/>
                <span>分类</span>
            </a>
        </li>
        <li>
            <a href="shopping" class="image">
                <img src="static/style_default/images/sho.png" alt=""/>
               	<span>购物车</span>
            </a>
        </li>
        <li>
            <a href="" >
                <img src="static/style_default/images/comments.png" alt=""/>
                <span>聊天</span>
            </a>
        </li>
        <li>
            <a href="mood_showlist" >
                <img src="static/style_default/images/update.png" alt=""/>
                <span>动态</span>
            </a>
        </li>
        <li>
            <a href="user_center" >
                <img src="static/style_default/images/data.png" alt=""/>
                <span>用户中心</span>
            </a>
        </li>
    </ul>
    <img class="xialaDD" src="static/style_default/images/lar.png" alt=""/>
</div>
<!-- 头部 -->