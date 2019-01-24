<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * @property \model\IndexModel index_model
 */
class Index_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();

        //实例化模型
//		$this->load->model('index_model');
        $this->index_model = \utils\Factory::getFactory('index');
    }

    public function index()
    {
        // 首页导航分类
        $a_res = $this->index_model->category();
        // 组装数组中多出来的那个位置
        $a_data = $this->index_model->arr($a_res);

        $this->view->display('index', $a_data);
    }

    public function test()
    {
        $this->load->library('wxpay_pub');
        $a_param  = [
            // 商品描述，必填
            'body'         => '测试',
            // 商户订单号，必填
            'out_trade_no' => date('Ymdhis', time()) . rand(100, 999),
            // 标价金额，必填，标价金额，单位为分
            'total_fee'    => 1,
            // 异步通知URL，必填
            'notify_url'   => $this->router->url('notify'),
            // 支付成功后，跳转链接，选参，不填写则不跳转，注意，不能作为可靠依据，请以异步通知，或者订单查询结果为准
            //'url_success' => $this->router->url('notify'),
            // 取消支付或支付失败后，跳转链接，选参，不填写则不跳转，注意，不能作为可靠依据，请以异步通知，或者订单查询结果为准
            'url_fail'     => $this->router->url('b')
        ];
        $s_result = $this->wxpay_pub->pay($a_param);
        echo $s_result;
        // 这里是支付链接
        echo '<button onclick="wxpay()" >立即支付</button>';

    }

    // 同步通知
    public function notify()
    {
        // 注意，异步通知，这里引用了另外一个类
        $this->load->library('wxpay_pub_notify');

        // true表示需要输出签名，默认是参数是true，适用于下面的方法一
        $this->wxpay_pub_notify->Handle(true);

        // 验证数据安全方法一：(签名验证)
        $b_result = $this->wxpay_pub_notify->get_verify_result();
        print_r($b_result);
        exit;


        $this->load->library('unionpay_geteway');
        print_r($this->general->post());
        // 安全验证，确认是不是支付宝返回的正确数据
        if ($this->unionpay_geteway->verify($this->general->post())) {
            // 验证成功，证实是支付宝返回的正确数据
            // 把订单的状态改为已经付款成功
            // 进行交易相关的业务逻辑处理
            //file_put_contents('./1.txt', print_r($_GET, true));
            echo '验证成功';
        } else {
            // 没有通过验证，肯定数据有问题，不做任何处理
            echo '验证失败';
        }
    }

    public function qrcode()
    {
        $this->load->library('alipay_wap');

        // 安全验证，确认是不是支付宝返回的正确数据
        if ($this->alipay_wap->verify($_GET)) {
            // 验证成功，证实是支付宝返回的正确数据
            // 把订单的状态改为已经付款成功
            // 进行交易相关的业务逻辑处理
            file_put_contents('./2.txt', print_r($_GET, true));
        } else {
            // 没有通过验证，肯定数据有问题，不做任何处理
        }
    }
}
