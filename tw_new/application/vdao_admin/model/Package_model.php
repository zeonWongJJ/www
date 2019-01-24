<?php

class Package_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 套餐列表 *************************************/

    /**
     * [get_pro_top description]
     * @return [type] [description]
     */
    public function get_pro_top()
    {
        $a_where = [
            'pro_id_1' => 0,
            'is_show'  => 1,
        ];
        $s_field = '';
        $a_order = [
            'pro_id' => 'desc',
        ];
        $a_data  = $this->db->get('pro', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************ 获取时间段 ************************************/

    public function get_time_all()
    {
        $a_order = [
            'time_id' => 'asc',
        ];
        $a_data  = $this->db->get('time', [], '', $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************* 获取产品 *************************************/

    /**
     * [get_product_bypro 获取产品]
     * @param  [type] $pro_id [description]
     * @return [type]         [description]
     */
    public function get_product_bypro($pro_id)
    {
        $a_where = [
            'proid_id_1' => $pro_id,
        ];
        $s_field = '';
        $a_order = [
            'product_id' => 'desc',
        ];
        $a_data  = $this->db->get('product', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************* 添加产品 *************************************/

    public function insert_product($a_data)
    {
        $i_result = $this->db->insert('product', $a_data);
        return $i_result;
    }

    /************************************* 添加价格 *************************************/

    public function insert_price($a_data)
    {
        $i_result = $this->db->insert('price', $a_data);
        return $i_result;
    }

    /************************************* 套餐列表 *************************************/

    public function get_package_page()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'product_group' => 1,
        ];
        $i_total = $this->db->get_total('product', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field           = 'proid_id_1, proid_id_2, proid_id_3, antistop, product_name, order, pro_details, pro_image, pro_img, goods_stye, pro_show, supply_time, product_group, group_product,' . $this->db->get_prefix() . 'product.product_id, ' . $this->db->get_prefix() . 'price.price';
        $a_order           = [
            'product_id' => 'desc',
        ];
        $a_data['product'] = $this->db->from('product')
            ->join('price', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'price.product_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count']   = $i_total;
        return $a_data;
    }

    /************************************* 修改套餐 *************************************/

    public function update_product($a_where, $a_data)
    {
        $i_result = $this->db->update('product', $a_data, $a_where);
        return $i_result;
    }

    /*********************************** 获取一条产品 ***********************************/

    public function get_product_one($product_id)
    {
        $a_where = [
            'product_id' => $product_id,
        ];
        $a_data  = $this->db->get_row('product', $a_where);
        return $a_data;
    }

    /*********************************** 删除一条产品 ***********************************/

    public function delete_product($product_id)
    {
        $a_where  = [
            'product_id' => $product_id,
        ];
        $i_result = $this->db->delete('product', $a_where);
        return $i_result;
    }

    /*********************************** 删除一条价格 ***********************************/

    public function delete_price($product_id)
    {
        $a_where  = [
            'product_id' => $product_id,
        ];
        $i_result = $this->db->delete('price', $a_where);
        return $i_result;
    }

    /*********************************** 获取一条价格 ***********************************/

    public function get_price_one($product_id)
    {
        $a_where = [
            'product_id' => $product_id,
        ];
        $a_data  = $this->db->get_row('price', $a_where);
        return $a_data;
    }

    /********************************** 获取分类下的产品 **********************************/

    public function get_product_bycate($pro_arr)
    {
        $a_order = [
            'product_id' => 'DESC',
        ];
        $a_data  = $this->db->where_in('proid_id_1', $pro_arr)
            ->get('product', [], '', $a_order, 0, 999999999);
        return $a_data;
    }

    /*********************************** 更新一条价格 ***********************************/

    public function update_price($a_where, $a_data)
    {
        $i_result = $this->db->update('price', $a_data, $a_where);
        return $i_result;
    }

    /************************************************************************************/

}
