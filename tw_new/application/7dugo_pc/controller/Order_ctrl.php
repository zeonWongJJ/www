<?php

/**
 * 订单控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */
class Order_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'pay'
        , 'pay_return'
    ];

//    protected $repository = \repositories\OrderRepository::class;

    /**
     * 发起订单支付
     * @router http://server.name/order.pay
     * @throws Exception
     */
    public function pay()
    {
//        $token = $_GET['token'] ?? '';

//        if ($token) {
//            $token = str_replace('%2B', '+', $token);
        /** @var \model\TokenModel $token_model */
//            $token_model = \utils\Factory::getFactory('token');
//            $token_model->parseToken($token);

        $data['order_sn']   = $this->request->get('order_sn', '', 'trim');
        $data['order_sign'] = $this->request->get('order_sign', '', 'trim');

        $this->validate($data, [
            'order_sn'   => 'required',
            'order_sign' => 'required'
        ]);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        return $order_model->payOrder(...array_values($data));
//        }
    }

    /**
     * 订单支付结果同步返回
     * @router http:://server.name/order.pay.return
     */
    public function pay_return()
    {
        echo '交易处理中，请不要关闭页面...';

        $data['out_trade_no'] = $this->request->get('out_trade_no', '', 'trim');
        $data['trade_no']     = $this->request->get('trade_no', '', 'trim');

        $database = new \utils\Medoo([
            'database_type' => 'mysql',
            'database_name' => 'wofei',
            'server'        => 'localhost',
            'username'      => 'wofei',
            'password'      => 'bbJZSw8Lxq8Th6MY',
            'charset'       => 'utf8',
            'prefix'        => 'wf_',
        ]);

        $order_info = $database->get(get_table('order'), '*', ['order_sn' => $data['out_trade_no']]);

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        try {
            // 如果是微信回调
            if ('wechat' == $this->router->get(1)) {
                if (is_weixin()) {
                    $this->load->library('wxpay_pub'); // 微信公众号打开，是公众号支付
                    $result = $this->wxpay_pub->query([
                        'transaction_id' => $data['out_trade_no']
                    ]);
                    if ($result['return_code'] === 'SUCCESS'
                        && $result['result_code'] === 'SUCCESS'
                        && $result['trade_state'] === 'SUCCESS'
                        && isset($result['trade_state'])
                        && $result['trade_state'] === 'SUCCESS'
                    ) {
                        $order_model->orderCallBack($data['out_trade_no']);
                    } else {
                        throw new RuntimeException($result['return_msg']);
                    }
                } else {
                    $this->load->library('wxpay_h5', '', [['out_trade_no' => $data['out_trade_no']]]);
                    $result = $this->wxpay_h5->query();
                    /** @noinspection TypeUnsafeComparisonInspection PhpUnreachableStatementInspection */
                    if ($result['return_code'] == 'SUCCESS' && $result['return_msg'] == 'OK') {
                        $order_model->orderCallBack($data['out_trade_no']);
                    } else {
                        throw new RuntimeException($result['return_msg']);
                    }
                }
            } elseif ('alipay' == $this->router->get(1)) {
                // 支付宝回调
                $order_model->orderCallBack($data['out_trade_no']);
            } elseif ('bankcard' == $this->router->get(1)) {
                $this->load->library('unionpay_geteway');
                $a_param  = [
                    'id_order' => $data['out_trade_no']
                ];
                $a_result = $this->unionpay_geteway->query($a_param);
                if ($this->unionpay_geteway->verify($a_result)) {
                    if ($a_result['origRespCode'] == '00') {
                        $order_model->orderCallBack($data['out_trade_no']);
                    } elseif (in_array($a_result['origRespCode'], ['03', '04', '05'], true)) {
                        throw new RuntimeException('交易处理中');
                    } else {
                        throw new RuntimeException('交易失败');
                    }
                } else {
                    throw new RuntimeException('验证签名失败');
                }
            }
//            header('Location:http://jiajie-touch.7dugo.com/orderDetails?order_sn=' . $data['out_trade_no']);
            /** @noinspection TypeUnsafeComparisonInspection */
            if (3 == $order_info['order_type']) {
                // 充值订单转跳用户钱包页面
                header('Location: http://jiajie-touch.7dugo.com/goto.php?route=balance');
            } else {
                header('Location: http://jiajie-touch.7dugo.com/redirectOrder.php?order_sn=' . $data['out_trade_no']);
            }
        } catch (Exception $e) {
            $order_model->rollbackOrder($data['out_trade_no']);
//            header('location:http://jiajie-touch.7dugo.com/myfb');
            header('location:http://jiajie-touch.7dugo.com/goto.php?route=orders');
        }
    }
}
