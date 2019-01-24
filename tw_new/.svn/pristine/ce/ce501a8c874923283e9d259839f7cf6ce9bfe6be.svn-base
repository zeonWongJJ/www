<?php

class Upload_ctrl extends \utils\BaseController
{

    public $_ignore_node = [
        'image',
        'uploadfile',
        'file',
        'base64'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }

    /**
     * 图片上传接口
     * @router http://server.name/upload.image
     */
    public function image()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $type = isset($_FILES['image']['type']) ? substr($_FILES['image']['type'], 0, strpos($_FILES['image']['type'], '/')) : 'default';
//            return $this->uploadfile($type, 'image');
            return $this->uploadfile('', 'image');
        }
    }

    /**
     * 统一处理文件上传
     * @param string $path
     * @param string $origin_name
     * @return string
     */
    public function uploadfile($path = '', $origin_name = '')
    {
        $path = 'uploadfile/' . $path;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $this->upload->set('path', $path);
        $this->upload->set('maxsize', 204800000);
        $this->upload->set('allowtype', ['gif', 'png', 'jpg', 'jpeg', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'psd', 'pdf', 'zip', 'rar', 'ppt']);
        $this->upload->set('israndname', true);
        $this->upload->set('originName', $origin_name);
        if ($this->upload->upload($origin_name, $_FILES)) {
            $file = $this->upload->getFileName();
            if ('ADMIN' === \model\TokenModel::getSourceSign()) {
                header('Content-type:text/json;charset=utf-8');
                echo json_encode([
                    'errno' =>  0,
                    'data'  =>  [
                        getenv('SERVER_DOMAIN') . '/uploadfile/' . $file
                    ]
                ]);
                exit;
            }
            return $this->success(['source_name' => $_FILES[$origin_name]['name'], 'file_name' => $file, 'path' => $path . '/' . $file]);
        }
        $msg = $this->upload->getErrorMsg();
        return $this->error($msg);
    }

    /**
     * 文件上传接口
     * @router http://server.name/upload.file
     */
    public function file()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
//            $type = isset($_FILES['file']['type']) ? substr($_FILES['file']['type'], 0, strpos($_FILES['file']['type'], '/')) : 'default';
//            return $this->uploadfile($type, 'file');
            return $this->uploadfile('', 'file');
        }
    }

    /**
     * 上传base64
     * @router http://server.name/upload.base64
     */
    public function base64()
    {
        $base64_img = $this->request->post('img', '', 'trim');
        $this->validate(compact('base64_img'), [
            'base64_img' => 'required'
        ]);
        $up_dir = $this->checkUploadPath();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {
            $type = $result[2];
            if (in_array($type, array('pjpeg', 'jpeg', 'jpg', 'gif', 'bmp', 'png'))) {
                $new_file = $up_dir . date('YmdHis_') . '.' . $type;
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))) {
                    $this->success([
                        'path' => str_replace(ROOT_PATH . 'web/', '', $new_file)
                    ]);
                }
                return $this->error('上传失败!');
            }
            return $this->error('图片上传类型错误');
        }
        return $this->error('文件错误');
    }

    private function checkUploadPath($save_path = '/')
    {
        $up_dir = ROOT_PATH . 'web/uploadfile' . $save_path;
        if (!is_dir($up_dir)) {
            mkdir($up_dir, 0777, true);
        }
        return $up_dir;
    }

    public function setField()
    {
        return [
            'base64_img' => '图片'
        ];
    }
}
