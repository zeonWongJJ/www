<?php

class Comment_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************** 一条门店 **************************************/

    /**
     * [get_store_one 获取一条门店信息]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_store_one($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $a_data  = $this->db->get_row('store', $a_where);
        return $a_data;
    }

    /************************************** 所有评论 **************************************/

    /**
     * [get_comment_all 获取所有评论]
     * @param  [type] $store_id [description]
     * @return [type]           [description]
     */
    public function get_comment_all($store_id)
    {
        $a_where = [
            'store_id' => $store_id,
        ];
        $s_field = '';
        $a_order = [
            'comment_id' => 'desc',
        ];
        $a_data  = $this->db->get('comment', $a_where, $s_field, $a_order, 0, 9999999999);
        return $a_data;
    }

    /************************************** 插入标签 **************************************/

    /**
     * [insert_comtag 插入标签]
     * @param  [array] $a_data [要插入的数据]
     * @return [int]           [返回新数据的id]
     */
    public function insert_comtag($a_data)
    {
        $i_result = $this->db->insert('comtag', $a_data);
        return $i_result;
    }

    /************************************** 删除标签 **************************************/

    /**
     * [delete_comtag 删除标签]
     * @param  [type] $comtag_id [description]
     * @return [type]            [description]
     */
    public function delete_comtag($comtag_id)
    {
        $a_where  = [
            'comtag_id' => $comtag_id,
        ];
        $i_result = $this->db->delete('comtag', $a_where);
        return $i_result;
    }

    /************************************** 所有标签 **************************************/

    /**
     * [get_comtag_all 获取所有标签]
     * @return [array] [返回查询到的所有标签 数组]
     */
    public function get_comtag_all()
    {
        $a_where = [
            'store_id' => $_SESSION['store_id'],
        ];
        $a_order = [
            'comtag_id' => 'desc',
        ];
        $a_data  = $this->db->get('comtag', $a_where, '', $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************** 房间评论 **************************************/

    public function get_comment_room($comment_cate, $comment_empty)
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
        if ($comment_cate == 9 && $comment_empty == 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type' => 1,
                $this->db->get_prefix() . 'comment.store_id'     => $_SESSION['store_id'],
            ];
        } else if ($comment_cate != 9 && $comment_empty != 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type'  => 1,
                $this->db->get_prefix() . 'comment.store_id'      => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_cate'  => $comment_cate,
                $this->db->get_prefix() . 'comment.comment_empty' => $comment_empty,
            ];
        } else if ($comment_cate == 9 && $comment_empty != 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type'  => 1,
                $this->db->get_prefix() . 'comment.store_id'      => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_empty' => $comment_empty,
            ];
        } else if ($comment_cate != 9 && $comment_empty == 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type' => 1,
                $this->db->get_prefix() . 'comment.store_id'     => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_cate' => $comment_cate,
            ];
        }
        $i_total = $this->db->get_total('comment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $s_field           = 'comment_id,' . $this->db->get_prefix() . 'comment.user_id, object_id, ' . $this->db->get_prefix() . 'comment.store_id, goods_score, service_score, comment_content, comment_pic, is_anonymous, comment_time, comment_type, ' . $this->db->get_prefix() . 'comment.order_number, comment_state, comment_tags, comment_cate, room_name, office_seatname, ' . $this->db->get_prefix() . 'user.user_name';
        $a_order           = [
            'comment_id' => 'desc',
        ];
        $a_data['comment'] = $this->db->from('comment')
            ->join('appointment', [$this->db->get_prefix() . 'appointment.appointment_id' => $this->db->get_prefix() . 'comment.object_id'])
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, $s_field, $a_order);
        $a_data['count']   = $i_total;
        return $a_data;
    }

    /************************************** 删除评论 **************************************/

    /**
     * [delete_comment 删除评论]
     * @param  [type] $comment_id [description]
     * @return [type]             [description]
     */
    public function delete_comment($comment_id)
    {
        $a_where  = [
            'comment_id' => $comment_id,
        ];
        $i_result = $this->db->delete('comment', $a_where);
        return $i_result;
    }

    /************************************** 修改评论 **************************************/

    /**
     * [update_comment 修改评论]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_comment($a_where, $a_data)
    {
        $i_result = $this->db->update('comment', $a_data, $a_where);
        return $i_result;
    }


    /************************************** 产品评论 **************************************/

    public function coffee_room($comment_cate, $comment_empty)
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
        if ($comment_cate == 9 && $comment_empty == 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type' => 2,
                $this->db->get_prefix() . 'comment.store_id'     => $_SESSION['store_id'],
            ];
        } else if ($comment_cate != 9 && $comment_empty != 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type'  => 2,
                $this->db->get_prefix() . 'comment.store_id'      => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_cate'  => $comment_cate,
                $this->db->get_prefix() . 'comment.comment_empty' => $comment_empty,
            ];
        } else if ($comment_cate == 9 && $comment_empty != 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type'  => 2,
                $this->db->get_prefix() . 'comment.store_id'      => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_empty' => $comment_empty,
            ];
        } else if ($comment_cate != 9 && $comment_empty == 9) {
            $a_where = [
                $this->db->get_prefix() . 'comment.comment_type' => 2,
                $this->db->get_prefix() . 'comment.store_id'     => $_SESSION['store_id'],
                $this->db->get_prefix() . 'comment.comment_cate' => $comment_cate,
            ];
        }
        $i_total = $this->db->get_total('comment', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        // $s_field = 'comment_id,'.$this->db->get_prefix().'comment.user_id, object_id, '.$this->db->get_prefix().'comment.store_id, goods_score, service_score, comment_content, comment_pic, is_anonymous, comment_time, comment_type, '.$this->db->get_prefix().'comment.order_number, comment_state, comment_tags, comment_cate, room_name, office_seatname, '.$this->db->get_prefix().'user.user_name';
        $a_order           = [
            'comment_id' => 'desc',
        ];
        $a_data['comment'] = $this->db->from('comment')
            ->join('product', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'comment.object_id'])
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $a_where, '', $a_order);
        $a_data['count']   = $i_total;
        return $a_data;
    }

    /************************************** 一条评论 **************************************/

    /**
     * [get_comment_one 获取一条评论]
     * @param  [type] $comment_id [description]
     * @return [type]             [description]
     */
    public function get_comment_one($comment_id)
    {
        $a_where = [
            'comment_id' => $comment_id,
        ];
        $a_data  = $this->db->get_row('comment', $a_where);
        return $a_data;
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
        $a_data  = $this->db->get_row('comtag', $a_where);
        return $a_data;
    }

    /**************************************** 更新一条标签 ********************************/

    /**
     * [update_comtag 更新一条标签]
     * @param  [type] $a_where [description]
     * @param  [type] $a_data  [description]
     * @return [type]          [description]
     */
    public function update_comtag($a_where, $a_data)
    {
        $i_result = $this->db->update('comtag', $a_data, $a_where);
        return $i_result;
    }

    /**************************************************************************************/

}
