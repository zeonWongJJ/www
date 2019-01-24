<?php
/**
 * 封装Pay SDK
 * @author rusice <liruizhao970302@outlook.com>
 */
namespace utils;

use Yansongda\Pay\Gateways\Alipay;
use Yansongda\Pay\Gateways\Wechat;
use Yansongda\Pay\Pay as YPay;

/**
 * Class Pay
 * @package utils
 */
class Pay
{
    /** @var Alipay|Wechat 支付方式 */
    protected $pay_way;

    /** @var array 支付配置 */
    private $pay_config = [];

    /** @var Pay */
    private static $instance;

    /**
     * 快速实例化当前类
     * @param $payway
     * @return Pay
     */
    public static function getInstance($payway)
    {
        if (!self::$instance) {
            self::$instance = new self($payway);
        }

        return self::$instance;
    }

    /**
     * Pay constructor.
     * @param string $payway 传入支付方式
     */
    public function __construct($payway)
    {
        $this->initPayWay($payway);
    }

    /**
     * 初始化支付SDK
     * @param $payway
     */
    private function initPayWay($payway)
    {

        if (($payway == 'alipay' || $payway == 'wechat') && \is_callable([\Yansongda\Pay\Pay::class, $payway])) {
            $config_path = PROJECTPATH . '/config/config_pay.php';

            /** @noinspection PhpIncludeInspection */
            $config = include $config_path;

            if (isset($config[$payway]) && $config[$payway]) {
                $this->pay_config = $config[$payway];
                $this->pay_way    = \Yansongda\Pay\Pay::$payway($this->pay_config);
            } else {
                throw new \RuntimeException('支付配置未定义!');
            }
        }
    }

    /**
     * 转账
     * @param $transfer_info
     */
    public function transfer($transfer_info)
    {
        $result = $this->pay_way->transfer($transfer_info);
        var_dump($result);
    }

    /**
     * @param $way
     * @param $order
     * @return bool
     */
    public function __call($way, $order)
    {
        if (\is_callable([$this->pay_way, $way])) {
            return $this->pay_way->$way($order[0]);
        }

        return false;
    }
}
