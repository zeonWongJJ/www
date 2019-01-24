<?php
class Evaluation_model extends TW_Model
{
    public function __construct()
    {
        $this->tw=$this->db->get_prefix();	
    }
	
    /**
     * [获取未曾评价的订单]
     * @param  [int]  [i_orderid]
     * @return [array]
     */
    public function not_evaluation($i_orderid=2){
    	// $a_where = ['order_id' => $i_orderid];
    	// $s_fields='goods_id,goods_pay_price';
    	// $a_where_not_in=('goods_id',);
  //   	SELECT   WHERE order_id = 2 AND goods_id NOT IN (SELECT `geval_goodsid` FROM `tw_evaluate_goods`
		// WHERE `geval_orderid` = '2');
		//使用框架 子查询失败
  //   	$a_result = $this->db->from('tw_order_goods')
  //                            ->select($s_fields,false)
  //                            ->where($a_where)
  //                            ->where_not_in('goods_id',['(SELECT `geval_goodsid` FROM `tw_evaluate_goods`
		// WHERE `geval_orderid` = 2)'])
  //                            ->get();

    	$s_sql='SELECT c.store_label,c.store_desccredit,c.store_servicecredit,c.store_deliverycredit,b.goods_name,b.goods_image,a.goods_id,a.goods_pay_price,c.store_name from tw_order_goods a left join tw_goods b on b.goods_id=a.goods_id left join tw_store c on a.store_id=c.store_id WHERE order_id = '.$i_orderid.' AND a.goods_id NOT IN (SELECT `geval_goodsid` FROM `tw_evaluate_goods`
		WHERE `geval_orderid` = '.$i_orderid.')';
		$a_result=$this->db->query($s_sql);
        
        foreach($a_result as $key=>$value){
        	var_dump($value);
        }
      
    }


    /**
     * [加密函数]
     * @param [string]  [字符串]
     * @param [string]  [operation 加密还是解密 E|D]
     * @param [string]  [ key 密钥]
     * @return [string]  [ key 密钥]
     */
	public function encrypt($string,$operation,$key='32121321121'){ 

    $key=md5($key); 
    $key_length=strlen($key); 
      $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string; 
    $string_length=strlen($string); 
    $rndkey=$box=array(); 
    $result=''; 
    for($i=0;$i<=255;$i++){ 
           $rndkey[$i]=ord($key[$i%$key_length]); 
        $box[$i]=$i; 
    } 
    for($j=$i=0;$i<256;$i++){ 
        $j=($j+$box[$i]+$rndkey[$i])%256; 
        $tmp=$box[$i]; 
        $box[$i]=$box[$j]; 
        $box[$j]=$tmp; 
    } 
    for($a=$j=$i=0;$i<$string_length;$i++){ 
        $a=($a+1)%256; 
        $j=($j+$box[$a])%256; 
        $tmp=$box[$a]; 
        $box[$a]=$box[$j]; 
        $box[$j]=$tmp; 
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
    } 
    if($operation=='D'){ 
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
            return substr($result,8); 
        }else{ 
            return''; 
        } 
    }else{ 
        return str_replace('=','',base64_encode($result)); 
    } 
} 

}