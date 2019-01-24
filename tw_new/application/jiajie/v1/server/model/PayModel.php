<?php
/**
 * 交易模型类，处理交易相关逻辑
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use utils\BaseModel;
use utils\Pay;

class PayModel extends BaseModel
{
    const ALIPAY = 'alipay';
    const WECHAT = 'wechat';
    const BANKCARD = 'bankcard';
    const DEDCUTIBLE = 'deductible';
    /**
     * 交易SDK实例化
     */
//    protected $pay_way; // 支付宝支付
    protected $pay; // 微信支付
    /** @var array 交易参数数组 */
    protected $order = []; // 银行卡支付

    /**
     * 设置交易SDK
     * @param $pay_way
     * @return PayModel
     */
    public function setPayWay($pay_way)
    {
        $this->pay = $pay_way;
//        $this->pay_way = Pay::getInstance($pay_way);
        return $this;
    }

    /**
     * 执行支付
     * @param array $order
     * @return
     */
    public function pay(array $order)
    {
        /** @noinspection TypeUnsafeComparisonInspection */
        if ($this->pay == 'wechat') { // 微信支付
            $data = [
                'body'             => $order['body'],
                'out_trade_no'     => $order['out_trade_no'],
                'total_fee'        => $order['total_fee'],
                'spbill_create_ip' => get_client_ip(),
                'notify_url'       => 'http://jiajie-server.7dugo.com/order.pay.ret-' . self::WECHAT, // 异步通知地址
            ];
            if (is_weixin()) { // 公众号支付处理
                app('load')->library('wxpay_pub');
                $data['url_fail'] = $data['url_success'] = 'http://jiajie-touch.7dugo.com/goto.php?route=orders';
                $result           = $this->wxpay_pub->pay($data);
                echo <<<EOF
{$result}
<script type="text/javascript">
    wxpay();
</script>
EOF;
            } else { // APP处理
                app('load')->library('wxpay_h5');
                $result = $this->wxpay_h5->pay($data);
                header('location:' . $result['mweb_url'] . '&redirect_url=' . urlencode('http://jiajie-touch.7dugo.com/goto.php?route=orders')); // 拉起支付
            }
        } /** @noinspection TypeUnsafeComparisonInspection */ elseif ($this->pay == 'bankcard') { // 银联支付
            app('load')->library('unionpay_geteway');
            $a_param = [
                // 订单号
                'id_order'  => $order['out_trade_no'],
                // 订单金额，以分为单位
                'amount'    => $order['total_fee'],
                'url_front' => 'http://jiajie-server.7dugo.com/order.pay.ret-' . self::BANKCARD . '?out_trade_no=' . $order['out_trade_no'],
                'url_back'  => 'http://jiajie-server.7dugo.com/order.pay.ret-' . self::BANKCARD . '?out_trade_no=' . $order['out_trade_no'],
            ];
            /** @noinspection PhpUndefinedFieldInspection */
            $a_result = $this->unionpay_geteway->pay($a_param);
            echo $a_result;
        } else { // 支付宝
            app('load')->library('alipay_wap');
            $order['notify_url'] = 'http://jiajie-server.7dugo.com/order.pay.ret-' . self::ALIPAY;
            $order['return_url'] =  'http://jiajie-touch.7dugo.com/goto.php?route=orders';
            echo $this->alipay_wap->pay($order);
        }
    }

    /**
     * 执行转账
     * @param array $transfer
     * @return bool|array
     * @throws \Exception
     */
    public function transfer(array $transfer)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }


        if ($this->pay == 'alipay') {
            // 支付宝转账
            app('load')->library('alipay_wap');
            $a_data   = [
                'out_biz_no'      => $transfer['out_biz_no'],
                'payee_account'   => $transfer['payee_account'],
                'amount'          => $transfer['amount'],
                'payee_real_name' => $transfer['payee_real_name'],
                'remark'          => '余额提现',
                // 设置是跳转到支付宝页面，还是返回执行结果，默认为前者，这里我们要设置为获取执行结果
                'is_page'         => false
            ];
            $a_result = $this->alipay_wap->transfer($a_data);

            if ($a_result['code'] == 10000) {
                return true;
            }
            $this->db->insert('withdraw_logs', [
                'user_id'       => $user_info->user_id,
                'error_content' => $a_result['sub_msg'],
                'error_code'    => $a_result['code'],
                'sub_code'      => $a_result['sub_code'],
                'wdtime'        => date('Y-m-d H:i:s'),
                'w_type'        => 1
            ]);
            return $a_result;
        }


        // 关于微信转账时，提示产品权限验证失败,请查看您当前是否具有该产品的权限：https://blog.csdn.net/haibo0668/article/details/78783005
        if ($this->pay == 'wechat') {
            // 微信转账
            $a_datas = [
                // 商品描述, 必填
                'openid'           => $transfer['openid'],
                // 商户订单号, 必填
                'partner_trade_no' => $transfer['partner_trade_no'],
                // 标价金额,以分为单位, 必填
//                 'total_fee' => $transfer['payee_account'],
                'amount'           => $transfer['amount'],
                // 终端IP, 必填
                'spbill_create_ip' => app('general')->get_ip(),
                'check_name'       => 'NO_CHECK',
                'desc'             => '积分提现',
                'nonce_str'        => random_int(100000, 999999),
            ];
            app('load')->library('wxpay_h5');
            $result = $this->wxpay_h5->pay_pocket($a_datas);
            if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                return true;
            }
            $this->db->insert('withdraw_logs', [
                'user_id'       => $user_info->user_id,
                'error_content' => $result['err_code_des'],
                'error_code'    => $result['result_code'],
                'sub_code'      => $result['err_code'],
                'wdtime'        => date('Y-m-d H:i:s'),
                'w_type'        => 3,
            ]);
            return ['msg' => $result['err_code_des']];
        }

        // 银行卡转账
        if ($this->pay == 'bankcard') {
            app('load')->library('unionpay_transfer');
            $transfer['trans_amt'] = (string)$transfer['trans_amt'];
            $a_result              = $this->unionpay_transfer->pay($transfer);

            if ($a_result['responseCode'] == '0000') {
                if ($a_result['stat'] == 's' || $a_result['stat'] == 2 || $a_result['stat'] == 3 || $a_result['stat'] == 4 || $a_result['stat'] == 5 || $a_result['stat'] == 7 || $a_result['stat'] == 8) {
                    return true;
                }
            }

            switch ((string)$a_result['responseCode']) {
                case '0100':
                    $msg = '商户提交的字段长度、格式错误';
                    break;
                case '0101':
                    $msg = '商户验签错误';
                    break;
                case '0102':
                    $msg = '手续费计算出错';
                    break;
                case '0103':
                    $msg = '商户备付金帐户金额不足';
                    break;
                case '0104':
                default:
                    $msg = '操作拒绝';
                    break;
                case '0105':
                    $msg = '待查询，重复交易';
                    break;
            }

            $this->db->insert('withdraw_logs', [
                'user_id'       => $user_info->user_id,
                'error_content' => $msg,
                'error_code'    => $a_result['responseCode'],
                'sub_code'      => $a_result['responseCode'],
                'wdtime'        => date('Y-m-d H:i:s'),
                'w_type'        => 2,
            ]);

            return compact('msg');
        }
    }
}
