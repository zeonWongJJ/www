<?php

class Assets_ctrl extends \utils\BaseController
{
    /**
     * 获取积分列表
     * @router http://server.name/assets.jifen.get.list
     */
    public function jifenGetList()
    {
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $rows = $this->db->limit($offset, $limit)->select('user_name,user_id,user_score,user_balance')->get('user');

        return $this->success(filter($rows));
    }
}
