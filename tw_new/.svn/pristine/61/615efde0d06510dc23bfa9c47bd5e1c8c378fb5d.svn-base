<?php

namespace model;

class ExpressModel extends TW_Model {
        //错误码
        private $errorNum;
        //错误信息
        private $errorMessage;
        //最终结果
        private $result;
        //物流公司编码
        private $express_code;
        //物流单号
        private $express_num;
        //连接词
        private $union;
        //订单id
        private $order_id;
        //物流详情
        private $express_data;

	public function __construct() {

    }

    /**
     * [curl 发送]
     * @param  [string]  [url]
     * @return [array]   [data]
     */
    public function c_post($url,$post_data){
    	$ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }


    /**
        * [获取物流信息]
        * @param  [int]  [order_id 订单ID]
        * @return [array][company=>name,express=>express_id]
    */
    public function express($order_id,$flow=null){

        $this->order_id=$order_id;

        if(!is_int($order_id)){
           $this->set_option("errorNum",'1');
           $this->errorMessage = $this->getError();
           return json_encode($this->errorMessage);
        }
        //获取物流公司编号与公司名字
        $express_code_name=$this->get_express_data($order_id);

        $this->express_code=$express_code_name['e_code'];
        $this->express_name=$express_code_name['e_name'];

        if(empty($this->express_code) || empty($this->express_name)){
           $this->set_option("errorNum",'2');
           $this->errorMessage = $this->getError();
           return json_encode($this->errorMessage);
        }


        //获取物流单号
        $this->express_num=$this->get_express_num($this->order_id);

        if(empty($this->express_num)){

           $this->set_option("errorNum",'3');
           $this->errorMessage = $this->getError();
           return json_encode($this->errorMessage);

        }else if($flow=='express_code_num'){
            //物流公司编码
            $a_array['data']['code']=$this->express_code;
            //物流单号
            $a_array['data']['num']=$this->express_num;
            //物流公司名
            $a_array['data']['name']=$this->express_name;

            //状态
            $a_array['status']=true;
            $a_array['tips']='请求成功';
            $a_array['code']=50;
            return json_encode($a_array);
        }

        //最终物流详情
        $this->express_data=$this->get_express_result($this->express_num);

        // if(empty( $this->express_data)){
        //    $this->set_option("errorNum",'4');
        //    $this->errorMessage = $this->getError();
        //    return json_encode($this->errorMessage);
        // }else{
           return json_encode($this->return_result());
        // }

    }

    //赋值
    private function set_option($key,$value){
        $this->$key=$value;
    }

    //错误类型统计
    private function getError() {
      switch ($this->errorNum) {
        case 1: $code=10;$case = "订单id:".$this->order_id."传入错误,请重新检查"; break;
        case 2: $code=20;$case = "订单id:".$this->order_id."查无物流公司"; break;
        case 3: $code=30;$case = "订单id:".$this->order_id."查无物流单号"; break;
        // case 4: $case = "订单id:".$this->order_id."的".$this->express_num."单号查无物流详情"; break;

        default: $case= "未知错误";
      }
      $this->result['status']=false;
      $this->result['tips']=$case;
      $this->result['code']=$code;

      return $this->result;
    }

    //返回错误信息
     public function getErrorMsg(){
      return $this->errorMessage;
    }

    /**
        * [获取公司编号与公司名]
        * @param  [int]  [order_id]
        * @return [array][company=>name,express=>express_id]
    */
    public function get_express_data($order_id){

    	$s_fields='e_code,e_name';
    	$a_where=['a.order_id'=>$order_id];
    	$result=$this->db->from("order_common as a")
                 ->join("express as b",['a.shipping_express_id'=>'b.id'])
    			 ->select($s_fields,false)
    			 ->where($a_where)
    			 ->get();
    	return $result[0];
    }

    public function get_express_num($order_id){
        $s_fields='shipping_code';
        $a_where=['order_id'=>$order_id];
        $result=$this->db->from("order")
                 ->select($s_fields,false)
                 ->where($a_where)
                 ->get();
        return $result['0']['shipping_code'];
    }

    public function get_express_result($express_num){
        $this->express_num=$express_num;

        $s_fields='shipping_data';
        $a_where=['shipping_code'=>$express_num];
        $result=$this->db->from("express_kuaidi100")
                 ->select($s_fields,false)
                 ->where($a_where)
                 ->get();
        return $result['0']['shipping_data'];
    }

    private function return_result(){
        $express_data=json_decode($this->express_data,true);
        $express_result['status']=true;
        $express_result['tips']='请求成功';
        $express_result['code']='40';

        $express_result['data']=$express_data;
        return $express_result;
    }
    // 判断是否有存储
    public function is_have($shipping_code){
        $a_result=$this->db->from("express_kuaidi100")
                           ->where(['shipping_code'=>$shipping_code])
                           ->get();
        return $a_result;
    }
    //更新物流信息
    public function update_express($shipping_code,$shipping_data){
        $a_result=$this->db->update('express_kuaidi100', ['shipping_data' =>$shipping_data], ['shipping_code' => $shipping_code]);

        return $a_result;
    }
    //新增物流信息
    public function add_express($shipping_code,$shipping_data){
        $a_result=$this->db->insert('express_kuaidi100', ['shipping_code'=>$shipping_code,'shipping_data' =>$shipping_data]);

        return $a_result;
    }


}
?>
