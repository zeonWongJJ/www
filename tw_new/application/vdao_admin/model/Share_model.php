<?php

class Share_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /*********************************** 分享列表 ***********************************/

    public function get_qualifi_goods($state)
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
        if ($state == 'all') {
            $a_where = [];
        } else {
            $a_where = [
                $this->db->get_prefix() . 'qualifi_goods.state' => $state,
            ];
        }
        $i_total = $this->db->get_total('qualifi_goods', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'goo_id, ' . $this->db->get_prefix() . 'qualifi_goods.user_id, ' . $this->db->get_prefix() . 'qualifi_goods.product_id, goods_license, distribution, state, operate_time, apply_time, product_name, pro_details, pro_img, pro_name, price';
        $a_order         = [
            'apply_time' => 'desc',
        ];
        $a_data['goods'] = $this->db->from('qualifi_goods')
            ->join('product', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'qualifi_goods.product_id'])
            ->join('pro', [$this->db->get_prefix() . 'pro.pro_id' => $this->db->get_prefix() . 'product.proid_id_1'])
            ->join('price', [$this->db->get_prefix() . 'price.product_id' => $this->db->get_prefix() . 'product.product_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /*********************************** 修改申请 ***********************************/

    /**
     * [update_qualifi_goods 修改申请]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_qualifi_goods($a_where, $a_data)
    {
        return $this->db->update('qualifi_goods', $a_data, $a_where);
    }

    /*********************************** 一条申请 ***********************************/

    /**
     * [get_qualifi_goods_one 获取一条申请]
     * @param  [type] $goo_id [description]
     * @return [type]         [description]
     */
    public function get_qualifi_goods_one($goo_id)
    {
        $a_where = [
            'goo_id' => $goo_id,
        ];
        return $this->db->get_row('qualifi_goods', $a_where);
    }

    /*********************************** 一条申请 ***********************************/

    /**
     * [get_qualifi_goods_row description]
     * @return [type] [description]
     */
    public function get_qualifi_goods_row($goo_id)
    {
        $a_where = [
            'goo_id' => $goo_id,
        ];
        $s_field = 'goo_id, ' . $this->db->get_prefix() . 'qualifi_goods.user_id, ' . $this->db->get_prefix() . 'qualifi_goods.product_id, goods_license, distribution, state, operate_time, apply_time, product_name, pro_details, pro_img, pro_name, price';
        $a_data  = $this->db->from('qualifi_goods')
            ->join('product', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'qualifi_goods.product_id'])
            ->join('pro', [$this->db->get_prefix() . 'pro.pro_id' => $this->db->get_prefix() . 'product.proid_id_1'])
            ->join('price', [$this->db->get_prefix() . 'price.product_id' => $this->db->get_prefix() . 'product.product_id'])
            ->get_row('', $a_where, $s_field);
        return $a_data;
    }

    /*********************************** 一条资质 ***********************************/

    /**
     * [get_qualifi_one 一条资质]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_qualifi_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        return $this->db->get_row('qualifi', $a_where);
    }

    /*********************************** 一条用户 ***********************************/

    /**
     * [get_user_one 一条用户]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        return $this->db->get_row('user', $a_where);
    }

    /*********************************** 分享详情 ***********************************/

}
