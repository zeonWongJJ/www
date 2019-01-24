<?php

class Store_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 门店列表 *************************************/

    /**
     * [get_store_showlist 获取所有的门店信息]
     * @return [array] [返回所有的门店信息]
     */
    public function get_store_showlist()
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
        $i_total = $this->db->get_total('store');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order         = [
            'store_id' => 'desc',
        ];
        $a_data['store'] = $this->db->get('store', [], '', $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************* 获取一条 *************************************/

    /**
     * [get_store_one 根据id获取一条门店信息]
     * @param  [int] $store_id  [要获取门店信息的id]
     * @return [array]          [返回查询到的门店信息]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /************************************* 添加门店 *************************************/

    /**
     * [insert_store 插入一条门店信息]
     * @param  [array] $a_data [description]
     * @return [int]           [description]
     */
    public function insert_store($a_data)
    {
        $i_result = $this->db->insert('store', $a_data);
        return $i_result;
    }

    /************************************* 添加分组 *************************************/

    /**
     * [insert_group 添加分组]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_group($a_data)
    {
        $i_result = $this->db->insert('group', $a_data);
        return $i_result;
    }

    /*********************************** 添加管理员 *************************************/

    /**
     * [insert_manager 添加管理员]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_manager($a_data)
    {
        $i_result = $this->db->insert('manager', $a_data);
        return $i_result;
    }

    /********************************* 获取一条管理员信息 *******************************/

    public function get_manager_one($store_id)
    {
        $a_where = [
            'store_id'     => $store_id,
            'manager_type' => 1,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }

    /********************************* 获取一条管理员信息 *******************************/

    public function get_manager_name($manager_name)
    {
        $a_where = [
            'manager_name' => $manager_name,
        ];
        $a_data  = $this->db->get_row('manager', $a_where);
        return $a_data;
    }


    /********************************* 修改一条管理员信息 *******************************/

    public function update_manager($a_where, $a_data)
    {
        $i_result = $this->db->update('manager', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 修改门店 *************************************/

    /**
     * [update_store 修改门店信息]
     * @param  [array] $a_where [要修改的条件]
     * @param  [array] $a_data  [要修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_store($a_where, $a_data)
    {
        $i_result = $this->db->update('store', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除门店 *************************************/

    /**
     * [delete_store_one 删除单个门店]
     * @param  [int] $store_id [要删除的门店id]
     * @return [int]           [返回删除的行数]
     */
    public function delete_store_one($store_id)
    {
        $a_where  = [
            'store_id' => $store_id,
        ];
        $i_result = $this->db->delete('store', $a_where);
        return $i_result;
    }

    /**
     * [delete_store_mony 批量删除门店]
     * @param  [array] $a_data     [要删除的门店id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_store_mony($a_data)
    {
        $i_result = $this->db->where_in('store_id', $a_data)->delete('store');
        return $i_result;
    }

    /************************************* 搜索门店 *************************************/

    /**
     * [get_store_search 通过关键词搜索门店]
     * @param  [string] $keywords [要搜索的关键词]
     * @return [array]            [返回搜索到的信息]
     */
    public function get_store_search($keywords)
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
            'store_name LIKE'    => '%' . $keywords . '%',
            'store_address LIKE' => '%' . $keywords . '%',
            'store_linkman LIKE' => '%' . $keywords . '%',
        ];
        $i_total    = $this->db->where_or($a_where_or)->get_total('store');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'store_id' => 'desc',
        ];
        $a_data['store'] = $this->db->where_or($a_where_or)->get('store', [], $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************* 照片审批 *************************************/

    /**
     * [get_store_photo 获取所门店照片信息]
     * @return [type] [返回查询到的所有门店照片信息]
     */
    public function get_store_photo()
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
            'store_img !=' => '',
        ];
        $i_total = $this->db->get_total('store', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'store_id,store_name,store_img';
        $a_order = [
            'store_id' => 'desc',
        ];
        $a_data  = $this->db->get('store', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /**
     * [update_store_photo 删除指定照片并更新数据库]
     * @param  [type] $store_id [要删除的照片的门店的id]
     * @param  [type] $num      [要删除第几张]
     * @return [type]           [返回修改的行数]
     */
    public function update_store_photo($store_id, $num)
    {
        //先查找原来的门店照片信息
        $a_where      = [
            'store_id' => $store_id,
        ];
        $a_data       = $this->db->get_row('store', $a_where);
        $a_data_photo = explode('&', $a_data['store_img']);
        unlink($a_data_photo[$num]);
        unset($a_data_photo[$num]);
        $a_data_update = [
            'store_img' => implode('&', $a_data_photo),
        ];
        $i_result      = $this->db->update('store', $a_data_update, $a_where);
        return $i_result;
    }

    /***********************************************************************************/

}
