<?php

class Shopman_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /******************************** 获取所有状态下的店主 ********************************/

    public function get_shopman_all()
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
        $a_where = [
            'is_shopman >' => 0,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'shopman_regtime' => 'desc',
        ];
        $a_data['user']  = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 获取一个店主 ***********************************/

    public function get_shopman_yes()
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
        $a_where = [
            'is_shopman' => 1,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'user_id' => 'desc',
        ];
        $a_data['user']  = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 获取一个店主 ***********************************/

    /**
     * [get_shopman_one 获取一条店主信息]
     * @param  [int]   $user_id   [传入的会员id]
     * @return [array]            [返回查询到的数据]
     */
    public function get_shopman_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /*********************************** 修改店主信息 ***********************************/

    /**
     * [update_user 修改店主信息]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_user($a_where, $a_data)
    {
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 删除一条店主 ***********************************/

    /**
     * [delete_shopman_one 删除一条店主信息 将is_shopman字段改为0]
     * @param  [int] $user_id [要删除的店主id]
     * @return [int]          [返回删除的行数]
     */
    public function delete_shopman_one($user_id)
    {
        $a_where  = [
            'user_id' => $user_id,
        ];
        $a_data   = [
            'is_shopman'    => 0,
            'shopman_state' => 0,
        ];
        $i_result = $this->db->update('user', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 批量删除店主 ***********************************/

    /**
     * [delete_store_mony 批量删除店主 将is_shopman字段改为0]
     * @param  [array] $a_data     [要删除的店主id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_shopman_mony($a_where)
    {
        $a_data   = [
            'is_shopman'    => 0,
            'shopman_state' => 0,
        ];
        $i_result = $this->db->where_in('user_id', $a_where)->update('user', $a_data);
        return $i_result;
    }

    /*********************************** 搜索店主信息 ***********************************/

    /**
     * [get_shopman_search 通过关键词搜索移动店主]
     * @param  [string] $keywords [要搜索的关键词]
     * @return [array]            [返回搜索到的信息]
     */
    public function get_shopman_search($keywords)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(4);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        $a_where    = [
            'is_shopman >' => 0,
        ];
        $a_where_or = [
            'user_name LIKE'  => '%' . $keywords . '%',
            'user_phone LIKE' => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'user_id' => 'desc',
        ];
        $a_data['user']  = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************ 搜索推荐人 ************************************/

    /**
     * [get_shopman_search 通过关键词搜索推荐人]
     * @param  [string] $keywords [要搜索的关键词]
     * @return [array]            [返回搜索到的信息]
     */
    public function get_referee_search($keywords, $user_id)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(5);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where    = [
            'user_referee' => $user_id,
        ];
        $a_where_or = [
            'user_name LIKE'  => '%' . $keywords . '%',
            'user_phone LIKE' => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field           = '';
        $a_order           = [
            'user_id' => 'desc',
        ];
        $a_data['referee'] = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->get('user', $a_where, $s_field, $a_order);
        $a_data['count']   = $i_total;
        return $a_data;
    }

    /********************************** 搜索推荐人订单 ***********************************/

    public function get_order_search($keywords, $user_id)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(5);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        $a_where    = [
            $this->db->get_prefix() . 'order.order_referee' => $user_id,
        ];
        $a_where_or = [
            $this->db->get_prefix() . 'user.user_name LIKE'   => '%' . $keywords . '%',
            $this->db->get_prefix() . 'user.user_phone LIKE'  => '%' . $keywords . '%',
            $this->db->get_prefix() . 'order.store_name LIKE' => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get_total('', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = $this->db->get_prefix() . 'user.user_name, user_sex, user_phone, store_name, ' . $this->db->get_prefix() . 'order.user_id, order_id, order_count, goods_amount, order_commission, time_create, user_pic, user_regtime';
        $a_order         = [
            'order_id' => 'desc',
        ];
        $a_data['order'] = $this->db->group_start('AND')
            ->where_or($a_where_or)
            ->group_end()
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /******************************** 获取部分推荐人订单 *********************************/

    public function get_part_order($user_id)
    {
        $a_where = [
            'order_referee' => $user_id,
            'order_state'   => 30,
        ];
        $s_field = $this->db->get_prefix() . 'user.user_name,user_sex,user_phone,store_name,' . $this->db->get_prefix() . 'order.user_id,order_id,order_count,goods_amount,order_commission,time_create';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_data  = $this->db->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 5);
        return $a_data;
    }

    /******************************** 获取全部推荐人订单 *********************************/

    public function get_all_order($user_id)
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
        $a_where = [
            'order_referee' => $user_id,
        ];
        $i_total = $this->db->get_total('order', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = $this->db->get_prefix() . 'user.user_name,user_sex,user_phone,store_name,' . $this->db->get_prefix() . 'order.user_id,order_id,order_count,goods_amount,order_commission,time_create, user_pic, user_regtime';
        $a_order         = [
            'order_id' => 'desc',
        ];
        $a_data['order'] = $this->db->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /********************************** 获取部分推荐人 ***********************************/

    public function get_part_referee($user_id)
    {
        $a_where = [
            'user_referee' => $user_id,
        ];
        $s_field = 'user_id,user_name,user_sex,user_phone,user_consume,user_commission,user_regtime';
        $a_order = [
            'user_id' => 'desc',
        ];
        $a_data  = $this->db->get('user', $a_where, $s_field, $a_order, 0, 5);
        return $a_data;
    }

    /********************************** 获取所有推荐人 ***********************************/

    public function get_all_referee($user_id)
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
        $a_where = [
            'user_referee' => $user_id,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field           = 'user_id,user_name,user_sex,user_phone,user_consume,user_commission,user_regtime,user_ordercount,, user_pic, user_regtime';
        $a_order           = [
            'user_id' => 'desc',
        ];
        $a_data['referee'] = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count']   = $i_total;
        return $a_data;
    }

    /*********************************** 获取申请列表 ***********************************/

    public function get_shopman_applylist()
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
        $a_where = [
            'is_shopman' => 2,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'user_id' => 'desc',
        ];
        $a_data['user']  = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 获取拒绝列表 ***********************************/

    public function get_shopman_refuselist()
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
        $a_where = [
            'is_shopman' => 3,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'user_id' => 'desc',
        ];
        $a_data['user']  = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 获取搁置列表 ***********************************/

    public function get_shopman_shelvelist()
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
        $a_where = [
            'is_shopman' => 4,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'user_id' => 'desc',
        ];
        $a_data['user']  = $this->db->get('user', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 推荐的人的订单 ***********************************/

    public function get_referee_order($user_id)
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
        $a_where = [
            $this->db->get_prefix() . 'order.user_id' => $user_id,
        ];
        $i_total = $this->db->get_total('order', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = $this->db->get_prefix() . 'user.user_name,user_sex,user_phone,store_name,' . $this->db->get_prefix() . 'order.user_id,order_id,order_count,goods_amount,order_commission,time_create, user_pic, user_regtime';
        $a_order         = [
            'order_id' => 'desc',
        ];
        $a_data['order'] = $this->db->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************************************************************/

}
