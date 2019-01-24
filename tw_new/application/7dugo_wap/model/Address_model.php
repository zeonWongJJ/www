<?php
class Address_model extends TW_Model
{
    public function __construct()
    {
        $this->tw=$this->db->get_prefix();

    }

    //把数据库地址表的数据保存到一个文本文件 
    public function address_export(){
   		$address_data=$this->db->from("area")->limit(0,9999)->get();
   		foreach($address_data as $key=>$value){
   			if($value['area_deep']>1){
   				$address_array['low'][$value['area_parent_id']][$value['area_id']]=$value['area_name'];
   			 }
   			 else{
   			 	$address_array['top'][$value['area_id']]=$value['area_name'];
   			 }
   		}
   		// var_dump($address_array);
   		$address_json=json_encode($address_array);
   		file_put_contents(AREA,$address_json);
   	}
    /**
     * [删除地址信息]
     * @param  [int]  [address_id]
     * @return [int]  [1|0] 成功与否
     */
    public function delete_address($address_id){
    
        $user_id = $_SESSION['user_id'];
        $a_where = ['address_id' => $address_id, 'member_id' => $user_id];
        $status_row = $this->db->where($a_where)
                               ->delete('address');
        // echo $this->db->get_sql();
        return $status_row;
    }
    /**$this->tw.'.'
     * [更新收获地址]
     * @param  [array]  [POST提交的数据]
     * @return [boolean][true|false 成功与否]
     */
    public function address_update($a_post_data){

        $a_where['member_id'] = $_SESSION['user_id'];
        $a_where['address_id'] = $a_post_data['address_id'];
        // print_r($a_where['address_id']);die;
        if ($a_post_data['is_default'] == 1) {
            $this->db->begin();
            $result = $this->db->update('address', $a_post_data, $a_where);
            $data = $this->set_default($a_where['address_id']);
        } else {
            $this->db->begin();
            //不是默认状态
            $result = $this->db->update('address', $a_post_data, $a_where);
        }
        if ($result > 0 ) {
            $this->db->commit();
            return 1;
        } else {
            $this->db->roll_back();
            return 0;
        }
    }
    /**
     * [scm_detail_infos 统计出库累计数据]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function address_add($a_post_data){
        $a_post_data['member_id'] = $_SESSION['user_id'];
        if ($a_post_data['is_default'] == 1) {
            //如果新增的数据是默认状态
            $this->db->begin();
            $result = $this->db->insert('address', $a_post_data);
            $data = $this->set_default($result);
                if($result>0){
                     $this->db->commit();
                     return 1;

                }else{
                      $this->db->roll_back();
                     return 0;
                }

        } else {

            //不是默认状态
            $result = $this->db->insert('address', $a_post_data);
                if( $result > 0 ){
                    return 1;
                }else{
                    return 0;
                }
        }
    }
     // 跟新默认收货地址
    public function upaddress($s_address){
        $this->db->update('address', ['is_default' => 0], ['member_id' => $_SESSION['user_id']]);
        $this->db->update('address', ['is_default' => 1], ['member_id' => $_SESSION['user_id'], 'address_id' => $s_address]);
        $a_data = $this->db->get_row('address', ['member_id' => $_SESSION['user_id'], 'address_id' => $s_address], 'address,true_name,mob_phone,area_info');
        $a_res[0] = $a_data['area_info'] . ' ' . $a_data['address'];
        $a_res[1] = $a_data['true_name'];
        //手机号码隐藏部分信息
        $a_res[2] =  substr($a_data['mob_phone'], 0, 3) . '****' . substr($a_data['mob_phone'], -4);
        return $a_res;
    }
}