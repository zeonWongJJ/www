<?php

class Pro_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /**
     * [get_cate_showlist 获取所有产品分类信息]
     * @return [array] [返回查询到的所有分类信息]
     */
    public function get_pro_showlist()
    {
        $a_data = $this->db->limit(0, 999999999)->get('pro');
        return $a_data;
    }

    /**
     * [get_cate_showlist 获取所有耗材信息]
     * @return [array] [返回查询到的所有分类信息]
     */
    public function get_cons_showlist()
    {
        $cate = $this->db->limit(0, 999999999)->get('consumable', ['cons_show' => 2]);
        foreach ($cate as $key => $value) {
            $hidden_arr[] = $value['id'];
        }
        $a_order = [
            'consumption_id' => 'asc',
        ];
        $con_arr = $this->db->limit(0, 999999999)->get('consumption', '', '', $a_order);
        if (!empty($hidden_arr)) {
            foreach ($con_arr as $key => $value) {
                if ($value['consu_id_3'] != null && in_array($value['consu_id_3'], $hidden_arr)) {
                    unset($con_arr[$key]);
                }
                if ($value['consu_id_2'] != null && in_array($value['consu_id_2'], $hidden_arr)) {
                    unset($con_arr[$key]);
                }
                if ($value['consu_id_1'] != null && in_array($value['consu_id_1'], $hidden_arr)) {
                    unset($con_arr[$key]);
                }
            }
        }
        return $con_arr;
    }

    /**
     * [get_cate_showlist 获取所有杯型信息]
     * @return [array] [返回查询到的所有分类信息]
     */
    public function get_cup_showlist()
    {
        $a_order = [
            'cup_id' => 'asc',
        ];
        $a_data  = $this->db->limit(0, 999999999)->get('cup', [], '', $a_order);
        return $a_data;
    }

    /************************************* 删除分类 *************************************/
    //获取条数
    public function get_cate_son($id)
    {
        $a_where  = [
            'pro_pid' => $id,
        ];
        $i_result = $this->db->get_total('pro', $a_where);
        return $i_result;
    }

    /**
     * [delete_cate 删除分类]
     * @param  [int] $cate_id [要删除的分类id]
     * @return [int]          [返回删除的总行数]
     */
    public function delete_one($i_id)
    {
        $i_result = $this->db->delete('pro', ['pro_id' => $i_id]);
        return $i_result;
    }

    /***************************************** 产品分类 *****************************************/
    public function category($i_one = false, $i_two = false)
    {
        // 一级
        $a_data['prot'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => 0, 'is_show' => 1], 'pro_pid,pro_name,pro_id');
        if ($i_one == false) {
            $a_cate = $this->db->get_row('pro', ['pro_pid' => 0, 'is_show' => 1], 'pro_id,pro_name,pro_pid');
            //如果第二个参数没有值，默认将二级分类选择第一个值
            // $i_two = $a_cate['pro_id'];
        } else {
            $a_cate = $this->db->get_row('pro', ['pro_id' => $i_one, 'is_show' => 1], 'pro_id,pro_name,pro_pid');
            // $i_two = $a_cate['pro_id'];
        }
        //本来判断第一级分类然后获取写死第二级分类
        $a_data['second'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $a_cate['pro_id'], 'is_show' => 1], 'pro_id,pro_pid,pro_name');
        //第三级分类
        if ($i_two == false) {
            $a_data['third'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $a_data['second'][0]['pro_id'], 'is_show' => 1], 'pro_pid,pro_name,pro_id');
        } else {
            $a_data['third'] = $this->db->limit(0, 999999999)->get('pro', ['pro_pid' => $i_two, 'is_show' => 1], 'pro_pid,pro_name,pro_id');
        }
        return $a_data;
    }
}
