<?php

class Appointment_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('appointment_model');
        $this->load->model('allow_model');
        $this->allow_model->is_login();
        $this->allow_model->is_allow();
    }

    /********************************* 预约办公室订单列表 *********************************/

    public function appointment_order()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $cate = $this->router->get(1);
            if (empty($cate)) {
                $cate = 1;
            }
            $state = $this->router->get(2);
            if (empty($state)) {
                $state = 9;
            }
            $a_data = $this->appointment_model->get_appointment_order($_SESSION['store_id'], $state, $cate);
            // 查询各状态下的订单数
            $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
            $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
            $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
            $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
            $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
            // 获取今日的订单数
            $today_start     = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $a_data['today'] = $this->appointment_model->get_appointment_today($_SESSION['store_id'], $today_start, $cate);
            // 获取门店所有办公室
            $a_data['office'] = $this->appointment_model->get_store_office($_SESSION['store_id']);
            $a_data['state']  = $state;
            $a_data['type']   = 1;
            $a_data['cate']   = $cate;
            if ($cate == 1) {
                $this->view->display('appointment_order2', $a_data);
            } else {
                $this->view->display('book_showlist', $a_data);
            }
        }
    }

    /****************************** 将订单状态改为待服务(接单) ****************************/

    public function appointment_getorder()
    {
        $appointment_id = trim($this->general->post('appointment_id'));
        $cate           = trim($this->general->post('cate'));
        $a_where        = [
            'appointment_id' => $appointment_id,
        ];
        $a_data         = [
            'appointment_state' => 3,
        ];
        $i_result       = $this->appointment_model->update_appointment($a_where, $a_data);
        if ($i_result) {
            // 重新获取各状态下的订单总数
            $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
            $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
            $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
            $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
            $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
            echo json_encode(['code' => 200, 'msg' => '接单成功', 'data' => $a_data]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '接单失败']);
        }
    }

    /**************************** 将订单状态改为服务中(开始服务) *************************/

    public function appointment_beginser()
    {
        $appointment_id = trim($this->general->post('appointment_id'));
        $cate           = trim($this->general->post('cate'));
        $a_where        = [
            'appointment_id' => $appointment_id,
        ];
        $a_data         = [
            'appointment_state' => 3,
        ];
        $i_result       = $this->appointment_model->update_appointment($a_where, $a_data);
        if ($i_result) {
            /*
            | --------------------------------------------------------------------------------------------
            | 将数据加入结算统计
            | 将数据加入移动店主统计
            | 将数据加入消费统计
            | --------------------------------------------------------------------------------------------
             */
            // 获取一条预约信息
            if ($cate == 1) {
                $a_this_order = $this->appointment_model->get_appointment_one($appointment_id);
                if ($a_this_order['appointment_state'] == 3) {
                    // 获取设置信息
                    $user_score_ratio      = $this->appointment_model->get_set_one('user_score_ratio');
                    $user_consume_ratio    = $this->appointment_model->get_set_one('user_consume_ratio');
                    $shopman_score_retio   = $this->appointment_model->get_set_one('shopman_score_retio');
                    $shopman_referee_ratio = $this->appointment_model->get_set_one('shopman_referee_ratio');
                    $score_tostore_ratio   = $this->appointment_model->get_set_one('score_tostore_ratio');
                    // 获取下单人的用户信息
                    $a_this_user = $this->appointment_model->get_user_one($a_this_order['user_id']);
                    // 判断是否有推荐人
                    if ($a_this_user['user_referee']) {
                        /*-------------------------------------------------------------------------------------------*/
                        // 判断用户的推荐人是否是移动店主且移动店主状态是否开启
                        $a_referee_row = $this->appointment_model->get_user_one($a_this_user['user_referee']);
                        if ($a_referee_row['is_shopman'] == 1 && $a_referee_row['shopman_state'] == 1) {
                            $order_commission = round(($shopman_referee_ratio / 100) * $a_this_order['appointment_price'], 2);
                        } else {
                            $order_commission = round(($user_consume_ratio / 100) * $a_this_order['appointment_price'], 2);
                        }
                        $score_tostore  = round(($score_tostore_ratio / 100) * $a_this_order['appointment_price'], 2);
                        $a_order_where  = [
                            'appointment_id' => $appointment_id,
                        ];
                        $a_order_update = [
                            'order_referee'    => $a_this_user['user_referee'],
                            'order_commission' => $order_commission,
                            'score_tostore'    => $score_tostore,
                        ];
                        // 更新订单信息
                        $this->appointment_model->update_appointment($a_order_where, $a_order_update);
                        /*-------------------------------------------------------------------------------------------*/
                        // 更新推荐人的积分和推荐人的推荐人消费总额
                        $a_referee_where = [
                            'user_id' => $a_this_user['user_referee'],
                        ];
                        if (empty($a_referee_row['user_refereeoffice'])) {
                            $user_refereeoffice = $order_id;
                        } else {
                            $user_refereeoffice = $a_referee_row['user_refereeoffice'] . ',' . $order_id;
                        }
                        $a_referee_update = [
                            'user_score'          => $a_referee_row['user_score'] + $order_commission,
                            'referee_consume'     => $a_referee_row['referee_consume'] + $a_this_order['appointment_price'],
                            'user_refereeoffice'  => $user_refereeoffice,
                            'referee_ordercount'  => $a_referee_row['referee_ordercount'] + 1,
                            'referee_officecount' => $a_referee_row['referee_officecount'] + 1,
                            'shopman_income'      => $a_referee_row['shopman_income'] + $order_commission,
                        ];
                        $i_result         = $this->appointment_model->update_user($a_referee_where, $a_referee_update);
                        /*-------------------------------------------------------------------------------------------*/
                        // 若更新成功则插入一条积分变动信息到'.$this->db->get_prefix().'points_log表
                        if ($i_result && $order_commission > 0) {
                            $a_points_log = [
                                'user_id'        => $a_this_user['user_referee'],
                                'user_name'      => $a_referee_row['user_name'],
                                'pl_type'        => 1,
                                'pl_variation'   => $order_commission,
                                'pl_score'       => $a_referee_row['user_score'] + $order_commission,
                                'pl_item'        => '推荐的人消费返积分',
                                'pl_description' => '用户' . $a_this_user['user_name'] . '消费' . $a_this_order['appointment_price'] . '元',
                                'pl_time'        => $_SERVER['REQUEST_TIME'],
                                'pl_code'        => 6,
                            ];
                            $this->appointment_model->insert_points_log($a_points_log);
                        }
                    } else {
                        $score_tostore  = round(($score_tostore_ratio / 100) * $a_this_order['appointment_price'], 2);
                        $a_order_where  = [
                            'appointment_id' => $a_this_order['appointment_id'],
                        ];
                        $a_order_update = [
                            'score_tostore' => $score_tostore,
                        ];
                        // 更新订单信息
                        $this->appointment_model->update_appointment($a_order_where, $a_order_update);
                    }
                    /*-------------------------------------------------------------------------------------------*/
                    // 判断用户自己是否是移动店主
                    if ($a_this_user['is_shopman'] == 1 && $a_this_user['shopman_state'] == 1) {
                        $add_user_score = round(($shopman_score_retio / 100) * $a_this_order['appointment_price'], 2);
                    } else {
                        $add_user_score = round(($user_score_ratio / 100) * $a_this_order['appointment_price'], 2);
                    }
                    // 更新自己的积分及消费金额
                    $a_where_thisuser = [
                        'user_id' => $a_this_order['user_id'],
                    ];
                    if (empty($a_this_user['user_selfoffice'])) {
                        $user_selfoffice = $a_this_order['appointment_id'];
                    } else {
                        $user_selfoffice = $a_this_user['user_selfoffice'] . ',' . $a_this_order['appointment_id'];
                    }
                    // 如果有推荐人则顺便更新给自己的推荐人的总提成字段 没有则直接更新消费金额和积分
                    if ($a_this_user['user_referee']) {
                        $a_thisuser_update = [
                            'user_consume'     => $a_this_user['user_consume'] + $a_this_order['appointment_price'],
                            'user_score'       => $a_this_user['user_score'] + $add_user_score,
                            'user_commission'  => $a_this_user['user_commission'] + $order_commission,
                            'user_selfoffice'  => $user_selfoffice,
                            'user_ordercount'  => $a_this_user['user_ordercount'] + 1,
                            'user_officecount' => $a_this_user['user_officecount'] + 1,
                        ];
                    } else {
                        $a_thisuser_update = [
                            'user_consume'     => $a_this_user['user_consume'] + $a_this_order['appointment_price'],
                            'user_score'       => $a_this_user['user_score'] + $add_user_score,
                            'user_selfoffice'  => $user_selfoffice,
                            'user_ordercount'  => $a_this_user['user_ordercount'] + 1,
                            'user_officecount' => $a_this_user['user_officecount'] + 1,
                        ];
                    }
                    $i_res = $this->appointment_model->update_user($a_where_thisuser, $a_thisuser_update);
                    /*-------------------------------------------------------------------------------------------*/
                    // 如果更新成功则插入一条积分变动信息
                    if ($i_res && $add_user_score > 0) {
                        $a_points_log = [
                            'user_id'        => $a_this_user['user_id'],
                            'user_name'      => $a_this_user['user_name'],
                            'pl_type'        => 1,
                            'pl_variation'   => $add_user_score,
                            'pl_score'       => $a_this_user['user_score'] + $add_user_score,
                            'pl_item'        => '消费返积分',
                            'pl_description' => '订单' . $a_this_order['appointment_number'] . '消费返积分',
                            'pl_time'        => $_SERVER['REQUEST_TIME'],
                            'pl_code'        => 5,
                        ];
                        $this->appointment_model->insert_points_log($a_points_log);
                    }
                    /*-------------------------------------------------------------------------------------------*/
                    // 当前月的起始时间戳
                    $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
                    // 判断结算数据表是否有当前月份的数据 有则获取并更新 无则创建
                    $a_account_row = $this->appointment_model->get_account_one($beginThismonth, $a_this_order['store_id']);
                    if ($a_account_row) {
                        // 为真则更新结算数据
                        $a_where_account = [
                            'account_id' => $a_account_row['account_id'],
                        ];
                        if (empty($a_account_row['office_order'])) {
                            $office_order = $a_this_order['appointment_id'];
                        } else {
                            $office_order = $a_account_row['office_order'] . ',' . $a_this_order['appointment_id'];
                        }
                        $a_data_account = [
                            'order_count'       => $a_account_row['order_count'] + 1,
                            'office_ordercount' => $a_account_row['office_ordercount'] + 1,
                            'money_count'       => $a_account_row['money_count'] + $a_this_order['appointment_price'],
                            'office_order'      => $office_order,
                            'month_score'       => $a_account_row['month_score'] + $score_tostore,
                            'office_money'      => $a_account_row['office_money'] + $a_this_order['appointment_price'],
                        ];
                        $this->appointment_model->update_account($a_where_account, $a_data_account);
                    } else {
                        // 为假则插入一条结算数据
                        $a_account_insert = [
                            'store_id'          => $a_this_order['store_id'],
                            'order_count'       => 1,
                            'office_ordercount' => 1,
                            'money_count'       => $a_this_order['appointment_price'],
                            'account_time'      => $beginThismonth,
                            'account_state'     => 0,
                            'office_order'      => $a_this_order['appointment_id'],
                            'month_score'       => $score_tostore,
                            'office_money'      => $a_this_order['appointment_price'],
                        ];
                        $this->appointment_model->insert_account($a_account_insert);
                    }
                    /*-------------------------------------------------------------------------------------------*/
                    // 获取一条门店信息
                    $a_store_this = $this->appointment_model->get_store_one($_SESSION['store_id']);
                    // 更新门店的成单数、门店销售总额、门店积分
                    $a_store_where  = [
                        'store_id' => $a_this_order['store_id'],
                    ];
                    $a_store_update = [
                        'store_amount'      => $a_store_this['store_amount'] + $a_this_order['appointment_price'],
                        'store_officeorder' => $a_store_this['store_officeorder'] + 1,
                        'store_score'       => $a_store_this['store_score'] + $score_tostore,
                        'store_allorder'    => $a_store_this['store_allorder'] + 1,
                        'accumulate_score'  => $a_store_this['accumulate_score'] + $score_tostore,
                    ];
                    $i_result_s     = $this->appointment_model->update_store($a_store_where, $a_store_update);
                    if ($i_result_s && $score_tostore > 0) {
                        // 插入一条门店积分变动信息
                        $a_insert_sc = [
                            'store_id'       => $a_this_order['store_id'],
                            'sc_type'        => 1,
                            'sc_score'       => $score_tostore,
                            'sc_time'        => $_SERVER['REQUEST_TIME'],
                            'sc_description' => '订单' . $a_this_order['appointment_number'] . '返积分',
                        ];
                        $this->appointment_model->insert_storescore($a_insert_sc);
                    }
                    /*-------------------------------------------------------------------------------------------*/
                    // 当前月的起始时间戳
                    $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
                    // 将自己的消费信息统计到用户消费统计表
                    $a_statistic_row = $this->appointment_model->get_statistic_one($a_this_order['user_id'], $beginThismonth);
                    // 有数据则修改 无数据则插入数据
                    if ($a_statistic_row) {
                        $a_where_sta = [
                            'sta_id' => $a_statistic_row['sta_id'],
                        ];
                        // 判断字段是否为空
                        if (empty($a_statistic_row['user_soffice'])) {
                            $user_soffice = $a_this_order['appointment_id'];
                        } else {
                            $user_soffice = $a_statistic_row['user_soffice'] . ',' . $a_this_order['appointment_id'];
                        }
                        $a_sta_update = [
                            'user_self'         => $a_statistic_row['user_self'] + $a_this_order['appointment_price'],
                            'user_sofficecount' => $a_statistic_row['user_sofficecount'] + 1,
                            'user_soffice'      => $user_soffice,
                            'user_selfsum'      => $a_statistic_row['user_selfsum'] + 1,
                        ];
                        $this->appointment_model->update_statistic($a_where_sta, $a_sta_update);
                    } else {
                        $a_sta_insert = [
                            'user_id'           => $a_this_order['user_id'],
                            'sta_time'          => $beginThismonth,
                            'user_self'         => $a_this_order['appointment_price'],
                            'user_sofficecount' => 1,
                            'user_soffice'      => $a_this_order['appointment_id'],
                            'user_selfsum'      => 1,
                        ];
                        $this->appointment_model->insert_statistic($a_sta_insert);
                    }
                    /*-------------------------------------------------------------------------------------------*/
                    // 判断用户是否有推荐人 如果有则判断推荐人本月是否有统计数据 有则更新 无则创建
                    if ($a_this_user['user_referee']) {
                        // 获取推荐人本月的消费统计表
                        $a_sta_referee = $this->appointment_model->get_statistic_one($a_this_user['user_referee'], $beginThismonth);
                        // 有统计数据则更新 没有则创建
                        if ($a_sta_referee) {
                            $a_stareferee_where = [
                                'sta_id' => $a_sta_referee['sta_id'],
                            ];
                            // 判断字段是否为空
                            if (empty($a_sta_referee['user_ooffice'])) {
                                $user_ooffice = $a_this_order['appointment_id'];
                            } else {
                                $user_ooffice = $a_sta_referee['user_ooffice'] . ',' . $a_this_order['appointment_id'];
                            }
                            $a_stareferee_data = [
                                'user_other'        => $a_sta_referee['user_other'] + $a_this_order['appointment_price'],
                                'user_oofficecount' => $a_sta_referee['user_oofficecount'] + 1,
                                'user_ooffice'      => $user_ooffice,
                                'user_othersum'     => $a_sta_referee['user_othersum'] + 1,
                            ];
                            $this->appointment_model->update_statistic($a_stareferee_where, $a_stareferee_data);
                        } else {
                            $a_stareferee_insertdata = [
                                'user_id'           => $a_this_user['user_referee'],
                                'sta_time'          => $beginThismonth,
                                'user_other'        => $a_this_order['appointment_price'],
                                'user_oofficecount' => 1,
                                'user_ooffice'      => $a_this_order['appointment_id'],
                                'user_othersum'     => 1,
                            ];
                            $this->appointment_model->insert_statistic($a_stareferee_insertdata);
                        }
                    }
                    /*-------------------------------------------------------------------------------------------*/
                }
            }
            /*
            | --------------------------------------------------------------------------------------------
            | 统计结束
            | --------------------------------------------------------------------------------------------
             */
            // 重新获取各状态下的订单总数
            $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
            $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
            $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
            $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
            $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
            // 如果为预约座位则单纯添加增加门店座位订单数量即可
            if ($cate == 2) {
                $a_store  = $this->appointment_model->get_store_one($_SESSION['store_id']);
                $a_uwhere = [
                    'store_id' => $_SESSION['store_id'],
                ];
                $a_udata  = [
                    'book_count'     => $a_store['book_count'] + 1,
                    'store_allorder' => $a_store['store_allorder'] + 1,
                ];
                $i_result = $this->appointment_model->update_store($a_uwhere, $a_udata);
            }
            echo json_encode(['code' => 200, 'msg' => '开始服务成功', 'data' => $a_data]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '开始服务失败']);
        }
    }

    /**************************** 将订单状态改为待评价(服务结束) *************************/

    public function appointment_overser()
    {
        $appointment_id = trim($this->general->post('appointment_id'));
        $cate           = trim($this->general->post('cate'));
        $a_where        = [
            'appointment_id' => $appointment_id,
        ];
        $a_data         = [
            'appointment_state' => 4,
            'officeseat_state'  => 0,
        ];
        $i_result       = $this->appointment_model->update_appointment($a_where, $a_data);
        if ($i_result) {
            $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
            $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
            $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
            $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
            $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
            echo json_encode(['code' => 200, 'msg' => '服务结束成功', 'data' => $a_data]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '服务结束失败']);
        }
    }

    /**************************** 将订单状态改为已取消(取消订单) *************************/

    public function appointment_cancel()
    {
        $appointment_id     = trim($this->general->post('appointment_id'));
        $cancel_reason      = trim($this->general->post('cancel_reason'));
        $cancel_description = trim($this->general->post('cancel_description'));
        $cate               = trim($this->general->post('cate'));
        // 获取一条预约信息
        $a_appointment = $this->appointment_model->get_appointment_one($appointment_id);
        // print_r($a_appointment);die;
        if ($a_appointment['appointment_state'] > 1 || $a_appointment['begin_time'] < time()) {
            echo json_encode(['code' => 400, 'msg' => '该订单不能取消了']);
            die;
        }
        // 初始值
        $isrefund = false;
        // 如果该订单已支付则进行退款操作
        if ($a_appointment['appointment_state'] > 0) {
            $isrefund = false;
            // 判断支付方式
            if ($a_appointment['pay_type'] == 1) {
                $this->load->library('alipay_wap');
                $a_data = [
                    // 商户订单号，商户网站订单系统中唯一订单号，必填
                    'out_trade_no'   => $a_appointment['appointment_number'],
                    // 请求退款金额，必填
                    'refund_amount'  => $a_appointment['actual_pay'],
                    'refund_reason'  => '订单退款',
                    // 退款交易号，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
                    'out_request_no' => 'tk' . date('YmdHis', time()),
                    'is_page'        => false,
                ];
                $result = $this->alipay_wap->refund($a_data);
                if ($result['code'] == 10000) {
                    $isrefund = true;
                }
            } else if ($a_appointment['pay_type'] == 2) {
                $a_data = [
                    // 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
                    'out_trade_no'   => $a_appointment['appointment_number'],
                    // 微信订单号
                    'transaction_id' => '',
                    // 商户退款单号（自定义的，单号唯一，用来识别退款记录的）
                    'out_refund_no'  => 'tk' . date('YmdHis', time()),
                    // 订单金额，不是退款金额，以分为单位,
                    'total_fee'      => $a_appointment['actual_pay'] * 100,
                    // 退款金额，以分为单位,
                    'refund_fee'     => $a_appointment['actual_pay'] * 100,
                    // 通知地址，请参考支付实例完成退款的通知处理
                    'notify_url'     => $this->router->url('wxrefund_notify'),
                ];
                $this->load->library('wxpay_h5', '', [$a_data]);
                $a_result = $this->wxpay_h5->refund();
                if ($a_result['return_code'] == 'SUCCESS') {
                    $isrefund = true;
                }
            } else if ($a_appointment['pay_type'] == 3) {
                $this->load->library('unionpay_geteway');
                $a_param  = [
                    // 订单号
                    'id_order' => $a_appointment['appointment_number'],
                ];
                $a_result = $this->unionpay_geteway->query($a_param);
                if ($this->unionpay_geteway->verify($a_result)) {
                    if ($a_result['origRespCode'] == '00') {
                        $a_param  = [
                            // 订单号
                            'id_order' => 'T' . $a_appointment['appointment_number'],
                            // 原消费的queryId，可以从查询接口或者通知接口中获取
                            'id_query' => $a_result['queryId'],
                            // （选填）交易金额，退货总金额需要小于或等于原消费
                            'amount'   => $a_appointment['actual_pay'] * 100,
                            // （选填）后台返回链接， 不传此参数将默认使用配置文件中的设置url
                            'url_back' => $this->router->url('unionpay_refund_notify'),
                        ];
                        $a_result = $this->unionpay_geteway->refund($a_param);
                        if ($this->unionpay_geteway->verify($a_result)) {
                            if ($a_result['respCode'] == '00') {
                                $isrefund = true;
                            }
                        }
                    }
                }
            }
        }
        // 退款成功则更改状态
        if ($isrefund == true) {
            $a_where  = [
                'appointment_id' => $appointment_id,
            ];
            $a_data   = [
                'appointment_state'  => 6,
                'officeseat_state'   => 0,
                'cancel_reason'      => $cancel_reason,
                'who_cancel'         => 2,
                'cancel_time'        => $_SERVER['REQUEST_TIME'],
                'cancel_description' => $cancel_description,
            ];
            $i_result = $this->appointment_model->update_appointment($a_where, $a_data);
            if ($i_result) {
                $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
                $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
                $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
                $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
                $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
                echo json_encode(['code' => 200, 'msg' => '取消订单成功', 'data' => $a_data]);
            } else {
                echo json_encode(['code' => 400, 'msg' => '取消订单失败']);
            }
        } else {
            echo json_encode(['code' => 400, 'msg' => '取消订单失败']);
        }
    }

    /************************************ 删除预约订单 ************************************/

    public function appointment_delete()
    {
        // $type为1代表单个删除 为2代表批量删除 [均为逻辑删除]
        $type = $this->general->post('type');
        if ($type == 1) {
            $appointment_id = $this->general->post('appointment_id');
            $a_where        = [
                'appointment_id' => $appointment_id,
            ];
            $a_data         = [
                'delete_store' => 0, //0代表已删除
            ];
            $i_result       = $this->appointment_model->update_appointment($a_where, $a_data);
            if ($i_result) {
                echo json_encode(['code' => 200, 'msg' => '删除成功']);
            } else {
                echo json_encode(['code' => 400, 'msg' => '删除失败']);
            }
        } else {
            $appointment_ids = $this->general->post('appointment_ids');
            $a_data          = [
                'delete_store' => 0, //0代表已删除
            ];
            $i_result        = $this->appointment_model->update_appointment_mony($appointment_ids, $a_data);
            if ($i_result) {
                echo json_encode(['code' => 200, 'msg' => '删除成功']);
            } else {
                echo json_encode(['code' => 400, 'msg' => '删除失败']);
            }
        }
    }

    /************************* 营业时间结束将所有预约改为已完成状态 ***********************/

    public function appointment_timing()
    {
        // 获取最近30小时所有非完成状态的办公室订单
        $a_data   = $this->appointment_model->get_appointment_timing();
        $a_data_u = [
            'officeseat_state'  => 0,
            'appointment_state' => 4,
            'complete_msg'      => '系统计划任务',
        ];
        foreach ($a_data as $key => $value) {
            $a_where_u = [
                'appointment_id' => $value['appointment_id'],
            ];
            $i_result  = $this->appointment_model->update_appointment($a_where_u, $a_data_u);
            if ($i_result) {
                // 如果执行成功则将该门店的订单量加1
                $a_store   = $this->appointment_model->get_store_one($value['store_id']);
                $a_where_s = [
                    'store_id' => $value['store_id'],
                ];
                $a_data_s  = [
                    'store_officeorder' => $a_store['store_officeorder'] + 1,
                    'store_allorder'    => $a_store['store_allorder'] + 1,
                ];
                $this->appointment_model->update_store($a_where_s, $a_data_s);
            }
        }
    }

    /************************************ 查询预约订单 ************************************/

    public function appointment_search()
    {
        // 接收关键词
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $keywords      = trim($this->general->post('keywords'));
            $search_office = trim($this->general->post('search_office'));
            $search_seat   = trim($this->general->post('search_seat'));
            $cate          = trim($this->general->post('cate'));
        } else {
            $cate          = $this->router->get(1);
            $search_office = $this->router->get(2);
            $search_seat   = urldecode($this->router->get(3));
            $keywords      = urldecode($this->router->get(4));
        }
        if (empty($keywords)) {
            $keywords = 9;
        }
        if (empty($search_seat)) {
            $search_seat = 'all';
        }
        $a_data = $this->appointment_model->get_appointment_search($_SESSION['store_id'], $keywords, $search_office, $search_seat, $cate);
        // 查询各状态下的订单数
        $a_data['state_one']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 1, $cate);
        $a_data['state_two']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 2, $cate);
        $a_data['state_three'] = $this->appointment_model->get_state_count($_SESSION['store_id'], 3, $cate);
        $a_data['state_five']  = $this->appointment_model->get_state_count($_SESSION['store_id'], 5, $cate);
        $a_data['state_six']   = $this->appointment_model->get_state_count($_SESSION['store_id'], 6, $cate);
        // 获取今日的订单数
        $today_start     = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $a_data['today'] = $this->appointment_model->get_appointment_today($_SESSION['store_id'], $today_start, $cate);
        // 获取门店所有办公室
        $a_data['office'] = $this->appointment_model->get_store_office($_SESSION['store_id']);
        // 获取座位
        if ($search_office != 'all') {
            $a_office       = $this->appointment_model->get_office_one($search_office);
            $a_data['seat'] = explode('-', $a_office['office_seatname']);
        }
        $a_data['state']         = 9;
        $a_data['type']          = 6;
        $a_data['keywords']      = $keywords;
        $a_data['search_office'] = $search_office;
        $a_data['search_seat']   = $search_seat;
        $a_data['cate']          = $cate;
        if ($cate == 1) {
            $this->view->display('appointment_order2', $a_data);
        } else {
            $this->view->display('book_showlist', $a_data);
        }
    }

    /********************************* 获取办公室的座位信息 ********************************/

    public function appointment_getseat()
    {
        $office_id = trim($this->general->post('office_id'));
        $a_data    = $this->appointment_model->get_office_one($office_id);
        if (!empty($a_data)) {
            $a_data = explode('-', $a_data['office_seatname']);
            echo json_encode(['code' => 200, 'msg' => '获取成功', 'data' => $a_data]);
        } else {
            echo json_encode(['code' => 400, 'msg' => '未设置座位', 'data' => '']);
        }
    }


    /********************************* 微信退款地址 ********************************/

    public function wxrefund_notify()
    {

    }

    /**************************************************************************************/

}
