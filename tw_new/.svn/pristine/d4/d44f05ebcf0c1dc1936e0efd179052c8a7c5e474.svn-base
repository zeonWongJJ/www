<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class MSMTemplate_ctrl extends BaseController
{
    protected $repository = \repositories\MSMTemplateRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $data = [
            'insert' => [
                // 'role_name' =>  $this->request->post('role_name', '', 'trim')
            ],
            'update' => [
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
        ];

        return $data[$method] ?? [];
    }
}
