<?php
/**
 * 用户模块
 */
class Ht_goods_model extends TW_Model {
    public function __construct() {
        parent :: __construct();
    }
    
    /**
     * [goods 商品列表]
     * @return [array] [商品列表信息]
     */
    public function goods(){

        // 查询出需要展示的数据
        $s_field = "goods_id,goods_name,store_name,goods_price,goods_promotion_type,goods_storage,goods_commend,goods_verify,goods_state,goods_click";
        //查询出所有商品信息
        $a_data = $this->db->get('goods', '', $s_field,'goods_id DESC',0,3000);
        // $a_data = $this->db->get('goods', '', $s_field,'',0,30);

        // 处理一下页面需要展示的数据
        foreach ($a_data as $key => $value) {
            if ($value['goods_promotion_type'] == 0){
                $a_data[$key]['goods_promotion_type'] = '无促销';
            } else if ($value['goods_promotion_type'] == 1){
                $a_data[$key]['goods_promotion_type'] = '团购';
            } else if ($value['goods_promotion_type'] == 2){
                $a_data[$key]['goods_promotion_type'] = '限时折扣';
            }

            if ($value['goods_commend'] == 0){
                $a_data[$key]['goods_commend'] = '不推荐';
            } else if ($value['goods_commend'] == 1){
                $a_data[$key]['goods_commend'] = '推荐';
            }

            if ($value['goods_verify'] == 0){
                $a_data[$key]['goods_verify'] = '未通过';
            } else if ($value['goods_verify'] == 1){
                $a_data[$key]['goods_verify'] = '通过';
            } else if ($value['goods_verify'] == 10){
                $a_data[$key]['goods_verify'] = '审核中';
            }

            if ($value['goods_state'] == 0){
                $a_data[$key]['goods_state'] = '下架';
            } else if ($value['goods_state'] == 1){
                $a_data[$key]['goods_state'] = '正常';
            } else if ($value['goods_state'] == 10){
                $a_data[$key]['goods_state'] = '违规（禁售）';
            }
        }
        return $a_data;
    }

     /**
     * [sold_out 下架商品列表]
     * @return [array] [下架商品列表信息]
     */
    public function sold_out(){

        // 查询出需要展示的数据
        $s_field = "goods_id,goods_name,store_name,goods_price,goods_promotion_type,goods_storage,goods_commend,goods_verify,goods_state,goods_click";
        //查询出所有商品信息
        $a_data = $this->db->get('goods', ['goods_state' => 0], $s_field,'',0,3000);
        // $a_data = $this->db->get('goods', ['goods_state' => 0], $s_field,'',0,30);

        // 处理一下页面需要展示的数据
        foreach ($a_data as $key => $value) {
            if ($value['goods_promotion_type'] == 0){
                $a_data[$key]['goods_promotion_type'] = '无促销';
            } else if ($value['goods_promotion_type'] == 1){
                $a_data[$key]['goods_promotion_type'] = '团购';
            } else if ($value['goods_promotion_type'] == 2){
                $a_data[$key]['goods_promotion_type'] = '限时折扣';
            }

            if ($value['goods_commend'] == 0){
                $a_data[$key]['goods_commend'] = '不推荐';
            } else if ($value['goods_commend'] == 1){
                $a_data[$key]['goods_commend'] = '推荐';
            }

            if ($value['goods_verify'] == 0){
                $a_data[$key]['goods_verify'] = '未通过';
            } else if ($value['goods_verify'] == 1){
                $a_data[$key]['goods_verify'] = '通过';
            } else if ($value['goods_verify'] == 10){
                $a_data[$key]['goods_verify'] = '审核中';
            }

            if ($value['goods_state'] == 0){
                $a_data[$key]['goods_state'] = '下架';
            } else if ($value['goods_state'] == 1){
                $a_data[$key]['goods_state'] = '正常';
            } else if ($value['goods_state'] == 10){
                $a_data[$key]['goods_state'] = '违规（禁售）';
            }
        }
        return $a_data;
    }

    /**
     * [update_goods 修改商品表信息]
     * @return [array] [需要修改的值]
     */
    public function update_goods($goods_id){
        $goods_name             = $this->general->post('goods_name');
        $goods_jingle           = $this->general->post('goods_jingle');
        $keywords               = $this->general->post('keywords');
        $store_id               = $this->general->post('store_id');
        $store_name             = $this->general->post('store_name');
        $brand_id               = $this->general->post('brand_id');
        $gc_id_1                = $this->general->post('gc_id_1');
        $gc_id_2                = $this->general->post('gc_id_2');
        $gc_id_3                = $this->general->post('gc_id_3');
        $areaid_1               = $this->general->post('areaid_1');
        $areaid_2               = $this->general->post('areaid_2');
        $transport_id           = $this->general->post('transport_id');
        $goods_freight          = $this->general->post('goods_freight');
        $goods_price            = $this->general->post('goods_price');
        $goods_marketprice      = $this->general->post('goods_marketprice');
        $goods_promotion_type   = $this->general->post('goods_promotion_type');
        $goods_promotion_price  = $this->general->post('goods_promotion_price');
        $goods_discount         = $this->general->post('goods_discount');
        $goods_storage_alarm    = $this->general->post('goods_storage_alarm');
        $goods_click            = $this->general->post('goods_click');
        $goods_salenum          = $this->general->post('goods_salenum');
        $goods_collect          = $this->general->post('goods_collect');
        $goods_storage          = $this->general->post('goods_storage');
        $deductible_point       = $this->general->post('deductible_point');
        $goods_feng             = $this->general->post('goods_feng');
        $payment                = $this->general->post('payment');
        $evaluation_count       = $this->general->post('evaluation_count');
        $evaluation_good_star   = $this->general->post('evaluation_good_star');
        $goods_state            = $this->general->post('goods_state');
        $goods_verify           = $this->general->post('goods_verify');
        $goods_commend          = $this->general->post('goods_commend');
        $is_virtual             = $this->general->post('is_virtual');
        $goods_lock             = $this->general->post('goods_lock');
        $virtual_indate         = $this->general->post('virtual_indate');
        $virtual_limit          = $this->general->post('virtual_limit');
        $have_gift              = $this->general->post('have_gift');
        $virtual_invalid_refund = $this->general->post('virtual_invalid_refund');
        $is_fcode               = $this->general->post('is_fcode');
        $is_appoint             = $this->general->post('is_appoint');
        $is_presell             = $this->general->post('is_presell');
        $is_own_shop            = $this->general->post('is_own_shop');
        $description            = $this->general->post('description');
        $goods_body             = $this->general->post('goods_body', false);
        $gc_id_1_name           = $this->general->post('gc_id_1_name');
        $gc_id_2_name           = $this->general->post('gc_id_2_name');
        $gc_id_3_name           = $this->general->post('gc_id_3_name');
        $brand_name             = $this->general->post('brand_name');
        $transport_title        = $this->general->post('transport_title');
        $type_id                = $this->general->post('type_id');
        $goods_image            = $this->general->post('goods_image');

        if( 
            ! empty($goods_name) &&
            ! empty($goods_jingle) &&
            ! empty($keywords) &&
            ! empty($store_id) &&
            ! empty($store_name) &&
            ! empty($brand_id) &&
            ! empty($gc_id_1) &&
            ! empty($gc_id_2) &&
            ! empty($gc_id_3) &&
            ! empty($areaid_1) &&
            ! empty($areaid_2) &&
            ! empty($transport_id) &&
            ! empty($goods_freight) &&
            $goods_price >= 0 &&
            $goods_marketprice >= 0 &&
            $goods_promotion_type >=0 &&
            $goods_promotion_price >= 0 &&
            $goods_discount >= 0 &&
            $goods_storage_alarm >= 0 &&
            $goods_click >= 0 &&
            $goods_salenum >= 0 &&
            $goods_collect >= 0 &&
            $goods_storage >= 0 &&
            $deductible_point >= 0 &&
            $goods_feng >= 0 &&
            ! empty($payment) &&
            $evaluation_count >= 0 &&
            $evaluation_good_star >= 0 &&
            $goods_state >= 0 &&
            $goods_verify >= 0 &&
            $goods_commend>= 0 &&
            $is_virtual >= 0 &&
            $goods_lock >= 0 &&
            $virtual_indate >= 0 &&
            $virtual_limit >= 0 &&
            $have_gift  >= 0 &&
            $virtual_invalid_refund >= 0 &&
            $is_fcode >= 0 &&
            $is_appoint >= 0 &&
            $is_presell >= 0 &&
            $is_own_shop >= 0 &&
            ! empty($description) &&
            ! empty($goods_body) &&
            ! empty($gc_id_1_name) &&
            ! empty($gc_id_2_name) &&
            ! empty($gc_id_3_name) &&
            ! empty($brand_name) &&
            ! empty($transport_title) 
            ){
                // 添加上传文件
                if(! empty($this->general->post('store_id'))){
                    if($_FILES['goods_image']['name'] != false){
                        if($_FILES['goods_image']['error'] == 0){
                            // 获取文件信息
                            $goods_image = '../7dugo_pc/upload/shop/store/goods/' . $_POST['store_id'] . '/' . $goods_image;
                            unlink ($goods_image);
                            $fileInfo = $_FILES['goods_image'];
                            $path = '../7dugo_pc/upload/shop/store/goods/' . $_POST['store_id'] . '/' . date('Y') . '/' . date('m');
                            $res = $this->uploadFile($fileInfo, $path);
                            $goods_image    = date('Y') . '/' . date('m') . '/' . $res;
                        }else{
                            $this->error->show_error('文件上传错误',$this->router->url('update_goods',['goods_id' => $goods_id]));
                        } 
                    }
                }
                $a_data = array();

                $edittime  = $_SERVER['REQUEST_TIME'];
                // 插入商品表数据
                $a_data = [  
                'goods_name'            =>  $goods_name,     
                'goods_jingle'          =>  $goods_jingle,  
                'keywords'              =>  $keywords,
                'description'           =>  $description,  
                'store_id'              =>  $store_id, 
                'store_name'            =>  $store_name, 
                'gc_id'                 =>  $gc_id_3,   
                'gc_id_1'               =>  $gc_id_1,   
                'gc_id_2'               =>  $gc_id_2,   
                'gc_id_3'               =>  $gc_id_3,   
                'brand_id'              =>  $brand_id, 
                'goods_price'           =>  $goods_price, 
                'goods_promotion_price' =>  $goods_promotion_price,   
                'goods_promotion_type'  =>  $goods_promotion_type,   
                'goods_marketprice'     =>  $goods_marketprice,
                'goods_storage_alarm'   =>  $goods_storage_alarm,  
                'goods_click'           =>  $goods_click,   
                'goods_salenum'         =>  $goods_salenum,   
                'goods_collect'         =>  $goods_collect,   
                'goods_storage'         =>  $goods_storage,   
                'goods_image'           =>  $goods_image,
                'goods_state'           =>  $goods_state,   
                'goods_verify'          =>  $goods_verify,    
                'goods_time_edit'       =>  $edittime,   
                'areaid_1'              =>  $areaid_1,   
                'areaid_2'              =>  $areaid_2,     
                'transport_id'          =>  $transport_id,   
                'goods_freight'         =>  $goods_freight,   
                'goods_commend'         =>  $goods_commend,   
                'evaluation_good_star'  =>  $evaluation_good_star,   
                'evaluation_count'      =>  $evaluation_count, 
                'is_virtual'            =>  $is_virtual,   
                'virtual_indate'        =>  $virtual_indate,   
                'virtual_limit'         =>  $virtual_limit,   
                'virtual_invalid_refund'=>  $virtual_invalid_refund,   
                'is_fcode'              =>  $is_fcode,   
                'is_appoint'            =>  $is_appoint,   
                'is_presell'            =>  $is_presell,   
                'have_gift'             =>  $have_gift,   
                'is_own_shop'           =>  $is_own_shop,   
                'deductible_point'      =>  $deductible_point,   
                'payment'               =>  $payment,   
                'goods_feng'            =>  $goods_feng   
                ];
                
                $a_data_common = array();

                // 插入商品公共表数据
                $a_data_common = [     
                'goods_name'            => $goods_name,       
                'goods_jingle'          => $goods_jingle,       
                'gc_id'                 => $gc_id_3,       
                'gc_id_1'               => $gc_id_1,       
                'gc_id_2'               => $gc_id_2,        
                'gc_id_3'               => $gc_id_3,        
                'gc_name'               => $gc_id_1_name . ' &gt;' . $gc_id_2_name . ' &gt;' . $gc_id_3_name,          
                'store_id'              => $store_id,          
                'store_name'            => $store_name,          
                'brand_id'              => $brand_id,      
                'brand_name'            => $brand_name,      
                'type_id'               => $type_id,       
                'goods_image'           => $goods_image,      
                'goods_body'            => $goods_body,       
                'mobile_body'           => $goods_body,       
                'goods_state'           => $goods_state,       
                'goods_verify'          => $goods_verify,       
                'goods_lock'            => $goods_lock,       
                'goods_price'           => $goods_price,       
                'goods_marketprice'     => $goods_marketprice,       
                'goods_discount'        => $goods_discount, 
                'goods_storage_alarm'   => $goods_storage_alarm,      
                'transport_id'          => $transport_id,      
                'transport_title'       => $transport_title,      
                'goods_commend'         => $goods_commend,      
                'goods_freight'         => $goods_freight,      
                'areaid_1'              => $areaid_1,       
                'areaid_2'              => $areaid_2,      
                'is_virtual'            => $is_virtual,       
                'virtual_indate'        => $virtual_indate,       
                'virtual_limit'         => $virtual_limit,      
                'virtual_invalid_refund'=> $virtual_invalid_refund,       
                'is_fcode'              => $is_fcode,      
                'is_appoint'            => $is_appoint,      
                'is_presell'            => $is_presell,      
                'is_own_shop'           => $is_own_shop,       
                'payment'               => $payment,       
                'goods_feng'            => $goods_feng,       
                ];

                // 插入商品图片表
                $goods_commonid = $this->db->get_row('goods',['goods_id' => $goods_id],'goods_commonid');

                // 开始事务插入数据
                $this->db->begin();
                // 更新数据
                $a_goods        = $this->db->update('goods', $a_data,['goods_id' => $goods_id]);
                $a_goods_common = $this->db->update('goods_common', $a_data_common,['goods_commonid' => $goods_commonid['goods_commonid']]);
                if ($a_goods != false && $a_goods_common != false){
                    $s_commit = 'commit';
                    // 提交事务
                    $this->db->commit();
                } else {
                    $s_roll_back = 'roll_back';
                    // 事务回滚
                    $this->db->roll_back();
                }
        
                if($s_roll_back == 'roll_back'){
                    $this->error->show_error('修改数据失败,请重新修改',$this->router->url('update_goods',['goods_id' => $goods_id]));
                }
        
                // 7度购，右边为对应数据库相应字段
                $a_update_data = array(
                    'goods_id'              => $goods_id,
                    'goods_name'            => $goods_name,
                    'goods_jingle'          => $goods_jingle,
                    'keywords'              => $keywords,
                    'description'           => $description,
                    'store_id'              => $store_id,
                    'store_name'            => $store_name,
                    'gc_id_1'               => $gc_id_1,
                    'gc_id_2'               => $gc_id_2,
                    'gc_id_3'               => $gc_id_3,
                    'brand_id'              => $brand_id,
                    'brand_name'            => $brand_name,
                    'goods_price'           => $goods_price,
                    'goods_promotion_price' => $goods_promotion_price,
                    'goods_promotion_type'  => $goods_promotion_type,
                    'goods_marketprice'     => $goods_marketprice,
                    'goods_image'           => $goods_image,
                    'evaluation_count'      => $evaluation_count,
                    'goods_edittime'        => $edittime,
                    'is_own_shop'           => $is_own_shop,
                    'goods_click'           => $goods_click,
                    'goods_salenum'         => $goods_salenum,
                    'goods_collect'         => $goods_collect,
                    'goods_body'            => $goods_body,
                    'deductible_point'      => $deductible_point,
                    'have_gift'             => $have_gift,
                    'evaluation_good_star'  => $evaluation_good_star,
                    'goods_feng'            => $goods_feng,
                    'type_id'               => $type_id
                );

                if($goods_verify == 1 && $goods_state == 1){
                    // 实例化搜索类
                    $this->load->library('search');
                    $this->search->project('7dugo');
                    // 执行插入或更新
                    $this->search->update($a_update_data);
                } else {
                    // 实例化搜索类
                    $this->load->library('search');
                    $this->search->project('7dugo');
                    // 执行插入或更新
                    $this->search->delete($goods_id);
                }
                if($s_commit == 'commit'){
                    $this->error->show_success('商品修改成功',$this->router->url('goods'));
                }  
            } else {
                $this->error->show_error('有存在未填写的字段',$this->router->url('update_goods',['goods_id' => $goods_id]));
            }
        
    }

    /**
     * [add_goods 添加商品表信息]
     * @return [array] [需要修改的值]
     */
    public function add_goods(){
        $goods_name             = $this->general->post('goods_name');
        $goods_jingle           = $this->general->post('goods_jingle');
        $keywords               = $this->general->post('keywords');
        $store_id               = $this->general->post('store_id');
        $store_name             = $this->general->post('store_name');
        $brand_id               = $this->general->post('brand_id');
        $gc_id_1                = $this->general->post('gc_id_1');
        $gc_id_2                = $this->general->post('gc_id_2');
        $gc_id_3                = $this->general->post('gc_id_3');
        $areaid_1               = $this->general->post('areaid_1');
        $areaid_2               = $this->general->post('areaid_2');
        $transport_id           = $this->general->post('transport_id');
        $goods_freight          = $this->general->post('goods_freight');
        $goods_price            = $this->general->post('goods_price');
        $goods_marketprice      = $this->general->post('goods_marketprice');
        $goods_promotion_type   = $this->general->post('goods_promotion_type');
        $goods_promotion_price  = $this->general->post('goods_promotion_price');
        $goods_discount         = $this->general->post('goods_discount');
        $goods_storage_alarm    = $this->general->post('goods_storage_alarm');
        $goods_click            = $this->general->post('goods_click');
        $goods_salenum          = $this->general->post('goods_salenum');
        $goods_collect          = $this->general->post('goods_collect');
        $goods_storage          = $this->general->post('goods_storage');
        $deductible_point       = $this->general->post('deductible_point');
        $goods_feng             = $this->general->post('goods_feng');
        $payment                = $this->general->post('payment');
        $evaluation_count       = $this->general->post('evaluation_count');
        $evaluation_good_star   = $this->general->post('evaluation_good_star');
        $goods_state            = $this->general->post('goods_state');
        $goods_verify           = $this->general->post('goods_verify');
        $goods_commend          = $this->general->post('goods_commend');
        $is_virtual             = $this->general->post('is_virtual');
        $goods_lock             = $this->general->post('goods_lock');
        $virtual_indate         = $this->general->post('virtual_indate');
        $virtual_limit          = $this->general->post('virtual_limit');
        $have_gift              = $this->general->post('have_gift');
        $virtual_invalid_refund = $this->general->post('virtual_invalid_refund');
        $is_fcode               = $this->general->post('is_fcode');
        $is_appoint             = $this->general->post('is_appoint');
        $is_presell             = $this->general->post('is_presell');
        $is_own_shop            = $this->general->post('is_own_shop');
        $description            = $this->general->post('description');
        $goods_body             = $this->general->post('goods_body', false);
        $gc_id_1_name           = $this->general->post('gc_id_1_name');
        $gc_id_2_name           = $this->general->post('gc_id_2_name');
        $gc_id_3_name           = $this->general->post('gc_id_3_name');
        $brand_name             = $this->general->post('brand_name');
        $transport_title        = $this->general->post('transport_title');
        $type_id                = $this->general->post('type_id');

        // 判断是否为空
        if( 
            ! empty($goods_name) &&
            ! empty($goods_jingle) &&
            ! empty($keywords) &&
            ! empty($store_id) &&
            ! empty($store_name) &&
            ! empty($brand_id) &&
            ! empty($gc_id_1) &&
            ! empty($gc_id_2) &&
            ! empty($gc_id_3) &&
            ! empty($areaid_1) &&
            ! empty($areaid_2) &&
            ! empty($transport_id) &&
            ! empty($goods_freight) &&
            $goods_price >= 0 &&
            $goods_marketprice >= 0 &&
            $goods_promotion_type >=0 &&
            $goods_promotion_price >= 0 &&
            $goods_discount >= 0 &&
            $goods_storage_alarm >= 0 &&
            $goods_click >= 0 &&
            $goods_salenum >= 0 &&
            $goods_collect >= 0 &&
            $goods_storage >= 0 &&
            $deductible_point >= 0 &&
            $goods_feng >= 0 &&
            ! empty($payment) &&
            $evaluation_count >= 0 &&
            $evaluation_good_star >= 0 &&
            $goods_state >= 0 &&
            $goods_verify >= 0 &&
            $goods_commend>= 0 &&
            $is_virtual >= 0 &&
            $goods_lock >= 0 &&
            $virtual_indate >= 0 &&
            $virtual_limit >= 0 &&
            $have_gift  >= 0 &&
            $virtual_invalid_refund >= 0 &&
            $is_fcode >= 0 &&
            $is_appoint >= 0 &&
            $is_presell >= 0 &&
            $is_own_shop >= 0 &&
            ! empty($description) &&
            ! empty($goods_body) &&
            ! empty($gc_id_1_name) &&
            ! empty($gc_id_2_name) &&
            ! empty($gc_id_3_name) &&
            ! empty($brand_name) &&
            ! empty($transport_title) 
            ){
                //判断是否有上传图片如果有删除并添加。如果没有不处理
                if(! empty($this->general->post('store_id'))){
                    if($_FILES['goods_image']['error'] == 0){
                        $fileInfo = $_FILES['goods_image'];
                        $path = '../7dugo_pc/upload/shop/store/goods/' . $_POST['store_id'] . '/' . date('Y') . '/' . date('m');
                        $res = $this->uploadFile($fileInfo, $path);
                        $goods_image = date('Y') . '/' . date('m') . '/' . $res;
                    } else {
                        $this->error->show_success('图片上传有误',$this->router->url('add_goods'));
                    }
                }
                $a_data = array();
                $goods_commonid = $this->db->get_row('goods','','goods_commonid',['goods_commonid' => desc]);
                $s_commonid = $goods_commonid['goods_commonid'] + 1;

                $addtime = $_SERVER['REQUEST_TIME'];
                // 插入商品表数据
                $a_data = [  
                'goods_name'            =>  $goods_name,   
                'goods_commonid'        =>  $s_commonid,   
                'goods_jingle'          =>  $goods_jingle,  
                'keywords'              =>  $keywords,
                'description'           =>  $description,  
                'store_id'              =>  $store_id, 
                'store_name'            =>  $store_name, 
                'gc_id'                 =>  $gc_id_3,   
                'gc_id_1'               =>  $gc_id_1,   
                'gc_id_2'               =>  $gc_id_2,   
                'gc_id_3'               =>  $gc_id_3,   
                'brand_id'              =>  $brand_id, 
                'goods_price'           =>  $goods_price, 
                'goods_promotion_price' =>  $goods_promotion_price,   
                'goods_promotion_type'  =>  $goods_promotion_type,   
                'goods_marketprice'     =>  $goods_marketprice,
                'goods_serial'          =>  '0', 
                'goods_storage_alarm'   =>  $goods_storage_alarm,  
                'goods_click'           =>  $goods_click,   
                'goods_salenum'         =>  $goods_salenum,   
                'goods_collect'         =>  $goods_collect,   
                'goods_spec'            =>  '0',  
                'goods_storage'         =>  $goods_storage,   
                'goods_image'           =>  $goods_image,
                'goods_state'           =>  $goods_state,   
                'goods_verify'          =>  $goods_verify,   
                'goods_time_create'     =>  $addtime,   
                'goods_time_edit'       =>  $addtime,   
                'areaid_1'              =>  $areaid_1,   
                'areaid_2'              =>  $areaid_2,   
                'color_id'              =>  '0',   
                'transport_id'          =>  $transport_id,   
                'goods_freight'         =>  $goods_freight,   
                'goods_vat'             =>  '0',   
                'goods_commend'         =>  $goods_commend,   
                'goods_stcids'          =>  '1',    
                'evaluation_good_star'  =>  $evaluation_good_star,   
                'evaluation_count'      =>  $evaluation_count, 
                'is_virtual'            =>  $is_virtual,   
                'virtual_indate'        =>  $virtual_indate,   
                'virtual_limit'         =>  $virtual_limit,   
                'virtual_invalid_refund'=>  $virtual_invalid_refund,   
                'is_fcode'              =>  $is_fcode,   
                'is_appoint'            =>  $is_appoint,   
                'is_presell'            =>  $is_presell,   
                'have_gift'             =>  $have_gift,   
                'is_own_shop'           =>  $is_own_shop,   
                'deductible_point'      =>  $deductible_point,   
                'payment'               =>  $payment,   
                'goods_feng'            =>  $goods_feng   
                ];
                
                $a_data_common = array();

                // 插入商品公共表数据
                $a_data_common = [
                'goods_commonid'        => $s_commonid,       
                'goods_name'            => $goods_name,       
                'goods_jingle'          => $goods_jingle,       
                'gc_id'                 => $gc_id_3,       
                'gc_id_1'               => $gc_id_1,       
                'gc_id_2'               => $gc_id_2,        
                'gc_id_3'               => $gc_id_3,        
                'gc_name'               => $gc_id_1_name . ' &gt;' . $gc_id_2_name . ' &gt;' . $gc_id_3_name,          
                'store_id'              => $store_id,          
                'store_name'            => $store_name,          
                'spec_name'             => 'N;',          
                'spec_value'            => 'N;',        
                'brand_id'              => $brand_id,      
                'brand_name'            => $brand_name,      
                'type_id'               => $type_id,       
                'goods_image'           => $goods_image,      
                'goods_attr'            => 'N;',       
                'goods_body'            => $goods_body,       
                'mobile_body'           => $goods_body,       
                'goods_state'           => $goods_state,       
                'goods_stateremark'     => '',       
                'goods_verify'          => $goods_verify,       
                'goods_verifyremark'    => ' ',       
                'goods_lock'            => $goods_lock,       
                'goods_time_create'     => $addtime,       
                'goods_time_sell'       => '0',       
                'goods_specname'        => '0',       
                'goods_price'           => $goods_price,       
                'goods_marketprice'     => $goods_marketprice,       
                'goods_costprice'       => '',       
                'goods_discount'        => $goods_discount, 
                'goods_serial'          => '0',       
                'goods_storage_alarm'   => $goods_storage_alarm,      
                'transport_id'          => $transport_id,      
                'transport_title'       => $transport_title,      
                'goods_commend'         => $goods_commend,      
                'goods_freight'         => $goods_freight,      
                'goods_vat'             => '0',       
                'areaid_1'              => $areaid_1,       
                'areaid_2'              => $areaid_2,      
                'goods_stcids'          => '1',       
                'plateid_top'           => '0',       
                'plateid_bottom'        => '0',       
                'is_virtual'            => $is_virtual,       
                'virtual_indate'        => $virtual_indate,       
                'virtual_limit'         => $virtual_limit,      
                'virtual_invalid_refund'=> $virtual_invalid_refund,       
                'is_fcode'              => $is_fcode,      
                'is_appoint'            => $is_appoint,      
                'appoint_satedate'      => '0',       
                'is_presell'            => $is_presell,      
                'presell_deliverdate'   => '0',       
                'is_own_shop'           => $is_own_shop,       
                'payment'               => $payment,       
                'goods_feng'            => $goods_feng,       
                ];

                $a_goods_images = [
                'goods_commonid'    => $s_commonid,
                'store_id'          => $store_id,
                'color_id'          => '0',
                'goods_image'       => $goods_image,
                'goods_image_sort'  => '1',
                'is_default'        => '1'
                ];

                // 开始事务插入数据
                $this->db->begin();
                // 插入数据
                $a_goods        = $this->db->insert('goods', $a_data);
                $a_goods_common = $this->db->insert('goods_common', $a_data_common);
                $a_goods_images = $this->db->insert('goods_images', $a_goods_images);
        
                if ($a_goods != false && $a_goods_common != false && $a_goods_images != false){
                    $s_commit = 'commit';
                    // 提交事务
                    $this->db->commit();
                } else {
                    $s_roll_back = 'roll_back';
                    // 事务回滚
                    $this->db->roll_back();
                }
        
                if($s_roll_back == 'roll_back'){
                    $this->error->show_error('添加数据失败,请重新添加',$this->router->url('add_goods'));
                }
        
                // 7度购，右边为对应数据库相应字段
                $a_update_data = array(
                    'goods_id'              => $a_goods,
                    'goods_commonid'        => $s_commonid,
                    'goods_name'            => $goods_name,
                    'goods_jingle'          => $goods_jingle,
                    'keywords'              => $keywords,
                    'description'           => $description,
                    'store_id'              => $store_id,
                    'store_name'            => $store_name,
                    'gc_id_1'               => $gc_id_1,
                    'gc_id_2'               => $gc_id_2,
                    'gc_id_3'               => $gc_id_3,
                    'brand_id'              => $brand_id,
                    'brand_name'            => $brand_name,
                    'goods_price'           => $goods_price,
                    'goods_promotion_price' => $goods_promotion_price,
                    'goods_promotion_type'  => $goods_promotion_type,
                    'goods_marketprice'     => $goods_marketprice,
                    'goods_image'           => $goods_image,
                    'evaluation_count'      => $evaluation_count,
                    'goods_addtime'         => $addtime,
                    'goods_edittime'        => $addtime,
                    'is_own_shop'           => $is_own_shop,
                    'goods_click'           => $goods_click,
                    'goods_salenum'         => $goods_salenum,
                    'goods_collect'         => $goods_collect,
                    'goods_body'            => $goods_body,
                    'deductible_point'      => $deductible_point,
                    'have_gift'             => $have_gift,
                    'evaluation_good_star'  => $evaluation_good_star,
                    'goods_feng'            => $goods_feng,
                    'type_id'               => $type_id
                );

                if($goods_verify == 1 && $goods_state == 1){
                    // 实例化搜索类并添加数据
                    $this->load->library('search');
                    $this->search->project('7dugo');
                    // 执行插入或更新
                    $this->search->update($a_update_data);
                }
                      
                if($s_commit == 'commit'){
                    $this->error->show_success('商品添加成功',$this->router->url('goods'));
                }  
            }else{
                $this->error->show_error('有存在未填写的字段',$this->router->url('add_goods'));
            }
   
              
    }

    /**
     * [add_goods_list 添加数据前需要展示的一些数据]
     * @return [array] [展示的一些数据]
     */
    public function add_goods_list(){
        // 查询出店铺的数据
        $a_data['store']    = $this->db->get('store', '', 'store_id,store_name');
        // 查询出第一级分类
        $a_data['gc_id_1']  = $this->classify(0);
        // 查询出城市
        $a_data['area']     = $this->area(0);
        // 查询出品牌
        $a_data['brand']    = $this->db->get('brand', '', 'brand_id,brand_name');
        // 查询出类型
        $a_data['type']     = $this->db->get('type', '', 'type_id,type_name');
        // 查询出运费模板
        $a_data['transport']= $this->db ->from('transport as a')
                                        ->join('transport_extend as b', ['a.id' => 'b.transport_id'])
                                        ->group_by('a.id')
                                        ->get('', '','a.id as id,a.title as title,b.sprice as sprice');
        return $a_data;
    }

    /**
     * [update_list 修改数据前需要展示的一些数据]
     * @return [array] [展示的一些数据]
     */
    public function update_list($a_goods){
        // var_dump($a_goods['areaid_2']);die;
        //获取商品列表
        $a_data['store']    = $this->db->get('store', '', 'store_id,store_name');
        //获取到第一级分类的数据
        $a_data['gc_id_1']  = $this->classify(0);
        //获取到第二级分类的数据
        $a_data['gc_id_2']  = $this->classify($a_goods['gc_id_1']);
        //获取到第三级分类的数据
        $a_data['gc_id_3']  = $this->classify($a_goods['gc_id_2']);
        //获取到第一级地区的数据
        $a_data['areaid_1']     = $this->area(0);
        //获取到第二级地区的数据
        $a_data['areaid_2']     = $this->area($a_goods['areaid_1']);

        $a_data['brand']    = $this->db->get('brand', '', 'brand_id,brand_name', '', 0, 9999);
        $a_data['type']     = $this->db->get('type', '', 'type_id,type_name', '', 0, 9999);
        $a_data['transport']= $this->db ->from('transport as a')
                                        ->join('transport_extend as b', ['a.id' => 'b.transport_id'])
                                        ->group_by('a.id')
                                        ->get('', '','a.id as id,a.title as title,b.sprice as sprice');
        return $a_data;
    }

     /**
     * [del_goods 删除商品表信息]
     * @return 
     */
    public function del_goods($del_goods) {
        //判断是否是数组，如果是循环删除图片并删除商品，如果不是删除图片
        if (is_array($del_goods)) {
            $a_goods = $this->db->where_in('goods_id',$del_goods)->get('goods','','goods_image,store_id');
            foreach ($a_goods as $key => $value) {
                $goods_image = '../7dugo_pc/upload/shop/store/goods/' . $value['store_id'] . '/' . $value['goods_image'];
                unlink($goods_image);
            }
            $a_res = $this->db->where_in('goods_id', $del_goods)->delete('goods');

            // 实例化搜索类
            $this->load->library('search');
            $this->search->project('7dugo');
            // 执行删除搜索里面的数据
            $this->search->delete($del_goods);
            return 'del';
        } else {
            $a_goods = $this->db->get_row('goods',['goods_id' => $del_goods] , 'goods_image,store_id');
            $goods_image = '../7dugo_pc/upload/shop/store/goods/' . $a_goods['store_id'] . '/' . $a_goods['goods_image'];
            unlink($goods_image);
            $a_res = $this->db->delete('goods',['goods_id' => $del_goods]);
            // 实例化搜索类
            $this->load->library('search');
            $this->search->project('7dugo');
            // 执行删除搜索里面的数据
            $this->search->delete($del_goods);  
            return 'del';      
        }
    }

    /**
     * [sold_off 下架商品表信息]
     * @return 
     */
    public function sold_off($sold_off){
        $a_sodld = $this->db->where_in('goods_id', $sold_off)->update('goods', ['goods_state' => 0]);
        // 实例化搜索类
        $this->load->library('search');
        $this->search->project('7dugo');
        // 执行下架搜索里面的数据
        foreach ($sold_off  as $ke => $val) {
            $a_data = [
                'goods_id' => $val,
                'goods_state' => 0
            ];
            $this->search->update($a_data);
        }
       return 'sold';
    }

    /**
     * [new_stock 上架商品表信息]
     * @return 
     */
    public function new_stock($new_stock){
        $a_new = $this->db->where_in('goods_id', $new_stock)->update('goods', ['goods_state' => 1]);
        // 实例化搜索类
        $this->load->library('search');
        $this->search->project('7dugo');
        // 执行上架搜索里面的数据
         foreach ($new_stock  as $ket => $va) {
            $a_data = [
                'goods_id' => $va,
                'goods_state' => 1
            ];
            $this->search->update($a_data);
        }
        return 'new'; 
    }

    /**
     * [classify 三级分类联动数据]
     * @return [array] [利用上级获取下去分类]
     */ 
    public function classify($pid = 0){
        $a_data = $this->db->get('goods_class', ['gc_parent_id' => $pid], 'gc_name,gc_id');
        return $a_data;
    }

    /**
     * [area 城市]
     * @return [array] [利用上级获取下去城市]
     */ 
    public function area($pid){
        $a_data = $this->db->get('area', ['area_parent_id' => $pid], 'area_id,area_name');
        return $a_data;
    }

    /**
     * [update_goods_list 查询需要修改商品的信息]
     * @param  [string] $goods_id [修改商品id]
     * @return [array]            [商品信息]
     */
    public function update_goods_list($goods_id){
        // 查询出所有商品的字段
        $s_field = "goods_id,a.goods_commonid,a.goods_name,a.goods_jingle,a.keywords,a.description,a.store_id,a.store_name,a.gc_id_1,a.gc_id_2,a.gc_id_3,a.brand_id,a.goods_price,a.goods_promotion_price,a.goods_promotion_type,a.goods_marketprice,a.goods_serial,a.goods_storage_alarm,a.goods_click,a.goods_salenum,a.goods_collect,a.goods_storage,a.goods_image,a.goods_state,a.goods_verify,a.areaid_1,a.areaid_2,a.transport_id,a.goods_commend,a.evaluation_good_star,a.evaluation_count,a.is_virtual,a.virtual_indate,a.virtual_limit,a.virtual_invalid_refund,a.is_fcode,a.is_appoint,a.is_presell,a.have_gift,a.is_own_shop,a.deductible_point,a.payment,a.goods_feng,b.goods_discount,b.goods_body,b.type_id";
        $a_data = $this->db ->from('goods as a')
                            ->join('goods_common as b',['a.goods_commonid' => 'b.goods_commonid'])
                            ->get_row('', ['goods_id' => $goods_id],$s_field);

        if (is_array($a_data)){
            return $a_data;
        } else {
            $this->error->show_error('没有这件商品',$this->router->url('goods'));
        }
    }

    private function uploadFile($fileInfo,$uploadPath='uploads',$flag=true,$allowExt=array('jpeg','jpg','png','gif'),$maxSize = 2097152){
    //判断错误号,只有为0或者是UPLOAD_ERR_OK,没有错误发生，上传成功
        if($fileInfo['error']>0){
            //注意！错误信息没有5
            switch($fileInfo['error']){
                case 1:
                    $mes= '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                    break;
                case 2:
                    $mes= '超过了HTML表单MAX_FILE_SIZE限制的大小';
                    break;
                case 3:
                    $mes= '文件部分被上传';
                    break;
                case 4:
                    $mes= '没有选择上传文件';
                    break;
                case 6:
                    $mes= '没有找到临时目录';
                    break;
                case 7:
                    $mes= '文件写入失败';
                    break;
                case 8:
                    $mes= '上传的文件被PHP扩展程序中断';
                    break;
                     
            }   
            exit($mes);
        }
        $ext=pathinfo($fileInfo['name'],PATHINFO_EXTENSION);
        // var_dump($ext);die;
        //$allowExt=array('jpeg','jpg','png','gif');
         
        //检测上传文件的类型
        if(! in_array($ext,$allowExt)){
            exit('非法文件类型'); 
        }
         
        //检测上传文的件大小是否符合规范
        //$maxSize = 2097152;//2M
        if($fileInfo['size']>$maxSize){
            exit('上传文件过大'); 
        }
         
        //检测图片是否为真实的图片类型
        //$flag=true;
        if($flag){
            if(!getimagesize($fileInfo['tmp_name'])){
                exit('不是真实的图片类型');  
            }   
        }
         
        //检测是否是通过HTTP POST方式上传上来
        if(!is_uploaded_file($fileInfo['tmp_name'])){
            exit('文件不是通过HTTP POST方式上传上来的'); 
        }
         
        //$uploadPath='uploads';
        //如果没有这个文件夹，那么就创建一个
        if(!file_exists($uploadPath)){
            mkdir( $uploadPath, 0777, true);
            chmod( $uploadPath, 0777 );
        }
        //新文件名唯一
        $uniName = substr(md5 ( uniqid( microtime(true),true) ),20).'.'.$ext;
        $destination = $uploadPath.'/'.$uniName;
        //@符号是为了不让客户看到错误信息
        if(! @move_uploaded_file($fileInfo['tmp_name'], $destination )){
            exit('文件移动失败'); 
        }
         
        //echo '文件上传成功';
        //return array(
        //  'newName'=>$destination,
        //  'size'=>$fileInfo['size'],
        //  'type'=>$fileInfo['type']
        //);
        return $uniName;
    }
}

?>

