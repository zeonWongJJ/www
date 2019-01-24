<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:21
 */

class ApiConsumerUser_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    // 用户分页查询
    public function user_list($pageNum, $raw, $keywords)
    {

        if (empty($pageNum)) {
            $pageNum = 1;
        }
        // 设置每页显示的数据行数
        if (empty($raw)) {
            $raw = 10;
        }
        // 加载分页类
        $this->load->library('pages');
        $s_field = 'user_id, user_name,payment_code,user_sex,user_age,user_realname,	user_city,user_phone,user_email,user_score,user_balance,user_consume,user_referee,user_regtime,user_state,is_shopman,shopman_regtime,shopman_state,referee_count,user_pic,user_position,referee_consume,	user_orders,referee_orders,user_ordercount,referee_ordercount,user_products,referee_products,user_nickname,user_erweima,user_ispush,shopman_income,user_selfoffice,user_officecount,user_refereeoffice,referee_officecount';
        if (!empty($keywords)) {
            $a_where = [
                'user_name LIKE' => '%' . $keywords . '%',
            ];
            $i_total = $this->db->get_total('user', $a_where, $s_field);
        } else {
            $a_where = [];
            $i_total = $this->db->get_total('user', $a_where, $s_field);
        }

        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);

        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        if (!empty($keywords)) {
            $a_data = $this->db->get('user', $a_where, $s_field);
        } else {
            $a_data = $this->db->get('user', $a_where, $s_field);
        }
        return $a_data;
    }


    // 用户分页查询
    public function shopkeeper_name_list($pageNum, $raw, $keywords, $shopman)
    {
        /*is_shopman 是否是移动店主 0代表否 1代表是 2代表申请中 3代表已拒绝 4代表已搁置*/
        if (empty($pageNum)) {
            $pageNum = 1;
        }
        // 设置每页显示的数据行数
        if (empty($raw)) {
            $raw = 10;
        }
        // 加载分页类
        $this->load->library('pages');
        $s_field = 'user_id, user_name,payment_code,user_sex,user_age,user_realname,	user_city,user_phone,user_email,user_score,user_balance,user_consume,user_referee,user_regtime,user_state,is_shopman,shopman_regtime,shopman_state,referee_count,user_pic,user_position,referee_consume,	user_orders,referee_orders,user_ordercount,referee_ordercount,user_products,referee_products,user_nickname,user_erweima,user_ispush,shopman_income,user_selfoffice,user_officecount,user_refereeoffice,referee_officecount';
        if (!empty($keywords)) {
            if (!empty($shopman)) {
                $a_where = [
                    'user_name LIKE' => '%' . $keywords . '%', 'is_shopman' => $shopman,
                ];
                $i_total = $this->db->get_total('user', $a_where, $s_field);
            } else {
                $is_shopman = ['1', '2', '3', '4'];
                $a_where    = ['user_name LIKE' => '%' . $keywords . '%'];
                $i_total    = $this->db->where_in('is_shopman', $is_shopman)->get_total('user', $a_where, $s_field);
            }
        } else {
            if (!empty($shopman)) {
                $a_where = [
                    'is_shopman' => $shopman,
                ];
                $i_total = $this->db->get_total('user', $a_where, $s_field);
            } else {
                $is_shopman = ['1', '2', '3', '4'];
                $a_where    = [];
                $i_total    = $this->db->where_in('is_shopman', $is_shopman)->get_total('user', $a_where, $s_field);
            }
        }
        if ($pageNum > ceil($i_total / $raw)) {
            return [];
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        if (!empty($keywords)) {
            if (!empty($shopman)) {
                $a_data = $this->db->get('user', $a_where, $s_field);
            } else {
                $a_data = $this->db->where_in('is_shopman', $is_shopman)->get('user', $a_where, $s_field);
            }
        } else {
            if (!empty($shopman)) {
                $a_data = $this->db->get('user', $a_where, $s_field);
            } else {
                //$is_shopman=['1','2','3','4'];
                $a_data = $this->db->where_in('is_shopman', $is_shopman)->get('user', $a_where, $s_field);
            }
        }
        return $a_data;
    }
}
