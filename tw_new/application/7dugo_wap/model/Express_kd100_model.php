<?php
class Express_kd100_model extends TW_Model {
    private $order_id;
    private $shipping_status;
    private $shipping_message;
    private $shipping_comNew;
    private $shipping_code;
    private $shipping_company;
    private $post_data;

    public function __construct() {
        parent::__construct();
        $this->load->model('express_model');
    }

    /**
     * [发送订阅]
     * @param  [int]  [订单ID]
     * @return [array][订阅接口返回信息]
     */
    public function express($order_id) {
        if (!empty($order_id)) {
            $this->order_id = $order_id;
            //获取 物流公司代码 与 物流单号
            return $this->express_code_num();
        }
    }

    /**
     * [订阅的操作]
     * @return [array]  [订阅接口返回信息]
     */
    private function send_express() {

        $o = "";
        foreach ($this->post_data as $k => $v) {
            $o.= "$k=" . urlencode($v) . "&";
        }
        $this->post_data = substr($o, 0, -1);

        return $this->express_model->c_post(get_config_item('express_url') , $this->post_data);
    }

    /**
     * [回调函数]
     * @return [array]  [订阅接口|快递数据]
     */
    public function call_back($data) {
        $data = json_decode(htmlspecialchars_decode($data) , true);
        $this->shipping_status = $data['status'];
        $this->shipping_message = $data['message'];
        $this->shipping_comNew = $data['comNew'];
        $this->shipping_code = $data['lastResult']['nu'];
        $this->shipping_company = $data['lastResult']['com'];
        $shipping_data = json_encode($data['lastResult']['data']);
        $this->shipping_data=$shipping_data;
        //是否需要重新订阅
        if ($this->shipping_status == 'abort' && empty($this->shipping_comNew) ) {
            $this->shipping_data=$data['lastResult']['message'];
            $this->insert_express_log();
            return $this->dispose_data();
        } else {

            $this->insert_express_log();


            //不需要重新订阅 请求数据库
            if ($shipping_data) {
                $a_result = $this->express_model->is_have($this->shipping_code);
                if (!empty($a_result) && $a_result) {
                    $a_finally = $this->express_model->update_express($this->shipping_code, $shipping_data);
                } else {
                    $a_finally = $this->express_model->add_express($this->shipping_code, $shipping_data);
                }
            }
        }
        //返回状态给快递100
        if (isset($a_finally)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * [call 查询是否有数据]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function call() {
        //查询是否有数据插入
        $data = $this->db->from("express_kuaidi100")->where(['shipping_code' => '884539353702257611'])->get();
        var_dump($data);
    }

    //处理发送的数据
    private function dispose_data() {
        $post_data = [];
        $post_data["schema"] = 'json';
        $post_data["param"] = '{"company":"' . $this->shipping_company . '", "number":"' . $this->shipping_code . '",';
        $post_data["param"] = $post_data["param"] . '"key":"' . get_config_item(express_token) . '",';
        $post_data["param"] = $post_data["param"] . '"parameters":{"callbackurl":"' . get_config_item(express_call_back) . '"}}';
        $this->post_data = $post_data;
        return $this->send_express();
    }

    //初次订阅|或者直接获取数据 获取快递编码和快递单号
    public function express_code_num($order_id=null) {
        //如果传入order_id  返回单号的 公司和单号
          if($order_id != null){
                    $this->order_id=$order_id;
                    return $this->take_express_message();
          }
        
        $this->take_express_message();
        
        if( !empty( $this->shipping_code ) && !empty( $this->shipping_company )){
       
                return $this->dispose_data();
            
        }else{
            $state['result'] = false;
            $state['returnCode'] = 600;
            $state['message'] = '查无该订单的物流公司编码或物流单号';
            return $state;
        }
    }

    public function take_express_message(){
        $result = $this->express_model->express($this->order_id, "express_code_num");
        if(!is_array($result)){
            $result=json_decode($result,true);
        }
        // var_dump($result);
        if(!$result['status']){
          return $result;
        }

        $this->shipping_code = $result['data']['num'];
        $this->shipping_company = $result['data']['code'];
        return $result;
    }

    //  public function add_table(){
    //      $sql="CREATE TABLE runoob_tbl(
    // -> runoob_id INT NOT NULL AUTO_INCREMENT,
    // -> runoob_title VARCHAR(100) NOT NULL,
    // -> runoob_author VARCHAR(40) NOT NULL,
    // -> submission_date DATE,
    // -> PRIMARY KEY ( runoob_id )
    // -> );";
    //  }
          // id int  primary key ,
          //   type varchar(10),
          //   company varchar(30),
          //   shipping_code varchar(50),
          //   time int(10),
          //   log varchar(20)
        //     $this->shipping_status = $data['status'];
        // $this->shipping_message = $data['message'];
        // $this->shipping_comNew = $data['comNew'];
        // $this->shipping_code = $data['lastResult']['nu'];
        // $this->shipping_company = $data['lastResult']['com'];
    private function insert_express_log(){
        $time=$_SERVER['REQUEST_TIME'];
        // var_dump($this->shipping_status);
        // var_dump($this->shipping_company);
        // var_dump($this->shipping_code);
        // // var_dump($this->shipping_data);
        // var_dump($time);
        //     die;

        $i_insert_id=$this->db->insert('express_log',['type'=>$this->shipping_status,'company'=>$this->shipping_company,'shipping_code'=>$this->shipping_code,'time'=>$time,'log'=>$this->shipping_data]);
    }
    
}

