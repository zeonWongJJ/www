<?php

class Config_ctrl extends \utils\BaseController
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'system.config.';

    protected $repository = \repositories\ConfigRepository::class;

    public function getData()
    {
        return [
            'config_key'      => $this->request->post('config_key', '', 'trim'),
            'config_info'     => $this->request->post('config_info', '', 'trim'),
            'config_enable'   => $this->request->post('config_enable', 1, 'intval'),
            'config_value'    => $this->request->post('config_value', '', 'trim'),
            'config_var_type' => $this->request->post('config_var_type', 'string', 'trim'),
            'config_remark'   => $this->request->post('config_remark', 'string', 'trim'),
        ];
    }

    public function valid()
    {
        return [
            'config_key'      => 'required',
            'config_enable'   => 'required',
            'config_info'     => 'required',
            'config_value'    => 'required',
            'config_var_type' => 'required',
        ];
    }

    /**
     * 提交设置
     * @router http://server.name/config.setting
     */
    public function setting()
    {
        $config_key   = $this->router->get(1);
        $config_value = $this->request->post('config_value', '', 'trim');

        $config_path = get_table('config');
        if (!$config_key || $config_key === 'admin') {
            $settings = $this->request->post('item/a', [], 'trim');
            if ($settings['default_service_remuneration'] + $settings['default_shop_division'] + $settings['default_platform_actual_income'] > 100) {
                return $this->error('默认分配策略出错，不能大于100%');
            }
            foreach ($settings as $key => $value) {
                if ($key === 'default_star_rated_return') {
                    // 设置默认各星级对应的订单结算策略时，判断五星的分配百分比是否超过最大的分配策略
                    $default_service_remuneration = $settings['default_service_remuneration']; // 设置的最大的分配策略
                    $temp                         = explode('-', $value);
                    sort($temp); // 避免恶意设值，令数组进行一次升序排序
                    if (end($temp) > $default_service_remuneration) {
                        return $this->error('五星的分配百分比超过最大的分配策略');
                    }
                    $settings['default_star_rated_return'] = implode('-', $temp); // 因为上面已经sort过数组，这里重新组合一次
                }
                $this->db->update($config_path, ['config_value' => $value], ['config_key' => $key]);
            }
            return $this->success(false);
        } else {
            $config = $this->db->get_row($config_path, compact('config_key'));
            if (!$config) {
                return $this->error('修改配置key不存在');
            }
            $this->db->update($config_path, compact('config_value'), ['config_key' => $config['config_key']]);
        }

        return $this->success(false);
    }
}
