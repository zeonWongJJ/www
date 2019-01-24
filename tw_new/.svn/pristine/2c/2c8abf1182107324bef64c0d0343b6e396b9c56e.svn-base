<?php

class Home_model extends TW_Model
{

    public function __construct()
    {
        parent:: __construct();
    }

    /************************************* 获取一条用户信息 *************************************/

    /**
     * [get_user_one 获取一条用户信息]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_user_one($user_id)
    {
        $a_where = [
            'user_id' => $user_id,
        ];
        $a_data  = $this->db->get_row('user', $a_where);
        return $a_data;
    }

    /************************************ 获取用户动态总条数 ************************************/

    /**
     * [get_mood_count 获取用户动态总条数]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_mood_count($user_id)
    {
        $a_where  = [
            'user_id' => $user_id,
        ];
        $i_result = $this->db->get_total('mood', $a_where);
        return $i_result;
    }

    /************************************** 获取热门关键词 *************************************/

    /**
     * [get_search_hot 获取热门关键词]
     * @return [type] [description]
     */
    public function get_search_hot()
    {
        $a_order = [
            'search_count' => 'desc',
        ];
        $a_data  = $this->db->get('search', [], '', $a_order, 0, 5);
        return $a_data;
    }

    /************************************ 获取分享者昨日的订单 ***********************************/

    /**
     * [get_order_yestoday description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_order_yestoday($user_id)
    {
        $start          = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $beginYesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
        $a_where        = [
            'share_userid'    => $user_id,
            'time_finnshed >' => $beginYesterday,
            'time_finnshed <' => $start,
        ];
        $s_field        = '';
        $a_order        = [
            'order_id' => 'desc',
        ];
        $a_data         = $this->db->where_in('order_state', [10, 80])
            ->get('order', $a_where, $s_field, $a_order, 0, 99999999);
        return $a_data;
    }

    /************************************** 获取两条热门动态 ************************************/

    /**
     * [get_mood_two 获取两条热门动态]
     * @return [type] [description]
     */
    public function get_mood_two()
    {
        $a_where = [
            'mood_state' => 1,
        ];
        $s_field = '';
        $a_order = [
            'mood_good' => 'desc',
        ];
        $a_data  = $this->db->from('mood')
            ->join('user', [$this->db->get_prefix() . 'user.user_id' => $this->db->get_prefix() . 'mood.user_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 2);
        return $a_data;
    }

    /************************************** 获取一条公告信息 ************************************/

    /**
     * [get_notice_one 获取一条公告信息]
     * @return [type] [description]
     */
    public function get_notice_one()
    {
        $a_where = [
            'notice_state' => 1,
        ];
        $s_order = "notice_id desc,notice_time desc";
        $a_data  = $this->db->get_row('notice', $a_where, '', $s_order);
        return $a_data;
    }

    /************************************ 获取用户的未读通知数 **********************************/

    /**
     * [get_mood_msgcount 获取用户的未读通知数]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_mood_msgcount($user_id)
    {
        $a_where  = [
            'user_id'  => $user_id,
            'msg_view' => 1,
        ];
        $i_result = $this->db->get_total('moodmsg', $a_where);
        return $i_result;
    }

    /************************************** 获取产品时间段 ************************************/

    /**
     * [get_time_all description]
     * @return [type] [description]
     */
    public function get_time_all()
    {
        $a_where = [];
        $s_field = '';
        $a_order = [
            'time_id' => 'asc',
        ];
        $a_data  = $this->db->get('time', $a_where, $s_field, $a_order, 0, 999999999);
        return $a_data;
    }

    /************************************** 获取五条产品信息 ************************************/

    /**
     * [get_product_five 获取五条产品信息]
     * @param  [type] $time_id [description]
     * @return [type]          [description]
     */
    public function get_product_five()
    {

        $a_where = [
            $this->db->get_prefix() . 'product.goods_stye' => 1,
            $this->db->get_prefix() . 'product.pro_show'   => 1,
            // 'product_id in' => $a_piddata,
        ];
        $s_field = $this->db->get_prefix() . 'product.product_id,proid_id_1, proid_id_2, proid_id_3, antistop, product_name, order, pro_details, pro_image, pro_img, goods_stye, pro_show, supply_time, sale_id, number';
        $a_order = [
            $this->db->get_prefix() . 'product_number.number' => 'desc',
        ];
        $a_data  = $this->db->from('product')
            ->join('product_number', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'product_number.product_id'])
            ->where($this->db->get_prefix() . 'product.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->get('', $a_where, $s_field, $a_order, 0, 9999999999);
        // echo $this->db->get_sql();
        return $a_data;
    }

    //返回热门推荐产品

    public function get_product_return($num = 0)
    {

        $a_where = [
            $this->db->get_prefix() . 'product.goods_stye' => 1,
            $this->db->get_prefix() . 'product.pro_show'   => 1,
            // 'product_id in' => $a_piddata,
        ];
        $s_field = $this->db->get_prefix() . 'product.product_id,proid_id_1, proid_id_2, proid_id_3, antistop, product_name, order, pro_details, pro_image, pro_img, goods_stye, pro_show, supply_time, sale_id, number';
        $a_order = [
            $this->db->get_prefix() . 'product_number.number' => 'desc',
        ];
        $a_data  = $this->db->from('product')
            ->join('product_number', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'product_number.product_id'])
            ->where($this->db->get_prefix() . 'product.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->get('', $a_where, $s_field, $a_order, 0, $num);
        // echo $this->db->get_sql();
        return $a_data;
    }

    //返回搜索产品
    public function search_product_return($search = "")
    {
        if ($search == "") {
            return false;
        }
        $a_where = [
            $this->db->get_prefix() . 'product.goods_stye' => 1,
            $this->db->get_prefix() . 'product.pro_show'   => 1,
            // $this->db->get_prefix().'product.product_name like'=>'%'.$search.'%',
            // $this->db->get_prefix().'product.antistop like'=>'%'.$search.'%',
            // 'product_id in' => $a_piddata,
        ];

        $s_field = $this->db->get_prefix() . 'product.product_id,proid_id_1, proid_id_2, proid_id_3, antistop, product_name, order, pro_details, pro_image, pro_img, goods_stye, pro_show, supply_time, sale_id, number,' . $this->db->get_prefix() . 'comment_product.pingl';
        $a_order = [
            $this->db->get_prefix() . 'product_number.number' => 'desc',
        ];
        $a_data  = $this->db->from('product')
            ->where("'.$this->db->get_prefix().'product.product_id in (select product_id from '.$this->db->get_prefix().'prod_sto where prod_show =1) and '.$this->db->get_prefix().'product.product_name like '%{$search}%' or '.$this->db->get_prefix().'product.antistop like '%{$search}%'", null, false)
            ->join('comment_product ', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'comment_product.product_id'])
            ->join('product_number', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'product_number.product_id'])
            ->get('', $a_where, $s_field, $a_order, 0, 99999999);
        // return $this->db->get_sql();
        //查询相对的时间
        $a_time_name = $this->db->get('time');
        foreach ($a_time_name as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $adata['time'][] = $time['time_id'];
            }
        }

        //处理产品数据
        if ($a_data) {
            foreach ($a_data as $key => $value) {
                $supply_time_arr = explode(',', trim($value['supply_time']));
                if (empty($adata['time'])) {
                    $value['in_sale'] = 2;
                } else {
                    if (array_intersect($adata['time'], $supply_time_arr)) {
                        //in_sale =1 在售产品
                        $value['in_sale'] = 1;
                    } else {
                        $value['in_sale'] = 2;
                    }
                }

                $value['prod_price'] = $this->db->get_row('price', ['price >' => 0, 'product_id' => $value['product_id']], 'price', ['price' => 'asc']);

                //价格
                $prod[$key] = $value;
            }
        }

        return $prod;
    }

    /************************************** 获取某分类的产品信息 ************************************/

    /**
     * [get_cate_product 获取某分类的产品信息]
     * @param int $cate
     * @return  array
     */
    public function get_cate_product($cate = 0)
    {

        $a_where = [
            $this->db->get_prefix() . 'product.goods_stye' => 1,
            $this->db->get_prefix() . 'product.pro_show'   => 1,
            $this->db->get_prefix() . 'product.proid_id_1' => $cate,
            // 'product_id in' => $a_piddata,
        ];
        $s_field = $this->db->get_prefix() . 'product.product_id,proid_id_1, proid_id_2, proid_id_3, antistop, product_name, order, pro_details, pro_image, pro_img, goods_stye, pro_show, supply_time, sale_id, number';
        $a_order = [
            $this->db->get_prefix() . 'product_number.number' => 'desc',
        ];
        $a_data  = $this->db->from('product')
            ->join('product_number', [$this->db->get_prefix() . 'product.product_id' => $this->db->get_prefix() . 'product_number.product_id'])
            ->where($this->db->get_prefix() . 'product.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->get('', $a_where, $s_field, $a_order, 0, 9999999999);
        // echo $this->db->get_sql();
        return $a_data;
    }

    /************************************** 获取五条广告信息 ************************************/

    public function get_ad_five()
    {
        $a_order = [
            'ad_order' => 'asc',
        ];
        $a_data  = $this->db->get('ad', [], '', $a_order, 0, 5);
        return $a_data;
    }

    /********************************************************************************************/

}
