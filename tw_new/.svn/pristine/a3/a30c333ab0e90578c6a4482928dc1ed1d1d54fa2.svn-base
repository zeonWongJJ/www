<?php

/**
 * @property \utils\ide\Db db
 */
class Shop_ctrl extends \utils\BaseController
{
    //店铺列表
    public function shop_list()
    {
        $store_total = $this->db->get_total('jiajie_store');
        $rows        = $this->db->limit(0, $store_total ?: 1)->get('jiajie_store');
        return $this->success($rows, $store_total);
    }

    //申请店铺
    public function apply_shop()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $this->request->post('', '', 'trim');
            //通过store_type去过滤一些请求体
            if ($data['store_type'] == 1) { // 1代表个人店铺 2代表企业店铺
                $this->validate($data, [
                    'store_name'    => 'required',
                    'store_address' => 'required',
                    'store_linkman' => 'required',
                    'linkman_card'  => 'required|number',
                    'store_tel'     => 'required',

                ]);
            } else {
                $this->validate($data, [
                    'store_name'    => 'required',
                    'store_address' => 'required',
                    'store_licence' => 'required',
                    'store_tel'     => 'required',

                ]);
            }
            if ($data) {
                $data['update_time'] = time();
                //                $data['user_id'] = $_SESSION['user_id'];
                $data['user_id'] = 122;
                $ids             = $this->db->insert("store", $data);
                if ($ids) {
                    $this->json('成功写入', 0);
                } else {
                    $this->json('写入失败!', 1);
                }
            } else {
                $this->json('没有数据插入!', 1);
            }
        } else {
            $this->json('请求错误!', 1);
        }
    }

    public function getOne()
    {
        $map['store_id'] = (int)$this->router->get(1);
        $this->validate($map, [
            'store_id' => 'required|number'
        ]);
        $store = $this->db->get_row(get_table('store'), $map);
        return $store ? $this->success(filter($store)) : $this->success(false);
    }

    //返回某个用户的店铺详情
    public function shopinfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //                $a_where['user_id'] = $_SESSION['user_id'];
            $a_where = ['user_id' => 122, 'store_state' => 1];
            $rows    = $this->db->get_row('store', $a_where);
            if ($rows) {
                $this->json("请求成功!", 0, $rows);
            } else {
                $this->json('没有相关数据!', 1);
            }
        } else {
            $this->json('请求错误!', 1);
        }
    }

    //审核店铺
    public function checks_shop()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $store_id = $this->request->post('store_id', '', 'trim');
            $a_where  = ['store_id' => $store_id, 'store_state' => 0];
            $a_field  = ['store_state' => 1];
            $rows     = $this->db->update("store", $a_field, $a_where);
            if ($rows) {
                $this->json("审核通过!", 0);
            } else {
                $this->json('审核失败!', 1);
            }
        } else {
            $this->json('请求错误!', 1);
        }
    }

    //停用店铺
    public function close_shop()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $store_id = (int)$this->router->get(1);
            $a_where  = ['store_id' => $store_id];
            $a_field  = ['store_state' => 2];
            if ($this->db->update('jiajie_store', $a_field, $a_where)) {
                return $this->success(false);
            }
        }
        return $this->error();
    }

    //启用店铺
    public function open_shop()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $store_id = (int)$this->router->get(1);
            $a_where  = ['store_id' => $store_id];
            $a_field  = ['store_state' => 1];
            if ($this->db->update('jiajie_store', $a_field, $a_where)) {
                return $this->success(false);
            }
        }
        return $this->error();
    }

    /**
     * 店铺更新
     * @return mixed|void
     */
    public function update()
    {

    }
}
