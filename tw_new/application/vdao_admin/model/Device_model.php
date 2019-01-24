<?php

class Device_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 设备列表 *************************************/

    /**
     * [get_device_all 获取所有某一页设备信息]
     * @return [array] [返回查询到的数据]
     */
    public function get_device_all()
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
        $i_total = $this->db->get_total('device');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order          = [
            'device_id' => 'desc',
        ];
        $a_data['device'] = $this->db->get('device', [], '', $a_order);
        $a_data['count']  = $i_total;
        return $a_data;
    }

    /************************************* 添加设备 *************************************/

    /**
     * [insert_device 添加设备]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_device($a_data)
    {
        $i_result = $this->db->insert('device', $a_data);
        return $i_result;
    }

    /************************************* 获取一条 *************************************/

    /**
     * [get_device_one 根据id获取一条设备信息]
     * @param  [int]    $device_id   [设备id]
     * @return [array]               [返回查询到的数据]
     */
    public function get_device_one($device_id)
    {
        $a_where = [
            'device_id' => $device_id,
        ];
        $a_data  = $this->db->get_row('device', $a_where);
        return $a_data;
    }

    /************************************* 修改设备 *************************************/

    /**
     * [update_device 修改设备]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_device($a_where, $a_data)
    {
        $i_result = $this->db->update('device', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除设备 *************************************/

    /**
     * [delete_device_one 删除单个设备]
     * @param  [int] $device_id   [要删除的设备id]
     * @return [array]            [返回删除的行数]
     */
    public function delete_device_one($device_id)
    {
        $a_where  = [
            'device_id' => $device_id,
        ];
        $i_result = $this->db->delete('device', $a_where);
        return $i_result;
    }

    /**
     * [delete_device_mony 批量删除设备]
     * @param  [array] $a_data     [要删除的设备的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_device_mony($a_data)
    {
        $i_result = $this->db->where_in('device_id', $a_data)->delete('device');
        return $i_result;
    }

    /************************************* 搜索设备 *************************************/

    /**
     * [get_device_search 搜索设备]
     * @param  [string] $keywords [传入的关键词]
     * @return [array]             [返回查询到的数据]
     */
    public function get_device_search($keywords)
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
            'device_name LIKE' => '%' . $keywords . '%',
        ];
        $i_total = $this->db->get_total('device', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_order          = [
            'device_id' => 'desc',
        ];
        $a_data['device'] = $this->db->get('device', $a_where, '', $a_order);
        $a_data['count']  = $i_total;
        return $a_data;
    }

    /************************************************************************************/

}
