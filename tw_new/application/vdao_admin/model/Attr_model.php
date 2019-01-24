<?php

class Attr_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /**
     * [get_cate_showlist 获取所有属性分类信息]
     * @return [array] [返回查询到的所有分类信息]
     */
    public function get_pro_showlist()
    {
        $a_data = $this->db->limit(0, 999999999)->get('attributive');
        return $a_data;
    }

    /************************************* 删除分类 *************************************/
    //获取条数
    public function get_cate_son($id)
    {
        $a_where  = [
            'attri_cupid' => $id,
        ];
        $i_result = $this->db->get_total('attributive', $a_where);
        return $i_result;
    }

    /**
     * [delete_cate 删除分类]
     * @param  [int] $cate_id [要删除的分类id]
     * @return [int]          [返回删除的总行数]
     */
    public function delete_one($i_id)
    {
        $i_result = $this->db->delete('attributive', ['attri_id' => $i_id]);
        return $i_result;
    }
}
