            <!--  标题 -->
            <div class="title">
                <h3>V稻-管理中心</h3>
                <div class="titleRight">
                    <a href="messages_showlist" class="newsContent" id="oute">
                        <img src="static/style_default/image/indexPic_03.png" alt=""/>
                        <span id="oute">消息</span>
                    </a>
                    <a href="loginout">
                        <img src="./static/style_default/image/indexPic_05.png" />
                        <span>注销</span>
                    </a>
                </div>
            </div>
            <!--  标题 -->
<script type="text/javascript">

        var oute = {
           url : 'oute',
           dataType : 'json',
           success:function(res) {
            if (res.data == 0) {
                $('#oute').html('<img src="static/style_default/image/indexPic_03.png" alt=""/><span id="oute">消息</span>');
            } else {                
               $('#oute').html('<img src="static/style_default/image/indexPic_03.png" alt=""/><span id="oute">消息</span><i>'+res.data+'</i>');
            };
           } 
        }
window.setInterval(function(){$.ajax(oute)},3000);
</script>