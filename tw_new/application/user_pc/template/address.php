<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<meta name="”viewport”" content="”width=device-width," initial-scale="1″"/>
<meta http-equiv="Cache-Control" content="max-age=7200"/>
<title></title>
<!-- <script type="text/javascript" src="script/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="style/UserCenter.css"> -->
<!-- <link rel="stylesheet" href="style/address.css"> -->

<?php echo $this->display('header');?>
<script type="text/javascript" src="js/toolbar.js"></script>
<script type="text/javascript" src="js/botton.js"></script>

  <div class="content_coll">
    <div class="content_coll_top">
      <div class="collect_l">
        <i class="ticon address-ticon"></i><span>收货地址</span>
        <p class="font4">
          为确保准确无误收到所购买的宝贝，需认真详细填写收件地址。
        </p>
      </div>
    </div>
    <hr style=" width:1000px;height:1px;border:0px;background-color:#d5d5d5;color:#d5d5d5; margin-left:20px;"/>
    <div class="user_address">
      <table border="0" cellspacing="0" cellpadding="0" class="user_address_table">
      <thead>
      <tr style="line-height:32px;">
        <td width="25" style="line-height:32px;">
          &nbsp;
        </td>
        <td width="100">
          收货人
        </td>
        <td width="435">
          收货地址
        </td>
        <td width="315">
          电话
        </td>
        <td>
          操作
        </td>
      </tr>
      </thead>
      <tbody>
      <?php
     if(!empty($a_view_data)){

     foreach($a_view_data as $a_field=>
      $a_value)
     {
     ?>
      <tr class="s-tr">
        <td width="13">
          &nbsp;
        </td>
        <td class="tName">
          <?php echo $a_value['true_name']; ?>
        </td>
        <td class="tAddress">
          <div  data-parentid="<?php echo $a_value['city_id'];?>" class="div-address" data='<?php echo $a_value['area_id'];?>
            ' data-word='
            <?php echo $a_value['three_grade'];?>
            '>            
            <?php echo $a_value['three_grade'].' '.$a_value['address'];?>
          </div>
        </td>
        <td class="tPhone">
          <p>
            <?php echo $a_value['mob_phone'];?>
          </p>
        </td>
        <td class="tOperate tr">
          <span class="<?php if ($a_value['is_default']!=0){echo 'fl d-show';}else{echo 'fl d-show2';}?>"><?php if ($a_value['is_default']!='0') echo "默认地址";?>
          </span>
          <div class="default-address-icon">
            <ul data="<?php echo $a_value['address_id'];?>" parent_city_id="<?php echo $a_value['city_id'];?>">
              <li class="<?php if ($a_value['is_default']!=0){echo 'default-address-icon';} else{echo 'address-icon1 " title="设为默认" ';}?>" ></li>
              <li class="default-address-icon2"></li>
              <li class="default-address-icon3"></li>
            </ul>
          </div>
        </td>
      </tr>
      <?php
      }
     }else{
      $tr='<tr class="s-tr" style="text-align:center"><td colspan="5">暂无数据，请添加。</td></tr>';
      echo $tr;
     }

    ?>
      </tbody>
      </table>
      <form method="POST" action="<?php echo $this->
        router->url('address_add_or_update');?>" class="form">
        <input type="hidden" name="area_id">
        <input type="hidden" name="area_info">
        <input type="hidden" name="address_id">
        <input type="hidden" name="city_id">
        <input type="hidden" name="is_default">
        <div class="new_address">
          <h3 class="font-green">添加新地址</h3>
          <div id="new_address_con">
            <dl>
              <dt style="color:#cb51f8;">
              <span class="cRed1 ">*</span>
                收货人：
              </dt>
              <dd>
              <input type="type" name="true_name" class="userName-text address_gain" value="">
              <i class="new_address-icon new_address-icon_user"></i>
              <span class="user-error-text" style="display:none">
              <i class="user-error-icon"></i>收货人姓名有误</span>
              </dd>
            </dl>
            <dl>
              <dt style="color:#ffc100;">
              <span class="cRed2">*</span>
                所在区域：
              </dt>
              <dd>
              <div class="city">
                <span id="address" class="regon">
                <a id="stockaddress" href="javascript:;" title="请选择地区:">请选择地区:</a><i></i></span>
                <div class="gCity" citytype="true" style="display:none">
                  <div id="citySelect" class="gctSelect clearfix">
                    <a href="javascript:;" id="pct_1" class="cur grade_index"><b>请选择</b><i></i></a>
                    <a href="javascript:;" id="cityClose" class="close"></a>
                  </div>
                  <div id="cityMBox">
                  </div>
                </div>
              </div>
              <span class="font-aide">如果你不确定您所处的乡镇或街道，请您选择就近区域下单</span>
              </dd>
            </dl>
            <dl>
              <dt style="color:#8bad4c;">
              <span class="cRed3">*</span>
                详细地址：
              </dt>
              <dd>
              <input type="type" name="address" class="userAddress-text">
              <i class="new_address-icon new_address-icon_userAddress"></i>
              <span class="userAddress-error-text" style="display:none">
              <i class="userAddress--icon"></i>所在区域或详细地址有误</span>
              </dd>
            </dl>
            <dl>
              <dt style="color:#22beef;">
              <span class="cRed4">*</span>
                手机号码：
              </dt>
              <dd>
              <input type="type" name="mob_phone" class="userMobile-text" maxlength="11" value="">
              <i class="new_address-icon new_address-icon_userMobile"></i>
              <span class="userMobile-error-text" style="display:none" data="123">
              <i class="userMobile--icon"></i>手机号码有误</span>
              <div class="userPhone">
                <span class="cRed4">固定电话：</span>
                <input type="type" name="tel_phone" placeholder="" style="width:168px;" class="userPhone-text" value="">
                <i class="new_address-icon new_address-icon_userPhone"></i>
                  <span class=" userTel-error-text"  data="123" style="padding-left:20px;display:none;color:#22beef">
                  <i class="userMobile--icon" style="left:260px;"></i>固定电话输入有误</span>
              </div>
              </dd>
            </dl>
            <dl style="min-height:0px">
            </dl>
            <dl id="showb">
              <dt>&nbsp;</dt>
              <dd class="">
              <input type="checkbox" class="checkbox checkText" id="inputCeckbox"><label for="inputCeckbox">设置默认地址</label>
              </dd>
            </dl>
            <dl>
              <dt>&nbsp;</dt>
              <dd><a class="button-green j-add-address save_address" href="javascript:;" data-id="">保存收货人地址</a>
              <a href="javascript:;" class="cancel-submit " style="display:none">取消</a>
              <span class="icon-box icon-box-suc" style="display:none"><i class="suc-icon"></i>保存成功</span>
              <span class="icon-box icon-box-fa" style="display:none"><i class="fa-icon"></i>保存失败</span>
              </dd>
            </dl>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php echo $this->display('footer');?> 
</div>


<!-- 判断页面是否已经进行过操作 -->
<input type="hidden" class="run" data="0">
<script type="text/javascript" src="script/address.js"></script>
<script>
          //设为默认操作
          $(".address-icon1").click(function(){
            var run=$(".run");
            var run_status=$(run).attr("data");
            if (run_status==0)
            {
                $(run).attr("data",'1');
            //获取该地址的id  
                var address_id=$(this).parent().attr('data');
                  $.ajax({
                  type: 'POST',
                  data: {id:address_id},
                  url : "<?php echo $this->router->url('address_ajax_set_default');?>",
                  beforeSend:function(){
                  $(run).attr("data","1");
                  },
                  success: function(status) {
                  // 设置为 可修改
                  $(run).attr("data","0");
                    if (status==1){
                      alert("修改成功");
                      self.location='<?php echo $this->router->url('address');?>'; 
                    }else{
                      alert("修改失败，请稍候再试。");
                    }
                  },
                  error: function() {
                $(run).attr("data","0");
                      alert('请检查网络配置,稍后再试');
                  }
              });
            }else{
              alert("请不要频繁操作,谢谢");
            }
  })
        //修改地址
        $(".default-address-icon2").click(function(){
          var address_id=$(this).parent().attr("data");
          var run=$(".run");
          var run_status=$(run).attr("data");
            if (run_status==0)
            {
                $(run).attr("data",'1');
                //获取该地址的id  
                var address_id=$(this).parent().attr('data');
                var grade_index=$(this).parents(".tOperate").siblings(".tAddress").children(".div-address");
                var grade_word=$(grade_index).attr("data-word");

                  $.ajax({
                  type: 'POST',
                  data: {id:address_id},
                  url : "<?php echo $this->router->url('address_ajax_select');?>",
                  beforeSend:function(){
                  $(run).attr("data","1");
                  },
                  success: function(status) {
                $(run).attr("data",'0');
                  if (!status){
                      alert('请求失败，请稍后再试。');
                  }else{  
                    var json = eval('(' + status + ')');
                    //用户名
                 
                    $(".userName-text").val(json['true_name']);
                    //地址
                    $(".userAddress-text").val(json['address']);
                    //手机号码
                    $(".userMobile-text").val(json['mob_phone']);
                    //固定电话
                    $(".userPhone-text").val(json['tel_phone']);
                    //所在区域文本框
                    $("#stockaddress").text(grade_word);
                    //form表单里的隐藏标签修改,用于提交表单
                    $("input[name=area_id]").val(json['area_id']);
                    $("input[name=area_info]").val(json['address']);
                    $("input[name=address_id]").val(json['address_id']);
                    $("input[name=city_id]").val(json['city_id']);

                    //添加新地址=>修改地址
                    $(".font-green").text("修改地址");
                    $(".cancel-submit").css("display","inline-block");
                    //本身是否为默认
                    if (json['is_default']==1){
                        $("input[name=is_default]").attr("value","1");
                        $("#inputCeckbox").parent("dd").addClass("botton-select");
                    }else{
                        $("#inputCeckbox").parent("dd").removeClass("botton-select")
                        $("input[name=is_default]").attr("value","0");
                    }
                  }
                  },
                  error: function() {
                      $(run).attr("data","0");
                      alert('请检查网络配置,稍后再试');
                  }
              });
            }else{
              alert("请不要频繁操作,谢谢");
            }
        })
        //删除该地址
          $(".default-address-icon3").click(function(){
            var run=$(".run");
            var run_status=$(run).attr("data");
            if (run_status==0)
            {
                $(run).attr("data",'1');
            //获取该地址的id  
                var address_id=$(this).parent().attr('data');
                  $.ajax({
                  type: 'POST',
                  data: {id:address_id},
                  url : "<?php echo $this->router->url('address_ajax_delete');?>",
                  beforeSend:function(){
                  $(run).attr("data","1");
                  },
                  success: function(status) {
                  // 设置为 可修改
                  $(run).attr("data","0");
                    if (status==1){
                      alert("删除成功");
                      self.location='<?php echo $this->router->url('address');?>'; 
                    }else{
                      alert("删除失败，请稍候再试。");
                    }
                  },
                  error: function() {
                $(run).attr("data","0");
                      alert('请检查网络配置,稍后再试');
                  }
              });
            }else{
              alert("请不要频繁操作,谢谢");
            }
  });
          //点击更新后再点击取消执行的操作
          $(".cancel-submit").click(function(){
          self.location='<?php echo $this->router->url('address');?>'; 
          })
    </script>
<script type="text/javascript" src="script/address_select.js"></script>
</body>
</html>