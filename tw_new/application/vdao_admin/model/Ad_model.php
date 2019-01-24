<?php

class Ad_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 广告列表 *************************************/

    public function get_ad_page()
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
        $i_total = $this->db->get_total('ad');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = '';
        $a_order         = [
            'ad_order' => 'asc',
        ];
        $a_data['ad']    = $this->db->get('ad', [], $s_field, $a_order);
        $a_data['count'] = $i_total;
        return $a_data;
    }

    /************************************* 删除广告 *************************************/

    /**
     * [delete_ad 删除广告]
     * @param  [type] $ad_id [description]
     * @return [type]        [description]
     */
    public function delete_ad($ad_id)
    {
        $a_where  = [
            'ad_id' => $ad_id,
        ];
        $i_result = $this->db->delete('ad', $a_where);
        return $i_result;
    }

    /************************************* 获取一条 *************************************/

    public function get_ad_one($ad_id)
    {
        $a_where = [
            'ad_id' => $ad_id,
        ];
        $a_data  = $this->db->get_row('ad', $a_where);
        return $a_data;
    }

    /************************************* 更新广告 *************************************/

    public function update_ad($a_where, $a_data)
    {
        $i_result = $this->db->update('ad', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 插入广告 *************************************/

    public function insert_ad($a_data)
    {
        $i_result = $this->db->insert('ad', $a_data);
        return $i_result;
    }

    /************************************************************************************/

}
