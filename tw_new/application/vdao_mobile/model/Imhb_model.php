<?php

class Imhb_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 获取一条token *************************************/

    /**
     * [get_token_one 获取一条token]
     * @param  [type] $access_token [description]
     * @return [type]               [description]
     */
    public function get_token_one($access_token)
    {
        $a_where = [
            'access_token' => $access_token,
        ];
        $a_data  = $this->db->get_row('oauth_access_tokens', $a_where);
        return $a_data;
    }

    /*********************************** 获取一条用户信息 ************************************/

    /**
     * [get_user_one 获取一条用户信息]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /*********************************** 修改一条用户信息 ************************************/

    /**
     * [update_user 修改一条用户信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 插入一条红包信息 ************************************/

    /**
     * [insert_hongbao 插入一条红包信息]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_hongbao($a_data)
    {
        $i_result = $this->db->insert('hongbao', $a_data);
        return $i_result;
    }

    /*********************************** 获取一条红包信息 ************************************/

    /**
     * [get_hongbao_one description]
     * @param  [type] $hb_id [description]
     * @return [type]        [description]
     */
    public function get_hongbao_one($hb_id)
    {
        $a_where = [
            'hb_id' => $hb_id,
        ];
        $a_data  = $this->db->get_row('hongbao', $a_where);
        return $a_data;
    }

    /*********************************** 更新一条红包信息 ************************************/

    /**
     * [update_hongbao 更新一条红包信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_hongbao($a_where, $a_data)
    {
        $i_result = $this->db->update('hongbao', $a_data, $a_where);
        return $i_result;
    }

    /******************************** 获取一条红包领取人信息 *********************************/

    public function get_hongbao_receive($hb_id)
    {
        $a_where = [
            'hb_fhbid' => $hb_id,
        ];
        $s_field = 'hb_id, ' . $this->db->get_prefix() . 'hongbao.user_id, hb_type, hb_amount, hb_time, hb_message, pay_type, hb_balance, hb_total, hb_remain, hb_fhbid, user_name, user_pic';
        $a_order = [
            'hb_id' => 'desc',
        ];
        $a_data  = $this->db->from('hongbao')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'hongbao.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 9999);
        return $a_data;
    }

    /******************************** 获取一个用户的红包信息 *********************************/

    public function get_hongbao_user($user_id, $pagesize, $pagecount)
    {
        // 先设置默认从第一页开始
        $i_page = $pagesize;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = $pagecount;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'user_id' => $user_id,
        ];
        $i_total = $this->db->get_total('hongbao', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'hb_id' => 'desc',
        ];
        $a_data  = $this->db->get('hongbao', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /***************************** 获取一个用户领取某个红包的次数 *****************************/

    /**
     * [get_thisuser_hbcount 获取一个用户领取某个红包的次数]
     * @param  [type] $hb_fid  [description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_thisuser_hbcount($hb_fid, $user_id)
    {
        $a_where  = [
            'user_id'  => $user_id,
            'hb_fhbid' => $hb_fid,
        ];
        $i_result = $this->db->get_total('hongbao', $a_where);
        return $i_result;
    }

    /*****************************************************************************************/

}