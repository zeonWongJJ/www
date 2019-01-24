<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author -AUTHOR- <-EMAIL->
 */

class -className- extends \utils\BaseController
{
    [--cacheKey--]
    protected $repository = -repositoryClass-;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method):array
    {
        $data = [
            'insert'    =>  [
                // 写入操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim')
            ],
            'update'    =>  [
                // 更新操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
        ];

        return $data[$method] ?? [];
    }


    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method):array
    {
        $valid =  [
            'insert'    =>  [
                // 写入时的数据验证如：
                // 'role_name' =>  'required'
            ],
            'update'    => [
                // 更新时的数据验证如：
                // 'role_name' =>  'required'
            ]
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义
}
