<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class ServicePriceRule_ctrl extends BaseController
{
    public $repository = \repositories\ServicePriceRuleRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'service_id'   => (int)$this->router->get(1),
            'change_type'  => $this->request->post('change_type', '', 'trim'),
            'diff_type'    => $this->request->post('diff_type', 'INCR', 'trim'),
            'begin_at'     => $this->request->post('begin_at', '00:00'),
            'end_at'       => $this->request->post('end_at', '00:00'),
            'price_change' => $this->request->post('price_change', 0.00, 'floatval'),
            'choose_date'  => $this->request->post('choose_date', '', 'trim'),
        ];

        $data = [
            'insert' => $row,
            'update' => $row
        ];

        return $data[$method] ?? [];
    }

    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $row = [
            'service_id'   => 'required|number',
            'change_type'  => 'required|number',
            'diff_type'    => 'required',
            'begin_at'     => 'required',
            'end_at'       => 'required',
            'price_change' => 'required',
            'choose_date'  => 'required'
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    /**
     * 字段定义
     * @return array
     */
    public function setField(): array
    {
        return [
            'service_id'   => '服务ID',
            'change_type'  => '价格变动性质',
            'diff_type'    => '变动类型',
            'begin_at'     => '开始时间',
            'end_at'       => '结束时间',
            'price_change' => '变动金额',
            'choose_date'  => '时间'
        ];
    }
}
