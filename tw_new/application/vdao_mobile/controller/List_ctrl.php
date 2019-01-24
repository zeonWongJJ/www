<?php

class List_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('allow_model');
        $this->load->model('store_model');
        $this->load->model('product_model');
        // $this->allow_model->is_login();
    }

    //产品分类页面
    public function product_category()
    {
        $this->view->display('product_category');
    }

    //新版产品分类页面
    public function n_goods_list()
    {
        //获取分类
        $a_data             = [];
        $a_data['category'] = $this->db->get('pro', ['pro_pid' => '0', 'is_show' => '1']);
        $a_data['prod']     = $this->product_model->goods_list('', 0, 99);
        // print_r($a_data['prod']);exit;
        // 配送费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        //获取购物车的商品数
        $ooo                  = $this->db->select('SUM(prot_count) as prot_count', false)->get("cart", ['user_id' => $_SESSION['user_id'], 'store_id' => 0], '', 0, 9999999999);
        $a_data['cart_count'] = !empty($ooo[0]['prot_count']) ? $ooo[0]['prot_count'] : 0;
        // print_r($a_data);
        $this->view->display('ngoods_list', $a_data);
    }


    //新版产品数据接口
    public function get_prod_list()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $res = ['code' => 400, 'msg' => '没数据返回!'];

            //d_type 1:产品分页 2:产品分类查询 3:产品属性查询 4：返回热门推荐 5:产品列表搜索返回的产品数据 6:清除个人搜索历史记录
            $d_type = $this->general->post('type');
            if ($d_type == 2) {
                $cate   = trim($this->general->post('cid'));
                $a_data = $this->product_model->goods_list($cate, 0, 9999);
                if ($a_data) {
                    $res = ["code" => 200, 'msg' => "请求成功", 'data' => $a_data];
                    echo(json_encode($res));
                    exit;
                }
            } else if ($d_type == 3) {
                $pid = trim($this->general->post('pid'));

                $prod_att['ptype'] = $this->db->limit(0, 9999)->get('price', ['product_id' => $pid]);
                if ($prod_att['ptype']) {
                    $prod_att['attr_list'] = $this->product_model->get_attr_type($pid);
                    $res                   = ["code" => 200, 'msg' => "请求成功", 'data' => $prod_att];
                    echo(json_encode($res));
                    exit;
                }
            } else if ($d_type == 4) {
                $this->load->model('home_model');
                $a_product = $this->home_model->get_product_return(4);
                $a_history = $this->db->get('history', ['user_id' => $_SESSION['user_id']], '', 'his_time desc', 0, 6);
                if ($a_product) {
                    $res = ['code' => 200, 'msg' => '请求成功', 'data' => $a_product, 'history' => $a_history];
                    echo(json_encode($res));
                    exit;
                }
            } else if ($d_type == 5) {
                $this->load->model('home_model');
                $s_search = $this->check_str($this->general->post('search'));
                if ($_SESSION['user_id']) {
                    $i_res = $this->db->update('history', ['his_time' => time()], ['user_id' => $_SESSION['user_id'], 'user_seasrch' => $s_search]);
                    if (empty($i_res)) {
                        $a_history = [
                            'user_id'      => $_SESSION['user_id'],
                            'user_seasrch' => $s_search,
                            'his_time'     => time(),
                        ];

                        $this->db->insert("history", $a_history);
                    }
                }
                $a_product = $this->home_model->search_product_return($s_search);
                if ($a_product) {
                    $res = ['code' => 200, 'msg' => '请求成功', 'data' => $a_product, 'search' => $s_search, 'i_res' => $i_res ?? ''];
                    echo(json_encode($res));
                    exit;
                }
            } else if ($d_type == 6) {
                if ($_SESSION['user_id']) {
                    $i_res = $this->db->delete("history", ['user_id' => $_SESSION['user_id']]);
                    if ($i_res) {
                        $res = ['code' => 200, 'msg' => '请求成功'];
                        echo(json_encode($res));
                        exit;
                    }

                    $res = ['code' => 400, 'msg' => '清求失败'];
                    echo(json_encode($res));
                }
            }
            exit(json_encode($res));
        }
    }

    //产品列表

    protected function check_str($string)
    {
        $result = false;
        $var    = $this->filter_keyword($string); // 过滤sql与php文件操作的关键字
        if (!empty($var)) {
            if (!get_magic_quotes_gpc()) { // 判断magic_quotes_gpc是否为打开
                $var = addslashes($string); // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
            }
            //$var = str_replace( "_", "\_", $var ); // 把 '_'过滤掉
            $var    = str_replace("%", "\%", $var); // 把 '%'过滤掉
            $var    = nl2br($var); // 回车转换
            $var    = htmlspecialchars($var); // html标记转换
            $result = $var;
        }
        return $result;
    }

    // 门店咖啡列表

    private function filter_keyword($string)
    {
        $keyword = 'select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|and|union|order|or|into|load_file|outfile';
        $arr     = explode('|', $keyword);
        $result  = str_ireplace($arr, '', $string);
        return $result;
    }

    //套餐

    public function list()
    {
        //产品类id
        $i_id           = $this->router->get(1);
        $a_sele         = 'a.product_id,a.product_name,a.antistop,a.pro_details,a.pro_img,b.pingl,d.number,a.supply_time';
        $a_data['prod'] = $this->db->from('product as a')
            ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->where('a.product_id in (select product_id from ' . $this->db->get_prefix() . 'prod_sto where prod_show =1)', null, false)
            ->limit(0, 9999999)
            ->get('', ['a.pro_show' => 1, 'a.proid_id_1' => $i_id, 'a.goods_stye' => 1], $a_sele, ['a.order' => 'asc']);

        // 产品价格起
        $a_data['cup'] = $this->db->limit(0, 9999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        // print_r($a_data['cup']);
        //查询相对的时间
        $a_data['time_name'] = $this->db->get('time');
        foreach ($a_data['time_name'] as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        }
        // var_dump($a_data['time']);exit;
        // print_r($a_data['time']);
        // 配送费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        if (empty($_SESSION['user_id'])) {
            $this->view->display('list', $a_data);
        } else {
            // 获取全部价格
            $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            // print_r($a_data['pric']);
            //获取产品属性
            $a_data['att'] = $this->db->limit(0, 9999999999)->get('product_att');
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
            $this->view->display('list1', $a_data);
        }

    }

    //选择杯型显示价格

    public function list_store()
    {
        //门店id
        $i_store = $this->router->get(1);
        //产品类id
        $i_goods = $this->router->get(2);
        $i_gooid = $this->router->get(3);
        //门店信息
        $a_data['store'] = $this->db->get_row('store', ['store_id' => $i_store]);
        // 获取门店所有评论
        $a_comment     = $this->store_model->get_store_comment($i_store);
        $goods_score   = 0;
        $service_score = 0;
        foreach ($a_comment as $key => $value) {
            $goods_score   = $goods_score + $value['goods_score'];
            $service_score = $service_score + $value['service_score'];
        }
        if ($goods_score != 0) {
            $a_data['goods_score'] = round($goods_score / count($a_comment), 1);
        } else {
            $a_data['goods_score'] = 5.0;
        }
        if ($service_score != 0) {
            $a_data['service_score'] = round($service_score / count($a_comment), 1);
        } else {
            $a_data['service_score'] = 5.0;
        }
        $a_data['all_score'] = round(($a_data['goods_score'] + $a_data['service_score']) / 2, 1);
        // 获取营业时间
        $a_set                     = $this->store_model->get_set_one('store_open_time');
        $a_data['store_open_time'] = $a_set['set_parameter'];
        // 判断用户是否登录 如果登录判断是否收藏了门店
        if (isset($_SESSION['user_id'])) {
            // 判断是否收藏了当前门店
            $a_collection = $this->store_model->get_collection_one($i_store, $_SESSION['user_id'], 1);
            if ($a_collection) {
                $a_data['collection'] = 1;
            } else {
                $a_data['collection'] = 2;
            }
        } else {
            $a_data['collection'] = 2;
        }
        $a_data['time'] = $this->db->get_row('set', ['set_name' => 'store_open_time']);
        //产品分类
        $a_data['pro'] = $this->db->limit(0, 9999999999)->get('pro', ['proid' => 1, 'is_show' => 1]);
        if (empty($i_goods)) {
            $a_wher = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $i_store, 'proid_id_1' => $a_data['pro'][0]['pro_id']];
        } else {
            $a_wher = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $i_store, 'proid_id_1' => $i_goods];
        }
        $a_slse         = "c.pingl,d.number,b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock";
        $a_data['prod'] = $this->db->from('prod_sto as a')
            ->join('product as b', ['a.product_id' => 'b.product_id'])
            ->join('comment_product as c', ['a.product_id' => 'c.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->get('', $a_wher, $a_slse, ['order' => 'asc']);
        /*
        |-----------------------------------------------------------------------------------------
        | wangjinshan
        | 2018-03-15
        | 产品当日库存量
        | begin
        |-----------------------------------------------------------------------------------------
         */
        // echo $this->db->get_sql();
        // print_r($a_data);exit;

        if (!empty($a_data['prod'])) {
            // 当日起始时间戳
            $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            foreach ($a_data['prod'] as $key => $value) {
                // 验证当前门店当前产品当日是否有为存量
                $a_where     = [
                    'store_id'   => $i_store,
                    'product_id' => $value['product_id'],
                    'stock_time' => $today_start,
                ];
                $a_stock_row = $this->db->get_row('stock', $a_where);
                if (empty($a_stock_row)) {
                    $value['today_stock'] = $value['pro_stock'];
                } else {
                    $value['today_stock'] = $a_stock_row['product_stock'];
                }
                $new_data[] = $value;
            }
            $a_data['prod'] = $new_data;
        }
        // print_r($a_data['prod']);
        /*
        |-----------------------------------------------------------------------------------------
        | end
        |-----------------------------------------------------------------------------------------
         */

        //查询相对的时间
        $a_data['time_name'] = $this->db->get('time');
        // print_r($a_data['time_name']);
        foreach ($a_data['time_name'] as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        }

        $a_data['cup'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        // 配送费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        if (empty($_SESSION['user_id'])) {
            $this->view->display('list_store', $a_data);
        } else {
            // 获取最低价格
            $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
            //获取产品属性
            $a_data['att'] = $this->db->limit(0, 9999999999)->get('product_att');
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
            // print_r($a_data['pric']);
            $this->view->display('list_store1', $a_data);
        }
    }

    //获取更多产品信息

    public function store_meal()
    {
        if (empty($_SESSION['user_id'])) {
            $this->error->show_error('请先登录！');
        }
        //门店id
        $i_store = $this->router->get(1);
        // 产品id
        $i_prouc = $this->router->get(2);
        //产品类id
        $i_goods = $this->router->get(3);
        //门店信息
        $a_data['store'] = $this->db->get_row('store', ['store_id' => $i_store]);
        // 获取门店所有评论
        $a_comment     = $this->store_model->get_store_comment($i_store);
        $goods_score   = 0;
        $service_score = 0;
        foreach ($a_comment as $key => $value) {
            $goods_score   = $goods_score + $value['goods_score'];
            $service_score = $service_score + $value['service_score'];
        }
        if ($goods_score != 0) {
            $a_data['goods_score'] = round($goods_score / count($a_comment), 1);
        } else {
            $a_data['goods_score'] = 5.0;
        }
        if ($service_score != 0) {
            $a_data['service_score'] = round($service_score / count($a_comment), 1);
        } else {
            $a_data['service_score'] = 5.0;
        }
        $a_data['all_score'] = round(($a_data['goods_score'] + $a_data['service_score']) / 2, 1);
        // 获取营业时间
        $a_set                     = $this->store_model->get_set_one('store_open_time');
        $a_data['store_open_time'] = $a_set['set_parameter'];
        // 判断用户是否登录 如果登录判断是否收藏了门店
        if (isset($_SESSION['user_id'])) {
            // 判断是否收藏了当前门店
            $a_collection = $this->store_model->get_collection_one($i_store, $_SESSION['user_id'], 1);
            if ($a_collection) {
                $a_data['collection'] = 1;
            } else {
                $a_data['collection'] = 2;
            }
        } else {
            $a_data['collection'] = 2;
        }
        if ($i_store == 0) {
            $a_data['meal'] = $this->db->from('product as a')
                ->join('price as b', ['a.product_id' => 'b.product_id'])
                ->get_row('', ['a.product_id' => $i_prouc]);
        } else {
            $a_wher         = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $i_store, 'a.product_id' => $i_prouc];
            $a_slse         = "b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock,b.group_product,d.price";
            $a_data['meal'] = $this->db->from('prod_sto as a')
                ->join('price as d', ['a.product_id' => 'd.product_id'])
                ->join('product as b', ['a.product_id' => 'b.product_id'])
                ->get_row('', $a_wher, $a_slse);
        }
        // print_r($a_data['meal']);
        $a_data['prod'] = $this->db->from('product as a')
            ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->get('', ['a.pro_show' => 1], '', '', 0, 9999999);
        //查询相对的时间
        $a_data['time_name'] = $this->db->get('time');
        // print_r($a_data['time_name']);
        foreach ($a_data['time_name'] as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        }
        // 获取全部价格
        $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        //获取产品属性
        $a_data['att'] = $this->db->limit(0, 9999999999)->get('product_att');
        //获取属性
        $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
        // print_r($a_data['prod']);
        $this->view->display('store_meal', $a_data);
    }

    //产品详情

    public function list_price()
    {
        $i_goods = $this->general->post('goods');
        $i_cup   = $this->general->post('cup');
        $i_price = $this->db->get_row('price', ['product_id' => $i_goods, 'cup_id' => $i_cup], ['price']);
        echo json_encode($i_price);
    }

    // 产品收藏

    public function list_up()
    {
        // 先设置默认从第一页开始
        $i_page = $this->general->post('page');
        if (empty($i_page)) {
            $i_page = 1;
        }
        $a_where = ['pro_show' => 1, 'goods_stye' => 1];
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = $this->db->get_total('product', $a_where);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        //总页数
        $page_total = ceil($i_total / $i_prow);
        //判断是否超过总页数
        if ($i_page > $page_total) {
            // $a_data = array('state' => 0);
            echo json_encode(0);
            die;
        }
        $a_data = $this->db->get('product', $a_where);
        echo json_encode($a_data);
    }

    // 咖啡评价

    public function item()
    {
        // 产品的类型id
        $i_le = $this->router->get(1);
        // 产品的id
        $i_id = $this->router->get(2);
        // 门店的id
        $i_sto           = $this->router->get(3);
        $a_data['store'] = $this->db->get_row('store', ['store_id' => $i_sto]);
        if (empty($i_sto)) {
            $a_data['goods'] = $this->db->from('product as a')
                ->join('qualifi_goods as b', ['a.product_id' => 'b.product_id'])
                ->join('user as c', ['b.user_id' => 'c.user_id'])
                ->get('', ['a.product_id' => $i_id, 'pro_show' => 1]);
            foreach ($a_data['goods'] as $value) {
                $value['today_stock'] = 1;
                $a_goods[]            = $value;
            }
            $a_data['goods'] = $a_goods;
        } else if ($i_sto == 'i') {
            $a_data['goods'] = $this->db->from('product as a')
                ->join('qualifi_goods as b', ['a.product_id' => 'b.product_id'])
                ->join('user as c', ['b.user_id' => 'c.user_id'])
                ->get('', ['a.product_id' => $i_id, 'pro_show' => 1]);
            foreach ($a_data['goods'] as $value) {
                $value['today_stock'] = 1;
                $a_goods[]            = $value;
            }
            $a_data['goods'] = $a_goods;
        } else {
            $a_data['goods'] = $this->db->from('prod_sto as a')
                ->join('product as b', ['a.product_id' => 'b.product_id'])
                ->join('store as c', ['a.store_id' => 'c.store_id'])
                ->get('', ['a.product_id' => $i_id, 'a.prod_show' => 1, 'a.store_id' => $i_sto, 'b.pro_show' => 1]);
            /*
            |-----------------------------------------------------------------------------------------
            | wangjinshan
            | 2018-03-15
            | 产品当日库存量
            | begin
            |-----------------------------------------------------------------------------------------
             */
            if (!empty($a_data['goods'])) {
                // 当日起始时间戳
                $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                foreach ($a_data['goods'] as $key => $value) {
                    // 验证当前门店当前产品当日是否有为存量
                    $a_where     = [
                        'store_id'   => $i_sto,
                        'product_id' => $value['product_id'],
                        'stock_time' => $today_start,
                    ];
                    $a_stock_row = $this->db->get_row('stock', $a_where);
                    if (empty($a_stock_row)) {
                        $value['today_stock'] = $value['pro_stock'];
                    } else {
                        $value['today_stock'] = $a_stock_row['product_stock'];
                    }
                    $new_data[] = $value;
                }
                $a_data['goods'] = $new_data;
            }

            /*
            |-----------------------------------------------------------------------------------------
            | end
            |-----------------------------------------------------------------------------------------
             */
            // print_r($a_data);
        }

        if (empty($a_data['goods'])) {
            $this->error->show_error('无该产品或该产品下架了！ ');
        }

        //查询相对的时间
        $a_data['time_name'] = $this->db->get('time');
        // print_r($a_data['time_name']);
        foreach ($a_data['time_name'] as $time) {
            $checkDayStr = date('Y-m-d', time());
            $startTime   = strtotime($checkDayStr . $time['start_time'] . ":00");
            $endTime     = strtotime($checkDayStr . $time['end_tiem'] . ":00");
            if ($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        }

        //查询产品有无被收藏
        $a_data['colle'] = $this->db->get_row('collection', ['collection_type' => 3, 'user_id' => $_SESSION['user_id'], 'object_id' => $i_id]);
        // 评论标签
        $comme = $this->db->get('comment', ['object_id' => $i_id, 'comment_type' => 2, 'comment_state' => 1], '', ['comment_id' => 'desc'], 0, 4);
        $a     = '';
        foreach ($comme as $product) {
            $a .= $product['comment_tags'] . ',';
        }
        $a              = str_replace(",,", ",", $a);
        $a              = ltrim(rtrim($a, ","), ",");
        $a              = explode(",", $a);
        $a_data['name'] = array_unique($a);
        // 好评百分比
        //各订单数
        $s_fields      = 'comment_cate,count(1) as num';
        $s_group_by    = 'comment_cate';
        $a_wher        = ['object_id' => $i_id, 'comment_type' => 2, 'comment_state' => 1];
        $a_data_result = $this->db
            ->select($s_fields, false)
            ->group_by($s_group_by)
            ->get('comment', $a_wher);
        foreach ($a_data_result as $key => $value) {
            $a_result[$value['comment_cate']] = $value['num'];
        }
        // 显示好评条数
        $a_data['hao'] = isset($a_result['1']) ? intval($a_result['1']) : 0;
        // 显示中评条数
        $a_data['zho'] = isset($a_result['2']) ? intval($a_result['2']) : 0;
        // 显示差评条数
        $a_data['cha']     = isset($a_result['3']) ? intval($a_result['3']) : 0;
        $a_data['out']     = $a_data['hao'] + $a_data['zho'] + $a_data['cha'];
        $a_data['payment'] = round($a_data['hao'] / ($a_data['out'] + 1), 1);
        // 获取最低价格
        $a_data['pric'] = $this->db->get('price', ['product_id' => $i_id, 'price >' => 0], '', ['price' => 'asc']);
        // 产品价格起
        $a_data['cup'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        // 配送费
        $a_data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);

        if (empty($_SESSION['user_id'])) {
            $this->view->display('item2', $a_data);
        } else {
            //获取产品属性
            $a_data['att'] = $this->db->limit(0, 9999999999)->get('product_att', ['product_id' => $i_id]);
            // print_r($a_data['att']);
            //获取属性
            $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
            $this->view->display('item2', $a_data);
        }
    }

    //过滤敏感字符串

    public function item_colle()
    {
        $i_goods = $this->general->post('goods');
        $a_data  = $this->db->get_row('collection', ['collection_type' => 3, 'user_id' => $_SESSION['user_id'], 'object_id' => $i_goods]);
        if (empty($a_data)) {
            $a_tare = [
                'collection_type' => 3,
                'user_id'         => $_SESSION['user_id'],
                'object_id'       => $i_goods,
                'collection_time' => $_SERVER['REQUEST_TIME'],
            ];
            $s_data = $this->db->insert('collection', $a_tare);
            if ($s_data) {
                echo json_encode(['code' => 200, 'msg' => '添加成功']);
            } else {
                echo json_encode(['code' => 400, 'msg' => '添加失败']);
            }
        } else {
            $s_data = $this->db->delete('collection', ['collection_id' => $a_data['collection_id']]);
            if ($s_data) {
                echo json_encode(['code' => 200, 'msg' => '删除成功']);
            } else {
                echo json_encode(['code' => 400, 'msg' => '删除失败']);
            }
        }

    }

    public function list_comment()
    {
        // 产品的类型id
        $i_lexin = $this->router->get(1);
        // 产品的id
        $goods_id = $this->router->get(2);
        // 店铺的id
        $store_id = $this->router->get(3);
        //评论条件
        $i_out  = $this->router->get(4);
        $a_data = [
            'i_lexin'  => $i_lexin,
            'goods_id' => $goods_id,
            'store_id' => $store_id,
        ];
        if (!empty($store_id)) {
            $a_where = "`object_id` = $goods_id AND `comment_type` = 2 AND `comment_state` = 1 AND `store_id` = $store_id";
        } else {
            $a_where = "`object_id` = $goods_id AND `comment_type` = 2 AND `comment_state` = 1";
        }
        if (!empty($i_out)) {
            if ($i_out != 4) {
                $a_where .= ($a_where ? ' AND ' : '') . "`comment_cate` = $i_out";
            } else {
                $a_where .= ($a_where ? ' AND ' : '') . "`comment_pic` > '0'";
            }
        }
        // 产品评论
        $a_data['comment'] = $this->db->from('comment as a')
            // ->join('product as b', ['b.product_id' => 'a.object_id'])
            ->get('', $a_where, '', ['comment_id' => 'desc'], 0, 999999999);
        // echo $this->db->get_sql();
        // print_r( $a_data['comment']);
        //用户信息
        $a_data['user'] = $this->db->limit(0, 9999999999)->get('user');

        //各订单数
        $s_fields   = 'comment_cate,count(1) as num';
        $s_group_by = 'comment_cate';
        if (!empty($store_id)) {
            $a_wher = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1, 'store_id' => $store_id];
        } else {
            $a_wher = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1];
        }
        $a_wher        = ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1];
        $a_data_result = $this->db
            ->select($s_fields, false)
            ->group_by($s_group_by)
            ->get('comment', $a_wher);
        foreach ($a_data_result as $key => $value) {
            $a_result[$value['comment_cate']] = $value['num'];
        }
        // 显示很满意条数
        $a_data['hao'] = isset($a_result['1']) ? intval($a_result['1']) : 0;
        // 显示满意条数
        $a_data['zho'] = isset($a_result['2']) ? intval($a_result['2']) : 0;
        // 显示待提高条数
        $a_data['cha'] = isset($a_result['3']) ? intval($a_result['3']) : 0;
        //显示有图条数
        $a_data['img'] = $this->db->get_total('comment', ['object_id' => $goods_id, 'comment_type' => 2, 'comment_state' => 1, 'comment_pic >' => 0]);

        $this->view->display('list_comment', $a_data);
    }

    /**
     * ajax判断座位是否被占用
     */
    public function check_seat_occupy()
    {
        header('Content-type:application/json;charset=utf8');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $office_seat      = $this->general->post('office_seat'); // 座位id
            $store_id         = $this->general->post('store_id'); // 商铺id
            $ishave_deduction = 1;
            $officeseat_state = 1;
            $count            = $this->db->get_total('appointment', compact('office_seat', 'store_id', 'ishave_deduction', 'officeseat_state'), 0, 99999999);
            // exit(json_encode(['sql' => $this->db->get_sql()]));
            if ($count > 0) {
                exit(json_encode(['code' => 400, 'msg' => '该座位已被占用!']));
            } else {
                exit(json_encode(['code' => 200, 'msg' => '座位状态正常']));
            }
        } else {
            $map['store_id'] = $store_id = $this->router->get(1);

            $count                   = $this->db->get_total('appointment', $map);
            $map['ishave_deduction'] = 1;
            $map['officeseat_state'] = 1;
            $rows                    = $this->db->limit(0, $count)->get('appointment', $map, 'office_seat');
            foreach ($rows as $key => $row) {
                if (!$row['office_seat']) unset($rows[$key]);
                $a_res = explode(',', $row['office_seat']);
                foreach ($a_res as $_key => $value) {
                    $new[]['office_seat'] = $value;
                }
            }
            echo json_encode(['code' => 200, 'msg' => '获取座位状态列表成功!', 'data' => $new]);
        }
    }


    // 店铺商品列表
    public function rewrite_list_store()
    {

        $store_id             = $this->router->get(1);
        $condition            = $data = [];
        $condition['proid']   = 1;
        $condition['is_show'] = 1;
        $data['categorys']    = $this->db->get('pro', $condition);
        $data['store']        = $this->db->get_row('store', ['store_id' => $this->router->get(1)]);

        $condition = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $store_id];

        $a_slse         = "c.pingl,d.number,b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock";
        $category_goods = $this->db->from('prod_sto as a')
            ->join('product as b', ['a.product_id' => 'b.product_id'])
            ->join('comment_product as c', ['a.product_id' => 'c.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->get('', $condition, $a_slse, ['order' => 'asc']);

        if ($category_goods) {
            $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            foreach ($category_goods as $key => $goods) {
                // 验证当前门店当前产品当日是否有为存量
                $a_where     = [
                    'store_id'   => $store_id,
                    'product_id' => $goods['product_id'],
                    'stock_time' => $today_start,
                ];
                $a_stock_row = $this->db->get_row('stock', $a_where);
                if (empty($a_stock_row)) {
                    $category_goods[$key]['today_stock'] = $goods['pro_stock'];
                } else {
                    $category_goods[$key]['today_stock'] = $a_stock_row['product_stock'];
                }


                $pingl                               = $this->db->get_row('comment_product', ['product_id' => $goods['product_id']], 'pingl');
                $number                              = $this->db->get_row('product_number', ['product_id' => $goods['product_id']], 'number');
                $price                               = $this->db->get_row('price', ['product_id' => $goods['product_id']], 'price', ['price' => 'ASC']);
                $category_goods[$key]['praise_rate'] = $pingl['pingl'] ?? 100;
                $category_goods[$key]['sale_number'] = $number['number'] ?? 0;
                $category_goods[$key]['min_price']   = $price['price'] ?? 0;
            }
        }
        $data['category_goods'] = $category_goods;

        //办公室  因为前同事的反人类设计，所以你看到这段代码的时候请不要惊讶
        $offices = $this->db->get('office', ['store_id' => $store_id, 'office_state' => 1]);
        if ($offices) {
            foreach ($offices as $key => $office) {
                $rooms_detail = $this->db->get('room', ['room_id' => $office['room_id'], 'room_state' => 1]);
                if ($rooms_detail) {
                    $unset = false;
                    foreach ($rooms_detail as $rk => $room_detail) {
                        $room_type = $this->db->get_row('roomtype', ['type_id' => $room_detail['type_id'], 'type_cate' => 1, 'type_state' => 1]);
                        if ($room_type) {
                            $rooms_detail[$rk]['room_type_name'] = $room_type['type_name'];
                        } else {
                            $unset = true;
                            unset($offices[$key]);
                            break;
                        }
                    }
                    if (!$unset) {
                        $offices[$key]['room_detail'] = $rooms_detail;
                    }
                } else {
                    unset($offices[$key]);
                }
            }
        }

        $data['offices'] = $offices;
        // var_dump($offices);exit;
        //收藏门店
        $data['collection'] = 2;
        if (!empty($_SESSION['user_id'])) {
            // 判断是否收藏了当前门店
            $collection         = $this->db->get_row('collection', ['object_id' => $store_id, 'user_id' => $_SESSION['user_id'], 'collection_type' => 1]);
            $data['collection'] = $collection ? 1 : 2;
        }

        //配送费
        $user_order_freight                = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        $store_open_time                   = $this->db->get_row('set', ['set_name' => 'store_open_time'], ['set_parameter']);
        $data['set']['user_order_freight'] = $user_order_freight['set_parameter'];
        $data['set']['store_open_time']    = $store_open_time['set_parameter'];

        // 获取门店所有评论
        $comment_condition                  = [];
        $comment_condition['store_id']      = $store_id;
        $comment_condition['comment_state'] = 1;
        $s_field                            = $this->db->get_prefix() . 'user.user_name,' . $this->db->get_prefix() . 'user.user_pic,' . $this->db->get_prefix() . 'comment.user_id,comment_id,object_id,comment_content,comment_time,comment_pic,store_id,goods_score,service_score,is_anonymous,comment_type,comment_tags';
        $a_order                            = [
            'comment_id' => 'desc',
        ];
        $comment_data                       = $this->db->from('comment')
            ->join('user', [$this->db->get_prefix() . 'comment.user_id' => $this->db->get_prefix() . 'user.user_id'])
            ->get('', $comment_condition, $s_field, $a_order, 0, 999999999);


        $goods_score   = 0;
        $service_score = 0;
        foreach ($comment_data as $key => $value) {
            $goods_score   = $goods_score + $value['goods_score'];
            $service_score = $service_score + $value['service_score'];
        }
        if ($goods_score != 0) {
            $data['set']['goods_score'] = round($goods_score / count($comment_data), 1);
        } else {
            $data['set']['goods_score'] = 5.0;
        }
        if ($service_score != 0) {
            $data['set']['service_score'] = round($service_score / count($comment_data), 1);
        } else {
            $data['set']['service_score'] = 5.0;
        }

        $this->view->display('rewrite_list_store', $data);

    }

    //分类商品
    public function category_goods()
    {
        $post     = $this->general->post();
        $store_id = intval($post['store_id']);
        $cat_id   = intval($post['cat_id']);
        $result   = ['error' => 0, 'msg' => '暂无数据', 'data' => ''];


        $condition = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $store_id];
        if (!empty($cat_id)) {
            $condition['proid_id_1'] = $cat_id;
        }


        $a_slse         = "c.pingl,d.number,b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock";
        $category_goods = $this->db->from('prod_sto as a')
            ->join('product as b', ['a.product_id' => 'b.product_id'])
            ->join('comment_product as c', ['a.product_id' => 'c.product_id'])
            ->join('product_number as d', ['a.product_id' => 'd.product_id'])
            ->get('', $condition, $a_slse, ['order' => 'asc']);


        if ($category_goods) {
            $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            foreach ($category_goods as $key => $goods) {
                // 验证当前门店当前产品当日是否有为存量
                $a_where     = [
                    'store_id'   => $store_id,
                    'product_id' => $goods['product_id'],
                    'stock_time' => $today_start,
                ];
                $a_stock_row = $this->db->get_row('stock', $a_where);
                if (empty($a_stock_row)) {
                    $category_goods[$key]['today_stock'] = $goods['pro_stock'];
                } else {
                    $category_goods[$key]['today_stock'] = $a_stock_row['product_stock'];
                }


                $pingl                               = $this->db->get_row('comment_product', ['product_id' => $goods['product_id']], 'pingl');
                $number                              = $this->db->get_row('product_number', ['product_id' => $goods['product_id']], 'number');
                $price                               = $this->db->get_row('price', ['product_id' => $goods['product_id']], 'price', ['price' => 'ASC']);
                $category_goods[$key]['praise_rate'] = $pingl['pingl'] ?? 0;
                $category_goods[$key]['sale_number'] = $number['number'] ?? 0;
                $category_goods[$key]['min_price']   = $price['price'] ?? 0;
            }
            $result['msg']  = '返回数据成功';
            $result['data'] = $category_goods;
        }

        echo json_encode($category_goods);
        exit;
    }

    //商品属性
    public function goods_spec()
    {
        $post       = $this->general->post();
        $product_id = intval($post['product_id']);
        if (empty($product_id)) {
            echo json_encode(['error' => 1, 'msg' => '产品ID不能为空']);
            exit;
        }
        $result = ['error' => 0, 'msg' => '暂无数据', 'data' => ''];
        $types  = $this->db->select('*,cup_name as attri_name', false)->get('price', ['product_id' => $product_id, 'price >' => 0], '', ['price' => 'asc']);

        $goods_spec        = [];
        $goods_spec[]      = ['attributive' => ['attri_name' => '类型'], 'attributive1' => $types];
        $spec_temperatures = $this->db->get('product_att', ['product_id' => $product_id]);
        if ($spec_temperatures) {
            foreach ($spec_temperatures as $spec_temperature) {
                $attributive  = $this->db->get_row('attributive', ['attri_id' => $spec_temperature['stye']]);
                $attri_id_arr = explode(',', $spec_temperature['attri_id']);
                $goods_spec[] = ['attributive' => $attributive, 'attributive1' => $this->db->where_in('attri_id', $attri_id_arr)->get('attributive')];
            }
        }

        if ($goods_spec) {
            $result['msg']  = '返回数据成功';
            $result['data'] = $goods_spec;
        }
        echo json_encode($result);
        exit;
    }

    public function shop_comment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post                       = $this->general->post();
            $store_id                   = intval($post['store_id']);
            $comment_type               = intval($post['comment_type']);
            $comment_cate               = intval($post['comment_cate']);
            $object_id                  = intval($post['object_id']);
            $condition                  = [];
            $condition['comment_state'] = 1;
            $condition['store_id']      = $store_id;
            $condition['comment_type']  = $comment_type;
            if (!empty($comment_cate)) {
                $condition['comment_cate'] = $comment_cate;
            }
            if (!empty($object_id)) {
                $condition['object_id'] = $object_id;
            }

            $result        = ['error' => 0, 'msg' => '暂无数据', 'data' => ''];
            $comment_lists = $this->db->get('comment', $condition);
            if ($comment_lists) {
                foreach ($comment_lists as $key => $comment_list) {
                    $comment_lists[$key]['comment_date']      = date('m-d', $comment_list['comment_time']);
                    $user                                     = $this->db->get_row('user', ['user_id' => $comment_list['user_id']], 'user_nickname,user_name,user_pic');
                    $comment_lists[$key]['comment_user_name'] = $user['user_nickname'] ?: mb_substr($user['user_name'], 0, 2, 'utf-8') . '******';
                    $comment_lists[$key]['user_pic']          = $user['user_pic'];
                    if ($comment_type == 2) {
                        $product                             = $this->db->get_row('product', ['product_id' => $comment_list['object_id']], 'product_name');
                        $comment_lists[$key]['product_name'] = $product['product_name'];
                    } else {
                        $product                             = $this->db->get_row('appointment', ['appointment_id' => $comment_list['object_id']], 'room_type,room_name');
                        $comment_lists[$key]['product_name'] = '[' . $product['room_type'] . ']' . $product['room_name'];
                    }
                }

                $result['msg']  = '返回数据成功';
                $result['data'] = $comment_lists;
            }
            echo json_encode($result);
            exit;
        }
    }

    function rewrite_item()
    {
        $data                 = [];
        $product_id           = (int)$this->router->get(2);
        $product              = $this->db->get_row('product', ['product_id' => $product_id]);
        $price                = $this->db->get_row('price', ['product_id' => $product['product_id']], 'price', ['price' => 'ASC']);
        $product['min_price'] = $price['price'] ?? 0;
        $data['product']      = $product;
        // 配送费
        $data['set'] = $this->db->get_row('set', ['set_name' => 'user_order_freight'], ['set_parameter']);
        // var_dump($data['set']);exit;
        //判断该商品是否已经收藏
        $data['collection'] = 2;
        if (!empty($_SESSION['user_id'])) {
            // 判断是否收藏了当前门店
            $collection         = $this->db->get_row('collection', ['object_id' => $product_id, 'user_id' => $_SESSION['user_id'], 'collection_type' => 3]);
            $data['collection'] = $collection ? 1 : 2;
        }


        $this->view->display('item2', $data);
    }
}
