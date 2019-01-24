<?php
/**
 * Created by PhpStorm.
 * User: 7du-28
 * Date: 2018/4/25
 * Time: 16:21
 */

class ApiStore_model extends TW_Model
{

    public function __construct() {
        parent :: __construct();
    }

    // 用户分页查询
    public function store_list($pageNum,$raw,$keywords) {
        // 先设置默认从第一页开始
        //$pageNum = $this->router->get(1);
        if (empty($pageNum)) {
            $pageNum = 1;
        }
        // 设置每页显示的数据行数
        if(empty($raw)){
            $raw = 10;
        }
        // 加载分页类
        $this->load->library('pages');
        if(!empty($keywords)){
            $a_where = [
                'store_name LIKE'    => '%'.$keywords.'%'
            ];
            $i_total = $this->db->get_total('store',$a_where);
        }else{
        // 获取数据总行数，以产品为例
            $i_total = $this->db->get_total('store');
        }
        if ($pageNum > ceil($i_total/$raw)) {
            return array();
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $pageNum, $raw);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        $s_field = 'store_id,store_name,store_address,store_position,store_output,store_order,store_score,store_introduction,store_mainimg,store_img,store_licence,store_linkman,store_contact,store_state,store_traffic,order_distance,store_balance,store_amount,store_officeorder,store_warning,store_salescount,store_longitude,store_latitude,store_visitorall,store_visitorcur,store_visitorlea,store_tel,store_allorder,store_touxiang,	store_regtime,update_time,store_areanum,store_citycode,mony_withdraw,score_withdraw,transport_id,store_star,book_count';
        if(!empty($keywords)){
            $a_data = $this->db->get('store',$a_where,$s_field);
        }else{
            $a_where=[];
            $a_data = $this->db->get('store',$a_where,$s_field);
        }
        return $a_data;
    }



    public function getStoreCommentByStoreId($store_id){
        $a_where = [
            'store_id' => $store_id
        ];
        $a_data=$this->db->get('comment', $a_where);
        return $a_data;
    }
}