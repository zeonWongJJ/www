<?php

class Cons_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 分类列表 *************************************/

    /**
     * [get_cate_showlist 获取所有分类信息]
     * @return [array] [返回查询到的所有分类信息]
     */
    public function get_cons_showlist()
    {
        $a_order = [
            'id' => 'desc',
        ];
        $a_data  = $this->db->get('consumable', ['cons_id' => 1, 'cons_show' => 1], '', $a_order);
        return $a_data;
    }

    /************************************* 获取一条 *************************************/

    /**
     * [get_cons_one 获取一条分类信息]
     * @param  [int] $id   [要查询的分类id]
     * @return [array]          [返回查询到数据]
     */
    public function get_cons_one($i_id)
    {
        $a_where = [
            'id' => $i_id,
        ];
        $a_data  = $this->db->get_row('consumable', $a_where);
        return $a_data;
    }

    /************************************* 增加分类 *************************************/

    /**
     * [insert_cate 增加分类]
     * @return [type]  $i_result [返回新数据的id]
     */
    public function insert_cate()
    {
        //接收提交的信息
        $a_name    = trim($this->general->post('name'));
        $i_show    = trim($this->general->post('show'));
        $cons_id_1 = trim($this->general->post('cons_id_1'));
        $cons_id_2 = trim($this->general->post('cons_id_2'));
        $i_cons_id = trim($this->general->post('cons_id'));
        if ($i_cons_id === 0) {
            $cons_upid = 0;
            $i_cons_id = 0;
        } else {
            $i_cons_id = explode('-', $i_cons_id);
            $cons_upid = $i_cons_id[0];
            $i_cons_id = $i_cons_id[1] + 1;
        }
        $cons_id_1 = explode('-', $cons_id_1);
        $cons_id_2 = explode('-', $cons_id_2);
        //组装数据并保存到数据
        $a_data   = [
            'cons_name' => $a_name,
            'cons_upid' => $cons_upid,
            'cons_id'   => $i_cons_id,
            'cons_show' => $i_show,
            'cons_id_1' => $cons_id_1['0'],
            'cons_id_2' => $cons_id_2['0'],
        ];
        $i_result = $this->db->insert('consumable', $a_data);
        return $i_result;
    }

    /************************************* 修改分类 *************************************/

    /**
     * [update_cate 修改分类信息]
     * @param  [array] $a_where [修改的条件]
     * @param  [array] $a_data  [修改的数据]
     * @return [int]            [返回修改受影响的行数]
     */
    public function update_cate()
    {
        //接收提交的信息
        $i_id      = $this->general->post('id');
        $a_name    = trim($this->general->post('name'));
        $i_show    = trim($this->general->post('show'));
        $i_cons_id = trim($this->general->post('cons_id'));
        $cons_id_1 = trim($this->general->post('cons_id_1'));
        $cons_id_2 = trim($this->general->post('cons_id_2'));
        if ($i_cons_id === 0) {
            $cons_upid = 0;
            $i_cons_id = 0;
        } else {
            $i_cons_id = explode('-', $i_cons_id);
            $cons_upid = $i_cons_id[0];
            $i_cons_id = $i_cons_id[1] + 1;
        }
        $cons_id_1 = explode('-', $cons_id_1);
        $cons_id_2 = explode('-', $cons_id_2);
        //组装数据并保存到数据
        $a_where  = [
            'id' => $i_id,
        ];
        $a_data   = [
            'cons_name' => $a_name,
            'cons_upid' => $cons_upid,
            'cons_id'   => $i_cons_id,
            'cons_show' => $i_show,
            'cons_id_1' => $cons_id_1['0'],
            'cons_id_2' => $cons_id_2['0'],
        ];
        $i_result = $this->db->update('consumable', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 删除分类 *************************************/
    //获取条数
    public function get_cate_son($id)
    {
        $a_where  = [
            'cons_upid' => $id,
        ];
        $i_result = $this->db->get_total('consumable', $a_where);
        return $i_result;
    }

    /**
     * [delete_cate 删除分类]
     * @param  [int] $cate_id [要删除的分类id]
     * @return [int]          [返回删除的总行数]
     */
    public function delete_one($i_id)
    {
        $i_result = $this->db->delete('consumable', ['id' => $i_id]);
        return $i_result;
    }

    /***************************************** 耗材分类 *****************************************/
    public function category($i_one = false, $s_second = false)
    {
        // 一级
        $a_data['cons'] = $this->db->limit(0, 999999999)->get('consumable', ['cons_id' => 1, 'cons_show' => 1], 'cons_upid,cons_name,id');
        if ($i_one == false) {
            $a_cate = $this->db->get_row('consumable', ['cons_upid' => 0, 'cons_show' => 1], 'id,cons_name,cons_upid');
        } else {
            $a_cate = $this->db->get_row('consumable', ['id' => $i_one, 'cons_show' => 1], 'id,cons_name,cons_upid');
        }
        //本来判断第一级分类然后获取写死第二级分类
        $a_data['second'] = $this->db->limit(0, 999999999)->get('consumable', ['cons_upid' => $a_cate['id'], 'cons_show' => 1], 'id,cons_upid,cons_name');
        //第三级分类
        if ($s_second == false) {
            $a_data['third'] = $this->db->limit(0, 999999999)->get('consumable', ['cons_upid' => $a_data['second'][0]['id'], 'cons_show' => 1], 'cons_upid,cons_name,id');
        } else {
            $a_data['third'] = $this->db->limit(0, 999999999)->get('consumable', ['cons_upid' => $s_second, 'cons_show' => 1], 'cons_upid,cons_name,id');
        }
        return $a_data;
    }

    /************************************************************************************/

}
