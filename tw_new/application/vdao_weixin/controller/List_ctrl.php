<?php
class List_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
        $this->load->model('allow_model');
        // $this->allow_model->is_login();
	}

    //产品分类页面
    public function product_category() {        
        $this->view->display('product_category');
    }

	//产品列表
	public function list() {
        //产品类id
        $i_id = $this->router->get(1);
		$a_data['prod'] = $this->db->limit(0, 9999999999)->get('product', ['pro_show' => 1, 'proid_id_1' => $i_id, 'goods_stye' => 1], '', ['order' => 'asc']);
        // 产品价格起
        $a_data['cup']  = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            // print_r($a_data['cup']);
        // 配送费
        $a_data['set']  = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        if (empty($_SESSION['user_id'])) {
            $this->view->display('list', $a_data);            
        } else {
            // 获取全部价格
            $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            // print_r($a_data['pric']);
            //获取产品属性
            $a_data['att']  = $this->db->limit(0, 9999999999)->get('product_att');
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
            $this->view->display('list1', $a_data); 
        }
	}

    // 门店咖啡列表
    public function list_store() {
        //门店id
        $i_store = $this->router->get(1);
        //产品类id
        $i_goods = $this->router->get(2);
        //门店信息
        $a_data['store'] = $this->db->get_row('store', ['store_id' => $i_store], ['store_name', 'store_address', 'store_tel']);
        $a_data['imte']  = $this->db->get_row('set', ['set_name' => 'store_open_time']);
        //产品分类
        $a_data['pro'] = $this->db->limit(0, 9999999999)->get('pro', ['proid' => 1, 'is_show' => 1]);
        // print_r($a_data['pro']);
        if (empty($i_goods)) {
            $a_wher = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $i_store, 'proid_id_1' => $a_data['pro'][0]['pro_id']];           
        } else {
            $a_wher = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $i_store, 'proid_id_1' => $i_goods];
        }
        $a_data['prod'] = $this->db->from('prod_sto as a')
                                        ->join('product as b', ['a.product_id' => 'b.product_id'])
                                        ->get('', $a_wher, '', ['order' => 'asc']);
        $a_data['cup']  = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        // print_r($a_data['cup']);
        // 配送费
        $a_data['set']  = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        if (empty($_SESSION['user_id'])) {
            $this->view->display('list_store', $a_data);            
        } else {
            // 获取最低价格
            $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            //获取产品属性
            $a_data['att']  = $this->db->limit(0, 9999999999)->get('product_att');
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
        //     // print_r($a_data['pric']);
            $this->view->display('list_store1', $a_data); 
        }
    }

    //选择杯型显示价格
    public function  list_price() {
        $i_goods = $this->general->post('goods');
        $i_cup = $this->general->post('cup');
        $i_price = $this->db->get_row('price', ['product_id' => $i_goods, 'cup_id' => $i_cup], ['price']);
        echo json_encode($i_price);
    }

	//获取更多产品信息
	public function list_up() {
        // 先设置默认从第一页开始
        $i_page = $this->general->post('page');
        if (empty($i_page)) {
            $i_page = 1;
        }
        $a_where = ['pro_show' => 1, 'goods_stye' => 1];
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = $this->db->get_total('product', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        //总页数
        $page_total = ceil($i_total/$i_prow);
        //判断是否超过总页数
        if ($i_page > $page_total) {
        	// $a_data = array('state' => 0);
        	echo json_encode(0);
            die;
        }
		$a_data = $this->db->get('product', $a_where);
		echo json_encode($a_data);
	}
	
    //产品详情
    public function item() {
        // 产品的类型id
        $i_le  = $this->router->get(1);
        // 产品的id
        $i_id  = $this->router->get(2);
        // 门店的id
        $i_sto = $this->router->get(3);
        if (empty($i_sto)) {
            $a_data['goods'] = $this->db->from('product as a')
                                        ->join('qualifi_goods as b', ['a.product_id' => 'b.product_id'])
                                        ->join('user as c', ['b.user_id' => 'c.user_id'])
                                        ->get('', ['a.product_id' => $i_id, 'pro_show' => 1]);
            // print_r($a_data);        
        } else if ($i_sto == 'i') {
            $a_data['goods'] = $this->db->from('product as a')
                                        ->join('qualifi_goods as b', ['a.product_id' => 'b.product_id'])
                                        ->join('user as c', ['b.user_id' => 'c.user_id'])
                                        ->get('', ['a.product_id' => $i_id, 'pro_show' => 1]);
        } else {
            $a_data['goods'] = $this->db->from('prod_sto as a')
                                        ->join('product as b', ['a.product_id' => 'b.product_id'])
                                        ->join('store as c', ['a.store_id' => 'c.store_id'])
                                        ->get('', ['a.product_id' => $i_id, 'a.prod_show' => 1, 'b.pro_show' => 1], $a_slse);
            // print_r($a_data);
        }
        // print_r($a_data['goods']);
        if (empty($a_data['goods'])) {
            $this->error->show_error('无该产品或该产品下架了！');
        }
        //查询产品有无被收藏
        $a_data['colle'] = $this->db->get_row('collection', ['collection_type' => 3, 'user_id' => $_SESSION['user_id'], 'object_id' => $i_id]);
        // 评论标签
        $comme = $this->db->get('comment', ['object_id' => $i_id, 'comment_type' => 2, 'comment_state' => 1], '', ['comment_id' => 'desc'], 0,4);
        $a = '';
        foreach ($comme as $product) {
            $a .= $product['comment_tags'].',';
        }
        $a = str_replace(",,",",", $a);
        $a =  ltrim(rtrim($a, ","), ",");
        $a = explode(",", $a);
        $a_data['name'] = array_unique($a);
        // 好评百分比
        //各订单数
        $s_fields = 'comment_cate,count(1) as num';
        $s_group_by = 'comment_cate';
        $a_wher = ['object_id' => $i_id, 'comment_type' => 2, 'comment_state' => 1];
        $a_data_result = $this->db
                       ->select($s_fields,false)
                       ->group_by($s_group_by)
                       ->get('comment', $a_wher);
        foreach($a_data_result as $key => $value) {
            $a_result[$value['comment_cate']] = $value['num'];
        }
        // 显示好评条数
        $a_data['hao'] = isset($a_result['1']) ? intval($a_result['1']) : 0;
         // 显示中评条数
        $a_data['zho'] = isset($a_result['2']) ? intval($a_result['2']) : 0;
         // 显示差评条数
        $a_data['cha'] = isset($a_result['3']) ? intval($a_result['3']) : 0;
        $a_data['out'] = $a_data['hao'] + $a_data['zho'] + $a_data['cha'];
        $a_data['payment'] = round($a_data['hao'] / ($a_data['out'] + 1), 1);
        // 获取最低价格
        $a_data['pric'] = $this->db->get('price', ['product_id' => $i_id, 'price >' => 0], '', ['price' => 'asc']);
        if (empty($_SESSION['user_id'])) {
            $this->view->display('item', $a_data);            
        } else {  
            //获取产品属性
            $a_data['att'] = $this->db->limit(0, 9999999999)->get('product_att', ['product_id' => $i_id]);
            // print_r($a_data['att']);
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
            $this->view->display('item1', $a_data);
        }                         
    }

    // 产品收藏
    public function item_colle() {
        $i_goods  = $this->general->post('goods');
        $a_data   = $this->db->get_row('collection', ['collection_type' => 3, 'user_id' => $_SESSION['user_id'], 'object_id' => $i_goods]);
        if (empty($a_data)) {
            $a_tare = [
                'collection_type' => 3,
                'user_id'   => $_SESSION['user_id'],
                'object_id' => $i_goods,
                'collection_time' => $_SERVER['REQUEST_TIME'],
            ];
           $s_data = $this->db->insert('collection', $a_tare);
           if ($s_data) {
                echo json_encode(array('code'=>200, 'msg'=>'添加成功'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'添加失败'));
            }
        } else {
            $s_data = $this->db->delete('collection', ['collection_id' => $a_data['collection_id']]);
            if ($s_data) {
                echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
            } else {
                echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
            }
        }
        
    }

    // 咖啡评价
    public function list_comment () {
        // 产品的类型id
        $i_lexin   = $this->router->get(1);
        // 产品的id
        $goods_id  = $this->router->get(2);
        // 店铺的id
        $store_id  = $this->router->get(3);
        //评论条件
        $i_out  = $this->router->get(4);
        $a_data = [
            'i_lexin'  => $i_lexin,
            'goods_id' => $goods_id,            
            'store_id' => $store_id,            
        ];
        if ( ! empty($store_id)) {
            $a_where = "`object_id` = $goods_id AND `comment_type` = 2 AND `comment_state` = 1 AND `store_id` = $store_id";
        } else {
            $a_where = "`object_id` = $goods_id AND `comment_type` = 2 AND `comment_state` = 1";       
        }
        if ( ! empty($i_out)) {
            if ($i_out != 4) {
                $a_where .= ($a_where ? ' AND ' : '') . "`comment_cate` = $i_out";               
            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`comment_pic` > '0'";
            }
        }
        // 产品评论
        $a_data['comment'] = $this->db->from('comment as a')
                                        // ->join('product as b', ['b.product_id' => 'a.object_id'])
                                        ->get('', $a_where, '', ['comment_id' => 'desc'], 0,999999999);
        // echo $this->db->get_sql();
        // print_r( $a_data['comment']);
        //用户信息
        $a_data['user'] = $this->db->limit(0, 9999999999)->get('user');

        //各订单数
        $s_fields = 'comment_cate,count(1) as num';
        $s_group_by = 'comment_cate';
         if ( ! empty($store_id)) {
            $a_wher = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1, 'store_id' => $store_id];
        } else {
            $a_wher = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1];       
        }
        $a_wher = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1];
        $a_data_result = $this->db
                       ->select($s_fields,false)
                       ->group_by($s_group_by)
                       ->get('comment', $a_wher);
        foreach($a_data_result as $key => $value) {
            $a_result[$value['comment_cate']] = $value['num'];
        }
        // 显示很满意条数
        $a_data['hao'] = isset($a_result['1']) ? intval($a_result['1']) : 0;
         // 显示满意条数
        $a_data['zho'] = isset($a_result['2']) ? intval($a_result['2']) : 0;
         // 显示待提高条数
        $a_data['cha'] = isset($a_result['3']) ? intval($a_result['3']) : 0;
        //显示有图条数
        $a_data['img'] = $this->db->get_total('comment', ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1, 'comment_pic >' => 0]);

        $this->view->display('list_comment', $a_data);
    }

}
?>