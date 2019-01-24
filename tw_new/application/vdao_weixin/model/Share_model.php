<?php

class Share_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************** 订单列表 **************************************/

    public function get_share_order($user_id, $type, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 15;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($type == 'all') {
            $a_where = [
                'share_userid' => $user_id,
            ];
        } else {
            $a_where = [
                'share_userid' => $user_id,
                'order_state'  => $type,
            ];
        }
        $i_total = $this->db->get_total('order', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'order_id, order_state, goods_amount, order_count, time_create, ' . $this->db->get_prefix() . 'order.user_name, user_pic, share_userid';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_data  = $this->db->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 验证是否超出最大页数
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }


    /************************************** 分享产品列表 **************************************/

    public function get_goods_list($user_id, $i_stuer, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = "`user_id` = '$user_id'";
        if (!empty($i_stuer)) {
            if ($i_stuer == 4) {
                $a_where .= ($a_where ? ' AND ' : '') . "`state` = '2'";
                $a_where .= ($a_where ? ' AND ' : '') . "`pro_show` = '2'";
            } else if ($i_stuer == 2) {
                $a_where .= ($a_where ? ' AND ' : '') . "`state` = '2'";
                $a_where .= ($a_where ? ' AND ' : '') . "`pro_show` = '1'";
            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`state` = $i_stuer";
            }
        }
        $i_total = $this->db->get_total('qualifi_goods', ['user_id' => $user_id]);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        $a_order = [
            'goo_id' => 'desc',
        ];
        $a_data  = $this->db->from('qualifi_goods as a')
            ->join('product as b', ['a.product_id' => 'b.product_id'])
            ->join('price as c', ['a.product_id' => 'c.product_id'])
            ->get('', $a_where, '', $a_order);
        // 验证是否超出最大页数
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /************************************** 一条商品 **************************************/

    /**
     * [get_goods_one 一条商品]
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function get_goods_one($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $a_data  = $this->db->get_row('order_goods', $a_where);
        return $a_data;
    }

    /************************************** 一条订单 **************************************/

    /**
     * [get_order_one description]
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function get_order_one($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $a_data  = $this->db->get_row('order', $a_where);
        return $a_data;
    }

    /************************************ 更新一条订单 ************************************/

    /**
     * [update_order 更新一条订单]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_order($a_where, $a_data)
    {
        $i_result = $this->db->update('order', $a_data, $a_where);
        return $i_result;
    }

    /************************************ 把产品购买加入月售数据表 ************************************/
    /**
     * [product_number 更新一条订单]
     * @param  [type] $a_data  [订单id]
     * @return [type]          [description]
     */
    public function product_number($a_data)
    {
        $a_order = $this->db->get('order_goods', ['order_id' => $a_data]);
        foreach ($a_order as $goods) {
            //把产品购买加入月售数据表
            $a_num = $this->db->get_row('product_number', ['product_id' => $goods['product_id']]);
            if (empty($a_num)) {
                $this->db->insert('product_number', ['product_id' => $goods['product_id'], 'number' => $goods['goods_num']]);
            } else {
                $this->db->set('number', 'number +' . $goods['goods_num'], false);
                $this->db->update('product_number', '', ['product_id' => $goods['product_id']]);
            }
        }
    }

    /************************************ 订单下的商品 ************************************/

    /**
     * [get_goods_order 订单下的商品]
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function get_goods_order($order_id)
    {
        $a_where = [
            'order_id' => $order_id,
        ];
        $s_field = '';
        $a_order = [
            'rec_id' => 'desc',
        ];
        $a_data  = $this->db->get('order_goods', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /************************************ 一条用户信息 ************************************/

    /**
     * [get_user_one 一条用户信息]
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

    /********************************* 插入一条订单日志 **********************************/

    /**
     * [insert_order_log 插入一条订单日志]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_order_log($a_data)
    {
        $i_result = $this->db->insert('order_log', $a_data);
        return $i_result;
    }

    /********************************* 获取一条订单日志 **********************************/

    /**
     * [get_log_one 获取一条订单日志]
     * @param  [type] $order_id    [description]
     * @param  [type] $order_state [description]
     * @return [type]              [description]
     */
    public function get_log_one($order_id, $order_state)
    {
        $a_where = [
            'order_id'       => $order_id,
            'log_orderstate' => $order_state,
        ];
        $a_data  = $this->db->get_row('order_log', $a_where);
        return $a_data;
    }

    /********************************* 更新一条用户信息 **********************************/

    /**
     * [update_user 更新一条用户信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /****************************** 根据设置名获取设置信息 *******************************/

    /**
     * [get_set_one 根据设置名获取设置信息]
     * @param  [type] $set_name [description]
     * @return [type]           [description]
     */
    public function get_set_one($set_name)
    {
        $a_where = [
            'set_name' => $set_name,
        ];
        $a_data  = $this->db->get_row('set', $a_where);
        return $a_data['set_parameter'];
    }

    /******************************** 插入一条积分记录 ************************************/

    /**
     * [insert_points_log description]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_points_log($a_data)
    {
        $i_result = $this->db->insert('points_log', $a_data);
        return $i_result;
    }

    /****************************** 获取一条消费统计信息 **********************************/

    /**
     * [get_statistic_one 获取一条消费统计信息]
     * @param  [type] $user_id  [description]
     * @param  [type] $sta_time [description]
     * @return [type]           [description]
     */
    public function get_statistic_one($user_id, $sta_time)
    {
        $a_where = [
            'user_id'  => $user_id,
            'sta_time' => $sta_time,
        ];
        $a_data  = $this->db->get_row('statistic', $a_where);
        return $a_data;
    }

    /****************************** 更新一条消费统计信息 **********************************/

    /**
     * [update_statistic 更新一条消费统计信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_statistic($a_where, $a_data)
    {
        $i_result = $this->db->update('statistic', $a_data, $a_where);
        return $i_result;
    }

    /****************************** 插入一条消费统计信息 **********************************/

    /**
     * [insert_statistic 插入一条消费统计信息]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_statistic($a_data)
    {
        $i_result = $this->db->insert('statistic', $a_data);
        return $i_result;
    }

    /*************************** 获取分享者7日内完成的订单 ********************************/

    /**
     * [get_share_seven 获取分享者7日内完成的订单]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_share_seven($user_id)
    {
        // 今日开始时间戳
        $start       = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $seven_start = $start - (3600 * 24 * 6);
        $a_where     = [
            'share_userid'    => $user_id,
            'time_finnshed >' => $seven_start,
        ];
        $s_field     = '';
        $a_order     = [
            'order_id' => 'desc',
        ];
        $a_data      = $this->db->where_in('order_state', [10, 80])
            ->get('order', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取分享者分享的所有产品 ********************************/

    /**
     * [get_qualifi_goods 获取分享者分享的所有产品]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_qualifi_goods($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $s_field = '';
        $a_order = [
            'goo_id' => 'desc',
        ];
        $a_data  = $this->db->get('qualifi_goods', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /*************************** 获取分享者分享的产品评价 ********************************/

    /**
     * [get_share_comment 获取分享者分享的产品评价]
     * @param  [type] $product_arr [description]
     * @return [type]              [description]
     */
    public function get_share_comment($product_arr)
    {
        // 今日开始时间戳
        $start       = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $seven_start = $start - (3600 * 24 * 6);
        $a_where     = [
            'comment_time >' => $seven_start,
        ];
        $s_field     = '';
        $a_order     = [
            'comment_id' => 'desc',
        ];
        $a_data      = $this->db->where_in('object_id', $product_arr)
            ->get('comment', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /**************************************************************************************/

}
