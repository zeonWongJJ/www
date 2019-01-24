<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Address_ctrl extends \utils\BaseController
{
    /**
     * 缓存key前缀
     * @var string
     */
    public $cache_key = 'user.address.';

    protected $repository = \repositories\AddressRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'contact_name'         => $this->request->post('contact_name', '', 'trim'),
            'contact_gender'       => $this->request->post('contact_gender', 0, 'intval'),
            'telephone_number'     => $this->request->post('telephone_number', '', 'trim'),
            'contact_house_number' => $this->request->post('contact_house_number', '', 'trim'),
            'contact_address_name' => $this->request->post('contact_address_name', '', 'trim'),
            'contact_lal'          => $this->request->post('contact_lal', '', 'trim')
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
            'contact_name'         => 'required',
            'contact_gender'       => 'required|number',
            'telephone_number'     => 'required',
            'contact_house_number' => 'required',
            'contact_address_name' => 'required',
            'contact_lal'          => 'lal',
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义
    public function setField()
    {
        return [
            'contact_name'           => '地址联系人'
            , 'contact_gender'       => '联系人性别'
            , 'telephone_number'     => '手机号码'
            , 'contact_house_number' => '联系门牌号'
            , 'contact_lal'          => '联系地址经纬度'
        ];
    }
}
