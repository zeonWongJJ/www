<?php

class TW_wx_tixian {

   //高级功能-》开发者模式-》获取
   private $app_id1 = 'wxeabc8436ab550bc3';      //appid
   private $app_secret1 = 'ca9c7837e87471f29972dd99164c1a08'; //secreat
   private $apikey1 = 'QvTcQYHYtfFBaywpv3h4XjRJTS82NqRP';  //支付秘钥
   private $mchid1 = '1488729882';        //商户号
   
   private $app_id=null;
   private $app_secret=null;
   private $apikey=null;
   private $mchid=null;
      
      
   public  $error=0;
   public $state = '';
   //金额,需在实例化时传入
   public $amount = '0';
   //用户订单号,需在实例化时传入
   public $order_sn = '';
   //用户openid,需在实例化时传入
   public $openid = '';
   
   

   //微信提现操作接口-------》
   public function actionAct_tixian($openid , $amount)
   {
      
      $this -> state=md5(uniqid(rand(), TRUE));
      $this -> amount=$amount;//设置POST过来钱数
      $this -> order_sn=rand(100,999).date('YmdHis');  //随机数可以作为单号
      $this -> openid= $openid;  //设置获取POST过来用户的OPENID
      $this -> app_id=$this->app_id1;
      $this -> app_secret=$this->app_secret1;
      $this -> apikey=$this->apikey1;
      $this -> mchid=$this->mchid1;
      $xml = $this->tiXianAction();
      $result = simplexml_load_string($xml);
      return $result; 
      // if($result->return_code=='SUCCESS' && $result->result_code=='SUCCESS') {

      //           $cash = D('cash');
      //           $data['user_id'] = $user_id;
      //           $data['amount'] = $this->amount;
      //           $res = $cash->where('user_id="'.$user_id.'"')->find();
      //           if($res){
      //               $res2 = $cash->where('user_id="'.$user_id.'"')->setInc('amount',$this->amount);
      //               $res4 = D('member')->where('user_id="'.$user_id.'"')->setDec('user_balance',$this->amount);
      //           }else{
      //               $res3 = $cash->add($data);
      //           }

      //       $output = array('code' => 1, 'data' => $result->result_code, 'info' => '提现成功');
      //       exit(json_encode($output));
      // }else{

      //       $output = array('code' => 2, 'data' => $xml, 'info' => '提现失败');
      //       exit(json_encode($output));
      // }
   }
   /**
    * 提现接口操作,控制器调用
    * @param $openid 用户openid 唯一标示
    * @return
    */
   //提现接口操作
   public function tiXianAction(){
      //获取xml数据
      $data=$this->getdataXml($this->openid);
      $ch = curl_init ();
      //接口地址
      $MENU_URL="https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";

      curl_setopt ( $ch, CURLOPT_URL, $MENU_URL );
      curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );

      //证书地址,微信支付下面

        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,BASEPATH . 'libraries/pay/wxpay_pub/apiclient_cert.pem'); //证书这块大家把文件放到哪都行、
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,  BASEPATH . 'libraries/pay/wxpay_pub/apiclient_key.pem');//注意证书名字千万别写错、

      //$zs1=dirname(dirname(__FILE__)).'\wx_pay\apiclient_cert.pem';
      //$zs2=dirname(dirname(__FILE__)).'\wx_pay\apiclient_key.pem';
      //show_bug($zs1);

      //curl_setopt($ch,CURLOPT_SSLCERT,$zs1);
      //curl_setopt($ch,CURLOPT_SSLKEY,$zs2);
      // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01;
      // Windows NT 5.0)');
      //curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
      curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      $info = curl_exec ( $ch );
        //返回结果
        if($info){
            curl_close($ch);
            return $info;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return "curl出错，错误码:$error";
        }
   }
   /**
    * 获取数据封装为数组
    * @param $openid 用户openid 唯一标示
    * @return xml
    */

   private function getdataXml($openid){
      //封装成数据
      $dataArr=array(
         'amount'=>$this->amount*100,//金额（以分为单位，必须大于100）
         'check_name'=>'NO_CHECK',//校验用户姓名选项，NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
         'desc'=>'提现',//描述
         'mch_appid'=>$this->app_id,
         'mchid'=>$this->mchid,//商户号
         'nonce_str'=>rand(100000, 999999),//不长于32位的随机数
         'openid'=>$openid,//用户唯一标识
         'partner_trade_no'=>$this->order_sn,//商户订单号
         're_user_name'=>'',//用户姓名，check_name为NO_CHECK时为可选项
         'spbill_create_ip'=>$_SERVER["REMOTE_ADDR"],//服务器ip
      );
      //获取签名
      $sign=$this->getSign($dataArr);
      //xml数据
      $data="<xml>
         <mch_appid>".$dataArr['mch_appid']."</mch_appid>
         <mchid>".$dataArr['mchid']."</mchid>
         <nonce_str>".$dataArr['nonce_str']."</nonce_str>
         <partner_trade_no>".$dataArr['partner_trade_no']."</partner_trade_no>
         <openid>".$dataArr['openid']."</openid>
         <check_name>".$dataArr['check_name']."</check_name>
         <re_user_name>".$dataArr['re_user_name']."</re_user_name>
         <amount>".$dataArr['amount']."</amount>
         <desc>".$dataArr['desc']."</desc>
         <spbill_create_ip>".$dataArr['spbill_create_ip']."</spbill_create_ip>
         <sign>".$sign."</sign>
         </xml>";
      return $data;

   }
   /**
    *     作用：格式化参数，签名过程需要使用
    */
   private function formatBizQueryParaMap($paraMap, $urlencode)
   {

      $buff = "";
      ksort($paraMap);
      foreach ($paraMap as $k => $v)
      {
         if($v){
            if($urlencode)
            {
               $v = urlencode($v);
            }

            $buff .= $k . "=" . $v . "&";
         }

      }
      $reqPar=NULL;
      if (strlen($buff) > 0)
      {
         $reqPar = substr($buff, 0, strlen($buff)-1);
      }

      return $reqPar;
   }

   /**
    *     作用：生成签名
    */
   private function getSign($Obj)
   {

      foreach ($Obj as $k => $v)
      {
         $Parameters[$k] = $v;
      }
      //签名步骤一：按字典序排序参数
      ksort($Parameters);
      $String = $this->formatBizQueryParaMap($Parameters, false);
      //echo '【string1】'.$String.'</br>';
      //签名步骤二：在string后加入KEY
      $String = $String."&key=".$this->apikey;
      //echo "【string2】".$String."</br>";
      //签名步骤三：MD5加密
      $String = md5($String);
      //echo "【string3】 ".$String."</br>";
      //签名步骤四：所有字符转为大写
      $result_ = strtoupper($String);
      //echo "【result】 ".$result_."</br>";
      return $result_;
   }
   //-----------
   private function http($url, $method='POST', $postfields = null, $headers = array())
   {
      header("Content-Type:text/html;charset=utf-8");
      $ch = curl_init();
      /* Curl settings */
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      switch ($method){
         case 'POST':
            curl_setopt($ch,CURLOPT_POST, true);
            break;
      }
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLINFO_HEADER_OUT, true);
      $response = curl_exec($ch);
      $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  //返回请求状态码
      curl_close($ch);
      return array($http_code, $response);
   }

}