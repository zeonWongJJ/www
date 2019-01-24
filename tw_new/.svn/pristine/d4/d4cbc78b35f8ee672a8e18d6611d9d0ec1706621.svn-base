        <div class="header">
            <div class="headLeft">
                <img src="./static/style_default/images/qi_03.png" alt=""/>
                <span>企擎门店管理中心</span>
            </div>
            <div class="headRight">
                <a class="store_news" href="<?php echo $this->router->url('message'); ?>">             
                    <img src="./static/style_default/images/store_06.png" alt=""/>
                </a>
                <a class="offPage" href="<?php echo $this->router->url('loginout'); ?>">
                    <img src="./static/style_default/images/store_03.png" alt=""/>
                </a>
            </div>
        </div>
<script type="text/javascript">

        var getting = {

            url: 'delivery_xindind',

            dataType:'json',

            success:function(res) {
                if (res.stur == 55) {
                    var audioElementHovertree = document.createElement('audio');

                    audioElementHovertree.setAttribute('src', './static/style_default/plugin/4252.mp3');

                    audioElementHovertree.setAttribute('autoplay', 'autoplay'); //打开自动播放
                };

            }

        };

        var oute = {
           url : 'oute',
           dataType : 'json',
           success:function(res) {
            if (res.data == 0) {
                $('.store_news').html('<img src="./static/style_default/images/store_06.png" alt=""/>');
            } else {                
               $('.store_news').html('<i>'+res.data+'</i> <img src="./static/style_default/images/store_06.png" alt=""/>');
            };
           } 
        }

//关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是1秒请求一次。

window.setInterval(function(){$.ajax(getting)},3000);
window.setInterval(function(){$.ajax(oute)},3000);

</script>