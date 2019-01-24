<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\GoodModel good_model
 */
class Good_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();

        //实例化商品模型
//		$this->load->model('good_model');
        $this->good_model = \utils\Factory::getFactory('good');
    }

    public function goods_details()
    {
        //获取传过来的商品ID
        $s_good_id = $this->general->get('good_id');

        if ($s_good_id) {
            //查询评价总数等信息
            $this->good_model->evadetails($s_good_id);

            //调用商品详情页模型
            $this->good_model->goods_details($s_good_id);

            //查询出商品的面包屑
            $this->good_model->crumbs($s_good_id);

            //查询出评价商品
            $this->good_model->evaluate($s_good_id);
        } else {
            $this->error->error('非法访问', 'index');
        }

    }
}
