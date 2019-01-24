<?php

class Mood_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 所有帖子 *************************************/

    public function get_mood_page($state, $time)
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(3);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($state == 9 && $time == 9) {
            $a_where = [];
        }
        if ($state == 9 && $time != 9) {
            $a_where = [
                'mood_time >' => $time,
            ];
        }
        if ($state != 9 && $time == 9) {
            $a_where = [
                'mood_state' => $state,
            ];
        }
        if ($state != 9 && $time != 9) {
            $a_where = [
                'mood_state'  => $state,
                'mood_time >' => $time,
            ];
        }
        $i_total = $this->db->get_total('mood', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'mood_id,mood_pic,mood_content,mood_time,mood_good,mood_discuss,last_discuss,mood_state,mood_view,relay_mood,mood_relay,mood_type,mood_tags,' . $this->db->get_prefix() . 'user.user_id,user_name,user_pic';
        $a_order         = [
            'mood_id' => 'desc',
        ];
        $a_data['count'] = $i_total;
        $a_data['mood']  = $this->db->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /********************************* 获取一条帖子记录 *********************************/

    /**
     * [get_mood_one 获取一条帖子记录]
     * @param  [int]   $mood_id [传入的心情id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_mood_one($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $a_data  = $this->db->get_row('mood', $a_where);
        return $a_data;
    }

    /************************************* 更新帖子 *************************************/

    /**
     * [update_mood 更新帖子]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_mood($a_where, $a_data)
    {
        $i_result = $this->db->update('mood', $a_data, $a_where);
        return $i_result;
    }

    /************************************* 单个删除 *************************************/

    /**
     * [delete_mood_one 单个删除]
     * @param  [int] $mood_id [传入的要删除的帖子id]
     * @return [int]          [返回删除的行数]
     */
    public function delete_mood_one($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        $i_result = $this->db->delete('mood', $a_where);
        return $i_result;
    }

    /************************************* 批量删除 *************************************/

    /**
     * [delete_mood_mony 批量删除帖子]
     * @param  [array] $a_data     [要删除的帖子的id数组]
     * @return [int]   $i_result   [返回删除的行数]
     */
    public function delete_mood_mony($a_data)
    {
        $i_result = $this->db->where_in('mood_id', $a_data)->delete('mood');
        return $i_result;
    }

    /************************************* 搜索帖子 *************************************/

    public function get_mood_search($keywords)
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
            $this->db->get_prefix() . 'user.user_name LIKE'     => '%' . $keywords . '%',
            $this->db->get_prefix() . 'user.user_phone LIKE'    => '%' . $keywords . '%',
            $this->db->get_prefix() . 'mood.mood_content LIKE'  => '%' . $keywords . '%',
            $this->db->get_prefix() . 'mood.mood_keywords LIKE' => '%' . $keywords . '%',
        ];
        $a_where    = [
            'mood_id >' => 1,
        ];
        $i_total    = $this->db->group_start('AND')->where_or($a_where_or)->group_end()->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get_total('', [], $s_field, $a_order);;
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field         = 'mood_id,mood_pic,mood_content,mood_time,mood_good,mood_discuss,last_discuss,mood_state,mood_view,relay_mood,mood_relay,mood_type,mood_tags,' . $this->db->get_prefix() . 'user.user_id,user_name,user_pic';
        $a_order         = [
            'mood_id' => 'desc',
        ];
        $a_data['count'] = $i_total;
        $a_data['mood']  = $this->db->group_start()->where_or($a_where_or)->group_end()->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get('', [], $s_field, $a_order);
        return $a_data;
    }

    /*********************************** 获取帖子评论 ***********************************/

    public function get_mood_discuss($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
            // ''.$this->db->get_prefix().'discuss.user_id >' => 0,
        ];
        $s_field = 'discuss_id, mood_id, ' . $this->db->get_prefix() . 'discuss.user_id, discuss_content, discuss_time, discuss_pid, discuss_leval, discuss_like, user_name, user_pic';
        $a_order = [
            'discuss_like' => 'desc',
        ];
        $a_data  = $this->db->from('discuss')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'discuss.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /*********************************** 获取一条帖子 ***********************************/

    public function get_mood_row($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $s_field = 'mood_id,mood_pic,mood_content,mood_time,mood_good,mood_discuss,last_discuss,mood_state,mood_view,relay_mood,mood_relay,mood_type,mood_tags,' . $this->db->get_prefix() . 'user.user_id,user_name,user_pic';
        $a_order = [
            'mood_id' => 'desc',
        ];
        $a_data  = $this->db->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get_row('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /*********************************** 删除一条评论 ***********************************/

    public function delete_discuss($discuss_id)
    {
        $a_where  = [
            'discuss_id' => $discuss_id,
        ];
        $i_result = $this->db->delete('discuss', $a_where);
        return $i_result;
    }

    /********************************* 获取动态评论条数 *********************************/

    public function get_discuss_total($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        $i_result = $this->db->get_total('discuss', $a_where);
        return $i_result;
    }

    /********************************* 插入一条动态评论 *********************************/

    public function insert_discuss($a_data)
    {
        $i_result = $this->db->insert('discuss', $a_data);
        return $i_result;
    }

    /***************************** 获取一条评论点赞记录 *****************************/

    /**
     * [get_discusslike_one 获取一条评论点赞记录]
     * @param  [int] $user_id      [传入的会员id]
     * @param  [int] $discuss_id   [传入的评论id]
     * @return [array]             [返回查询到的数据]
     */
    public function get_discusslike_one($user_id, $discuss_id)
    {
        $a_where = [
            'user_id'    => $user_id,
            'discuss_id' => $discuss_id,
        ];
        $a_data  = $this->db->get_row('discusslike', $a_where);
        return $a_data;
    }

    /***************************** 删除一条评论点赞记录 *****************************/

    /**
     * [delete_discusslike 删除一条评论点赞记录]
     * @param  [int] $dlike_id [传入的要删除的记录id]
     * @return [int]           [返回删除的总行数]
     */
    public function delete_discusslike($dlike_id)
    {
        $a_where  = [
            'dlike_id' => $dlike_id,
        ];
        $i_result = $this->db->delete('discusslike', $a_where);
        return $i_result;
    }

    /***************************** 插入一条评论点赞记录 *****************************/

    /**
     * [insert_discusslike 插入一条评论点赞记录]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_discusslike($a_data)
    {
        $i_result = $this->db->insert('discusslike', $a_data);
        return $i_result;
    }

    /***************************** 更新一条评论点赞总数 *****************************/

    /**
     * [update_discuss 更新一条评论点赞总数]
     * @param  [array] $a_where [更新的条件]
     * @param  [array] $a_data  [更新的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_discuss($a_where, $a_data)
    {
        $i_result = $this->db->update('discuss', $a_data, $a_where);
        return $i_result;
    }

    /***************************** 获取一条评论点赞总数 *****************************/

    /**
     * [get_discusslike_total 获取一条评论点赞总数]
     * @param  [int] $discuss_id [传入的评论id]
     * @return [int]             [返回查询到的总条数]
     */
    public function get_discusslike_total($discuss_id)
    {
        $a_where  = [
            'discuss_id' => $discuss_id,
        ];
        $i_result = $this->db->get_total('discusslike', $a_where);
        return $i_result;
    }

    /*********************************** 获取所有标签 ***********************************/

    /**
     * [get_tag_all 获取所有标签]
     * @return [array] [返回查询到的所有标签]
     */
    public function get_tag_all()
    {
        $s_field = 'tag_id, tag_name, tag_time';
        $a_order = [
            'tag_id' => 'asc',
        ];
        $a_data  = $this->db->get('tag', [], $s_field, $a_order, 0, 999999);
        return $a_data;
    }

    /****************************** 通过标签名获取标签总个数 *****************************/

    /**
     * [get_tag_name 通过标签名获取标签总个数]
     * @param  [string] $tag_name [传入的标签名]
     * @return [int]              [返回查询到的总个数]
     */
    public function get_tag_name($tag_name)
    {
        $a_where  = [
            'tag_name' => $tag_name,
        ];
        $i_result = $this->db->get_total('tag', $a_where);
        return $i_result;
    }

    /********************************* 插入一条标签数据 *********************************/

    /**
     * [insert_tag 插入一条标签数据]
     * @param  [array] $a_data [传入的要插入的数据数组]
     * @return [int]           [返回新数据的id]
     */
    public function insert_tag($a_data)
    {
        $i_result = $this->db->insert('tag', $a_data);
        return $i_result;
    }

    /******************************* 通过id数组标签数据 *******************************/

    public function get_tag_ids($tag_ids)
    {
        $s_field = 'tag_id, tag_name, tag_time';
        $a_order = [
            'tag_id' => 'asc',
        ];
        $a_data  = $this->db->where_in('tag_id', $tag_ids)
            ->get('tag', [], $s_field, $a_order, 0, 999999);
        return $a_data;
    }

    /******************************* 根据id删除一个标签 *******************************/

    public function delete_tag($tag_id)
    {
        $a_where  = [
            'tag_id' => $tag_id,
        ];
        $i_result = $this->db->delete('tag', $a_where);
        return $i_result;
    }

    /************************************************************************************/

}
