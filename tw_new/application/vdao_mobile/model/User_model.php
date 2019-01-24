<?php

class User_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /********************************* 获取一条用户信息 *********************************/

    /**
     * [get_user_one 获取一条用户信息]
     * @param  [int] $user_id   [传入的用户id]
     * @return [array]          [返回查询到的数据]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        return $this->db->get_row('user', $a_where);
    }

    /********************************* 更新一条用户记录 *********************************/

    /**
     * [update_user 更新一条用户记录]
     * @param  [array] $a_where [要更新的条件]
     * @param  [array] $a_data  [要更新的数据]
     * @return [int]            [返回修改的行数]
     */
    public function update_user($a_where, $a_data)
    {
        return $this->db->update('user', $a_data, $a_where);
    }

    /******************************* 插入一条消息记录 ***********************************/

    /**
     * [insert_messagess 插入一条消息]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_messagess($a_data)
    {
        return $this->db->insert('messagess', $a_data);
    }

    /******************************* 获取我推荐的人的订单 *******************************/

    /**
     * [get_order_referee 获取我推荐的人的订单]
     * @param  [type] $order_ids [description]
     * @return [type]            [description]
     */
    public function get_order_referee($order_ids)
    {
        $s_field = $this->db->get_prefix() . 'user.user_id,' . $this->db->get_prefix() . 'user.user_name,' . $this->db->get_prefix() . 'user.user_pic,' . $this->db->get_prefix() . 'order.order_price,' . $this->db->get_prefix() . 'order.order_commission,' . $this->db->get_prefix() . 'order.time_create, ' . $this->db->get_prefix() . 'order.goods_amount';
        $a_order = [
            'order_id' => 'desc',
        ];
        $a_data  = $this->db->where_in('order_id', $order_ids)
            ->from('order')
            ->join('user', [$this->db->get_prefix() . 'order.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', NULL, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /******************************** 获取我的推荐人列表 ********************************/

    /**
     * [get_user_referee 获取我的推荐人列表]
     * @param  [int]   $user_id [传入的推荐人id]
     * @param  [int]   $i_page  [传入的页码数]
     * @return [array]          [返回查询到的数据]
     */
    public function get_user_referee($user_id, $i_page)
    {
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            'user_referee' => $user_id,
        ];
        $i_total = $this->db->get_total('user', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'user_id, user_name, user_pic, user_regtime';
        $a_order = [
            'user_id' => 'desc',
        ];

        //总页数
        $page_total = ceil($i_total / $i_prow);
        //判断是否超过总页数
        if ($i_page > $page_total) {
            return ['code' => 400, 'msg' => '没有更多数据了'];
        }
        return $this->db->get('user', $a_where, $s_field, $a_order);
    }

    /******************************** 搜索我的推荐人信息 ********************************/

    /**
     * [get_referee_search 搜索我的推荐人信息]
     * @param  [type] $keywords [description]
     * @return [type]           [description]
     */
    public function get_referee_search($keywords)
    {
        $a_where = [
            'user_name LIKE' => '%' . $keywords . '%',
            'user_referee'   => $_SESSION['user_id'],
        ];
        $s_field = 'user_id, user_name, user_pic, user_regtime';
        $a_order = [
            'user_id' => 'desc',
        ];
        return $this->db->get('user', $a_where, $s_field, $a_order, 0, 999999);
    }

    /******************************** 获取用户发表的动态 ********************************/

    public function get_user_mood($user_id, $page)
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
        $a_where = [
            'user_id' => $user_id,
        ];
        $i_total = $this->db->get_total('mood', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = '';
        $a_order = [
            'mood_id' => 'desc',
        ];
        $a_data  = $this->db->get('mood', $a_where, $s_field, $a_order);
        // 计算总页数
        if ($i_page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /****************************** 获取一条动态的点赞信息 ******************************/

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
            'mood_id'        => $mood_id,
            'discuss_pid !=' => 0,
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

    /***************************** 根据id获取动态消息列表 *******************************/

    public function get_user_moodmsg($user_id, $page)
    {
        // 先设置默认从第一页开始
        $i_page = $page;
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 20;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_where = [
            $this->db->get_prefix() . 'moodmsg.user_id' => $user_id,
        ];
        $i_total = $this->db->get_total('moodmsg', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'msg_id,' . $this->db->get_prefix() . 'moodmsg.user_id, send_uid, msg_content, msg_type, msg_time, user_pic, user_name, ' . $this->db->get_prefix() . 'moodmsg.mood_id, mood_pic';
        $a_order = [
            'msg_id' => 'desc',
        ];
        $a_data  = $this->db->from('moodmsg')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'moodmsg.send_uid'])
            ->join('mood', [$this->db->get_prefix() . 'mood.mood_id' => $this->db->get_prefix() . 'moodmsg.mood_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 验证是否超过最大页码
        if ($page > ceil($i_total / $i_prow)) {
            return [];
        } else {
            return $a_data;
        }
    }

    /***************************** 根据id获取一条动态信息 *******************************/

    /**
     * [get_mood_one 根据id获取一条动态信息]
     * @param  [type] $mood_id [description]
     * @return [type]          [description]
     */
    public function get_mood_one($mood_id)
    {
        $a_where = [
            'mood_id' => $mood_id,
        ];
        $a_data  = $this->db->get_row('mood', $a_where);
        return $a_data;
    }

    /********************************** 新消息条数 ************************************/

    /**
     * [get_newmsg_count 新消息条数]
     * @return [type] [description]
     */
    public function get_newmsg_count($user_id)
    {
        $a_where  = [
            'user_id'  => $user_id,
            'msg_view' => 1,
        ];
        $i_result = $this->db->get_total('moodmsg', $a_where);
        return $i_result;
    }

    /********************************** 修改动态消息 ************************************/

    /**
     * [update_moodmsg 清空动态消息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_moodmsg($a_where, $a_data)
    {
        $i_result = $this->db->update('moodmsg', $a_data, $a_where);
        return $i_result;
    }

    /********************************** 清空动态消息 ************************************/

    /**
     * [moodmsg_clear 清空动态消息]
     * @param  [int] $user_id [要清空的用户id]
     * @return [int]          [返回删除的行数]
     */
    public function delete_moodmsg($user_id)
    {
        $a_where  = [
            'user_id' => $user_id,
        ];
        $i_result = $this->db->delete('moodmsg', $a_where);
        return $i_result;
    }

    /******************************** 插入一条意见与反馈 ********************************/

    /**
     * [insert_feedback 插入一条意见与反馈]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_feedback($a_data)
    {
        $i_result = $this->db->insert('feedback', $a_data);
        return $i_result;
    }

    /******************************** 获取一条统计数据 ********************************/

    /**
     * [get_statistic_one 获取一条统计数据]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_statistic_one($user_id, $beginThismonth)
    {
        $a_where = [
            'user_id'  => $user_id,
            'sta_time' => $beginThismonth,
        ];
        return $this->db->get_row('statistic', $a_where);
    }

    /******************************** 插入一条统计数据 *******************************/

    /**
     * [insert_statistic 插入一条统计数据]
     * @param  [type] $a_data [description]
     * @return [type]         [description]
     */
    public function insert_statistic($a_data)
    {
        return $this->db->insert('statistic', $a_data);
    }

    /******************************* 获取我的推荐人列表 ******************************/

    /**
     * [get_myreferees 获取我的推荐人列表]
     * @return [type] [description]
     */
    public function get_myreferees($user_id)
    {
        $a_where = [
            'user_referee' => $user_id,
        ];
        $s_field = 'user_id, user_name, user_pic, user_regtime';
        $a_order = [
            'user_regtime' => 'desc',
        ];
        return $this->db->get('user', $a_where, $s_field, $a_order, 0, 99999999);
    }

    /******************************* 获取一条评论信息 ******************************/

    /**
     * [get_comment_one 获取一条评论信息]
     * @param  [type] $comment_id [description]
     * @return [type]             [description]
     */
    public function get_comment_one($comment_id)
    {
        $a_where = [
            'comment_id' => $comment_id,
        ];
        return $this->db->get_row('comment', $a_where);
    }

    /******************************* 修改一条评论信息 ******************************/

    /**
     * [update_comment 修改一条评论信息]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_comment($a_where, $a_data)
    {
        return $this->db->update('comment', $a_data, $a_where);
    }

    /******************************* 获取我的评论列表 ******************************/

    /**
     * [get_user_comment 获取我的评论列表]
     * @param  [type] $user_id [description]
     * @param  [type] $page    [description]
     * @return [type]          [description]
     */
    public function get_user_comment($user_id, $page)
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
        $a_where = [
            'user_id' => $user_id,
        ];
        $i_total = $this->db->get_total('comment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field = 'comment_id, comment_content, comment_cate, comment_tags, comment_time, ' . $this->db->get_prefix() . 'comment.store_id, store_name, store_touxiang, store_introduction, is_anonymous, comment_pic';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->from('comment')
            ->join('store', [$this->db->get_prefix() . 'comment.store_id' => $this->db->get_prefix() . 'store.store_id'])
            ->get('', $a_where, $s_field, $a_order);
        // 判断是否超出最大页码
        if ($i_page > ceil($i_total / $i_prow)) {
            return [];
        }

        return $a_data;
    }

    /*************************************** 删除一条动态 ******************************/

    /**
     * [delete_mood description]
     * @param  [type] $mood_id [description]
     * @return [type]          [description]
     */
    public function delete_mood($mood_id)
    {
        $a_where  = [
            'mood_id' => $mood_id,
        ];
        return $this->db->delete('mood', $a_where);
    }

    /************************************* 获取一条标签 ********************************/

    /**
     * [get_tag_one 获取一条标签]
     * @param  [type] $store_id    [description]
     * @param  [type] $comtag_name [description]
     * @param  [type] $comtag_type [description]
     * @return [type]              [description]
     */
    public function get_tag_one($store_id, $comtag_name, $comtag_type)
    {
        $a_where = [
            'store_id'    => $store_id,
            'comtag_name' => $comtag_name,
            'comtag_type' => $comtag_type,
        ];
        return $this->db->get_row('comtag', $a_where);
    }

    /************************************* 更新一条标签 ********************************/

    /**
     * [update_comtag description]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_comtag($a_where, $a_data)
    {
        return $this->db->update('comtag', $a_data, $a_where);
    }

    /************************************* 删除一条标签 ********************************/

    /**
     * [delete_comment 删除一条标签]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete_comment($comment_id)
    {
        $a_where  = [
            'comment_id' => $comment_id,
        ];
        return $this->db->delete('comment', $a_where);
    }

    /************************* 根据手机号码获取一条用户总数 **************************/

    /**
     * [get_user_byphone 根据手机号码获取一条用户总数]
     * @param  [type] $user_phone [description]
     * @return [type]             [description]
     */
    public function get_user_byphone($user_phone)
    {
        $a_where = [
            'user_phone' => $user_phone,
        ];
        return $this->db->get_row('user', $a_where);
    }

    /*********************************************************************************/
}
