<?php

defined('BASEPATH') or exit('禁止访问！');

class Join_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('join_model');
        $this->load->model('allow_model');
        $this->allow_model->is_login();
    }

    /**************************************** 上传文件 ****************************************/
    /**
     * 上传身份证
     * https://vdao-mobile.7dugo.com/njoin_upload-id_card-1 正面上传 POST
     * https://vdao-mobile.7dugo.com/njoin_upload-id_card-2 背面上传 POST
     * 上传营业执照
     * https://vdao-mobile.7dugo.com/njoin_upload-business_license POST
     * 打开上传身份证页面
     * https://vdao-mobile.7dugo.com/njoin_upload-id_card GET
     * 打开上传营业执照页面
     * https://vdao-mobile.7dugo.com/njoin_upload-business_license GET
     * @param $key
     */
    public function join_upload()
    {
        $type = $this->router->get(1); // 上传身份证/营业执照
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type:Application/json;charset=utf8');
            // 上传身份证，判断正反
            if ($type === 'id_card') {
                $face = $this->router->get(2);
                $s_upload_key = $face == 1 ? 'id_card_positive' : 'id_card_back';
            } else {
                $s_upload_key = 'business_license';
            }
            // 执行文件上传操作
            if (isset($_FILES[$s_upload_key]) && !empty($_FILES[$s_upload_key])) {
                $s_file_name = time() . $_FILES[$s_upload_key]['name'];
                $result      = move_uploaded_file($_FILES[$s_upload_key]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/join/' . $s_file_name);
                if ($result) {
                    echo json_encode(['code' => 200, 'msg' => '上传成功', 'path' => '/upload/join/' . $s_file_name]);
                } else {
                    echo json_encode(['code' => 400, 'msg' => '上传失败']);
                }
            }
        } else {
            // 打开页面
            $this->view->display(
                $type == 'id_card' ? 'join_upload_id_card' : 'join_upload_business_license'
            );
        }
    }

    /**************************************** 申请加盟 ****************************************/

    public function join_apply()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type:Application/json;charset=utf8');
            $a_parameter  = [
                'msg'  => '这是提示信息',
//                'url'  => 'join_showlist',
//                'log'  => false,
//                'wait' => 2,
            ];
            $i_result     = $this->join_model->join_apply();
            $is_temporary = $this->router->get(1);
            if ($i_result) {
                if ($is_temporary == 1) {
                    $a_parameter['msg'] = '保存成功';
                    $a_parameter['code'] = 200;
                } else {
                    $a_parameter['msg'] = '提交成功';
                    $a_parameter['code'] = 200;
                }
                // $this->error->show_success($a_parameter);
                // echo json_encode($a_parameter);
            } else {
                if ($is_temporary == 1) {
                    $a_parameter['msg'] = '保存失败';
                    $a_parameter['code'] = 400;
                } else {
                    $a_parameter['msg'] = '提交失败';
                    $a_parameter['code'] = 400;
                }
                // echo json_encode($a_parameter);
                // $this->error->show_error($a_parameter);
            }
            die(json_encode($a_parameter));
        } else {
            // 展示加盟页面
            $this->view->display('join_apply');
        }
    }

    /**************************************** 加盟列表 ****************************************/

    public function join_showlist()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $user_id        = $_SESSION['user_id'];
            $a_data['join'] = $this->join_model->get_join_user($user_id);
            $this->view->display('join_showlist', $a_data);
        }
    }

    /**************************************** 修改申请 ****************************************/

    public function join_update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a_parameter  = [
                'msg'  => '这是提示信息',
                'url'  => 'join_showlist',
                'log'  => false,
                'wait' => 2,
            ];
            $i_result     = $this->join_model->join_update();
            $is_temporary = $this->router->get(2);
            if ($i_result) {
                if ($is_temporary == 'draft') {
                    $a_parameter['msg'] = '保存成功';
                } else {
                    $a_parameter['msg'] = '提交成功';
                }
                $this->error->show_success($a_parameter);
            } else {
                if ($is_temporary == 'draft') {
                    $a_parameter['msg'] = '保存失败';
                } else {
                    $a_parameter['msg'] = '提交失败';
                }
                $this->error->show_error($a_parameter);
            }
        } else {
            // 接收需要修改的申请id
            $join_id = $this->router->get(1);
            // 获取数据
            $a_data = $this->join_model->get_join_one($join_id);
            // 展示页面
            $this->view->display('join_update', $a_data);
        }
    }

    /******************************************************************************************/

}

?>