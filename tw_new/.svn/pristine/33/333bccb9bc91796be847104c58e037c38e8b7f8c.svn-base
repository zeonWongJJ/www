<?php
date_default_timezone_set('PRC');

class Shop_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('shop_model');
        $this->load->model('allow_model');
        //$this->allow_model->is_login();
    }


    // 购物车
    public function shopping()
    {
        //判断是否有订单号传入
        $repurchase = $this->general->post('repurchase');
        if (!empty($repurchase)) {
            $a_data['repurchase'] = $this->shop_model->repurchase($repurchase);
        }
        // // print_r($a_data);exit;
        // //查询购物车页面输出的数据
        // $group_store =  $this->db->group_by('store_id')->get('cart', ['user_id' => $_SESSION['user_id']], 'store_id,store_name', ['store_id' => 'desc'], 0, 99999999999);
        // $cart = array();
        // foreach($group_store as $key =>$value){
        //    $this_store =  $this->db->get_row('store', ['store_id'=>$value['store_id']], 'store_name', '', 0, 99999999999);
        //    if($this_store){
        //      $value['store_name'] =$this_store['store_name'] ;
        //  }else{
        //      $value['store_name'] ='不指定门店';
        //  }
           
        //     $value['goods'] =   $this->db->get('cart', ['user_id' => $_SESSION['user_id'],'store_id'=>$value['store_id']], '', ['cart_id' => 'desc'], 0, 99999999999);
        //     $cart[$key] = $value;
        // }
        
        // // print_r($cart);exit;
        // //购物车
        // // $a_data['goods'] = $this->db->get('cart', ['user_id' => $_SESSION['user_id']], '', ['cart_id' => 'desc'], 0, 99999999999);
        // $a_data['total'] = $this->db->get_total('cart', ['user_id' => $_SESSION['user_id']]);
        // 后台设置的运费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight']);
        // 门店表
        // $a_data['store'] = $this->db->get('store', '', '', '', 0, 99999999999);
        // print_r( $a_data['set']);
        $this->view->display('new_shopping',$a_data);
    }

    public function shopping_msg(){
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //判断是否有订单号传入
        $repurchase = $this->general->post('repurchase');
        if (!empty($repurchase)) {
            $a_data['repurchase'] = $this->shop_model->repurchase($repurchase);
        }
        // print_r($a_data);
        //查询购物车页面输出的数据
        $group_store =  $this->db->group_by('store_id')->get('cart', ['user_id' => $_SESSION['user_id']], 'store_id,store_name', ['store_id' => 'desc'], 0, 99999999999);
        $cart = array();
        foreach($group_store as $key =>$value){
           $this_store =  $this->db->get_row('store', ['store_id'=>$value['store_id']], 'store_name', '', 0, 99999999999);
           if($this_store){
             $value['store_name'] =$this_store['store_name'] ;
         }else{
             $value['store_name'] ='不指定门店';
         }
           
            $value['goods'] =   $this->db->get('cart', ['user_id' => $_SESSION['user_id'],'store_id'=>$value['store_id']], '', ['cart_id' => 'desc'], 0, 99999999999);
            $cart[$key] = $value;
        }
        $a_data['data'] = $cart;
        
        // print_r($cart);exit;
        //购物车
        $a_data['total'] = $this->db->get_total('cart', ['user_id' => $_SESSION['user_id']]);
        // 后台设置的运费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight']);
        // 门店表
        exit(json_encode(['code'=>200,'data'=>$a_data]));
         }else{ 
             exit(json_encode(['code'=>400]));
         }

    }

    //添加购物车
    public function shop_add()
    {
        if (empty($_SESSION['user_id'])) {
            //exit(array("code"=>205,'msg'=>"请登录后才操作!"));
            echo json_encode(['code' => 205, 'msg' => '请先登录!']);
            exit;
        }

        $i_tost = $this->general->post('tost');
        $i_goods = $this->general->post('goods');
        $i_manoe = $this->general->post('manoe');
        $i_shuxi = rtrim($this->general->post('shuxi'), '/');
        $a_name = $this->general->post('name');
        $i_spec = $this->general->post('spec');
        $a_meal = rtrim($this->general->post('meal'), ' + ');
        $i_oute = $this->general->post('oute');
        $share_userid = $this->general->post('share_userid');

        //查询产品数据
        $a_prod = $this->db->get_row('product', ['product_id' => $i_goods]);
        //查询购物车数据
        $a_cart = $this->db->get_row('cart', ['user_id' => $_SESSION['user_id'], 'store_id' => $i_tost, 'shux_name' => $i_shuxi, 'product_id' => $i_goods, 'set_meal' => $a_meal]);
        if (empty($a_cart)) {
            $a_datr = [
                'user_id' => $_SESSION['user_id'],
                'store_id' => $i_tost,
                'shux_name' => $i_shuxi,
                'store_name' => $a_name,
                'share_userid' => $share_userid,
                'product_id' => $i_goods,
                'product_name' => $a_prod['product_name'],
                'money' => $i_manoe,
                'spec' => $i_spec,
                'set_meal' => $a_meal,
                'prot_count' => 1,
                'pro_img' => $a_prod['pro_img'],
            ];
            $s_data = $this->db->insert('cart', $a_datr);
        } else {
            $i_goodsnum = $a_cart['prot_count'] + $i_oute;
            $s_data = $this->db->update('cart', ['prot_count' => $i_goodsnum, 'money' => $i_manoe], ['user_id' => $_SESSION['user_id'], 'cart_id' => $a_cart['cart_id']]);
        }
        if (!empty($s_data)) {
            $ooo = $this->db->select("SUM(prot_count) as prot_count", false)->get("cart", ['store_id' => $i_tost, 'user_id' => $_SESSION['user_id']], "", 0, 999999);
            echo json_encode(['code' => 200, 'msg' => '添加成功', 'count' => $ooo[0]['prot_count']]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '添加失败']);
        }
    }

    //返回购物车的总产品数
    public function cart_port_count($store = 0)
    {
        $num = 0;
        $ooo = $this->db->select("SUM(prot_count) as prot_count", false)->get("cart", ['store_id' => $store, 'user_id' => $_SESSION['user_id']], "", 0, 999999);
        if ($ooo[0]['prot_count'] > 0) {
            $num = $ooo[0]['prot_count'];
        }
        return $num;

    }

    //购物车删除
    public function shop_dele()
    {
        //获取到删除购物车的第一个删除
        $i_del = $this->general->post('id');
        $i_out = explode(",", $i_del);
        foreach ($i_out as $hoys) {
            $i_del = $this->db->delete('cart', ['user_id' => $_SESSION['user_id'], 'cart_id' => $hoys]);
        }
        if ($i_del) {
            echo json_encode(['code' => 200, 'msg' => '删除成功', 'data' => $this->general->post(), "count" => $this->cart_port_count(0)]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '删除失败']);
        }
    }

    // 购物删除一个门店的全部数据
    public function shop_delete()
    {
        $i_store = $this->general->post('stoue');
        $a_delete = $this->db->delete('cart', ['store_id' => $i_store, 'user_id' => $_SESSION['user_id']]);
        if ($a_delete) {
            echo json_encode(['code' => 200, 'msg' => '删除成功']);
        } else {
            echo json_encode(['code' => 400, 'msg' => '删除失败']);
        }
    }

    // 查询购物车的数据
    public function shop_inex()
    {
        $i_usoer = $this->general->post('usore');
        $a_data['goods'] = $this->db->limit(0, 9999999999)->get('cart', ['store_id' => $i_usoer, 'user_id' => $_SESSION['user_id']]);
        $sum = 0;
        foreach ($a_data['goods'] as $key => $value) {
            $a_mout = $this->db->get_row('price', ['product_id' => $value['product_id'], 'cup_id' => $value['spec']]);
            // $price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $a_mout['price'];          
            $sum += $value['prot_count'] * $value['money'];
        }
        //总运费
        $freight = $this->db->get('set');
        $a_res['freight'] = $freight[7]['set_parameter'];
        $a_data['pout'] = sprintf("%.2f", $sum) ? sprintf("%.2f", $sum) : 0;
        if ($a_data) {
            echo json_encode(['code' => 200, 'msg' => '查询成功', 'data' => $a_data]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '查询失败']);
        }
    }

    //产品增加减少
    public function shop_reudaa()
    {
        $i_cart = $this->general->post('id');
        $i_stou = $this->general->post('stou');
        $i_vart = $this->general->post('vart');
        if ($i_vart == 1) {

            $a_data = $this->db->set('prot_count', 'prot_count + 1', false)->update('cart', '', ['store_id' => $i_stou, 'user_id' => $_SESSION['user_id'], 'cart_id' => $i_cart]);
        } else {
            $a_data = $this->db->set('prot_count', 'prot_count - 1', false)->update('cart', NULL, ['store_id' => $i_stou, 'user_id' => $_SESSION['user_id'], 'cart_id' => $i_cart]);
        }
        if ($a_data) {
            echo json_encode(['code' => 200, 'msg' => '修改成功', 'count' => $this->cart_port_count($i_stou)]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '修改失败']);
        }
    }


    // 更新购物车数量
    function shopcar_update()
    {
        $cart_id = trim($this->general->post('cart_id'));
        $prot_count = trim($this->general->post('num'));
        // 数量不能小于1
        if ($prot_count < 1) {
            $prot_count = 1;
        }
        // 获取一条购物车信息
        $a_where = [
            'cart_id' => $cart_id
        ];
        $a_data = $this->db->get_row('cart', $a_where);
        // 更新购物车数量
        $a_new_data = [
            'prot_count' => $prot_count
        ];
        $i_result = $this->db->update('cart', $a_new_data, $a_where);
        if ($i_result) {
            echo json_encode(['code' => 200, 'msg' => '更新成功']);
        } else {
            echo json_encode(['code' => 400, 'msg' => '更新失败']);
        }
    }

}