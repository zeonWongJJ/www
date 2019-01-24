<?php
//数据检测类
class Check_model extends TW_Model {
    public function __construct() {
    }

    //验证手机号
    public function check_mobile($phonenumber){
     return preg_match("/^1[34578]{1}\d{9}$/",$phonenumber)? true : false;
    }
    //验证用户名
    public function check_username($str){
       return preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,10}$/u",$str)?true:false; 
    }
    //验证用户名必须是中文
    public function check_name($str){
       return preg_match("/^[\x{4e00}-\x{9fa5}]{0,18}$/u",$str)?true:false; 
    }
    public function check_password($password){
       return preg_match("/^[a-zA-Z\d_]{6,16}$/",$password)?true:false; 
    }

    

    /**
     * [check参数是否整齐]
     * @param  [$_POST]  [数据]
     * @param  [变量=>方法]
     */
    public function check_parm($post_data,$key_array){

        foreach($key_array as $key=>$value){

            if(! array_key_exists($key,$post_data)){
                return false;
            }

            if(empty($post_data[$key])){
                return false;
            }

           if($value!=null){

                $function_name=explode("/",$value);

                foreach($function_name as $k=>$v){

                    $check_state=$this->$v($post_data[$key]);

                    if(!$check_state){
                        return false;
                    }

                }
            }
        }

        return true;

    }

    /**
     * [查询重复数据]
     * @param  [array]  [数据]
     * @return [array]  [是否有重复数据]
     */
    public function check_repeat_data($table,$a_where){
             $result=$this->db->from($table)
                         ->where($a_where)
                         ->get_total();
        return $result;
    }



}
?>