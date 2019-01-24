<?php

class Home_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('home_model');
        $this->load->model('store_model');
    }

    /******************************************* 首页 *******************************************/

    public function nindex()
    {
        // 获取两条热门动态
        $a_data['mood'] = $this->home_model->get_mood_two();
        // 获取最近的一条公告信息
        $a_data['notice'] = $this->home_model->get_notice_one();
        // 验证是否有未读的动态
        if (isset($_SESSION['user_id'])) {
            $a_data['moodmsg'] = $this->home_model->get_mood_msgcount($_SESSION['user_id']);
        } else {
            $a_data['moodmsg'] = 0;
        }
        // 获取所在城市的天气
        // $this->load->library('map_gaode');
        // $a_result =$this->map_gaode->ip_to_address($this->general->get_ip());
        // $a_result =$this->map_gaode->weather($a_result['adcode']);
        // if ($a_result['infocode'] == 10000) {
        // 	$a_data['weather'] = $a_result['lives'][0];
        // } else {
        // 	$a_data['weather'] = array();
        // }
        // 获取产品时间段
        $a_data['time'] = $this->home_model->get_time_all();
        // 获取第一个时间段的产品
        if (!empty($a_data['time'])) {
            $a_product = $this->home_model->get_product_five();
            if (!empty($a_product)) {
                foreach ($a_product as $key => $value) {
                    if (!empty($value['supply_time'])) {
                        $this_cates = explode(',', $value['supply_time']);
                        if (!in_array($a_data['time'][0]['time_id'], $this_cates)) {
                            unset($a_product[$key]);
                        } else {
                            $value['gourl'] = $this->router->url('item', ['pid' => $value['proid_id_1'], 'product_id' => $value['product_id'], 'store_id' => '0']);
                            $new_data[]     = $value;
                        }
                    } else {
                        unset($a_product[$key]);
                    }
                }
                if (!empty($new_data)) {
                    $a_data['product'] = $new_data;
                } else {
                    $a_data['product'] = array();
                }
            } else {
                $a_data['product'] = array();
            }
        } else {
            $a_data['product'] = array();
        }
        // 获取前五张广告
        $a_data['ad'] = $this->home_model->get_ad_five();
        $this->view->display('index3', $a_data);
    }

    /****************************************改版首页**************************************************/
    public function index()
    {
        // 获取两条热门动态
        $a_data['mood'] = $this->home_model->get_mood_two();
        // 获取最近的一条公告信息

        $a_data['notice'] = $this->db->get("notice",['notice_state'=>1],'', "notice_id desc,notice_time desc",0,9999999999);
        // 验证是否有未读的动态
        if (isset($_SESSION['user_id'])) {
            $a_data['moodmsg'] = $this->home_model->get_mood_msgcount($_SESSION['user_id']);
        } else {
            $a_data['moodmsg'] = 0;
        }
        //获取分类
        $a_data['category'] = $this->db->get('pro', ['pro_pid' => '0', 'is_show' => '1']);
        // 获取前五张广告
        $a_data['ad'] = $this->home_model->get_ad_five();
        //获取销量最好的产品
        $a_product = $this->home_model->get_product_five();

        $a_data['prod_data'] = array();
        if ($a_product) {
            $a_data['prod_data'] = $a_product;
        }
        //店铺列表
        $a_res = $this->store_model->new_get_stroe_nearby($citycode = "020");
        foreach ($a_res as $key => $value) {
            $store_id = $value['store_id'];
            // 获取门店所有评论
            $a_comment     = $this->store_model->get_store_comment($value['store_id']);
            $goods_score   = 0;
            $service_score = 0;
            foreach ($a_comment as $key => $values) {
                $goods_score   = $goods_score + $values['goods_score'];
                $service_score = $service_score + $values['service_score'];
            }
            if ($goods_score > 0) {
                $goods_scores = round($goods_score / count($a_comment), 1);
            } else {
                $goods_scores = 5.0;
            }
            if ($service_score > 0) {
                $service_scores = round($service_score / count($a_comment), 1);
            } else {
                $service_scores = 5.0;
            }
            $value['all_score']  = round(($goods_scores + $service_scores) / 2, 1);
            $value['month_sale'] = $this->store_model->get_stroe_order_sale($value['store_id']);
            $value['set']        = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
            if (empty($value['store_mainimg'])) {
                $value['main_pic'] = get_config_item('store_touxiang') . 'upload/store/20180124055629958.jpg';
            } else {
                $value['main_pic'] = get_config_item('store_touxiang') . $value['store_mainimg'];
            }
            //获取门店的销量产品
            $value['sale_prod'] = $this->store_model->get_stroe_prod_sale($value['store_id']);

            //门店距离
            list($f_order_longitude, $f_order_latitude) = explode(',', $value['store_position']);
            $distance = $this->store_model->get_distance($_SESSION['user_lngs'], $_SESSION['user_lats'],
                $f_order_longitude, $f_order_latitude);
            $distance > 100 ? $value['distance'] = '>50' : $value['distance'] = $distance;
            // 产品价格起
            $value['cup'] = $this->db->limit(0, 9999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            $new_data[]   = $value;
        }
        $a_data['shop_list'] = $new_data;
        $this->view->display('nindex', $a_data);
    }

    //产品列表接口
    public function search_cate_prod()
    {
        $res = array('code' => 400, 'msg' => '错误请求', 'data' => array());
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cate_id = trim($this->general->post('cat_id'));
            if ($cate_id) {
                $a_result = $this->home_model->get_cate_product($cate_id);
                if ($a_result) {
                    $res = array('code' => 200, 'msg' => '成功请求', 'data' => $a_result);
                }
            }
        }
        echo json_encode($res);
        exit;
    }

    /**************************************** 热门推荐 ****************************************/

    public function hot_recommend()
    {
        $time_id   = trim($this->general->post('time_id'));
        $a_product = $this->home_model->get_product_five();
        if (!empty($a_product)) {
            $i = 0;
            foreach ($a_product as $key => $value) {
                if ($i < 4) {
                    if (!empty($value['supply_time'])) {
                        $this_cates = explode(',', $value['supply_time']);
                        if (!in_array($time_id, $this_cates)) {
                            unset($a_product[$key]);
                        } else {
                            $i++;
                            $subject              = strip_tags($value['pro_details']); //去除html标签
                            $pattern              = '/\s/'; //去除空白
                            $content              = preg_replace($pattern, '', $subject);
                            $seodata              = mb_substr($content, 0, 18); //截取100个汉字
                            $value['pro_details'] = $seodata;
                            $value['gourl']       = $this->router->url('item', ['pid' => $value['proid_id_1'], 'product_id' => $value['product_id'], 'store_id' => '0']);
                            $new_data[]           = $value;
                        }
                    } else {
                        unset($a_product[$key]);
                    }
                }
            }
            if (!empty($new_data)) {
                echo json_encode(array('code' => 200, 'msg' => 'success', 'data' => $new_data));
            } else {
                echo json_encode(array('code' => 400, 'msg' => 'error', 'data' => ''));
            }
        } else {
            echo json_encode(array('code' => 400, 'msg' => 'error', 'data' => ''));
        }
    }

    /**************************************** 用户中心 ****************************************/

    public function user_center()
    {
        if (empty($_SESSION['user_id'])) {
            $this->view->display('user_center1');
        } else {
            // 用户信息
            $a_data['user'] = $this->home_model->get_user_one($_SESSION['user_id']);
            if (!$a_data['user']) {
                $b_result    = session_destroy();
                $a_parameter = [
                    'msg'  => '请重新登录',
                    'url'  => 'login',
                    'log'  => false,
                    'wait' => 2,
                ];
                $this->error->show_error($a_parameter);
            }
            // 动态数量
            $a_data['mood_count'] = $this->home_model->get_mood_count($_SESSION['user_id']);
            $this->view->display('user_center2', $a_data);
        }
    }

    /**************************************** 客服中心 ****************************************/

    public function call_center()
    {
        $this->view->display('call_center');
    }

    /**************************************** 搜索中心 ****************************************/

    public function index_search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        } else {
            $this->view->display('index_search');
        }
    }

    /**************************************** 获取天气 ****************************************/

    public function get_weather()
    {
        // 接收参数
        $adcode = $this->general->post('adcode');
        // 获取所在城市的天气
        $this->load->library('map_gaode');
        $a_result = $this->map_gaode->weather($adcode);
        if ($a_result['infocode'] == 10000) {
            echo json_encode(array('code' => 200, 'msg' => 'success', 'data' => $a_result['lives'][0]));
        } else {
            echo json_encode(array('code' => 400, 'msg' => 'error', 'data' => ''));
        }
    }

    /**************************************** 了解使用 ****************************************/

    public function index_use()
    {
        $this->view->display('index_use');
    }


    // 银行卡退款
    public function unionpay_refund_notify()
    {

    }

    // 微信退款
    public function wxrefund_notify()
    {

    }

    /********************************************************************************************/

    // 扫码下载
    public function scan_code_download()
    {
        $s_useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($s_useragent, 'iphone') !== false) {
            //echo '苹果版app正在上线中';
            $this->error->location('https://itunes.apple.com/cn/app/id1364846176?mt=8');
        } else {
            $this->error->location('https://vdao-mobile.7dugo.com/vdao.apk');
        }
    }

    // 自动生成微信支付订单，为了申请微信提现功能临时用
    public function wx_tmp_order()
    {
        $a_product = [
            1  => '柚子冰红茶',
            2  => '柚其爱柠',
            3  => '原味鸡蛋仔',
            4  => '百香苹果红',
            5  => '摩卡挝啡',
            6  => '招牌挝啡',
            7  => '鸳鸯挝啡',
            8  => '芝心鸡蛋仔',
            9  => '芝心冰红茶',
            10 => '经典芝心挝啡',
            11 => '桂花茶'
        ];
        $a_price   = [
            1  => 1400,
            2  => 1200,
            3  => 1000,
            4  => 1800,
            5  => 1500,
            6  => 1300,
            7  => 1800,
            8  => 1300,
            9  => 1800,
            10 => 1800,
            11 => 1300
        ];
        $i_rand    = rand(1, 11);
        $a_data    = [
            // 商品描述, 必填
            'body'             => $a_product[$i_rand],
            // 商户订单号, 必填
            'out_trade_no'     => $_SERVER['REQUEST_TIME'] . rand(10000000, 99999999),
            // 标价金额,以分为单位, 必填
            'total_fee'        => $a_price[$i_rand],
            // 终端IP, 必填
            'spbill_create_ip' => $this->general->get_ip(),
        ];
        $this->load->library('wxpay_h5');
        $a_result = $this->wxpay_h5->pay($a_data);
        echo '你点的产品是：' . $a_data['body'];
        echo '<br />价格是：' . ($a_data['total_fee'] / 100) . '元';
        echo '<br /><a href="' . $a_result['mweb_url'] . '" style="font-size: 30px;">支付</a>';
    }

    //新版会员中心
    public function nuser_center()
    {
        if ($_SESSION['user_id']) {
            $s_field            = "is_shopman,user_id,user_name,user_score,user_balance,user_erweima,user_pic";
            $a_data             = $this->db->get_row("user", ['user_id' => $_SESSION['user_id'], 'user_state' => 1], $s_field);
            $a_data['is_login'] = 1;
            if (empty($a_data['user_pic'])) {
                $a_data['user_pic'] = 'static/style_default/images/tou_03.png';
            }
            $a_data['collect'] = $this->db->get_total("collection", ['user_id' => $a_data['user_id']], 0, 999999999);
        } else {
            $a_data = array("is_login" => 0);
        }

        if ($_COOKIE['client_id']) {
            // 缓存中读取
            $row = [];
            if (class_exists('memcache')) {
                $m = new Memcache();
            } else if (class_exists('memcached')) {
                $m = new Memcached();
            } else {
                $m = false;
            }
            if ($m) {
                $m->addServer('localhost', 11211);
                $row = $m->get('current_client_history' . $_COOKIE['client_id']);
            }

            if (!$row) {
                $map   = ['client_id' => $_COOKIE['client_id']];
                $count = $this->db->get_total('login_history', $map);
                $row   = $this->db->limit(0, $count)->get('login_history', $map, '*', [
                    'post_at' => 'desc'
                ]);
                //                $m && $m->add('current_client_history' . $_COOKIE['client_id'], $row, 5);
            }

            $a_data['history'] = $row;
        }

        $this->view->display('nuser_center', $a_data);
    }

    /**
     * 自动登录
     */
    public function userAutoLogin()
    {
        $client_id = $this->general->post('client_id');
        if($client_id) {
            $row = $this->db->get_row('user_auto_login', compact('client_id'));
        }
    }


	public function new_user_msg() {

		$a_where =[
			'ues_id'=>$_SESSION['user_id'],
				];
		$a_order=['mess_time'=>"desc"];
		$a_data = $this->db->get("messagess",$a_where,'',$a_order,0,99999999);
		$this->view->display('new_user_msg',$a_data );
	}

	public function indexsearch(){
        $a_data['product'] = $this->home_model->get_product_return(4);
        $a_data['history'] = $this->db->get("history", ['user_id' => $_SESSION['user_id']], '', "his_time desc", 0, 6);
		$this->view->display('indexSearch',$a_data );
	}
}

?>