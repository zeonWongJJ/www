<?php

class Mood_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /****************************** 获取一条总设置信息 *******************************/

    /**
     * [get_set_one 获取一条总设置信息]
     * @param  [type] $set_name [description]
     * @return [type]           [description]
     */
    public function get_set_one($set_name)
    {
        $a_where = [
            'set_name' => $set_name,
        ];
        $a_data  = $this->db->get_row('set', $a_where);
        return $a_data;
    }

    /*********************************** 发表动态 ***********************************/

    /**
     * [insert_mood 插入一条动态信息]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_mood($a_data)
    {
        $i_result = $this->db->insert('mood', $a_data);
        return $i_result;
    }

    /***************************** 获取所有人可见的动态 *****************************/

    /**
     * [get_mood_all 获取所有人可见的动态]
     * @return [type] [description]
     */
    public function get_mood_page($keywords, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        if ($keywords == 'all') {
            $a_where = [
                'mood_state' => 1,
                'mood_view'  => 1,
            ];
        } else {
            $a_where = [
                'mood_state'         => 1,
                'mood_view'          => 1,
                'mood_keywords LIKE' => '%' . $keywords . '%',
            ];
        }
        $i_total = $this->db->get_total('mood', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'mood_id,mood_pic,mood_content,mood_time,mood_good,mood_discuss,last_discuss,mood_state,mood_view,relay_mood,mood_relay,mood_type,relay_mood,mood_keywords,mood_tags,' . $this->db->get_prefix() . 'user.user_id,user_name,user_pic';
        $a_order = [
            'mood_id' => 'desc',
        ];
        $a_data  = $this->db->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 判断是否超出最大页码
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /******************************* 获取一条用户信息 *******************************/

    /**
     * [gte_user_one 获取一条用户信息]
     * @param  [int] $user_id   [传入的用户信息]
     * @return [array]          [返回查询到的信息]
     */
    public function gte_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /******************************* 获取一条动态点赞信息 ***************************/

    /**
     * [get_like_one 获取一条动态点赞信息]
     * @param  [int] $user_id   [传入的会员id]
     * @param  [int] $mood_id   [传入的动态id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_like_one($user_id, $mood_id)
    {
        $a_where = [
            'user_id' => $user_id,
            'mood_id' => $mood_id,
        ];
        $a_data  = $this->db->get_row('moodlike', $a_where);
        return $a_data;
    }

    /******************************* 插入一条动态点赞信息 ***************************/

    /**
     * [insert_moodlike 插入一条动态点赞信息]
     * @param  [array] $a_data [传入的要插入的信息]
     * @return [int]           [返回新数据的id]
     */
    public function insert_moodlike($a_data)
    {
        $i_result = $this->db->insert('moodlike', $a_data);
        return $i_result;
    }

    /***************************** 删除一条动态点赞信息 *****************************/

    /**
     * [delete_moodlike 删除一条动态点赞信息]
     * @param  [int] $like_id [要删除的记录id]
     * @return [int]          [返回删除的行数]
     */
    public function delete_moodlike($like_id)
    {
        $a_where  = [
            'like_id' => $like_id,
        ];
        $i_result = $this->db->delete('moodlike', $a_where);
        return $i_result;
    }

    /***************************** 获取一条动态点赞总数 *****************************/

    /**
     * [get_like_total 获取一条动态点赞总数]
     * @param  [int] $mood_id [传入的动态id]
     * @return [int]          [返回查询到的总数]
     */
    public function get_like_total($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        $i_result = $this->db->get_total('moodlike', $a_where);
        return $i_result;
    }

    /******************************* 修改一条动态记录 *******************************/

    /**
     * [update_mood 修改一条动态记录]
     * @param  [array] $a_where [要修改的条件]
     * @param  [array] $a_data  [要修改的数据]
     * @return [int]            [返回受影响的行数]
     */
    public function update_mood($a_where, $a_data)
    {
        $i_result = $this->db->update('mood', $a_data, $a_where);
        return $i_result;
    }

    /*************************** 根据id获取一条动态信息 *****************************/

    /**
     * [get_mood_one 根据id获取一条动态信息]
     * @param  [int] $mood_id [传入的用户id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_mood_one($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $s_field = 'mood_id,mood_pic,mood_content,mood_time,mood_good,mood_discuss,last_discuss,mood_state,mood_view,relay_mood,mood_relay,mood_type,' . $this->db->get_prefix() . 'user.user_id,' . $this->db->get_prefix() . 'user.user_name,user_pic';
        $a_order = [
            'mood_id' => 'desc',
        ];
        $a_data  = $this->db->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get_row('', $a_where, $s_field, $a_order);
        return $a_data;
    }

    /****************************** 插入一格评论信息 ********************************/

    /**
     * [insert_discuss 插入一格评论信息]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_discuss($a_data)
    {
        $i_result = $this->db->insert('discuss', $a_data);
        return $i_result;
    }

    /************************ 根据id获取一条动态的评论总数 **************************/

    /**
     * [get_discuss_total 获取一条动态的评论总数]
     * @param  [int] $mood_id [传入的动态id]
     * @return [int]          [返回查询到的评论总数]
     */
    public function get_discuss_total($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        $i_result = $this->db->get_total('discuss', $a_where);
        return $i_result;
    }

    /*************************** 插入一条记录到动态转发表 ***************************/

    /**
     * [insert_moodrelay 插入一条记录到动态转发表]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_moodrelay($a_data)
    {
        $i_result = $this->db->insert('moodrelay', $a_data);
        return $i_result;
    }

    /***************************** 获取一条动态的转发量 *****************************/

    /**
     * [get_relay_total 获取一条动态的转发量]
     * @param  [int] $mood_id [传入的动态id]
     * @return [int]          [返回查询的总条数]
     */
    public function get_relay_total($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        $i_result = $this->db->get_total('moodrelay', $a_where);
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

    /***************************** 插入一条动态消息通知 *****************************/

    /**
     * [insert_moodmsg 插入一条动态消息通知]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的行数]
     */
    public function insert_moodmsg($a_data)
    {
        $i_result = $this->db->insert('moodmsg', $a_data);
        return $i_result;
    }

    /***************************** 获取一条动态评论信息 *****************************/

    /**
     * [get_discuss_one 获取一条动态评论信息]
     * @param  [int]   $discuss_id [传入的评论id]
     * @return [array]             [返回查询到的信息]
     */
    public function get_discuss_one($discuss_id)
    {
        $a_where = [
            'discuss_id' => $discuss_id,
        ];
        $a_data  = $this->db->get_row('discuss', $a_where);
        return $a_data;
    }

    /******************************** 获取动态的标签 ********************************/

    /**
     * [function_name 获取动态的标签]
     * @return [type] [description]
     */
    public function get_tag_all()
    {
        $a_order = [
            'tag_id' => 'desc',
        ];
        $a_data  = $this->db->get('tag', [], '', [], 0, 999999);
        return $a_data;
    }

    /******************************* 获取一条动态标签 *******************************/

    /**
     * [get_tag_one 获取一条动态标签]
     * @return [type] [description]
     */
    public function get_tag_one($tag_id)
    {
        $a_where = [
            'tag_id' => $tag_id,
        ];
        $a_data  = $this->db->get_row('tag', $a_where);
        return $a_data;
    }

    /****************************** 获取一条动态的点赞信息 ******************************/

    /**
     * [get_mood_like 获取一条动态的点赞信息]
     * @param  [type] $mood_id [description]
     * @return [type]          [description]
     */
    public function get_mood_like($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $s_field = 'user_name,like_id,' . $this->db->get_prefix() . 'user.user_id,user_pic,mood_id,like_time';
        $a_order = [
            'like_id' => 'desc',
        ];
        $a_data  = $this->db->from('moodlike')
            ->join('user', [$this->db->get_prefix() . 'moodlike.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /****************************** 获取一条动态的转发信息 ******************************/

    /**
     * [get_mood_relay 获取一条动态的转发信息]
     * @param  [type] $mood_id [description]
     * @return [type]          [description]
     */
    public function get_mood_relay($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $s_field = 'relay_id, mood_id, relay_time, ' . $this->db->get_prefix() . 'user.user_id, user_pic, user_name';
        $a_order = [
            'relay_id' => 'desc',
        ];
        $a_data  = $this->db->from('moodrelay')
            ->join('user', [$this->db->get_prefix() . 'moodrelay.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /****************************** 获取某个用户的动态评论 ******************************/

    public function get_discuss_parent($mood_id)
    {
        $a_where = [
            'mood_id'     => $mood_id,
            'discuss_pid' => 0,
        ];
        $s_field = 'discuss_id, mood_id, ' . $this->db->get_prefix() . 'discuss.user_id, discuss_content, discuss_time, discuss_pid, discuss_leval, discuss_like, user_name, user_pic';
        $a_order = [
            'discuss_like' => 'desc',
        ];
        $a_data  = $this->db->from('discuss')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'discuss.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /************************ 根据id获取一条动态的子级评论 **************************/

    /**
     * [get_discuss_son 根据id获取一条动态的子级评论]
     * @param  [int]   $mood_id [传入的动态id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_discuss_son($mood_id)
    {
        $a_where = [
            'mood_id'       => $mood_id,
            'discuss_pid >' => 0,
        ];
        $s_field = 'discuss_id, mood_id, ' . $this->db->get_prefix() . 'discuss.user_id, discuss_content, discuss_time, discuss_pid, discuss_leval, discuss_like,user_name,user_pic';
        $a_order = [
            'discuss_like' => 'desc',
        ];
        $a_data  = $this->db->from('discuss')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'discuss.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /********************************************************************************/

}