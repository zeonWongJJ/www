<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/5/3
 * Time: 9:59
 */

class ApiToken_model extends TW_Model
{

    public function __construct() {
        parent :: __construct();
    }
    public function token_no_allow(){
        $result = array(
            'code' => 404,
            'msg' => 'token失效，请重新登录',
            'data' => '',
        );
        return $result;
    }

    public function is_allow() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = trim($this->general->post('token'));
            $a_where = [
                'token' => $token
            ];
            $a_data = $this->db->get_row('token', $a_where);
            if ($a_data['token'] == $token) {
                //如果当前时间小于失效时间,说明token已经失效
                if ($a_data['expires_time'] < time()) {
                    return false;
                }
                return true;
            }
            return false;
        }
    }
    public function setToken($create_time,$expires_time,$token){

        $a_data=['create_time' => $create_time,
            'expires_time' => $expires_time,
            'token' => $token];
        $this->db->insert('token', $a_data);
    }
}
