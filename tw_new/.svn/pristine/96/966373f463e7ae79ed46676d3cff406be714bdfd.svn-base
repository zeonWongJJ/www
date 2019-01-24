<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

class ConfigModel extends BaseModel
{
    const CACHE_KEY = 'config.item.';

    /**
     * 获取配置项
     * @param $key
     * @param null $default
     * @return mixed
     */
    public static function getItem($key, $default = null)
    {
        $self = new self();
        $config_val = $self->cache(self::CACHE_KEY . $key);
        if (!$config_val) {
            $config = $self->db->get_row(get_table('config'), ['config_key' => $key], 'config_value');
            if (!$config) {
                return $default;
            }
            $config_val = $config['config_value'];
            $self->cache(self::CACHE_KEY . $key, $config_val, 3600);
        }
        return $config_val;
    }
}
