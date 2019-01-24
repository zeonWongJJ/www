<?php
/**
 * 用户模块
 */
class Good_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
        $this->prefix=$this->db->get_prefix();
    }
	
// 	SELECT a.goods_id, GROUP_CONCAT(c.goods_image) AS details_image
// FROM tw_goods a
// 	LEFT JOIN tw_goods_common b ON a.goods_commonid = b.goods_commonid
// 	LEFT JOIN tw_goods_images c ON b.goods_commonid = c.goods_commonid
// WHERE a.goods_id = 1
// GROUP BY a.goods_id;

	//查询出商品的详情
	public function goods_details($s_good_id){
		$a_where = ['goods_id' => $s_good_id,'a.goods_verify'=>'1']; 
		$s_field = 'a.goods_marketprice,a.goods_state,a.goods_freight,b.goods_body,d.brand_class,d.brand_name,GROUP_CONCAT(c.goods_image) AS details_image,a.goods_id,a.goods_name,a.goods_jingle,a.description,a.store_id,a.store_name,a.goods_price,a.goods_promotion_price,a.goods_marketprice,a.goods_image,a.goods_feng,a.have_gift';
		$a_order=['c.is_default' => 'desc', 'c.goods_image_sort' => 'asc'];
		$a_data  = $this->db->from("goods as a")
							->join('goods_common as b',['a.goods_commonid'=>'b.goods_commonid'])
							->join('goods_images as c',['b.goods_commonid'=>'c.goods_commonid'])
							->join('brand as d',['a.brand_id'=>'d.brand_id'])
							->select($s_field,false)
							->where($a_where)
							->group_by("a.goods_id")
							->order_by($a_order)
							->get();
		return $a_data;
	}

	//查询出商品的面包屑
	public function crumbs($s_good_id){
		$a_where = 'a.goods_id = '.$s_good_id.'
					AND a.gc_id = d.gc_id
					and d.gc_parent_id = c.gc_id
					and c.gc_parent_id = b.gc_id';

		$s_field_name = 'b.gc_id as one_id,c.gc_id as two_id,d.gc_id as three_id,b.gc_name AS one_name, c.gc_name AS two_name, d.gc_name AS three_name, a.gc_id_1, a.gc_id_2
			, a.gc_id_3, a.goods_name';

		$table='goods as a,goods_class as b,goods_class as c,goods_class as d';

		$a_result=$this->db->from($table)
				 ->select($s_field_name,false)
				 ->group_by('d.gc_id')
				 ->where($a_where)
				 ->get();

				 
		// $a_res['goods_name'] = $a_data['goods_name'];
		return $a_result;
	}

	//查看评价页面的其他信息
	public function evadetails($s_good_id){
		$a_where = ['geval_goodsid' => $s_good_id];
		$s_field = 'sum(geval_scores=1) as eve_one,sum(geval_scores=2) as eve_two,sum(geval_scores=3) as eve_three,sum(geval_scores=4) as eve_four,sum(geval_scores=5) as eve_five,count(geval_image) as photo_num';
		$a_data  = $this->db
						->select($s_field, false)
						->get_row('evaluate_goods',$a_where);

		$a_data['good'] = intval($a_data['eve_five']) + intval($a_data['eve_four']);
		$a_data['milieu'] = intval($a_data['eve_three']);
		$a_data['faute'] = intval($a_data['eve_one']) + intval($a_data['eve_two']);

		//统计所有评价数目
		$a_data['all_num']=$a_data['good'] + $a_data['milieu'] +$a_data['faute'];

		//如果有评价，统计好评率
		if ( $a_data['all_num']==0){

		$a_data['good_pie']=100;
		$a_data['milieu_pie']=100;
		$a_data['faute_pie']=100;
		}else{

		$a_data['good_pie']=round( ($a_data['good'] / $a_data['all_num'])*100 ,0);
		$a_data['milieu_pie']=round( ($a_data['milieu'] / $a_data['all_num'])*100 ,0);
		$a_data['faute_pie']=round( ($a_data['faute'] / $a_data['all_num'])*100 ,0);

		}
		return $a_data;
	}
	
	//查询评价数据并进行分页
	public function evaluate($s_good_id, $s_class = false){
		//条件
		$a_where = ['geval_goodsid' => $s_good_id];
		//晒图评价
		if($s_class == 1){
			$a_where_or = ['geval_image !=' => ''];
		} else if ($s_class == 2){
			$a_where_or = ['geval_scores' => '4', 'geval_scores' => '5'];
		} else if ($s_class == 3){
			$a_where_or = ['geval_scores' => '3'];
		} else if ($s_class == 4){
			$a_where_or = ['geval_scores' => '2', 'geval_scores' => '1'];
		} else {
			$a_where_or = [];
		}
		$s_field = 'member_name,time_finnshed,geval_goodsimage,geval_scores,geval_image,geval_content,geval_time_create,geval_storename,geval_storeid,geval_remark,geval_explain';
		$a_order = ['geval_time_create' => 'asc'];

		//获取参数
		// $i_page = $this->router->get(1);
		// empty($i_page)?$i_page = 1:$i_page;

		//实例化分页类
		// $this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->from('evaluate_goods')
							->where($a_where)
						    ->get_total('',$a_where);
					
		//调用分页运算函数
		// $a_pdata = $this->pages->get($i_total, $i_page, 5);
		// $this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data = $this->db->from('evaluate_goods')
								   ->join('member',[$this->db->get_prefix('member') . '.member_id' => $this->db->get_prefix('evaluate_goods') . '.geval_frommemberid'])
								   ->join('order',[$this->db->get_prefix('order') . '.order_id' => $this->db->get_prefix('evaluate_goods') . '.geval_orderid'])
								   ->where($a_where)
								   ->order_by($a_order)
								   ->group_by("geval_id")
								   ->select($s_field,false)
								   ->get();
		// var_dump($a_data);
		// echo $this->db->get_Sql();
		// die;
		// var_dump($a_data);
		// die;
		//处理图片	 start

		//有图片的评论数

		$have_pic_common_num=0;
		foreach ($a_data as $key => $value) {

			if( !empty($value['geval_image']) ){
				$a_data[$key]['img_type']="photo";

				$have_pic_common_num++;
				//分割图像路径
				$a_data[$key]['show_explode_img']=explode(",",$value['geval_image']);
			}
				//多久后评论的   取绝对值
			    $a_data[$key]['time_diff']=abs(round( ( ($value['geval_time_create'] - $value['time_finnshed'])/60/60/24),0));
			    $a_data[$key]['geval_time_create']=date("Y-m-d H:i",$value['geval_time_create']);

			    if($value['geval_scores']>3){
				  $a_data[$key]['pl_type']="good";
			    }else if($value['geval_scores']==3){
				  $a_data[$key]['pl_type']="milieu";
			    }else{
				  $a_data[$key]['pl_type']="faute";
			    }

		}

		$a_result['details']=$a_data;

		$a_result['all_num']=$i_total;
		$a_result['have_pic_common_num']=$have_pic_common_num;

		//处理图片  end

		//分页
		// $a_data['page'] = $this->pages->link_style_one($this->router->url('good-', [], false, false));	
		return $a_result;
	}

    /**
     * [获取热销与积分]
     * @param  [int]  [store  店铺ID]
     * @return [array][$a_order_goods 热销的商品]
     */
	public function get_order_max_goods($store_id){
		$a_where=['a.store_id'=>$store_id];
		$s_table='order_goods as a';
		$s_field='a.store_id,b.goods_promotion_price,b.goods_name,b.goods_image,a.goods_id, COUNT(a.goods_id) AS count_num';
		$a_order=['count_num'=>'desc'];

		//查询该店铺的销量最好的10件商品
		$result=$this->db->from($s_table)
						 ->join('goods as b',['a.goods_id'=>'b.goods_id'])
						 ->select($s_field,false)
						 ->where($a_where)
						 ->group_by("a.goods_id")
						 ->order_by($a_order)
						 ->limit(0,10)
						 ->get();
		//如果有意外情况，随便拿10件				 
		if(empty($result)){
						 $result=$this->db->from($s_table)
						 ->join('goods as b',['a.goods_id'=>'b.goods_id'])
						 ->select($s_field,false)
						 ->group_by("a.goods_id")
						 ->order_by($a_order)
						 ->limit(0,10)
						 ->get();
		}

		foreach($result as $key=>$value){
			$name=$value['goods_name'];
			$result[$key]['goods_name']=mb_substr($name,0,10,'utf-8');
			$name_length=mb_strlen($name,"utf8");
			if($name_length>10){
				$result[$key]['goods_name']=$result[$key]['goods_name'].' ..';
			}
		}

		return $result;

	}

    /**
	     * [获取店铺评分信息]
	     * @param  [int]  [store_id]
	     * @return [array][description]
	     */
	// public function get_store_message($store_id){
	// 		$result=$this->db->from("evaluate_store")
	// 			 ->where(['seval_storeid'=>$store_id])
	// 			 ->select("seval_desccredit,seval_servicecredit,seval_deliverycredit")
	// 			 ->get();
	// 		return $result;
	// }

}

?>

