<?php

class Statistic_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /********************************** 根页码获取用户消费统计数据 **********************************/

    public function get_statistic_page($time)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(2);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($time == 9) {
            $a_where = [];
        } else {
            $a_where = [
                'sta_time' => $time,
            ];
        }
        $i_total = $this->db->get_total('statistic', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'sta_id, ' . $this->db->get_prefix() . 'user.user_id, sta_time, user_self, user_other, user_selfcount, user_othercount, user_selforder, user_otherorder, ' . $this->db->get_prefix() . 'user.user_name, referee_consume, user_consume, user_pic, user_regtime, user_selfsum, user_othersum';
        $a_order         = [
            'sta_id' => 'desc',
        ];
        $a_data['user']  = $this->db->from('statistic')
            ->join('user', [$this->db->get_prefix() . 'statistic.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        $a_data['page']  = $i_page;
        return $a_data;
    }

    /******************************** 根据id获取一条用户消费统计数据 ********************************/

    /**
     * [get_statistic_one 根据id获取一条用户消费统计数据]
     * @param  [int]   $sta_id [传入的id]
     * @return [array]         [返回查询到的数据]
     */
    public function get_statistic_one($sta_id)
    {
        $a_where = [
            'sta_id' => $sta_id,
        ];
        $a_data  = $this->db->get_row('statistic', $a_where);
        return $a_data;
    }

    /******************************** 根据订单id数组获取相关订单数据 ********************************/

    public function get_order_self($user_selforder)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(2);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = count($user_selforder);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'order_id, order_number, time_create, order_time, order_count, goods_amount, ' . $this->db->get_prefix() . 'order.user_id, ' . $this->db->get_prefix() . 'order.user_name, store_name, order_commission, ' . $this->db->get_prefix() . 'user.user_regtime';
        $a_order         = [
            'order_id' => 'desc',
        ];
        $a_data['order'] = $this->db->where_in('order_id', $user_selforder)
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************** 搜索用户当月的订单 *************************************/

    public function get_orderself_search($user_selforder, $keywords)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(3);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where_or = [
            'store_name LIKE'                                => $keywords,
            'order_number LIKE'                              => $keywords,
            $this->db->get_prefix() . 'order.user_name' => $keywords,
        ];
        $i_total    = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->where_in('order_id', $user_selforder)
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get_total('', $a_where, $s_field, $a_order);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'order_id, order_number, time_create, order_time, order_count, goods_amount, ' . $this->db->get_prefix() . 'order.user_id, ' . $this->db->get_prefix() . 'order.user_name, store_name, order_commission, ' . $this->db->get_prefix() . 'user.user_regtime';
        $a_order         = [
            'order_id' => 'desc',
        ];
        $a_data['order'] = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->where_in('order_id', $user_selforder)
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 获取所有的消费统计数据 ************************************/

    public function get_statistic_all()
    {
        $a_data = $this->db->get('statistic', [], '', [], 0, 9999999);
        return $a_data;
    }

    /******************************** 根关键词获取用户消费统计数据 ********************************/

    public function get_statistic_search($keywords)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(2);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where_or = [
            $this->db->get_prefix() . 'user.user_name LIKE'  => '%' . $keywords . '%',
            $this->db->get_prefix() . 'user.user_phone LIKE' => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->group_start('AND')->where_or($a_where_or)->group_end()
            ->from('statistic')
            ->join('user', [$this->db->get_prefix() . 'statistic.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get_total('', [], $s_field, $a_order);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'sta_id, ' . $this->db->get_prefix() . 'user.user_id, sta_time, user_self, user_other, user_selfcount, user_othercount, user_selforder, user_otherorder, ' . $this->db->get_prefix() . 'user.user_name, referee_consume, user_consume, user_pic, user_regtime, user_selfsum, user_othersum, ' . $this->db->get_prefix() . 'user.user_phone';
        $a_order         = [
            'sta_id' => 'desc',
        ];
        $a_data['user']  = $this->db->group_start('AND')->where_or($a_where_or)->group_end()
            ->from('statistic')
            ->join('user', [$this->db->get_prefix() . 'statistic.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', [], $s_field, $a_order);
        $a_data['count'] = $i_total;
        $a_data['page']  = $i_page;
        return $a_data;
    }

    /*************************************** 获取一条用户信息 **************************************/

    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /***********************************************************************************************/

}

?>
