<?php
class Check_model extends TW_Model {
    public function __construct() {
    }
    //验证是否为指定长度的字母/数字组合
    function fun_text1($num1, $num2, $str) {
        Return (preg_match("/^[a-zA-Z0-9]{" . $num1 . "," . $num2 . "}$/", $str)) ? true : false;
    }
    //验证是否为指定长度数字
    function fun_text2($num1, $num2, $str) {
        return (preg_match("/^[0-9]{" . $num1 . "," . $num2 . "}$/i", $str)) ? true : false;
    }
    //验证是否为指定长度汉字
    function fun_font($num1, $num2, $str) {
        // preg_match("/^[\xa0-\xff]{1,4}$/", $string);
        return (preg_match("/^([\x81-\xfe][\x40-\xfe]){" . $num1 . "," . $num2 . "}$/", $str)) ? true : false;
    }
    /**
     * 判断是否为合法的身份证号码
     * @param $mobile
     * @return int
     */
    function fun_status($vStr){
      $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
      );
      if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
      if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
      $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
      $vLength = strlen($vStr);
      if ($vLength == 18) {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
      } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
      }
      if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
      if ($vLength == 18) {
        $vSum = 0;
        for ($i = 17 ; $i >= 0 ; $i--) {
          $vSubStr = substr($vStr, 17 - $i, 1);
          $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }
        if($vSum % 11 != 1) return false;
      }
      return true;
    }

    //验证邮件地址
    function fun_email($str) {
        return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/', $str)) ? true : false;
    }
    //验证电话号码
    function fun_phone($str) {
        return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/", $str)) ? true : false;
    }
    //验证邮编
    function fun_zip($str) {
        return (preg_match("/^[1-9]\d{5}$/", $str)) ? true : false;
    }
    //验证url地址
    function fun_url($str) {
        return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/", $str)) ? true : false;
    }
    // 数据入库 转义 特殊字符 传入值可为字符串 或 一维数组
    function data_join(&$data) {
        if (get_magic_quotes_gpc() == false) {
            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    $data[$k] = addslashes($v);
                }
            } else {
                $data = addslashes($data);
            }
        }
        Return $data;
    }
    // 数据出库 还原 特殊字符 传入值可为字符串 或 一/二维数组
    function data_revert(&$data) {
        if (is_array($data)) {
            foreach ($data as $k1 => $v1) {
                if (is_array($v1)) {
                    foreach ($v1 as $k2 => $v2) {
                        $data[$k1][$k2] = stripslashes($v2);
                    }
                } else {
                    $data[$k1] = stripslashes($v1);
                }
            }
        } else {
            $data = stripslashes($data);
        }
        Return $data;
    }
    // 数据显示 还原 数据格式 主要用于内容输出 传入值可为字符串 或 一/二维数组
    // 执行此方法前应先data_revert()，表单内容无须此还原
    function data_show(&$data) {
        if (is_array($data)) {
            foreach ($data as $k1 => $v1) {
                if (is_array($v1)) {
                    foreach ($v1 as $k2 => $v2) {
                        $data[$k1][$k2] = nl2br(htmlspecialchars($data[$k1][$k2]));
                        $data[$k1][$k2] = str_replace(" ", " ", $data[$k1][$k2]);
                        $data[$k1][$k2] = str_replace("\n", "<br>\n", $data[$k1][$k2]);
                    }
                } else {
                    $data[$k1] = nl2br(htmlspecialchars($data[$k1]));
                    $data[$k1] = str_replace(" ", " ", $data[$k1]);
                    $data[$k1] = str_replace("\n", "<br>\n", $data[$k1]);
                }
            }
        } else {
            $data = nl2br(htmlspecialchars($data));
            $data = str_replace(" ", " ", $data);
            $data = str_replace("\n", "<br>\n", $data);
        }
        Return $data;
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