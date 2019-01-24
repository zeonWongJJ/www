<?php

class Join_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /**************************************** 申请加盟 ****************************************/

    public function join_apply()
    {
        header('Content-Type:Application/json;charset=utf8');
        // 接收数据
        $a_data = $this->general->post();
        // 验证数据
        $a_parameter = [
            'msg'  => '这是提示信息',
            'code' => 400,
//			'url'      => 'join_showlist',
//			'log'      => false,
//			'wait'     => 2,
        ];
        // 验证是保存草稿还是直接提交
        $is_temporary = $this->router->get(1);
        // is_temporary为1则是保存草稿
        if ($is_temporary == 1) {
            $join_state = 1;
        } else {
            // 验证是否为空
            if (empty($a_data['join_phone']) || empty($a_data['user_code'])) {
                $a_parameter['msg'] = '必填项不能为空';
                echo json_encode($a_parameter);
                exit(0);
                // $this->error->show_error($a_parameter);
            }
            // 验证手机是否与发送验证码的手机一致
            if ($_SESSION['user_phone'] != $a_data['join_phone']) {
                $a_parameter['msg'] = '手机号码不正确';
                echo json_encode($a_parameter);
                exit(0);
                // $this->error->show_error($a_parameter);
            }
            // 验证验证码是否正确
            if ($_SESSION['code'] != $a_data['user_code']) {
                $a_parameter['msg'] = '验证码不正确';
                echo json_encode($a_parameter);
                exit(0);
                // $this->error->show_error($a_parameter);
            }
            $join_state = 2;
            //申请添加到消息表
            $this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '加盟申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
        }
        // 组装数据
        $a_insert_data = [
            'user_id'          => $_SESSION['user_id'],
            'user_name'        => $_SESSION['user_name'],
            'join_storename'   => $a_data['join_storename'],
            'join_storecount'  => $a_data['join_storecount'],
            'join_province'    => $a_data['join_province'],
            'join_city'        => $a_data['join_city'],
            'join_district'    => $a_data['join_district'],
            'join_address'     => $a_data['join_address'],
            'join_passenger'   => $a_data['join_passenger'],
            'join_size'        => $a_data['join_size'],
            'join_floor'       => $a_data['join_floor'],
            'join_licence'     => $a_data['join_licence'],
            'join_regmark'     => $a_data['join_regmark'],
            'join_licname'     => $a_data['join_licname'],
            'join_corporation' => $a_data['join_corporation'],
            'join_expirydate'  => $a_data['join_expirydate'],
            'join_idcard'      => $a_data['join_idcard'],
            'join_idcardpic'   => $a_data['join_idcardpic'],
            'join_linkman'     => $a_data['join_linkman'],
            'join_phone'       => $a_data['join_phone'],
            'join_state'       => $join_state,
            'join_time'        => $_SERVER['REQUEST_TIME'],
        ];
        // 将数据插入到数据库
        $i_result = $this->insert_join($a_insert_data);
        return $i_result;
    }

    /************************************* 插入一条申请记录 *************************************/

    /**
     * [insert_join 插入一条申请记录]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_join($a_data)
    {
        $i_result = $this->db->insert('join', $a_data);
        return $i_result;
    }

    /************************************* 获取用户所有申请记录 *************************************/

    /**
     * [get_join_user 插入一条申请记录]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_join_user($user_id)
    {
        $a_where = [
            'user_id' => $user_id
        ];
        $s_field = '';
        $a_order = [
            'join_id' => 'desc'
        ];
        $a_data  = $this->db->get('join', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************* 获取一条申请记录 *************************************/

    /**
     * [get_join_one 获取一条申请记录]
     * @param  [type] $join_id [description]
     * @return [type]          [description]
     */
    public function get_join_one($join_id)
    {
        $a_where = [
            'join_id' => $join_id
        ];
        $a_data  = $this->db->get_row('join', $a_where);
        return $a_data;
    }

    /************************************* 更新一条申请记录 *************************************/

    public function join_update()
    {
        // 接收数据
        $a_data = $this->general->post();
        // 验证数据
        $a_parameter = [
            'msg'  => '这是提示信息',
            'url'  => 'join_showlist',
            'log'  => false,
            'wait' => 2,
        ];
        // 验证当前状态
        $join_row = $this->get_join_one($a_data['join_id']);
        if ($a_data['join_state'] == 3) {
            $a_parameter['msg'] = '该申请已通过不允许修改';
            $this->error->show_error($a_parameter);
        }
        // 验证是保存草稿还是直接提交
        $is_temporary = $this->router->get(2);
        // is_temporary为1则是保存草稿
        if ($is_temporary == 'draft') {
            $join_state = 1;
        } else {
            // 验证是否为空
            if (empty($a_data['join_phone']) || empty($a_data['user_code'])) {
                $a_parameter['msg'] = '必填项不能为空';
                $this->error->show_error($a_parameter);
            }
            // 验证手机是否与发送验证码的手机一致
            if ($_SESSION['user_phone'] != $a_data['join_phone']) {
                $a_parameter['msg'] = '手机号码不正确';
                $this->error->show_error($a_parameter);
            }
            // 验证验证码是否正确
            if ($_SESSION['code'] != $a_data['user_code']) {
                $a_parameter['msg'] = '验证码不正确';
                $this->error->show_error($a_parameter);
            }
            $join_state = 2;
            //申请添加到消息表
            $this->db->insert('messagess', ['ues' => 1, 'ues_id' => $_SESSION['user_id'], 'ues_name' => $_SESSION['user_name'], 'content' => '加盟申请', 'examine' => 1, 'mess_time' => $_SERVER['REQUEST_TIME']]);
        }
        // 组装数据
        $a_update_where = [
            'join_id' => $a_data['join_id'],
        ];
        $a_update_data  = [
            'user_id'          => $_SESSION['user_id'],
            'user_name'        => $_SESSION['user_name'],
            'join_storename'   => $a_data['join_storename'],
            'join_storecount'  => $a_data['join_storecount'],
            'join_province'    => $a_data['join_province'],
            'join_city'        => $a_data['join_city'],
            'join_district'    => $a_data['join_district'],
            'join_address'     => $a_data['join_address'],
            'join_passenger'   => $a_data['join_passenger'],
            'join_size'        => $a_data['join_size'],
            'join_floor'       => $a_data['join_floor'],
            'join_licence'     => $a_data['join_licence'],
            'join_regmark'     => $a_data['join_regmark'],
            'join_licname'     => $a_data['join_licname'],
            'join_corporation' => $a_data['join_corporation'],
            'join_expirydate'  => $a_data['join_expirydate'],
            'join_idcard'      => $a_data['join_idcard'],
            'join_idcardpic'   => $a_data['join_idcardpic'],
            'join_linkman'     => $a_data['join_linkman'],
            'join_phone'       => $a_data['join_phone'],
            'join_state'       => $join_state,
            'join_time'        => $_SERVER['REQUEST_TIME'],
        ];
        // 将数据保存到数据库
        $i_result = $this->update_join($a_update_where, $a_update_data);
        return $i_result;
    }

    /************************************* 更新一条申请记录 *************************************/

    /**
     * [update_join 更新一条申请记录]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_join($a_where, $a_data)
    {
        $i_result = $this->db->update('join', $a_data, $a_where);
        return $i_result;
    }

    /********************************************************************************************/

}

?>