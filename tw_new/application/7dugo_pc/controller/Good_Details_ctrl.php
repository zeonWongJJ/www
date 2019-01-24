<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\GoodModel good_model
 * @property \model\IndexModel index_model
 * @property \model\SearchModel search_model
 */
class Good_Details_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();

        //实例化商品模型
//		$this->load->model('good_model');
        $this->good_model   = \utils\Factory::getFactory('good');
        $this->index_model  = \utils\Factory::getFactory('index');
        $this->search_model = \utils\Factory::getFactory('search');
    }

    /**
     * [scm_detail_infos 统计出库累计数据]
     * @param  [type]  [description]
     * @return [type]        [description]
     */
    public function item()
    {

        // $this->load->model('search_model');
//		$this->load->model('index_model');
        $a_res = $this->index_model->category();
        // 组装数组中多出来的那个位置
        $a_view_data['cate'] = $this->index_model->arr($a_res);

        //获取传过来的商品ID
        $s_good_id_url = $this->router->get(1);
        $s_good_id     = urldecode(str_replace('+', '-', $s_good_id_url));

        //如果不存在goods_id参数

        if ($s_good_id) {
            //查询评价总数等信息 好评率 中评率 差评率
            $a_details = $this->good_model->goods_details($s_good_id);

            //如果参数没有查到数据
            if (empty($a_details)) {
                $this->error->show_warning("信息错误,请重新查询");
                die;
            }
            $a_view_data['k_goods_id'] = $s_good_id;

            $a_evadetails           = $this->good_model->evadetails($s_good_id);
            $a_view_data['pingjia'] = $a_evadetails;

            //调用商品详情页模型 start *******************

            //如果积分字段没有设置
            if ($a_details['goods_feng'] == 0) {
                $a_details['goods_feng'] = $a_details['goods_promotion_price'];
            }
            //切割 图片   原数据格式为   123.jpg,333.jpg
            $a_images = explode(",", $a_details['0']['details_image']);

            unset($a_details['0']['details_image']);

            $a_details['0']['details_image'] = $a_images;
            $a_details['0']['main_image']    = $a_details['0']['goods_image'];

            $a_view_data['shangpin'] = $a_details[0];

            // 商品详情信息 end ***************************

            //获取面包屑 start
            $a_bread                = $this->good_model->crumbs($s_good_id);
            $a_view_data['daohang'] = $a_bread[0];

            //获取左侧分类 start
//			$this->load->model('index_model');
            $a_res                 = $this->index_model->category();
            $a_view_data['fenlei'] = $a_res;

            //获取热销商品  start

            $a_hot_goods           = $this->good_model->get_order_max_goods($a_view_data['shangpin']['store_id']);
            $a_view_data['rexiao'] = $a_hot_goods;

            //获取评论信息 start
            $a_eva_goods = $this->good_model->evaluate($s_good_id);

            $a_view_data['pinglun'] = $a_eva_goods;

            //点击量+1
            //update student set score=score+1 where id = 1
            $this->db->set('goods_click', 'goods_click + 1', false);
            $this->db->update("goods", null, ['goods_id' => $s_good_id]);

            //店铺信息
            // $a_store_message=$this->good_model->get_store_message($a_view_data['shangpin']['store_id']);

            // var_dump($a_store_message);
            // die;
            // var_dump($a_view_data['shangpin']['store_id']);
            // die;
            $this->view->display('item', $a_view_data);
            // var_dump($a_details);
            //查询出商品的面包屑


            //查询出评价商品


        } else {
            $this->error->show_warning('非法访问', '/');

        }
        //echo '123';
    }


}
