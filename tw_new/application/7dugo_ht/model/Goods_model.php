<?php
/**
 * 用户模块
 */
class Goods_model extends TW_Model {
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
    	$a_data = $this->db->get('goods', '', $s_field,'',0,3000);

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
    public function update_goods(){
    	
    	
    }

    /**
     * [add_goods 修改商品表信息]
     * @return [array] [需要修改的值]
     */
    public function add_goods(){
        
        
    }

    /**
     * [add_goods_list 添加数据前需要展示的一些数据]
     * @return [array] [展示的一些数据]
     */
    public function add_goods_list(){
        echo '123';die;
        // $a_data['store'] = $this->db->get('store','','store_id,store_name');
        // var_dump($a_data['store']);die;
        // return $a_data;
    }
}

?>

