<?php

class Notice_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 公告列表 *************************************/

    public function get_notice_showlist()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 3;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_data_count = $this->db->query("SELECT count(*) as total, group_concat(notice_id) as ids, from_unixtime(notice_time,'%Y%m%d') as day from '.$this->db->get_prefix().'notice group by day order by day desc");
        $i_total      = 0;
        foreach ($a_data_count as $key => $value) {
            $i_total++;
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_data = $this->db->query("SELECT count(*) as total, group_concat(notice_id) as ids, from_unixtime(notice_time,'%Y%m%d') as day from '.$this->db->get_prefix().'notice group by day order by day desc limit " . ($i_page - 1) * $i_prow . ',' . $i_prow);
        // return $this->db->get_sql();
        return $a_data;
    }

    /************************************* 所有公告 *************************************/

    public function get_notice_all()
    {
        $a_order = [
            'notice_id' => 'desc',
        ];
        $a_data  = $this->db->get('notice', [], '', $a_order, 0, 999999);
        return $a_data;
    }

    /************************************* 公告条数 *************************************/

    public function get_notice_count()
    {
        $i_result = $this->db->get_total('notice');
        return $i_result;
    }

    /************************************* 添加公告 *************************************/

    /**
     * [insert_notice 插入一条公告信息]
     * @param  [array] $a_data        [要插入的数据]
     * @return [int]   $i_result    [返回新数据的id]
     */
    public function insert_notice($a_data)
    {
        $i_result = $this->db->insert('notice', $a_data);
        return $i_result;
    }

    /************************************* 修改公告 *************************************/

    /**
     * [update_notice description]
     * @param  [array] $a_where   [修改的条件]
     * @param  [array] $a_data    [修改的数据]
     * @return [int]   $i_result  [返回爱影响的行数]
     */
    public function update_notice($a_where, $a_data)
    {
        $i_result = $this->db->update('notice', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除一条 *************************************/

    /**
     * [delete_user 删除公告 单个删除]
     * [操作的表 user 操作方式 delete]
     * @param  [int] $user_id [要删除公告的id]
     * @return [int]          [返回删除受影响的行数]
     */
    public function delete_notice_one($notice_id)
    {
        $a_where  = [
            'notice_id' => $notice_id,
        ];
        $i_result = $this->db->delete('notice', $a_where);
        return $i_result;
    }

    /************************************* 删除多条 *************************************/

    /**
     * [delete_room_mony 批量删除公告]
     * @param  [array] $a_data     [要删除的公告的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_notice_mony($a_data)
    {
        $i_result = $this->db->where_in('notice_id', $a_data)->delete('notice');
        return $i_result;
    }

    /************************************* 获取一条 *************************************/

    /**
     * [get_notice_one 获取一条公告的信息]
     * @param  [type] $notice_id [description]
     * @return [type]            [description]
     */
    public function get_notice_one($notice_id)
    {
        $a_where = [
            'notice_id' => $notice_id,
        ];
        $a_data  = $this->db->get_row('notice', $a_where);
        return $a_data;
    }

    /************************************************************************************/

}
